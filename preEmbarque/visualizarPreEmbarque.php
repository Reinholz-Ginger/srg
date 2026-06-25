<?php
include '../generalPhp/conection.php';

$camposPreEmbarque = [
    ["nome" => "Número do container", "tipo" => "foto"],
    ["nome" => "Número do lacre definitivo", "tipo" => "foto"],
    ["nome" => "Número do lacre provisório", "tipo" => "foto"],
    ["nome" => "Número do termógrafo", "tipo" => "foto"],
    ["nome" => "Verificar se o termógrafo está ligado corretamente", "tipo" => "video"],
    ["nome" => "Inserir as horas após ligar o termógrafo", "tipo" => "escrito"],
    ["nome" => "Placa do veículo", "tipo" => "foto"],
    ["nome" => "Hora de chegada do motorista", "tipo" => "escrito"],
    ["nome" => "Hora de saída do motorista", "tipo" => "escrito"],
    ["nome" => "Verificar se há avarias", "tipo" => "video"],
    ["nome" => "Verificar obstruções no dreno do container", "tipo" => "video"],
    ["nome" => "Número de nota fiscal de saída da empresa", "tipo" => "foto"],
    ["nome" => "Número de pedido", "tipo" => "foto"],
];


if (!isset($_GET['id'])) {
    http_response_code(400);
    die("Link inválido.");
}

$id = $_GET['id'];

if (!preg_match('/^[A-Za-z0-9_-]{6,80}$/', $id)) {
    http_response_code(400);
    die("Link inválido.");
}

// Verifica se o registro existe em pre_embarque
$stmt = $conn->prepare("SELECT name, container, data FROM pre_embarque WHERE uniqId = ?");
if (!$stmt) {
    error_log('Erro ao preparar consulta pública de pré-embarque: ' . $conn->error);
    http_response_code(500);
    die("Não foi possível carregar o pré-embarque.");
}
$stmt->bind_param("s", $id);
if (!$stmt->execute()) {
    error_log('Erro ao executar consulta pública de pré-embarque: ' . $stmt->error);
    http_response_code(500);
    die("Não foi possível carregar o pré-embarque.");
}
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die("Pré-embarque não encontrado.");
}

$info = $result->fetch_assoc();
$name = $info['name'];
$container = $info['container'];
$dataEmissao = date("d/m/y", strtotime($info['data']));

// Coleta os dados salvos em pre_embarque_files
$dadosCampos = [];
$stmtCampos = $conn->prepare("SELECT nomeCampo, caminho, resposta FROM pre_embarque_files WHERE uniqId = ? ORDER BY nomeCampo ASC");
if (!$stmtCampos) {
    error_log('Erro ao preparar consulta pública dos arquivos de pré-embarque: ' . $conn->error);
    http_response_code(500);
    die("Não foi possível carregar o pré-embarque.");
}
$stmtCampos->bind_param("s", $id);
if (!$stmtCampos->execute()) {
    error_log('Erro ao executar consulta pública dos arquivos de pré-embarque: ' . $stmtCampos->error);
    http_response_code(500);
    die("Não foi possível carregar o pré-embarque.");
}
$resultCampos = $stmtCampos->get_result();

while ($row = $resultCampos->fetch_assoc()) {
    $nomeCampo = $row['nomeCampo'] ?? '';
    if (trim($nomeCampo) !== '') {
        $dadosCampos[] = [
            'nomeCampo' => $nomeCampo,
            'caminho' => $row['caminho'] ?? '',
            'resposta' => $row['resposta'] ?? ''
        ];
    }
}

usort($dadosCampos, function ($a, $b) {
    preg_match('/\d+$/', $a['nomeCampo'], $numA);
    preg_match('/\d+$/', $b['nomeCampo'], $numB);
    return (int)$numA[0] <=> (int)$numB[0];
});
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização do Pré-Embarque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../assets/favicon.svg" type="image/png">
</head>


<body class="bg-white text-gray-900 p-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="border border-gray-300 rounded-lg p-4 flex items-start justify-between">
            <div class="flex items-start gap-4">
                <img src="../assets/logoLogin.png" alt="Logo" class="w-20 h-20 object-contain">
                <div class="text-sm">
                    <h2 class="font-bold text-base">REINHOLZ GINGER COMERCIO DE RAIZES LTDA</h2>
                    <p>50.688.819/0001-61</p>
                    <p>AE ZONA RURAL, S/N GALO - DOMINGOS MARTINS ES - CEP:29260-000</p>
                    <p>reinholzginger0@outlook.com</p>
                </div>
            </div>
            <div class="text-sm text-right">
                <p><strong>Container:</strong> <?= htmlspecialchars($container) ?></p>
                <p><strong>Cliente:</strong> <?= htmlspecialchars($name) ?></p>
                <p><strong>Emissão:</strong> <?= $dataEmissao ?></p>
            </div>
        </div>
       <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
<?php
foreach ($camposPreEmbarque as $index => $campoReferencia) {
    $nomeCampoBanco = 'campo_' . $index;
    $nomeReal = $campoReferencia['nome'];

    // Busca no array de dados pelo campo correspondente
    $dado = array_filter($dadosCampos, function ($dado) use ($nomeCampoBanco) {
        return $dado['nomeCampo'] === $nomeCampoBanco;
    });
    $dado = reset($dado);

    echo '<div class="border border-gray-300 rounded-lg p-4 shadow">';
    echo '<h2 class="font-semibold text-lg mb-2">' . htmlspecialchars($nomeReal) . '</h2>';

    if ($dado) {
        $ext = strtolower(pathinfo($dado['caminho'], PATHINFO_EXTENSION));
        if (!empty($dado['caminho'])) {
            $caminho = str_replace('\\', '/', $dado['caminho']);
            $caminho = ltrim($caminho, '/');
            $caminhoSeguro = './listarPreembarque/' . $caminho;

            if (str_contains($caminho, '..')) {
                $caminhoSeguro = '';
            }

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                if ($caminhoSeguro !== '') {
                    echo "<img src='" . htmlspecialchars($caminhoSeguro, ENT_QUOTES, 'UTF-8') . "' alt='Imagem' class='w-full rounded mb-2'>";
                }
            } elseif (in_array($ext, ['mp4', 'webm'])) {
                if ($caminhoSeguro !== '') {
                    echo "<video src='" . htmlspecialchars($caminhoSeguro, ENT_QUOTES, 'UTF-8') . "' controls class='w-full rounded mb-2'></video>";
                }
            }
        }
        if (!empty($dado['resposta'])) {
            echo "<p class='text-gray-700'><strong>Resposta:</strong> " . htmlspecialchars($dado['resposta']) . "</p>";
        }
    } else {
        echo '<p class="text-gray-500 italic">Campo não preenchido.</p>';
    }

    echo '</div>';
}
?>
</div>



    </div>
    </div>

        <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400 print:hidden">
        <a target="_blank" href="https://lucasrd.site">
            <p id="data-footer"></p>
        </a>
    </footer>
</body>
<script src="../generalScripts/version.js"></script>
</html>
