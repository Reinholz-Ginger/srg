<?php
include '../generalPhp/conection.php';
include '../protect.php';
?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="nofollow,noindex">
  <link rel="shortcut icon" href="../assets/favicon.svg" type="image/x-icon">
  <title>Cadastros</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' };
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="../generalScripts/darkmode.js"></script>
  <script src="../onLoad/onLoad.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans min-h-screen flex flex-col" onload="onLoad()">

  <!-- Preloader -->
  <div class="fixed inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-50" id="preload">
    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-500"></div>
  </div>
    <!-- Mobile Menu -->
    <div id="mobileMenu"
        class="fixed bottom-0 md:top-0 md:right-0 w-full md:w-[20%] backdrop-blur-[5px] h-[60%] md:h-full dark:bg-gray-800/50  dark:text-white bg-white/50 shadow-lg transform translate-y-full md:translate-x-full opacity-0 hidden z-50 transition duration-500">
        <!-- conteúdo do menu -->
    </div>

  <!-- Header -->
<header class="flex justify-between items-center px-4 py-3 bg-green-800 text-white shadow">
  <!-- Voltar -->
  <a href="../main.php" class="flex items-center gap-2 font-semibold">
    <i class="fas fa-arrow-left text-lg"></i>
    <span>Menu Principal</span>
  </a>

  <!-- Toggle Tema -->
  <button onclick="toggleTheme()" title="Alternar tema" class="text-yellow-400 text-lg">
    <i class="fas fa-circle-half-stroke"></i>
  </button>

  <!-- Menu -->
  <button onclick="openMenu()" title="Abrir menu">
    <i class="fas fa-bars text-white text-lg"></i>
  </button>
</header>

  <!-- Conteúdo Principal -->
  <main class="flex-1 max-w-7xl mx-auto px-4 py-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <a href="fornecedores/cadastrodeFornecedor.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
      <img src="../assets/categories/Cadastros/fornecedor.svg" class="w-8 h-8">
      <h2 class="text-green-800 dark:text-green-400 font-semibold">FORNECEDOR</h2>
    </a>
    <a href="produtos/cadastrodeproduto.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
      <img src="../assets/categories/Cadastros/produto.svg" class="w-8 h-8">
      <h2 class="text-green-800 dark:text-green-400 font-semibold">PRODUTO</h2>
    </a>
    <a href="clientes/cadastrodecliente.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
      <img src="../assets/categories/Cadastros/cliente.svg" class="w-8 h-8">
      <h2 class="text-green-800 dark:text-green-400 font-semibold">CLIENTE</h2>
    </a>
    <a href="usuarios/cadastrodeusuarios.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
      <img src="../assets/categories/Cadastros/usuarios.svg" class="w-8 h-8">
      <h2 class="text-green-800 dark:text-green-400 font-semibold">USUÁRIOS</h2>
    </a>
  </main>

  <!-- Rodapé -->
  <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400 md:fixed md:bottom-0 md:left-1/2 md:-translate-x-1/2 w-full bg-gray-100 dark:bg-gray-900">
    <a target="_blank" href="https://www.lucasrd.site">
      <p id="data-footer"></p>
    </a>
  </footer>

  <!-- Scripts -->
  <script src="../generalScripts/toastify.js"></script>
  <script src="../mobileMenu/js/mobileMenu.js"></script>
  <script src="../generalScripts/version.js"></script>
</body>
</html>
