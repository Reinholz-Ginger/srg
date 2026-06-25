<?php
// Incluir a conexão com banco de dados
include '../generalPhp/conection.php';
include '../protect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se todos os campos foram enviados
    if (isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['numero_container']) && isset($_POST['data_inspecao'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $numeroContainer = $_POST['numero_container'];
        $dataInspecao = $_POST['data_inspecao'];

        // Prepara a consulta para atualizar a inspeção
        $stmt = $conn->prepare("UPDATE inspecoes SET nome = ?, numero_container = ?, data_inspecao = ? WHERE id = ?");
        $stmt->bind_param('sssi', $nome, $numeroContainer, $dataInspecao, $id);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Inspeção editada com sucesso.";
        } else {
            echo "Erro ao editar a inspeção: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        echo "Dados incompletos.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
