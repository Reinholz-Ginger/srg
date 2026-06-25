<?php

if (!isset($_SESSION)) {
    session_start();
}

if (getenv('APP_BASE_PATH') === false) {
    $envPath = __DIR__ . '/.env';

    if (is_file($envPath) && is_readable($envPath)) {
        foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
            $linha = trim($linha);

            if ($linha === '' || str_starts_with($linha, '#') || !str_contains($linha, '=')) {
                continue;
            }

            [$chave, $valor] = explode('=', $linha, 2);
            $chave = trim($chave);
            $valor = trim($valor, " \t\n\r\0\x0B\"'");

            if ($chave === 'APP_BASE_PATH') {
                putenv($chave . '=' . $valor);
                $_ENV[$chave] = $valor;
                break;
            }
        }
    }
}

if (!isset($_SESSION['id'])) {
    $basePath = getenv('APP_BASE_PATH') ?: '';
    $basePath = rtrim($basePath, '/');
    $loginPath = ($basePath === '' ? '' : $basePath) . '/index.php';

    if (headers_sent()) {
        echo '<script>window.location.href = ' . json_encode($loginPath) . ';</script>';
        exit;
    }

    header('Location: ' . $loginPath);
    exit;
}
