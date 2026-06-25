<?php
    include 'generalPhp/conection.php';
    include 'protect.php';
?>

<!DOCTYPE html>
<html lang="pt-br" class="">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
      <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
  <title>Sistema de Cadastros</title>

  <!-- Tailwind + Font Awesome -->
  <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>

    <link rel="manifest" href="/manifest.json">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


  <!-- Script dark mode --> 
    <script src="generalScripts/darkmode.js?v=1.7.2"></script>
  <script src="onLoad/onLoad.js?v=1.7.2"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans" onload="onLoad()">

  <!-- Preloader -->
  <div class="overflow white" id="preload">
    <div class="circle-line">
      <div class="circle-red">&nbsp;</div>
      <div class="circle-blue">&nbsp;</div>
      <div class="circle-green">&nbsp;</div>
      <div class="circle-yellow">&nbsp;</div>
    </div>
  </div>

  <!-- Cabeçalho -->
  <header class="bg-white dark:bg-gray-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
      <div class="flex items-center gap-4">
        <img src="./assets/logoLogin.png" alt="Logo" class="w-14 h-11" />
        <div>
          <h1 class="text-xl font-semibold text-green-700 dark:text-green-400">Sistema de Cadastros e Relatórios</h1>
          <p id="data-hora" class="text-sm text-gray-500 dark:text-gray-400">Segunda-feira | 13:13</p>
        </div>
      </div>

      <div class="flex items-center gap-4">
        <!-- Botão tema -->
        <button onclick="toggleTheme()" title="Alternar tema" class="text-xl text-yellow-500 hover:text-yellow-400 transition">
          <i class="fas fa-circle-half-stroke"></i>
        </button>

        <!-- Botão sair -->
        <a href="logout.php" title="Sair" class="text-red-500 hover:text-red-600 text-xl">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </div>
    </div>
  </header>

  <!-- Conteúdo Principal -->
  <main class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
      <a href="cadastros/cadastros.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
        <img src="assets/categories/cadastro.svg" alt="Cadastro" class="w-8 h-8" />
        <span class="text-green-800 dark:text-green-400 font-semibold">CADASTROS</span>
      </a>

      <a href="pedidos/cadastrodepedidos.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
        <img src="assets/categories/pedidos.svg" alt="Pedidos" class="w-8 h-8" />
        <span class="text-green-800 dark:text-green-400 font-semibold">PEDIDOS</span>
      </a>

      <a href="relatorios/relatorios.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
        <img src="assets/categories/relatorios.svg" alt="Relatórios" class="w-8 h-8" />
        <span class="text-green-800 dark:text-green-400 font-semibold">RELATÓRIOS</span>
      </a>

      <a href="inspessao/cadastro.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
        <img src="assets/categories/inspessao.svg" alt="Inspeção" class="w-8 h-8" />
        <span class="text-green-800 dark:text-green-400 font-semibold">INSPEÇÃO</span>
      </a>

      <a href="preEmbarque/preEmbarque.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#BB4430" class="size-8">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
</svg>

        <span class="text-green-800 dark:text-green-400 font-semibold">PRÉ EMBARQUE</span>
      </a>

      <a href="packingList/cadastropackinglist.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
        <img src="assets/categories/packing_list.svg" alt="Packing List" class="w-8 h-8" />
        <span class="text-green-800 dark:text-green-400 font-semibold">PACKING LIST</span>
      </a>
      <a href="configuracoes/configuracoes.php" class="bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 flex flex-col items-center justify-center gap-4 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#BB4430" class="size-8">
  <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
</svg>

        <span class="text-green-800 dark:text-green-400 font-semibold"> CONFIGURAÇÕES</span>
      </a>
    </div>
  </main>

  <!-- Rodapé -->
  <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400 md:fixed md:bottom-0 md:left-1/2 md:-translate-x-1/2 w-full bg-gray-100 dark:bg-gray-900">
  
    <a target="_blank" href="https://www.lucasrd.site">
        <p id="data-footer"></p>
    </a>
  </footer>

  <!-- Scripts -->
  <script src="generalScripts/version.js?v=1.7.2"></script>
  <script src="generalScripts/timeFormat.js?v=1.7.2"></script>
  <script src="../main.js?v=1.7.2"></script>

</body>
</html>


