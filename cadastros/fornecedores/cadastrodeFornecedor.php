<?php
include '../../generalPhp/conection.php';
include '../../protect.php';
?>

<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="nofollow,noindex">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
  <title>Cadastro Fornecedores</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body onload="onLoad()" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen">

  <!-- Preload -->
  <div id="preload" class="fixed inset-0 bg-white dark:bg-gray-900 flex items-center justify-center z-50">
    <div class="flex space-x-2">
      <div class="w-4 h-4 rounded-full bg-red-500 animate-bounce"></div>
      <div class="w-4 h-4 rounded-full bg-blue-500 animate-bounce [animation-delay:-0.1s]"></div>
      <div class="w-4 h-4 rounded-full bg-green-500 animate-bounce [animation-delay:-0.2s]"></div>
      <div class="w-4 h-4 rounded-full bg-yellow-500 animate-bounce [animation-delay:-0.3s]"></div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="fixed top-0 left-0 w-full h-full bg-gray-100 dark:bg-gray-800 z-40 hidden">
    <div class="p-4">
      <button onclick="openMenu()" class="w-10 h-10 mb-4">
        <img src="../../assets/x.svg" alt="Fechar Menu">
      </button>
      <div class="space-y-4">
        <a href="../../main.php" class="flex items-center space-x-2">
          <img src="../../assets/mobileIcons/icon _home_.svg" class="w-5 h-5">
          <h2>INÍCIO</h2>
        </a>
        <a href="../cadastros.php" class="flex items-center space-x-2">
          <img src="../../assets/mobileIcons/icon _book_-1.svg" class="w-5 h-5">
          <h2>CADASTROS</h2>
        </a>
        <a href="../../pedidos/cadastrodepedidos.php" class="flex items-center space-x-2">
          <img src="../../assets/mobileIcons/icon _list_-1.svg" class="w-5 h-5">
          <h2>PEDIDOS</h2>
        </a>
        <a href="../../relatorios/relatorios.php" class="flex items-center space-x-2">
          <img src="../../assets/mobileIcons/icon _pie chart_-1.svg" class="w-5 h-5">
          <h2>RELATÓRIOS</h2>
        </a>
        <a href="../../inspessao/cadastro.php" class="flex items-center space-x-2">
          <img src="../../assets/mobileIcons/icon _magnifying glass_-1.svg" class="w-5 h-5">
          <h2>INSPEÇÃO</h2>
        </a>
        <a href="../../packingList/cadastropackinglist.php" class="flex items-center space-x-2">
          <img src="../../assets/mobileIcons/icon _check_-1.svg" class="w-5 h-5">
          <h2>PACKING LIST</h2>
        </a>
      </div>
    </div>
  </div>

  <!-- Header -->
  <header class="flex flex-row  items-start p-4 bg-gray-200 dark:bg-gray-800 shadow-md">

      <a href="../cadastros.php">
        <button class="w-10 h-10">
          <img src="../../assets/backArrow.svg" alt="Voltar">
        </button>
      </a>

    <form id="cadastroForm" class="flex flex-col sm:flex-row gap-4 w-full mt-4">
      <input type="number" id="numero" name="numero" placeholder="NÚMERO" required class="px-4 py-2 border rounded w-full sm:w-40 text-black">
      <input type="text" id="nome" name="nome" placeholder="NOME" required class="px-4 py-2 border rounded w-full sm:w-64 text-black">
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded flex items-center gap-2">
        SALVAR <img src="../../assets/save.svg" class="w-4 h-4">
      </button>
    </form>
  </header>

  <!-- Search -->
  <form method="POST" id="form-pesquisa" class="p-4">
    <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar" class="w-full px-4 py-2 border rounded text-black">
  </form>

  <!-- Container -->
  <section id="containerList" class="p-4 space-y-4">
    <!-- Conteúdo listado via JS -->
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 border-t mt-10 dark:border-gray-700">
    <p id="data-footer"></p>
  </footer>

  <!-- Scripts -->
  <script src="../../onLoad/onLoad.js"></script>
  <script src="../../mobileMenu/js/mobileMenu.js"></script>
  <script src="../../generalScripts/version.js"></script>
  <script src="../../generalScripts/backPage.js"></script>
  <script src="cadastroFonecedor.js"></script>
  <script src="listarFornecedores.js"></script>
  <script src="busca.js"></script>
</body>

</html>
