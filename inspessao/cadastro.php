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
<html lang="pt-br" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="nofollow,noindex">
  <title>Inspeção</title>
  <link rel="shortcut icon" href="../assets/favicon.svg" type="image/x-icon">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>
    <script src="../generalScripts/toastify.js?v=1.7.0"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="../generalScripts/darkmode.js?v=1.7.0"></script>
  <script src="../onLoad/onLoad.js?v=1.7.0"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans" onload="onLoad()">

  <!-- Preloader -->
  <div class="fixed inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-50" id="preload">
    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-500"></div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="fixed inset-0  bg-gray-800 bg-opacity-90 z-40 hidden flex-col p-4 text-white">

  </div>

  <!-- Header -->
  <header class="flex justify-between items-center px-4 py-3 bg-green-800 text-white shadow">
    <a href="../main.php" class="flex items-center gap-2 font-semibold">
      <i class="fas fa-arrow-left text-lg"></i>
      <span>Menu Principal</span>
    </a>
    <h1 class="text-lg font-semibold">Inspeção</h1>
    <div class="flex items-center gap-4">
      <button onclick="toggleTheme()" title="Alternar tema" class="text-yellow-400 text-lg">
        <i class="fas fa-circle-half-stroke"></i>
      </button>
      <button onclick="openMenu()" title="Abrir menu">
        <i class="fas fa-bars text-white text-lg"></i>
      </button>
    </div>
  </header>

  <!-- Formulário de Inspeção -->
  <main class="p-4 max-w-4xl mx-auto">
    <form id="" class=" formCadastroInspecao bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md grid gap-4">
      <h2 class="text-xl font-semibold text-green-700 dark:text-green-400">Nova Inspeção</h2>
      <input name="nome" placeholder="Nome" type="text" class="p-2 border rounded dark:bg-gray-900">
      <input name="numero_container" placeholder="Nº Container" type="text" class="p-2 border rounded dark:bg-gray-900">
      <input name="data_inspecao" type="date" class="p-2 border rounded dark:bg-gray-900">
      <button type="button" onclick="salvarInspecao()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Salvar</button>
    </form>

    <!-- Campo de busca -->
    <form method="POST" id="form-pesquisa" class="mt-6">
      <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar" class="w-full p-2 border rounded dark:bg-gray-900">
    </form>

    <!-- Editar inspeção -->
    <div id="divEditarInspecao" class="hidden mt-6 bg-yellow-50 dark:bg-yellow-900 p-4 rounded shadow">
      <h4 class="font-semibold text-lg">Editar Inspeção</h4>
      <form class="grid gap-4 mt-4">
        <div>
          <label>Nome</label>
          <input id="editarNome" name="nome" placeholder="Nome" type="text" class="p-2 border rounded w-full dark:bg-gray-900">
        </div>
        <div>
          <label>Nº Container</label>
          <input id="editarNumero_container" name="numero_container" type="text" class="p-2 border rounded w-full dark:bg-gray-900">
        </div>
        <div>
          <label>Data</label>
          <input id="editarData" name="data_inspecao" type="date" class="p-2 border rounded w-full dark:bg-gray-900">
        </div>
        <div class="flex gap-4">
          <button type="button" onclick="salvarEdicaoInspecao()" class="bg-green-600 text-white px-4 py-2 rounded">Salvar</button>
          <button type="button" onclick="fecharDivEdicao()" class="bg-red-600 text-white px-4 py-2 rounded">Cancelar</button>
        </div>
      </form>
    </div>

    <!-- Lista -->
    <section id="containerList" class="mt-8 space-y-4">
      <!-- Conteúdo dinâmico listado aqui -->
    </section>
  </main>

  <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400">
    <p id="data-footer"></p>
  </footer>

  <!-- Scripts -->

  <script src="../mobileMenu/js/mobileMenu.js?v=1.7.0"></script>
  <script src="../generalScripts/version.js?v=1.7.0"></script>
  <script src="../generalScripts/backPage.js?v=1.7.0"></script>
  <script src="listar.js?v=1.7.0"></script>
  <script src="../pedidos/busca.js?v=1.7.0"></script>
</body>
</html>
