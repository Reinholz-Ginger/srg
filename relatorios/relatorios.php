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
<html lang="pt-br" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="nofollow,noindex">
  <link rel="shortcut icon" href="../assets/favicon.svg" type="image/x-icon">
  <title>Relatórios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="../generalScripts/darkmode.js?v=1.7.2"></script>
  <script src="../onLoad/onLoad.js?v=1.7.2"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans" onload="onLoad()">

  <!-- Preloader -->
  <div class="fixed inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-50" id="preload">
    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-500"></div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="fixed inset-0 bg-gray-800 bg-opacity-90 z-40 hidden flex-col p-4 text-white">

  </div>

  <!-- Header -->
  <header class="flex justify-between items-center px-4 py-3 bg-green-800 text-white shadow print:hidden">
    <a href="../main.php" class="flex items-center gap-2 font-semibold">
      <i class="fas fa-arrow-left text-lg"></i>
      <span>Menu Principal</span>
    </a>
    <h1 class="text-lg font-semibold">Relatórios</h1>
    <div class="flex items-center gap-4">
      <button onclick="toggleTheme()" title="Alternar tema" class="text-yellow-400 text-lg">
        <i class="fas fa-circle-half-stroke"></i>
      </button>
      <button onclick="openMenu()" title="Abrir menu">
        <i class="fas fa-bars text-white text-lg"></i>
      </button>
    </div>
  </header>

  <!-- Impressão Header -->
  <section class="hidden print:block p-4 border-b border-gray-300">
    <div class="flex items-start gap-4">
      <img src="../assets/logoLogin.png" alt="Logo Reinholz Ginger" class="w-20 h-20">
      <div class="text-sm">
        <p class="font-bold">REINHOLZ GINGER COMERCIO DE RAIZES LTDA</p>
        <p><img src="../assets/cnpj.svg" class="inline w-4"> 50.688.819/0001-61</p>
        <p><img src="../assets/local.svg" class="inline w-4"> AE ZONA RURAL, S/N GALO - DOMINGOS MARTINS ES - CEP:29260-000</p>
        <p><img src="../assets/email.svg" class="inline w-4"> reinholzginger0@outlook.com</p>
      </div>
    </div>
  </section>

  <!-- Formulário de Filtro -->
  <main class="p-4">
    <form id="cadastroForm" class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md grid gap-4">
      <div class="flex items-center gap-2">
        <img src="../assets/categories/relatorios.svg" class="w-8">
        <h2 class="text-lg font-semibold text-green-700 dark:text-green-400">RELATÓRIOS</h2>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <input id="pesquisaFornecedor" name="pesquisaFornecedor" type="text" placeholder="FORNECEDOR" class="w-full p-2 border rounded dark:bg-gray-900">
        <select name="fornecedor" id="fornecedor" class="w-full p-2 border rounded dark:bg-gray-900">
          <option value=""></option>
        </select>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label>Data Inicial</label>
          <input id="dataInicial" type="date" class="w-full p-2 border rounded dark:bg-gray-900">
        </div>
        <div>
          <label>Data Final</label>
          <input id="dataFinal" type="date" class="w-full p-2 border rounded dark:bg-gray-900">
        </div>
      </div>
      <button type="button" id="filtrarButton"  class="self-start px-4 py-2 bg-green-700 text-white rounded hover:bg-green-800 flex items-center gap-2">
        FILTRAR <img src="../assets/filtrar.svg" alt="">
      </button>
    </form>

    <!-- Resumo -->
    <div class="grid grid-cols-3 text-center mt-8 font-semibold">
      <div>
        Quantidade<br>de pedidos
        <div id="quantidadePedidos" class="text-xl mt-2">0</div>
      </div>
      <div>
        Total Caixas
        <div id="totalCaixas" class="text-xl mt-2">0</div>
      </div>
      <div>
        Valor total<br>unificado
        <div id="ValorUnificado" class="text-xl mt-2">R$ 0,00</div>
      </div>
    </div>

    <!-- Cabeçalho Itens -->
    <div class="grid grid-cols-5 gap-2 text-sm mt-8 font-bold border-b pb-2">
      <div>Nº P</div>
      <div>DATA</div>
      <div>DATA RET.</div>
      <div>QNT</div>
      <div class="text-center cursor-pointer" onclick="imprimirRelatorios()">
        <img src="../assets/print.svg" alt="Imprimir" class="mx-auto h-6">
      </div>
    </div>

    <!-- Lista -->
    <section id="containerList" class="mt-4 space-y-2">
      <!-- Conteúdo gerado por JS -->
    </section>
  </main>

  <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400">
    <p id="data-footer"></p>
  </footer>

  <!-- Scripts -->
  <script src="../mobileMenu/js/mobileMenu.js?v=1.7.2"></script>
  <script src="../generalScripts/version.js?v=1.7.2"></script>
  <script src="../generalScripts/backPage.js?v=1.7.2"></script>
  <script src="buscaFornecedor.js?v=1.7.2"></script>
  <script src="filtrarPedidos.js?v=1.7.2"></script>
  <script src="mostrarInfo.js?v=1.7.2"></script>
  <script src="../generalScripts/print.js?v=1.7.2"></script>
  <script>
    var today = new Date();
    var day = (today.getDate()).toString().padStart(2, '0');
    var month = (today.getMonth() + 1).toString().padStart(2, '0');
    var year = today.getFullYear();
    var formattedDate = year + "-" + month + "-" + day;
    document.getElementById("dataInicial").value = formattedDate;
    document.getElementById("dataFinal").value = formattedDate;
  </script>
</body>
</html>