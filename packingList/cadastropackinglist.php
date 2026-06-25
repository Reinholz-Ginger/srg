<?php
include '../generalPhp/conection.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['id'])) {
    die(header("Location: ../index.php"));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Packing List</title>
<link rel="shortcut icon" href="../assets/favicon.svg" type="image/x-icon">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>

  <script src="../mobileMenu/js/mo"></script>
    <script src="../generalScripts/toastify.js?v=1.7.1"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="../generalScripts/darkmode.js?v=1.7.1"></script>
  <script src="../onLoad/onLoad.js?v=1.7.1"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white" onload="onLoad()">



  <!-- Header -->
  <!-- Header -->
  <header class="flex justify-between items-center px-4 py-3 bg-green-800 text-white shadow">
    <a href="../main.php" class="flex items-center gap-2 font-semibold">
      <i class="fas fa-arrow-left text-lg"></i>
      <span>Menu Principal</span>
    </a>
    <h1 class="text-lg font-semibold">Packing List</h1>
    <div class="flex items-center gap-4">
      <button onclick="toggleTheme()" title="Alternar tema" class="text-yellow-400 text-lg">
        <i class="fas fa-circle-half-stroke"></i>
      </button>
 
    </div>
  </header>

  <!-- Formulário principal -->
  <div class="max-w-4xl mx-auto px-4 py-6">
    <form class="formCadastroPackingList flex flex-col md:flex-row gap-4 mb-6 bg-white dark:bg-gray-800 p-4 rounded shadow">
      <input name="nome" placeholder="Nome" type="text" class="flex-1 p-2 border rounded dark:bg-gray-700">
      <input name="numero_container" placeholder="N° Container" type="number" class="flex-1 p-2 border rounded dark:bg-gray-700">
      <input name="data_PackingList" type="date" class="p-2 border rounded dark:bg-gray-700">
      <button type="button" onclick="salvarPackingList()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
        Salvar
      </button>
    </form>

    <!-- Campo de busca -->
    <form id="form-pesquisa" class="mb-6">
      <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar"
        class="w-full p-2 border rounded shadow dark:bg-gray-700">
    </form>

    <!-- Lista de dados -->
    <section id="containerList" class="space-y-4">
      <?php
      $pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT) ?: 1;
      $qnt_result_pg = filter_input(INPUT_POST, 'qnt_result_pg', FILTER_SANITIZE_NUMBER_INT) ?: 10;
      $inicio = ($pagina - 1) * $qnt_result_pg;

      $sql = "SELECT * FROM listpack ORDER BY id DESC LIMIT ?, ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $inicio, $qnt_result_pg);
      $stmt->execute();
      $resultado_sql = $stmt->get_result();

      if ($resultado_sql && $resultado_sql->num_rows > 0) {
          while ($row_sql = $resultado_sql->fetch_assoc()) {
              $dataFormatada = date('d/m/Y', strtotime($row_sql['data_packingList']));
              echo '
              <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-800 p-4 rounded shadow">
                  <div class="flex flex-col text-sm text-gray-600 dark:text-gray-300">
                      <span class="font-semibold text-sm">N° Cont.: ' . htmlspecialchars($row_sql['numero_container']) . '</span>
                      <span>Data: ' . htmlspecialchars($dataFormatada) . '</span>
                      <span class="text-green-700 font-medium dark:text-green-400">' . htmlspecialchars($row_sql['nome']) . '</span>
                  </div>
                  <div class="flex space-x-3 mt-3 md:mt-0">
                      <a href="../packingList/editar/editar.php?id=' . urlencode($row_sql['id']) . '" title="Visualizar">
                        <img src="../assets/file_green.svg" class="w-6 h-6">
                      </a>
                      <button onclick="deletarPackingList(' . (int) $row_sql['id'] . ')" title="Deletar">
                        <img src="../assets/erase.svg" class="w-6 h-6">
                      </button>
                      <button onclick="editarPackingList(' . (int) $row_sql['id'] . ', \'' . addslashes($row_sql['nome']) . '\',' . (int) $row_sql['numero_container'] . ',\'' . addslashes($row_sql['data_packingList']) . '\')" title="Editar">
                        <img src="../assets/edit.svg" class="w-6 h-6">
                      </button>
                  </div>
              </div>';
          }
      } else {
          echo '
          <div class="text-center py-12">
              <img src="../assets/notFound.svg" alt="Nada encontrado" class="mx-auto mb-4 w-32">
              <h3 class="text-xl font-medium">NENHUM PEDIDO SALVO</h3>
          </div>';
      }
      ?>
    </section>
  </div>

  <script>
    function openMenu() {
      const menu = document.getElementById("mobileMenu");
      menu.classList.toggle("-translate-x-full");
    }

    function onLoad() {
      document.getElementById('preload')?.remove();
    }
  </script>

</body>



</html>


  <script src="../generalScripts/backPage.js?v=1.7.1"></script>
  <script src="../generalScripts/version.js?v=1.7.1"></script>
  <script src="../pedidos/busca.js?v=1.7.1"></script>
  <script src="listar.js?v=1.7.1"></script>
