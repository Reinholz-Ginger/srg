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
    <title>Configurações</title>

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
    <link rel="stylesheet" href="../onLoad/onLoad.css?v=1.7.2">
    <script src="../onLoad/onLoad.js?v=1.7.2"></script>
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
        <h1>Configurações</h1>
  <!-- Toggle Tema -->
  <button onclick="toggleTheme()" title="Alternar tema" class="text-yellow-400 text-lg">
    <i class="fas fa-circle-half-stroke"></i>
  </button>

  <!-- Menu -->
  <button onclick="openMenu()" title="Abrir menu">
    <i class="fas fa-bars text-white text-lg"></i>
  </button>
</header>

<main>
    <button id="btnInstalarApp" disabled class="mt-6 mx-auto block px-6 py-2 rounded bg-gray-400 text-white font-semibold cursor-not-allowed transition disabled:opacity-50 disabled:cursor-not-allowed hover:bg-green-700">
  Instalar Aplicação no Dispositivo
</button>

</main>


    <!-- Rodapé -->
    <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400">
        <p id="data-footer"></p>
    </footer>

    <!-- Scripts -->
    <script src="../generalScripts/toastify.js?v=1.7.2"></script>
    <script src="../generalScripts/darkmode.js?v=1.7.2"></script>
    <script src="../mobileMenu/js/mobileMenu.js?v=1.7.2"></script>
    <script src="../generalScripts/version.js?v=1.7.2"></script>
    <script src="../generalScripts/backPage.js?v=1.7.2"></script>
    <script src="./js/preEmbarque.js?v=1.7.2"></script>
    <script src="../pedidos/busca.js?v=1.7.2"></script>
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
<script>
  let deferredPrompt;

  window.addEventListener('beforeinstallprompt', (e) => {
    // Impede o comportamento automático
    e.preventDefault();
    deferredPrompt = e;

    // Ativa o botão
    const btn = document.getElementById('btnInstalarApp');
    btn.disabled = false;
    btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
    btn.classList.add('bg-green-600', 'hover:bg-green-700', 'cursor-pointer');

    btn.addEventListener('click', () => {
      if (deferredPrompt) {
        deferredPrompt.prompt();

        deferredPrompt.userChoice.then(choiceResult => {
          if (choiceResult.outcome === 'accepted') {
            console.log('Usuário aceitou a instalação');
            toastifyMessage('Aplicativo instalado com sucesso!');
          } else {
            console.log('Usuário recusou a instalação');
            toastifyMessage('Instalação cancelada.');
          }
          deferredPrompt = null;
        });
      }
    });
  });

  // Se clicar no botão antes do evento, avisar
  document.getElementById('btnInstalarApp').addEventListener('click', () => {
    if (!deferredPrompt) {
      toastifyMessage('Instalação não disponível no momento. Tente mais tarde.');
    }
  });

  function toastifyMessage(texto) {
    Toastify({
      text: texto,
      duration: 3000,
      gravity: "bottom",
      position: "center",
      style: {
        background: "#16a34a",
      }
    }).showToast();
  }
</script>

</html>