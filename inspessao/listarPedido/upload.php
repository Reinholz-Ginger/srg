<?php
include '../../generalPhp/conection.php';

if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

function responderUpload($success, $message, $statusCode = 200, $details = array())
{
    http_response_code($statusCode);
    echo json_encode(array_merge(array(
        'success' => $success,
        'message' => $message
    ), $details));
    exit;
}

function validarArquivoUpload($fieldName)
{
    if (!isset($_FILES[$fieldName])) {
        responderUpload(false, "Arquivo {$fieldName} não foi enviado.", 400);
    }

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        responderUpload(false, "Erro no upload do arquivo {$fieldName}.", 400, array(
            'upload_error' => $_FILES[$fieldName]['error']
        ));
    }
}

function prepararDiretorio($dir)
{
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
        responderUpload(false, "Não foi possível criar o diretório {$dir}.", 500);
    }

    if (!is_writable($dir)) {
        responderUpload(false, "O diretório {$dir} não tem permissão de escrita.", 500);
    }
}

if (!isset($_SESSION['id'])) {
    responderUpload(false, 'Sessão expirada. Faça login novamente.', 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderUpload(false, 'Método de requisição inválido.', 405);
}

$id_item = $_POST['id_item'] ?? '';
if ($id_item === '') {
    responderUpload(false, 'ID do item não informado.', 400);
}

validarArquivoUpload('imagem1');
validarArquivoUpload('imagem2');

$uploadDirThumb = 'thumbnails/';
$uploadDirHigh = 'imgHigh/';
prepararDiretorio($uploadDirThumb);
prepararDiretorio($uploadDirHigh);

$idImagem = uniqid();
$fileName = uniqid() . '_redimensionada.jpg';
$thumbPath = $uploadDirThumb . $fileName;
$highPath = $uploadDirHigh . $fileName;
$arquivosMovidos = array();
$transacaoIniciada = false;

try {
    if (!move_uploaded_file($_FILES['imagem1']['tmp_name'], $thumbPath)) {
        throw new Exception('Não foi possível salvar o thumbnail no servidor.');
    }
    $arquivosMovidos[] = $thumbPath;

    if (!move_uploaded_file($_FILES['imagem2']['tmp_name'], $highPath)) {
        throw new Exception('Não foi possível salvar a imagem em alta definição no servidor.');
    }
    $arquivosMovidos[] = $highPath;

    $conn->begin_transaction();
    $transacaoIniciada = true;

    $sqlThumb = "INSERT INTO imagens (id, id_item, pathImagem) VALUES (?, ?, ?)";
    $stmtThumb = $conn->prepare($sqlThumb);
    if (!$stmtThumb) {
        throw new Exception('Erro ao preparar insert do thumbnail: ' . $conn->error);
    }
    $stmtThumb->bind_param("sss", $idImagem, $id_item, $thumbPath);
    if (!$stmtThumb->execute()) {
        throw new Exception('Erro ao inserir thumbnail no banco: ' . $stmtThumb->error);
    }

    $sqlHigh = "INSERT INTO imagensalta (id, id_item, pathImagem) VALUES (?, ?, ?)";
    $stmtHigh = $conn->prepare($sqlHigh);
    if (!$stmtHigh) {
        throw new Exception('Erro ao preparar insert da imagem HD: ' . $conn->error);
    }
    $stmtHigh->bind_param("sss", $idImagem, $id_item, $highPath);
    if (!$stmtHigh->execute()) {
        throw new Exception('Erro ao inserir imagem HD no banco: ' . $stmtHigh->error);
    }

    $conn->commit();

    responderUpload(true, 'Imagem salva com sucesso.', 200, array(
        'id_imagem' => $idImagem,
        'thumbnail' => $thumbPath,
        'high_definition' => $highPath
    ));
} catch (Throwable $error) {
    if ($transacaoIniciada) {
        try {
            $conn->rollback();
        } catch (Throwable $rollbackError) {
        }
    }

    foreach ($arquivosMovidos as $arquivo) {
        if (is_file($arquivo)) {
            unlink($arquivo);
        }
    }

    error_log('[upload inspeção] ' . $error->getMessage());
    responderUpload(false, 'Erro ao salvar imagem da inspeção.', 500, array(
        'error' => $error->getMessage()
    ));
}
