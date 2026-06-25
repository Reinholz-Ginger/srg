<?php
include '../../generalPhp/conection.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));
}

$busca = trim($_POST['palavra'] ?? '');
$buscaParam = '%' . $busca . '%';

$sql = "SELECT id, usuario FROM usuarios WHERE usuario LIKE ? OR id LIKE ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $buscaParam, $buscaParam);
$stmt->execute();
$resultado_sql = $stmt->get_result();

if ($resultado_sql->num_rows <= 0) {
    echo '<div class="flex flex-col items-center justify-center text-center p-8 text-gray-700 dark:text-gray-300">';
    echo '<img src="../../assets/notFound.svg" alt="Nada encontrado" class="w-32 h-32 mb-4">';
    echo '<h3 class="text-lg font-semibold">USUÁRIO NÃO ENCONTRADO</h3>';
    echo '</div>';
    exit;
}

echo '<div class="overflow-x-auto">';
echo '<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">';
echo '<thead class="bg-gray-100 dark:bg-gray-800">';
echo '<tr>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">N°</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Usuário</th>
        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Ações</th>
      </tr>';
echo '</thead><tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">';

while ($row_sql = mysqli_fetch_assoc($resultado_sql)) {
    $id = (int) $row_sql['id'];
    $usuario = htmlspecialchars($row_sql['usuario'], ENT_QUOTES, 'UTF-8');

    echo '<tr>';
    echo '<td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">' . $id . '</td>';
    echo '<td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">' . $usuario . '</td>';
    echo '<td class="px-4 py-2 flex gap-3">
            <a href="editarSenha.php?id=' . $id . '" class="text-blue-600 hover:underline">
                <img src="../../assets/edit.svg" alt="Editar" class="w-5 h-5 inline">
            </a>
            <a href="apagarUsuario.php?id=' . $id . '" class="text-red-600 hover:underline">
                <img src="../../assets/erase.svg" alt="Excluir" class="w-5 h-5 inline">
            </a>
          </td>';
    echo '</tr>';
}

echo '</tbody></table></div>';
