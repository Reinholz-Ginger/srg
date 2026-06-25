<?php
include '../../generalPhp/conection.php';
include '../../protect.php';

$data = json_decode(file_get_contents("php://input"), true);
$itensEnviados = $data['dados'];

try{


if (isset($itensEnviados['idItem'])) {
    $idItem = $itensEnviados['idItem'];
    $chaveAcesso = $itensEnviados['chaveAcesso'];
    $quantidade = $itensEnviados['quantidade'];
    $valorUnit = $itensEnviados['valorUnit'];

    // Busca o valor total atual do pedido
    $stmtTotal = $conn->prepare('SELECT valor_total FROM pedidoscadastro WHERE chaveAcesso = ?');
    $stmtTotal->bind_param('s', $chaveAcesso);
    $stmtTotal->execute();
    $resultTotal = $stmtTotal->get_result();
    $rowTotal = $resultTotal->fetch_assoc();
    $valorTotal = $rowTotal ? $rowTotal['valor_total'] : 0;

    // Busca o valor total do item antigo
    $stmtItem = $conn->prepare('SELECT valor_total FROM pedidos_dados WHERE id = ?');
    $stmtItem->bind_param('i', $idItem);
    $stmtItem->execute();
    $resultItem = $stmtItem->get_result();
    $rowItem = $resultItem->fetch_assoc();
    $valorTotalItem = $rowItem ? $rowItem['valor_total'] : 0;

    // Calcula o valor total resetado e o valor do novo item
    $valorTotalResetado = $valorTotal - $valorTotalItem;
    $valorItemNovo = $quantidade * $valorUnit;

    // Atualiza o valor total
    $valorAtualizado = $valorTotalResetado + $valorItemNovo;

    // Atualiza a tabela pedidos_dados
    $sql = $conn->prepare('UPDATE pedidos_dados SET quantidade = ?, valor_total = ? WHERE id = ?');
    $sql->bind_param('iii', $quantidade, $valorItemNovo, $idItem);

    if ($sql->execute()) {
        // Atualiza o valor total do pedido
        atualizarValorTotal($conn, $valorAtualizado, $chaveAcesso);
        echo json_encode(['message' => 'Quantidade alterada com sucesso.']);
    } else {
        echo json_encode(['message' => 'Falha ao alterar quantidade.']);
    }
}
} catch (Exception $e) {
    echo json_encode('message: ' . $e->getMessage());
}


function atualizarValorTotal($conn, $valorAtualizado, $chaveAcesso)
{
    // Atualiza a tabela pedidoscadastro
    $sql1 = $conn->prepare('UPDATE pedidoscadastro SET valor_total = ? WHERE chaveAcesso = ?');
    $sql1->bind_param('is', $valorAtualizado, $chaveAcesso);

}
?>



