<?php
include '../../generalPhp/conection.php';

if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

function responderApagarImagem($success, $message, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode(array(
        'success' => $success,
        'message' => $message
    ));
    exit;
}

function caminhoSeguroParaApagar($path, $prefixosPermitidos)
{
    $path = trim((string) $path);

    if ($path === '' || strpos($path, '..') !== false || strpos($path, "\0") !== false) {
        return false;
    }

    foreach ($prefixosPermitidos as $prefixo) {
        if (strpos($path, $prefixo) === 0) {
            return true;
        }
    }

    return false;
}

if (!isset($_SESSION['id'])) {
    responderApagarImagem(false, 'Sessão expirada. Faça login novamente.', 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderApagarImagem(false, 'Método de requisição inválido.', 405);
}

$idImg = isset($_POST['id_image']) ? trim((string) $_POST['id_image']) : '';

if ($idImg === '' || !ctype_alnum($idImg)) {
    responderApagarImagem(false, 'Imagem inválida.', 400);
}

$transacaoIniciada = false;
$thumbPath = '';
$highPath = '';

try {
    $stmtBuscaThumb = $conn->prepare("SELECT pathImagem FROM imagens WHERE id = ? LIMIT 1");
    if (!$stmtBuscaThumb) {
        throw new Exception('Erro ao preparar busca do thumbnail: ' . $conn->error);
    }

    $stmtBuscaThumb->bind_param("s", $idImg);
    if (!$stmtBuscaThumb->execute()) {
        throw new Exception('Erro ao buscar thumbnail: ' . $stmtBuscaThumb->error);
    }

    $resultadoThumb = $stmtBuscaThumb->get_result();
    if ($resultadoThumb->num_rows === 0) {
        responderApagarImagem(false, 'Imagem não encontrada.', 404);
    }

    $thumbPath = (string) $resultadoThumb->fetch_assoc()['pathImagem'];
    $stmtBuscaThumb->close();

    $stmtBuscaHigh = $conn->prepare("SELECT pathImagem FROM imagensalta WHERE id = ? LIMIT 1");
    if (!$stmtBuscaHigh) {
        throw new Exception('Erro ao preparar busca da imagem HD: ' . $conn->error);
    }

    $stmtBuscaHigh->bind_param("s", $idImg);
    if (!$stmtBuscaHigh->execute()) {
        throw new Exception('Erro ao buscar imagem HD: ' . $stmtBuscaHigh->error);
    }

    $resultadoHigh = $stmtBuscaHigh->get_result();
    if ($resultadoHigh->num_rows > 0) {
        $highPath = (string) $resultadoHigh->fetch_assoc()['pathImagem'];
    }
    $stmtBuscaHigh->close();

    $conn->begin_transaction();
    $transacaoIniciada = true;

    $stmtDeleteHigh = $conn->prepare("DELETE FROM imagensalta WHERE id = ?");
    if (!$stmtDeleteHigh) {
        throw new Exception('Erro ao preparar exclusão da imagem HD: ' . $conn->error);
    }

    $stmtDeleteHigh->bind_param("s", $idImg);
    if (!$stmtDeleteHigh->execute()) {
        throw new Exception('Erro ao excluir imagem HD: ' . $stmtDeleteHigh->error);
    }
    $stmtDeleteHigh->close();

    $stmtDeleteThumb = $conn->prepare("DELETE FROM imagens WHERE id = ?");
    if (!$stmtDeleteThumb) {
        throw new Exception('Erro ao preparar exclusão do thumbnail: ' . $conn->error);
    }

    $stmtDeleteThumb->bind_param("s", $idImg);
    if (!$stmtDeleteThumb->execute()) {
        throw new Exception('Erro ao excluir thumbnail: ' . $stmtDeleteThumb->error);
    }

    if ($stmtDeleteThumb->affected_rows !== 1) {
        throw new Exception('Nenhum thumbnail foi excluído.');
    }
    $stmtDeleteThumb->close();

    $conn->commit();
    $transacaoIniciada = false;

    $arquivosParaApagar = array(
        array('path' => $thumbPath, 'prefixos' => array('thumbnails/')),
        array('path' => $highPath, 'prefixos' => array('imgHigh/'))
    );

    foreach ($arquivosParaApagar as $arquivo) {
        if (caminhoSeguroParaApagar($arquivo['path'], $arquivo['prefixos']) && is_file($arquivo['path'])) {
            if (!unlink($arquivo['path'])) {
                error_log('[apagar imagem inspeção] Não foi possível apagar arquivo: ' . $arquivo['path']);
            }
        }
    }

    responderApagarImagem(true, 'Imagem apagada com sucesso.');
} catch (Throwable $error) {
    if ($transacaoIniciada) {
        try {
            $conn->rollback();
        } catch (Throwable $rollbackError) {
            error_log('[apagar imagem inspeção] Erro no rollback: ' . $rollbackError->getMessage());
        }
    }

    error_log('[apagar imagem inspeção] ' . $error->getMessage());
    responderApagarImagem(false, 'Não foi possível apagar a imagem.', 500);
}
?>
