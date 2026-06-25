<?php
include '../../generalPhp/conection.php';
if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));

}
$chaveAcesso = isset($_POST['chaveAcesso']) ? trim($_POST['chaveAcesso']) : '';
$fornecedor = isset($_POST['fornecedor']) ? trim($_POST['fornecedor']) : '';

if ($chaveAcesso === '' || $fornecedor === '') {
    http_response_code(400);
    echo json_encode(["status" => "erro", "mensagem" => "Selecione um produtor válido antes de adicionar."]);
    exit;
}

$stmtFornecedor = $conn->prepare("SELECT nome FROM fornecedores WHERE nome = ? LIMIT 1");

if (!$stmtFornecedor) {
    error_log('Erro ao preparar validação do produtor: ' . $conn->error);
    http_response_code(500);
    echo json_encode(["status" => "erro", "mensagem" => "Não foi possível validar o produtor."]);
    exit;
}

$stmtFornecedor->bind_param("s", $fornecedor);

if (!$stmtFornecedor->execute()) {
    error_log('Erro ao validar produtor: ' . $stmtFornecedor->error);
    http_response_code(500);
    echo json_encode(["status" => "erro", "mensagem" => "Não foi possível validar o produtor."]);
    exit;
}

$resultadoFornecedor = $stmtFornecedor->get_result();

if ($resultadoFornecedor->num_rows === 0) {
    http_response_code(400);
    echo json_encode(["status" => "erro", "mensagem" => "Produtor não encontrado no cadastro."]);
    exit;
}

$fornecedor = $resultadoFornecedor->fetch_assoc()['nome'];
$stmtFornecedor->close();

$sql = "INSERT INTO inspecao (chaveAcesso, fornecedor) VALUES (?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $chaveAcesso, $fornecedor);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Dados inseridos com sucesso!"]);
    } else {
        error_log('Erro ao inserir produtor na inspeção: ' . $stmt->error);
        http_response_code(500);
        echo json_encode(["status" => "erro", "mensagem" => "Não foi possível adicionar o produtor."]);
    }

    $stmt->close();
} else {
    error_log('Erro ao preparar inserção do produtor na inspeção: ' . $conn->error);
    http_response_code(500);
    echo json_encode(["status" => "erro", "mensagem" => "Não foi possível adicionar o produtor."]);
}

$conn->close();
?>
