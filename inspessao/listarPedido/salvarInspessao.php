<?php
include '../../generalPhp/conection.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));
}

if (isset($_GET['id']) && isset($_GET['numero']) && isset($_GET['cliente'])) {
    $id = $_GET['id'];
    $numero = $_GET['numero'];
    $cliente = $_GET['cliente'];
    $numero_container = $_GET['numero_container'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM inspecao WHERE chaveAcesso = ?");
    $stmt->bind_param("s", $id);

    if (!$stmt->execute()) {
        error_log('Erro ao carregar itens da inspeção: ' . $stmt->error);
        http_response_code(500);
        die("Não foi possível carregar a inspeção.");
    }

    $result = $stmt->get_result();
} else {
    header("Location:../cadastro.php");
    exit;
}

$numeroSeguro = htmlspecialchars($numero, ENT_QUOTES, 'UTF-8');
$clienteSeguro = htmlspecialchars($cliente, ENT_QUOTES, 'UTF-8');
$containerSeguro = htmlspecialchars($numero_container, ENT_QUOTES, 'UTF-8');
$printUrl = '../listarPedido/print/printInspessao.php?id=' . urlencode($id)
    . '&numero=' . urlencode($numero)
    . '&cliente=' . urlencode($cliente)
    . '&numero_container=' . urlencode($numero_container);
?>

<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow,noindex">
    <link rel="stylesheet" href="../../index/root.css">
    <link rel="stylesheet" href="../../onLoad/onLoad.css">
    <link rel="stylesheet" href="../../mobileMenu/css/mobileMenu.css">
    <link rel="stylesheet" href="salvarInspessao.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
    </script>
    <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
    <title>Inspeção</title>
    <script src="../../onLoad/onLoad.js"></script>
</head>

<body id="body" class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans" onload="onLoad()">
    <div class="overflow white" id="preload">
        <div class="circle-line">
            <div class="circle-red">&nbsp;</div>
            <div class="circle-blue">&nbsp;</div>
            <div class="circle-green">&nbsp;</div>
            <div class="circle-yellow">&nbsp;</div>
        </div>
    </div>

    <div id="loadingScreen" class="fixed inset-0 z-[9999999999] flex items-center justify-center bg-white/80 dark:bg-gray-950/80 hidden">
        <div class="rounded-lg bg-white dark:bg-gray-800 px-6 py-4 text-gray-800 dark:text-gray-100 shadow-lg font-semibold">Salvando...</div>
    </div>

    <div style="z-index:9999999999;" id="mobileMenu" class="mobileMenuContainer">
        <button style="width: 50px;" onclick="openMenu()" id="mobileMenuButtonClose" class="mobileMenuButtonClose">
            <img style="width:35px" src="../../assets/x.svg" alt="Fechar menu">
        </button>
        <div class="mobileMenuButtons">
            <a href="../../main.php">
                <div class="menuButtonsMobile">
                    <button class="categorieButtonMobile">
                        <div class="divImgCategorieButtonMobile"><img style="width:20px" src="../../assets/mobileIcons/icon _home_.svg" alt=""></div>
                        <div class="divNameCategorieButtonMobile"><h2>INÍCIO</h2></div>
                    </button>
                </div>
            </a>
            <a href="../../cadastros/cadastros.php">
                <div class="menuButtonsMobile">
                    <button class="categorieButtonMobile">
                        <div class="divImgCategorieButtonMobile"><img style="width:20px" src="../../assets/mobileIcons/icon _book_-1.svg" alt=""></div>
                        <div class="divNameCategorieButtonMobile"><h2>CADASTROS</h2></div>
                    </button>
                </div>
            </a>
            <a href="../../pedidos/cadastrodepedidos.php">
                <div class="menuButtonsMobile">
                    <button class="categorieButtonMobile">
                        <div class="divImgCategorieButtonMobile"><img style="width:20px" src="../../assets/mobileIcons/icon _list_-1.svg" alt=""></div>
                        <div class="divNameCategorieButtonMobile"><h2>PEDIDOS</h2></div>
                    </button>
                </div>
            </a>
            <a href="../../relatorios/relatorios.php">
                <div class="menuButtonsMobile">
                    <button class="categorieButtonMobile">
                        <div class="divImgCategorieButtonMobile"><img style="width:20px" src="../../assets/mobileIcons/icon _pie chart_-1.svg" alt=""></div>
                        <div class="divNameCategorieButtonMobile"><h2>RELATÓRIOS</h2></div>
                    </button>
                </div>
            </a>
            <a href="../../inspessao/cadastro.php">
                <div class="menuButtonsMobile">
                    <button class="categorieButtonMobile">
                        <div class="divImgCategorieButtonMobile"><img style="width:20px" src="../../assets/mobileIcons/icon _magnifying glass_-1.svg" alt=""></div>
                        <div class="divNameCategorieButtonMobile"><h2>INSPEÇÃO</h2></div>
                    </button>
                </div>
            </a>
            <a href="../../packingList/cadastropackinglist.php">
                <div class="menuButtonsMobile">
                    <button class="categorieButtonMobile">
                        <div class="divImgCategorieButtonMobile"><img style="width:20px" src="../../assets/mobileIcons/icon _check_-1.svg" alt=""></div>
                        <div class="divNameCategorieButtonMobile"><h2>PACKING LIST</h2></div>
                    </button>
                </div>
            </a>
        </div>
    </div>

    <header class="inspectionHeader">
        <div class="headerInner">
            <a href="../cadastro.php" id="backButton" class="iconAction backButton" title="Voltar">
                <img src="../../assets/backArrow.svg" alt="Voltar">
            </a>

            <div class="headerTitle">
                <img src="../../assets/categories/inspessao.svg" alt="">
                <div>
                    <p>Inspeção Nº <?= $numeroSeguro ?></p>
                    <h1><?= $clienteSeguro ?></h1>
                    <span>Container <?= $containerSeguro ?></span>
                </div>
            </div>

            <div class="headerActions">
                <a href="<?= htmlspecialchars($printUrl, ENT_QUOTES, 'UTF-8') ?>" class="iconAction" title="Imprimir">
                    <img src="../../assets/print.svg" alt="Imprimir">
                </a>
                <button type="button" onclick="openMenu()" id="mobileMenuButton" class="iconAction mobileMenuButton" title="Abrir menu">
                    <img src="../../assets/menu_mobile.svg" alt="Menu">
                </button>
            </div>
        </div>
    </header>

    <main class="inspectionMain">
        <form class="inputSearchHeaderInspecao" id="form-pesquisa2" action="">
            <input id="chaveAcesso" type="hidden" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
            <select name="fornecedor" id="fornecedor" aria-label="Fornecedor">
                <?php
                $stmtFornecedores = $conn->prepare("SELECT nome FROM fornecedores ORDER BY nome ASC");
                $stmtFornecedores->execute();
                $resultFornecedores = $stmtFornecedores->get_result();

                if ($resultFornecedores && $resultFornecedores->num_rows != 0) {
                    while ($rowFornecedor = mysqli_fetch_assoc($resultFornecedores)) {
                        $fornecedorOption = $rowFornecedor['nome'];
                        echo '<option value="' . htmlspecialchars($fornecedorOption, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars(strtoupper($fornecedorOption), ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                }
                ?>
            </select>
            <button type="button" class="buttonAdicionarProdutor" onclick="adicionarProdutor()">Adicionar Produtor</button>
        </form>

        <section id="containerList" class="containerList">
            <?php
            if ($result && $result->num_rows != 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $fornecedor = $row['fornecedor'];
                    $id_item = $row['id'];
                    $numeroFornecedor = '';

                    $stmt1 = $conn->prepare("SELECT numero FROM fornecedores WHERE nome = ?");
                    $stmt1->bind_param("s", $fornecedor);
                    $stmt1->execute();
                    $resultado = $stmt1->get_result();

                    if ($resultado->num_rows > 0) {
                        $rowNumero = $resultado->fetch_assoc();
                        $numeroFornecedor = $rowNumero['numero'];
                    }

                    $fornecedorSeguro = htmlspecialchars($fornecedor, ENT_QUOTES, 'UTF-8');
                    $numeroFornecedorSeguro = htmlspecialchars($numeroFornecedor, ENT_QUOTES, 'UTF-8');
                    $idItemSeguro = htmlspecialchars($id_item, ENT_QUOTES, 'UTF-8');

                    echo '
                    <form class="formImgens" action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="dadosFornecedor">
                            <div>
                                <span class="forncedorNum">N° ' . $numeroFornecedorSeguro . '</span>
                                <strong class="nomeFornecedor">' . $fornecedorSeguro . '</strong>
                            </div>
                            <button type="button" class="deleteFornecedorButton" onclick="deleteProdutorInspecao(' . (int) $id_item . ')" title="Remover produtor">
                                <img src="../../assets/delete.svg" alt="Remover">
                            </button>
                        </div>
                        <div class="inputContainer">';

                    $stmt0 = $conn->prepare("SELECT * FROM imagens WHERE id_item = ?");
                    $stmt0->bind_param("i", $id_item);
                    $stmt0->execute();
                    $resultado0 = $stmt0->get_result();

                    if ($resultado0 && $resultado0->num_rows != 0) {
                        while ($rows0 = mysqli_fetch_assoc($resultado0)) {
                            $path = $rows0['pathImagem'];
                            $id_image = $rows0['id'];
                            $pathHD = '';

                            $stmtHD = $conn->prepare("SELECT pathImagem FROM imagensalta WHERE id = ?");

                            if ($stmtHD) {
                                $stmtHD->bind_param("s", $id_image);
                                $stmtHD->execute();
                                $resultadoHD = $stmtHD->get_result();

                                if ($resultadoHD && $resultadoHD->num_rows != 0) {
                                    $rows1 = mysqli_fetch_assoc($resultadoHD);
                                    $pathHD = $rows1['pathImagem'];
                                }
                            } else {
                                echo '<script>console.error("Erro ao preparar consulta da imagem HD:", ' . json_encode($conn->error) . ');</script>';
                            }

                            if ($pathHD === '') {
                                echo '<script>console.warn("Imagem sem registro HD correspondente:", ' . json_encode(array('id' => $id_image, 'thumbnail' => $path)) . ');</script>';
                            }

                            echo '
                            <div id="' . htmlspecialchars($id_image, ENT_QUOTES, 'UTF-8') . 'thumb" class="thumbnailImageLoaded">
                                <button type="button" class="apagarImagem" onclick="apagarImagem(\'' . htmlspecialchars($id_image, ENT_QUOTES, 'UTF-8') . '\')" title="Apagar imagem"><img src="../../assets/erase1.svg" alt="Apagar"></button>
                                <div class="buttonUploadImg"> <img src="' . htmlspecialchars($path, ENT_QUOTES, 'UTF-8') . '" alt="Imagem da inspeção"> </div>
                                <input id="' . htmlspecialchars($id_image, ENT_QUOTES, 'UTF-8') . 'inputThumb" type="hidden" value="' . htmlspecialchars($path, ENT_QUOTES, 'UTF-8') . '">
                                <input id="' . htmlspecialchars($id_image, ENT_QUOTES, 'UTF-8') . 'input" type="hidden" value="' . htmlspecialchars($pathHD, ENT_QUOTES, 'UTF-8') . '">
                            </div>';
                        }
                    }

                    echo '
                            <div class="inputThumbnail">
                                <input type="file" accept="image/*" capture="environment" id="' . $idItemSeguro . '" onchange="enviarImagem(this)">
                                <button type="button" class="buttonUploadImg uploadButton" onclick="teste(\'' . $idItemSeguro . '\')" title="Adicionar imagem">
                                    <img src="../../assets/photo.svg" alt="Adicionar imagem">
                                    <span>Foto</span>
                                </button>
                            </div>
                        </div>
                    </form>';
                }
            } else {
                echo '
                <div class="emptyState">
                    <img src="../../assets/categories/inspessao.svg" alt="">
                    <h2>Nenhum produtor adicionado</h2>
                    <p>Selecione um fornecedor acima para começar a anexar imagens nesta inspeção.</p>
                </div>';
            }
            ?>
        </section>
    </main>

    <footer>
        <p id="data-footer"></p>
    </footer>

    <script src="../../mobileMenu/js/mobileMenu.js"></script>
    <script src="../../generalScripts/version.js"></script>
    <script src="../../generalScripts/backPage.js"></script>
    <script src="upload.js"></script>
    <script src="apagarImg.js"></script>
    <script src="abrirImgHD.js"></script>
    <script>
        function reload() {
            window.location.reload();
        }

        function teste(id) {
            document.getElementById(id).click();
            console.log(id);
        }

        let adicionarProdutor = () => {
            let chaveAcesso = document.getElementById('chaveAcesso').value;
            let fornecedor = document.getElementById('fornecedor').value;
            let formData = new FormData();

            formData.append('chaveAcesso', chaveAcesso);
            formData.append('fornecedor', fornecedor);

            fetch('adicionarProdutor.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(async data => {
                await appAlert(data, { title: 'Produtor da inspeção' });
                window.location.reload();
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        };

        let deleteProdutorInspecao = (id) => {
            let formData = new FormData();
            formData.append('idItem', id);

            fetch('deletarProdutorInspecao.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                window.location.reload();
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        };
    </script>
</body>

</html>
