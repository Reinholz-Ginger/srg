<?php
include '../../generalPhp/conection.php';
include '../../protect.php';

$data = json_decode(file_get_contents("php://input"), true);
$dados = $data['dados'];

$id = isset($dados['idItem']) ? intval($dados['idItem']) : 0;
$data_retirada = isset($dados['dataRetirada']) ? $dados['dataRetirada'] : '';

if ($id > 0 && !empty($data_retirada)) {
    try {
        $stmt = $conn->prepare("UPDATE pedidos_dados SET data_retirada = ? WHERE id = ?");
        $stmt->bind_param('si', $data_retirada, $id); // 's' para string, 'i' para inteiro

        if ($stmt->execute()) {
            echo json_encode(['message' => "Data de retirada atualizada com sucesso."]);
        } else {
            echo json_encode(['message' => "Erro ao atualizar data de retirada."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['message' => "Erro de conexão: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['message' => "Dados inválidos."]);
}
?>
