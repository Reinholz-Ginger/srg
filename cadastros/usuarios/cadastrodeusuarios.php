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
  <title>Cadastro Usuários</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' };
  </script>
  <script src="../../onLoad/onLoad.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body class="min-h-screen bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans" onload="onLoad()">
  <div id="preload" class="fixed inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-500"></div>
  </div>

  <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
      <a href="../cadastros.php" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700" title="Voltar">
        <i class="fas fa-arrow-left text-green-700 dark:text-green-400"></i>
      </a>

      <div class="flex-1 min-w-0">
        <p class="text-xs uppercase font-semibold text-green-700 dark:text-green-400">Cadastros</p>
        <h1 class="text-lg font-semibold truncate">Usuários</h1>
      </div>
    </div>
  </header>

  <main class="max-w-6xl mx-auto w-full px-4 py-6 space-y-6">
    <section class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-4">
      <form id="cadastroForm" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="grid gap-1">
          <label for="nome" class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Usuário</label>
          <input id="nome" name="nome" placeholder="Usuário" type="text" required
            class="h-10 w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600/20">
        </div>

        <div class="grid gap-1">
          <label for="senha" class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Senha</label>
          <input id="senha" name="senha" placeholder="Senha" type="password" required
            class="h-10 w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600/20">
        </div>

        <div class="grid gap-1">
          <label for="senha1" class="text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Repita a senha</label>
          <input id="senha1" name="senha_confirmada" placeholder="Repita a senha" type="password" required
            class="h-10 w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600/20">
        </div>

        <button type="submit" class="h-10 inline-flex items-center justify-center gap-2 rounded bg-green-600 hover:bg-green-700 text-white px-4 text-sm font-semibold shadow-sm">
          SALVAR <i class="fas fa-save"></i>
        </button>
      </form>
    </section>

    <section class="space-y-4">
      <form method="POST" id="form-pesquisa" action="">
        <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar"
          class="h-10 w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 text-sm outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600/20">
      </form>

      <section id="containerList" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden"></section>
    </section>
  </main>

  <footer class="text-center py-4 text-xs text-gray-500 dark:text-gray-400">
    <p id="data-footer"></p>
  </footer>

  <script src="../../generalScripts/toastify.js"></script>
  <script src="../../generalScripts/darkmode.js"></script>
  <script src="../../mobileMenu/js/mobileMenu.js"></script>
  <script src="../../generalScripts/version.js"></script>
  <script src="../../generalScripts/backPage.js"></script>
  <script src="cadastro.js"></script>
  <script src="listar.js"></script>
  <script src="busca.js"></script>
</body>

</html>
