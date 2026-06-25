<?php
include 'generalPhp/conection.php';

if (isset($_POST['email']) || isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        echo '<div id="errorMsg" class="error-message">Preencha seu E-mail!</div>';
    } else if (strlen($_POST['senha']) == 0) {
        echo '<div id="errorMsg" class="error-message">Preencha sua senha!</div>';
    } else {

        $email = $conn->real_escape_string($_POST['email']);
        $senha = $conn->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE usuario = ? AND senha = ?";
        $stmt = $conn->prepare($sql_code);
        $stmt->bind_param("ss", $email, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        $quantidade = $result->num_rows;

        if ($quantidade == 1) {

            $usuario = $result->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['usuario'];

            header("Location: main.php");
        } else {
            echo '<div id="errorMsg" class="error-message">Falha ao logar!<br> E-mail ou senha incorretos!</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="onLoad/onLoad.css?v=1.7.2">
    <link rel="stylesheet" href="index/root.css?v=1.7.2">
    <link rel="stylesheet" href="index/login.css?v=1.7.2">
    <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
    <link rel="manifest" href="/manifest.json">
    <title>Login</title>
</head>

<body id="body" onload="onLoad()">

    <!-- Preloader -->
    <div class="overflow white" id="preload">
        <div class="circle-line">
            <div class="circle-red">&nbsp;</div>
            <div class="circle-blue">&nbsp;</div>
            <div class="circle-green">&nbsp;</div>
            <div class="circle-yellow">&nbsp;</div>
        </div>
    </div>

    <!-- Formulário de login -->
    <form action="" method="POST">
        <img class="logo" src="assets/logoLogin.png" alt="Reinholz Ginger Logo">
        <h2>LOGIN</h2>
        <div class="inputLogin">
            <div><img src="assets/loginUser.svg" alt=""></div>
            <input type="text" name="email">
        </div>
        <div class="inputLogin">
            <div><img src="assets/passWord.svg" alt=""></div>
            <input type="password" name="senha">
        </div>
        <button type="submit">ENTRAR</button>
        <p id="data-footer"> </p>
    </form>

    <!-- Scripts -->
    <script src="onLoad/onLoad.js?v=1.7.2"></script>
    <script src="generalScripts/version.js?v=1.7.2"></script>

    <!-- Service Worker (agora no lugar certo) -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker
                    .register('service-worker.js?v=1.7.2') // relativo à pasta /srg/
                    .then(reg => console.log('Service Worker registrado com sucesso:', reg.scope))
                    .catch(err => console.error('Erro ao registrar o Service Worker:', err));
            });
        }
    </script>

    <!-- Observador de erro -->
    <script>
        // Função a ser executada quando a div for criada
        function minhaFuncao() {
            appAlert("A div foi criada!", { title: 'Login' });
        }

        // Configurar o observador de mutação
        const targetNode = document.querySelector('form');
        const config = { childList: true };

        const callback = function (mutationsList, observer) {
            for (let mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    const addedNodes = Array.from(mutation.addedNodes);
                    for (const addedNode of addedNodes) {
                        if (addedNode.id === 'errorMsg') {
                            minhaFuncao();
                        }
                    }
                }
            }
        };

        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    </script>

</body>

</html>
