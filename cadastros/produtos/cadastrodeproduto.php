<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="nofollow,noindex">
  <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
  <title>Cadastro produtos</title>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    <script src="generalScripts/darkmode.js?v=1.7.2"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen" onload="onLoad()">

  <!-- Loader -->
  <div id="preload" class="fixed inset-0 bg-white dark:bg-gray-900 z-50 flex items-center justify-center">
    <div class="flex space-x-2">
      <div class="w-4 h-4 bg-red-500 rounded-full animate-bounce"></div>
      <div class="w-4 h-4 bg-blue-500 rounded-full animate-bounce delay-100"></div>
      <div class="w-4 h-4 bg-green-500 rounded-full animate-bounce delay-200"></div>
      <div class="w-4 h-4 bg-yellow-500 rounded-full animate-bounce delay-300"></div>
    </div>
  </div>

  <!-- Header -->
  <header class="p-4 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 shadow bg-white dark:bg-gray-800">
    <!-- Botões topo -->
    <div class="flex items-center gap-4">
      <a href="../cadastros.php">
        <button class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full">
          <img src="../../assets/backArrow.svg" alt="Voltar" class="w-6 h-6">
        </button>
      </a>

      <button onclick="openMenu()" class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full lg:hidden">
        <img src="../../assets/menu_mobile.svg" alt="Menu mobile" class="w-6 h-6">
      </button>
    </div>

    <!-- Formulário de cadastro -->
    <form id="cadastroForm" class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
      <div class="flex flex-col">
        <label for="produto" class="text-sm font-semibold">PRODUTO</label>
        <input id="produto" name="produto" type="text" required placeholder="PRODUTO"
          class="px-4 py-2 rounded border dark:bg-gray-700 dark:border-gray-600">
      </div>

      <div class="flex flex-col">
        <label for="valor" class="text-sm font-semibold">VALOR</label>
        <input id="valor" name="valor" required placeholder="VALOR" type="text"
          onkeypress="$(this).mask('R$ ###.###.##',{ reverse: true })"
          class="px-4 py-2 rounded border dark:bg-gray-700 dark:border-gray-600">
      </div>

      <button type="submit"
        class="mt-4 sm:mt-auto px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 flex items-center gap-2">
        SALVAR <img src="../../assets/save.svg" alt="" class="w-4 h-4">
      </button>
    </form>
  </header>

  <!-- Campo de busca -->
  <form method="POST" id="form-pesquisa" action=""
    class="p-4 w-full max-w-4xl mx-auto flex justify-center">
    <input type="text" id="pesquisa" name="pesquisa" placeholder="Buscar"
      class="w-full sm:w-96 px-4 py-2 rounded border dark:bg-gray-800 dark:border-gray-600">
  </form>

  <!-- Lista -->
  <section id="containerList" class="p-4 grid gap-4 max-w-6xl mx-auto">
    <!-- Conteúdo dinâmico será renderizado aqui -->
  </section>

  <!-- Footer -->
  <footer class="text-center text-sm py-4 text-gray-500 dark:text-gray-400">
    <p id="data-footer"></p>
  </footer>

  <!-- Scripts -->
  <script src="../../onLoad/onLoad.js?v=1.7.2"></script>
  <script src="../../mobileMenu/js/mobileMenu.js?v=1.7.2"></script>
  <script src="../../generalScripts/version.js?v=1.7.2"></script>
  <script src="../../generalScripts/backPage.js?v=1.7.2"></script>
  <script src="cadastro.js?v=1.7.2"></script>
  <script src="listar.js?v=1.7.2"></script>
  <script src="busca.js?v=1.7.2"></script>
</body>
