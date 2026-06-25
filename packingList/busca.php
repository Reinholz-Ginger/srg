<?php
include '../generalPhp/conection.php';
include '../protect.php';

$busca = $_POST['palavra'];

$sql = "SELECT * FROM listpack WHERE nome LIKE ?";
$stmt = $conn->prepare($sql);
$buscaParam = "%$busca%";
$stmt->bind_param("s", $buscaParam);
$stmt->execute();
$resultado_sql = $stmt->get_result();

if ($resultado_sql->num_rows <= 0) {
    echo '
    <div class="text-center py-12">
        <img src="../assets/notFound.svg" alt="Nada encontrado" class="mx-auto mb-4 w-32">
        <h3 class="text-xl font-medium text-gray-700 dark:text-white">PEDIDO NÃO ENCONTRADO</h3>
    </div>';
} else {
    while ($row_sql = $resultado_sql->fetch_assoc()) {
        $dataFormatada = date('d/m/y', strtotime($row_sql['data_packingList']));
        echo '
        <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
            <div class="flex flex-col text-sm text-gray-600 dark:text-gray-300">
                <span class="font-semibold text-sm">N° Cont.: ' . htmlspecialchars($row_sql['numero_container']) . '</span>
                <span>Data: ' . htmlspecialchars($dataFormatada) . '</span>
                <span class="text-green-700 font-medium dark:text-green-400">' . htmlspecialchars($row_sql['nome']) . '</span>
            </div>
            <div class="flex space-x-3 mt-3 md:mt-0">
                <a href="../packingList/editar/editar.php?id=' . urlencode($row_sql['id']) . '&numero=' . urlencode($row_sql['id']) . '&cliente=' . urlencode($row_sql['nome']) . '&numero_container=' . urlencode($row_sql['numero_container']) . '" title="Visualizar">
                    <img src="../assets/file_green.svg" class="w-6 h-6">
                </a>
                <button onclick="deletarPackingList(' . (int)$row_sql['id'] . ')" title="Deletar">
                    <img src="../assets/erase.svg" class="w-6 h-6">
                </button>
                <button onclick="editarPackingList(' . (int)$row_sql['id'] . ', \'' . addslashes($row_sql['nome']) . '\',' . (int)$row_sql['numero_container'] . ',\'' . $row_sql['data_packingList'] . '\')" title="Editar">
                    <img src="../assets/edit.svg" class="w-6 h-6">
                </button>
            </div>
        </div>';
    }
}
?>
