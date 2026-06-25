<?php

include '../../generalPhp/conection.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));
}

// Paginação
$pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
$qnt_result_pg = filter_input(INPUT_POST, 'qnt_result_pg', FILTER_SANITIZE_NUMBER_INT);
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

// Consulta
$result_sql = "SELECT * FROM usuarios ORDER BY id DESC LIMIT $inicio, $qnt_result_pg";
$resultado_sql = mysqli_query($conn, $result_sql);

if (($resultado_sql) && ($resultado_sql->num_rows != 0)) {
    echo '<div class="overflow-x-auto">';
    echo '<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">';
    echo '<thead class="bg-gray-100 dark:bg-gray-800">';
    echo '<tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">N°</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Usuário</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Ações</th>
          </tr>';
    echo '</thead><tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">';

    while ($row = mysqli_fetch_assoc($resultado_sql)) {
        echo '<tr>';
        echo '<td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">' . $row['id'] . '</td>';
        echo '<td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">' . $row['usuario'] . '</td>';
        echo '<td class="px-4 py-2 flex gap-3">
                <a href="editarSenha.php?id=' . $row['id'] . '" class="text-blue-600 hover:underline">
                    <img src="../../assets/edit.svg" alt="Editar" class="w-5 h-5 inline">
                </a>
                <a href="apagarUsuario.php?id=' . $row['id'] . '" class="text-red-600 hover:underline">
                    <img src="../../assets/erase.svg" alt="Excluir" class="w-5 h-5 inline">
                </a>
              </td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';

    // Paginação
    $result_pg = "SELECT COUNT(id) AS num_result FROM usuarios";
    $resultado_pg = mysqli_query($conn, $result_pg);
    $row_pg = mysqli_fetch_assoc($resultado_pg);
    $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

    $max_links = 2;
    echo "<div class='mt-4 justify-center flex flex-wrap gap-2 text-sm text-gray-800 dark:text-gray-200'>";
    echo "<a href='#' onclick='listar(1, $qnt_result_pg)' class='px-3 py-1 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600'>&lt; Primeira</a>";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant >= 1) {
            echo "<a href='#' onclick='listar($pag_ant, $qnt_result_pg)' class='px-3 py-1 bg-gray-200 dark:bg-gray-800 rounded hover:bg-gray-300 dark:hover:bg-gray-700'>$pag_ant</a>";
        }
    }

    echo "<span class='px-3 py-1 font-bold bg-green-200 dark:bg-green-800 rounded'>$pagina</span>";

    for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
        if ($pag_dep <= $quantidade_pg) {
            echo "<a href='#' onclick='listar($pag_dep, $qnt_result_pg)' class='px-3 py-1 bg-gray-200 dark:bg-gray-800 rounded hover:bg-gray-300 dark:hover:bg-gray-700'>$pag_dep</a>";
        }
    }

    echo "<a href='#' onclick='listar($quantidade_pg, $qnt_result_pg)' class='px-3 py-1 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600'>Última ></a>";
    echo "</div>";
} else {
    echo '<div class="flex flex-col items-center justify-center text-center p-6 text-gray-700 dark:text-gray-300">';
    echo '<img src="../../assets/notFound.svg" alt="Nada encontrado" class="w-32 h-32 mb-4">';
    echo '<h3 class="text-lg font-semibold">NÃO HÁ REGISTROS</h3>';
    echo '</div>';
}
