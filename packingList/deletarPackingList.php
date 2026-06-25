<?php
// Incluir a conexão com banco de dados
include '../generalPhp/conection.php';
include '../protect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID foi enviado
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Prepara a consulta para deletar a inspeção
        $stmt = $conn->prepare("DELETE FROM listpack WHERE id = ?");
        $stmt->bind_param('i', $id); // 'i' significa integer

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Inspeção deletada com sucesso.";
        } else {
            echo "Erro ao deletar a inspeção: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        echo "ID não fornecido.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
