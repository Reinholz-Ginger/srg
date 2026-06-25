<?php
include '../../generalPhp/conection.php';
include '../../protect.php';

$data = json_decode(file_get_contents("php://input"), true);
$dados = $data['dados']; // ← Correto agora

$id = isset($dados['idItem']) ? intval($dados['idItem']) : 0;


$id = isset($dados['idItem']) ? intval($dados['idItem']) : 0;

if ($id > 0) {
    try {
        $stmt = $conn->prepare("DELETE FROM pedidos_dados WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => "Item apagado com sucesso."]);
        } else {
            echo json_encode(['message' => "Erro ao apagar o item."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['message' => "Erro de conexão: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['message' => " Dados inválidos.".$id]);
}
?>
