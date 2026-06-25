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

            if ($linha === '' || strpos($linha, '#') === 0 || strpos($linha, '=') === false) {
                continue;
            }

            [$chave, $valor] = explode('=', $linha, 2);
            $chave = trim($chave);
            $valor = trim($valor);

            if (
                (substr($valor, 0, 1) === '"' && substr($valor, -1) === '"') ||
                (substr($valor, 0, 1) === "'" && substr($valor, -1) === "'")
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
    error_log(sprintf(
        'Erro de conexão com o banco: %s | host=%s port=%s db=%s user=%s',
        $conn->connect_error,
        $serverName,
        $port,
        $dbname,
        $username
    ));
    http_response_code(500);
    die('Não foi possível conectar ao banco de dados.');
}

$conn->set_charset('utf8mb4');
