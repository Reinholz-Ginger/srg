<?php
include '../../../generalPhp/conection.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));

}

// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $numero = $_GET['numero'];
    $cliente = $_GET['cliente'];
    $container = $_GET['numero_container'];

 
    $stmt = $conn->prepare("SELECT * FROM inspecoes WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt2 = $conn->prepare("SELECT * FROM inspecao WHERE chaveAcesso = ?");
    $stmt2->bind_param("s", $id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow,noindex">
    <link rel="stylesheet" href="../../../index/root.css?v=1.7.0">
    <link rel="stylesheet" href="../../../onLoad/onLoad.css?v=1.7.0">
    <link rel="stylesheet" href="../../../mobileMenu/css/mobileMenu.css?v=1.7.0">
    <link rel="stylesheet" href="printInspessao.css?v=1.7.0">

    <link rel="shortcut icon" href="../../../assets/favicon.svg" type="image/x-icon">
    <title>Inspeção</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>
<script src="../../../onLoad/onLoad.js?v=1.7.0"></script>




<div class="overflow white" id="preload">
    <div class="circle-line">
        <div class="circle-red">&nbsp;</div>
        <div class="circle-blue">&nbsp;</div>
        <div class="circle-green">&nbsp;</div>
        <div class="circle-yellow">&nbsp;</div><br>

    </div>
    <p class="carregandoImagens"><strong>Carregando Imagens...</strong></p>
</div>


<div class="botoes">
    <button onclick="imprimirPaginaSimples()"><img style="width:30px;" src="../../../assets/printwhite.svg"
            alt=""></button><br>
    <button id="downLoadButton" onclick="downloadAllImages()"><img src="../../../assets/arowDown.svg" alt=""></button><br>
    <button onclick="backPage()"><img src="../../../assets/backArrow.svg" alt=""></button><br>
</div>

<body id="body" onload="onLoad()">

    <!--Menu mobile   -->


    <section class="headerPrint">

        <div class="logoGinger">
            <img src="../../../assets/logoLogin.png" alt="Logo Reinholz Ginger">
        </div>

        <div class="dadosEmpresa">
            <p id="nomeEmpresa">REINHOLZ GINGER COMERCIO DE RAIZES LTDA</p>
            <p> <img src="../../../assets/cnpj.svg"> 50.688.819/0001-61</p>
            <p> <img src="../../../assets/local.svg"> AE ZONA RURAL, S/N GALO-DOMINGOS MARTINS ES- CEP:29260-000</p>
            <p><img src="../../../assets/email.svg"> reinholzginger0@outlook.com</p>
        </div>

        <!-- <div class="dadosPedidos">
        <div> N&deg; PEDIDO <STRONg> <?php echo $idPedido ?></STRONg></div>
            <div> EMISSÃO: <strong><?php echo date('d/m/y', strtotime($dataAtual)) ?></strong></div>
            </div> -->


    </section>

    <header>
        <div class="cabecalhoNome">
            <H3> N°
                <?php echo $numero.'|'; ?>
                <?php echo'Container'. $container.'|'; ?>
                <?php echo $cliente; ?> | DATA
                <?php echo date("d/m/y") ?>
            </H3>
         <input id="numeroPedidoParadownload" type="hidden"  value="<?php echo $numero.'-'.$cliente; ?>">
        </div>

    </header>


    <div class="containerList">

        <?php
        if ($result2 && $result2->num_rows != 0) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $fornecedor = $row['fornecedor'];
                $id_item = $row['id'];

                $stmt1 = $conn->prepare("SELECT numero FROM fornecedores WHERE nome = ?");
                $stmt1->bind_param("s", $fornecedor);
                $stmt1->execute();
                $resultado = $stmt1->get_result();

                if ($resultado->num_rows > 0) {
                    $row = $resultado->fetch_assoc();
                    $numero = $row['numero'];
                }

                echo ' 
                    <form class="formImgens" action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="dadosFornecedor">
                            <div class="forncedorNum">N° ' . $numero . '</div>
                            <div class="nomeFornecedor"> ' . $fornecedor . '</div>
                        </div>
                        <div class="inputContainer">';

                // Listar registros de imagens para esse pedido 
                $stmt0 = $conn->prepare("SELECT * FROM imagens WHERE id_item = ?");
                $stmt0->bind_param("i", $id_item);
                $stmt0->execute();
                $resultado0 = $stmt0->get_result();

                if ($resultado0 && $resultado0->num_rows != 0) {
                    while ($rows0 = mysqli_fetch_assoc($resultado0)) {
                        $path = $rows0['pathImagem'];
                        $id_image = $rows0['id'];

                        $slq2 = "SELECT pathimagem FROM imagensalta WHERE id = '$id_image' ";
                        $resultadoSql2 = mysqli_query($conn, $slq2);

                        if ($resultadoSql2 && $resultadoSql2->num_rows != 0) {
                            $rows1 = mysqli_fetch_assoc($resultadoSql2);
                            $pathHD = $rows1['pathimagem'];

                            echo '
                                <div id="' . $pathHD . 'thumb" class="thumbnailImageLoaded">
                                   
                                    <div class="buttonUploadImg"  > <img src="../' . $pathHD . '"> </div>
                                    <input id="' . $pathHD . 'inputThumb"  type="hidden" value="' . $path . '">
                                    <input id="' . $pathHD . 'input"  type="hidden" value="' . $pathHD . '">

                                       
                                </div>

                                
                                ';
                        }
                    }
                } else {
                    echo "";
                }

                echo '
                        
                            
                        </div>
                    </form>';


            }
        }

        ?>

    </div>

    <footer>
        <p id="data-footer"> </p>
    </footer>

</body>

</html>



<script src="../../../generalScripts/version.js?v=1.7.0"></script>

<script src="../../generalScripts/backPage.js?v=1.7.0"></script>
<script src="../../../generalScripts/print.js?v=1.7.0"></script>
<script src="../../../generalScripts/backPage.js?v=1.7.0"></script>



<script>
    window.onafterprint = function () {
        //  window.history.back()
    };

    
function imprimirPaginaSimples(){


window.print()

}
</script>


<!-- Biblioteca que gera o zip  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>

<script>

let numeroPedidoParadownload = document.getElementById('numeroPedidoParadownload').value

function convertImageToDataUrl(img) {
    return new Promise(function(resolve) {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        canvas.width = img.naturalWidth;
        canvas.height = img.naturalHeight;
        ctx.drawImage(img, 0, 0);
        resolve(canvas.toDataURL('image/png'));
    });
}

function downloadAllImages() {
    var divs = document.querySelectorAll('.buttonUploadImg');
    var zip = new JSZip();

    divs.forEach(function(div, index) {
        var imagem = div.querySelector('img');
        var nomeFornecedor = div.closest('.formImgens').querySelector('.nomeFornecedor').innerText.trim();
        var filename = nomeFornecedor + '_imagem_' + index + '.png';

        convertImageToDataUrl(imagem)
            .then(function(dataUrl) {
                // Adiciona a imagem ao zip com o nome do arquivo
                zip.file(filename, dataUrl.split(',')[1], { base64: true });
                
                // Se for a última imagem, cria e faz o download do arquivo zip
                if (index === divs.length - 1) {
                    zip.generateAsync({ type: 'blob' }).then(function(content) {
                        var link = document.createElement('a');
                        link.href = URL.createObjectURL(content);
                        link.download ='Pedido'+numeroPedidoParadownload+'.zip';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });
                }
            });
    });
}
</script>
