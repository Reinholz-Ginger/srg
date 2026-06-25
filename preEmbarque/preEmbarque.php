<?php
//Incluir a conexão com banco de dados
include '../generalPhp/conection.php';
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die(header("Location: ../index.php"));
}
?>

<!DOCTYPE html>
<html lang="pt-br" class="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="nofollow,noindex" />
    <link rel="shortcut icon" href="../assets/favicon.svg" type="image/x-icon">
    <title>Pré Embarque</title>

    <!-- Tailwind CSS + Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>



    <!-- Estilos e scripts existentes -->
    <link rel="stylesheet" href="../onLoad/onLoad.css?v=1.7.1">
    <script src="../onLoad/onLoad.js?v=1.7.1"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>

<body class="bg-gray-100 h-[100dvh] dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans" onload="onLoad()">
    <!-- Preloader -->
    <div class="overflow white" id="preload">
        <div class="circle-line">
            <div class="circle-red"></div>
            <div class="circle-blue"></div>
            <div class="circle-green"></div>
            <div class="circle-yellow"></div>
        </div>
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
        <h1>Pré-Embarque</h1>
  <!-- Toggle Tema -->
  <button onclick="toggleTheme()" title="Alternar tema" class="text-yellow-400 text-lg">
    <i class="fas fa-circle-half-stroke"></i>
  </button>

  <!-- Menu -->
  <button onclick="openMenu()" title="Abrir menu">
    <i class="fas fa-bars text-white text-lg"></i>
  </button>
</header>

    <!-- Formulário Principal -->
    <section class="p-6">
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white dark:bg-gray-800 p-6 rounded-lg shadow" id="cadastroForm">
            <input name="nome" placeholder="Nome" type="text" class="border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <input name="numero_container" placeholder="Nº Container" type="text" class="border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <input name="data" type="date" class="border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <button type="button" onclick="salvarPreEmbarque()" class="md:col-span-3 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Salvar</button>
        </form>
    </section>

    <!-- Busca -->
    <section class="px-6">
        <form method="POST" id="form-pesquisa" class="mb-4">
            <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
        </form>
    </section>

    <!-- Edição -->
    <section id="divEditarInspecao" style="display:none;" class="px-6">
        <div class="bg-yellow-100 dark:bg-yellow-200 p-4 rounded shadow">
            <h4 class="font-semibold text-lg mb-2 text-gray-900">Editar Inspeção</h4>
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-900">Nome</label>
                    <input id="editarNome" name="nome" type="text" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-gray-900">Nº Container</label>
                    <input id="editarNumero_container" name="numero_container" type="text" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-gray-900">Data</label>
                    <input id="editarData" name="data" type="date" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <button type="button" onclick="salvarEdicaoPreEmbarque()" class="md:col-span-3 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Salvar</button>
                <button type="button" onclick="fecharDivEdicao()" class="md:col-span-3 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Cancelar</button>
            </form>
        </div>
    </section>

    <!-- Listagem -->
    <section id="containerList" class="p-6"></section>

    <!-- Rodapé -->
    <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400">
        <p id="data-footer"></p>
    </footer>

    <!-- Scripts -->
    <script src="../generalScripts/toastify.js?v=1.7.1"></script>
    <script src="../generalScripts/darkmode.js?v=1.7.1"></script>
    <script src="../mobileMenu/js/mobileMenu.js?v=1.7.1"></script>
    <script src="../generalScripts/version.js?v=1.7.1"></script>
    <script src="../generalScripts/backPage.js?v=1.7.1"></script>
    <script src="./js/preEmbarque.js?v=1.7.1"></script>
    <script src="../pedidos/busca.js?v=1.7.1"></script>
</body>
<script>
    function copiarLink(e) {
        const link = e.dataset.link;
        if (link) {
            navigator.clipboard.writeText(link)
                .then(() => {
                    console.log("Link copiado: " + link);
                    toastifyMessage('Link copiado para área de transferência.')
                })
                .catch(err => {
                    console.error("Erro ao copiar o link: ", err);
                });
        }
    }
</script>

</html>