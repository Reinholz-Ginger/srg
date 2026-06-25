<?php

if (!function_exists('carregarEnv')) {
    function carregarEnv($path)
    {
        if (!is_file($path) || !is_readable($path)) {
            return;
        }

        $linhas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($linhas as $linha) {
            $linha = trim($linha);

            if ($linha === '' || str_starts_with($linha, '#') || !str_contains($linha, '=')) {
                continue;
            }

            [$chave, $valor] = explode('=', $linha, 2);
            $chave = trim($chave);
            $valor = trim($valor);

            if (
                (str_starts_with($valor, '"') && str_ends_with($valor, '"')) ||
                (str_starts_with($valor, "'") && str_ends_with($valor, "'"))
            ) {
                $valor = substr($valor, 1, -1);
            }

            if ($chave !== '' && getenv($chave) === false) {
                putenv($chave . '=' . $valor);
                $_ENV[$chave] = $valor;
            }
        }
    }
}

carregarEnv(dirname(__DIR__) . '/.env');

$serverName = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'root';
$dbname = getenv('DB_NAME') ?: 'reinholzGingerSystem';
$port = (int) (getenv('DB_PORT') ?: 3306);

$conn = new mysqli($serverName, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    error_log('Erro de conexão com o banco: ' . $conn->connect_error);
    http_response_code(500);
    die('Não foi possível conectar ao banco de dados.');
}

$conn->set_charset('utf8mb4');
