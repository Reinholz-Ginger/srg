<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));
}
?>

<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="nofollow,noindex">
  <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
  <title>Cadastro Clientes</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>

<body onload="onLoad()" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex flex-col">

  <!-- Loader -->
  <div id="preload" class="fixed inset-0 bg-white dark:bg-gray-900 z-50 flex items-center justify-center">
    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-500"></div>
  </div>

  <!-- Header -->
  <header class="flex flex-col sm:flex-row justify-center items-center gap-4 p-4 shadow bg-gray-100 dark:bg-gray-800">
    <div class="flex items-center gap-2 w-full sm:w-auto">
      <a href="../cadastros.php">
        <button class="p-2 rounded hover:bg-gray-300 dark:hover:bg-gray-700">
          <img src="../../assets/backArrow.svg" alt="Voltar" class="h-6 w-6">
        </button>
      </a>
    </div>
    <form id="cadastroForm" class="flex flex-col sm:flex-row gap-4 items-center w-full sm:w-auto">
      <div class="flex flex-col">

        <input placeholder="CLIENTE" type="text" id="nome" name="nome" required
               class="px-3 py-2 rounded bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm w-64">
      </div>
        
      <button type="submit"
              class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
        SALVAR <img src="../../assets/save.svg" alt="" class="w-4 h-4">
      </button>
    </form>
  </header>

  <!-- Search -->
  <div class="p-4">
    <form method="POST" id="form-pesquisa" action="" class="w-full max-w-md mx-auto">
      <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar"
             class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
    </form>
  </div>

  <!-- Lista -->
  <section id="containerList" class="flex-1 p-4 space-y-4 overflow-y-auto">
    <!-- Conteúdo dinâmico será inserido aqui -->
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-xs text-gray-500 dark:text-gray-400">
    <p id="data-footer"></p>
  </footer>

  <!-- Scripts -->
  <script src="../../generalScripts/version.js?v=1.7.0"></script>
  <script src="../../generalScripts/backPage.js?v=1.7.0"></script>
  <script src="cadastro.js?v=1.7.0"></script>
  <script src="listar.js?v=1.7.0"></script>
  <script src="busca.js?v=1.7.0"></script>
  <script>
    function onLoad() {
      document.getElementById('preload').style.display = 'none';
    }
  </script>
</body>
</html>
