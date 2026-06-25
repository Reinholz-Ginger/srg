<?php
include '../generalPhp/conection.php';
include '../protect.php';


// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the 'id' value from the URL
    $id = $_GET['id'];

    // Create a SQL query to fetch the data for the specified 'id'
    $sql = "SELECT * FROM pedidos_dados WHERE chaveAcesso = '$id'";
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT * FROM pedidoscadastro WHERE chaveAcesso ='$id'";
    $resultSql1 = mysqli_query($conn, $sql1);

    if ($resultSql1 && $resultSql1->num_rows != 0) {
        while ($row = mysqli_fetch_assoc($resultSql1)) {
            $valorTotalSalvoPedido = $row['valor_total'];
            $dataAtual = $row['dataAtual'];
            $idPedido = $row['id'];
            $nomeCliente = $row['cliente'];


        }
    }

    // esse array recebe os  dados das etiquetas que serão impressas 


    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="nofollow,noindex">
        <link rel="stylesheet" href="../index/root.css">
        <link rel="stylesheet" href="../onLoad/onLoad.css">
        <link rel="stylesheet" href="../mobileMenu/css/mobileMenu.css">
        <link rel="stylesheet" href="../pedidos/print.css">
        <link rel="stylesheet" href="../pedidos/paginaetiquetas.css">

        <link rel="shortcut icon" href="../assets/favicon.svg" type="image/x-icon">
        <title><?php echo $nomeCliente ?> N&deg; <?php echo $idPedido ?></title>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    </head>
    <script src="../onLoad/onLoad.js"></script>


    <div class="overflow white" id="preload">
        <div class="circle-line">
            <div class="circle-red">&nbsp;</div>
            <div class="circle-blue">&nbsp;</div>
            <div class="circle-green">&nbsp;</div>
            <div class="circle-yellow">&nbsp;</div>
        </div>
    </div>


    <body id="body" onload="onLoad()">



<section id="containerBody" class="containerBody">
    
    
            <header>
    
                <div class="logoGinger">
                    <img src="../assets/logoLogin.png" alt="Logo Reinholz Ginger">
                </div>
    
                <div class="dadosEmpresa">
                    <p id="nomeEmpresa">REINHOLZ GINGER COMERCIO DE RAIZES LTDA</p>
                    <p> <img src="../assets/cnpj.svg"> 50.688.819/0001-61</p>
                    <p> <img src="../assets/local.svg"> AE ZONA RURAL, S/N GALO-DOMINGOS MARTINS ES- CEP:29260-000</p>
                    <p><img src="../assets/email.svg"> reinholzginger0@outlook.com</p>
                </div>
    
                <div class="dadosPedidos">
                    <div> N&deg; PEDIDO <STRONg> <?php echo $idPedido ?></STRONg></div>
                    <div> EMISSÃO: <strong><?php echo date('d/m/y', strtotime($dataAtual)) ?></strong></div>
                </div>
    
    
            </header>
    
    
            <section class="cliente">
                <p> <strong> CLIENTE: </strong> <?php echo $nomeCliente ?> </p>
    
            </section>
    
            <div class="containerList">
    
                <table>
    
                    <tr>
                        <th class="tableFornecedor">Fornecedor</th>
                        <th class="tableProduto">Produto</th>
                        <th class="tableQuantidade">Quant</th>
                        <th class="tableValorUnit">Unidade</th>
                        <th class="tableValorTotal">Total</th>
                    </tr>
    
                    <?php
    
                    $dadosEtiquetas = array();
    
                    // Check if the query was successful and data was found
                    if ($result && $result->num_rows != 0) {
    
                        $somaQuantidadeTotal = 0;
    
                        while ($row = mysqli_fetch_assoc($result)) {
                            $fornecedor = $row['fornecedor'];
                            $quantidade = $row['quantidade'];
                            $valor_unit = $row['valor_unit'];
                            $valor_total = $row['valor_total'];
                            $produto = $row['produto'];
                            $idItem = $row['id'];
                            $numeroProdutor = preg_replace('/[^0-9]/', '', $row['fornecedorNumero']);
                            $chaveAcesso = $row['chaveAcesso'];

                                

                            $stmtSoma = $conn->prepare('SELECT  SUM(valor_total) AS total FROM pedidos_dados WHERE chaveAcesso = ? ');
                            $stmtSoma->bind_param('s',$chaveAcesso);
                            if($stmtSoma->execute()){
                                $resultSoma = $stmtSoma->get_result();
                                $row1 = $resultSoma->fetch_assoc();
                                $somaTotalValor = $row1['total'] ?? 0;
                            }

    
    
                            $somaQuantidadeTotal += $quantidade;
                            $dadosEtiquetas[] = array(
                                'numero' => $numeroProdutor,
                                'quantidade' => $quantidade,
                            );
    
                            echo '<tr class="itensPedido">
                                <td class="tableFornecedor">' . strtolower($fornecedor) . '</th>
                                <td class="tableProduto">' . strtolower($produto) . '</td>
                                <td class="tableQuantidade">' . $quantidade . '</td>
                                <td class="tableValorUnit">' . number_format($valor_unit / 100, 2, ",", ".") . '</td>
                                <td class="tableValorTotal">' . number_format($valor_total / 100, 2, ",", ".") . '</td>
                                </tr>';
    
                        }
                                    } else {
                                        echo 'Registro n�o encontrado!';
                                    }
                    } else {
                        echo 'ID n�o fornecido na URL!';
                    }
    
                    
        ?>
    
            </table>
    
    
        </div>
    
        <div class="botoes">
            <button title="Imprimir Página" onclick="imprimirPagina()"><img style="width:30px;"
                    src="../assets/printwhite.svg" alt=""></button><br>
            <button title="Imprimir Etiquetas" onclick="imprimirEtiquetas()"><img style="width:30px;fill:white;"
                    src="../assets/file_white.svg" alt=""></button><br>
            <button title="Página Anterior" onclick="backPage()"><img src="../assets/backArrow.svg" alt=""></button><br>
    
        </div>
        <div id="containerValoresFinais" class="containerValoresFinais">
            <div id="containerInternoValoresFinais" class="containerInternoValoresFinais">
                <div id="" class="headValores">
                    <p>Quantidade de caixas: <strong><?php echo $somaQuantidadeTotal ?></strong></p>
                </div>
                <div id="" class="headValores">
                    <p>Valor Total :<strong> R$
                            <?php echo number_format($somaTotalValor / 100, 2, ",", "."); ?></strong></p>
                </div>
            </div>
        </div>
    
        <div class="assinaturas">
            <div class="data">
                <p>Data</p>
            </div>
            <div class="assCliente">
                <p>Assinatura Cliente</p>
            </div>
            <div class="assTecnico">
                <p>Assinatura do Técnico Responsável</p>
            </div>
        </div>
    
        <footer>
            <p id="data-footer"> </p>
        </footer>
    
    
        </script>
</section>



<section id="containerEtiquetas" class="containerEtiquetas">
    <?php

    // Quantidade máxima de divs por página
    $maxDivsPerPage = 96;

    // Quantidade de números adicionais por número existente
    $numerosAdicionais = 5;

    // Variáveis para controlar a quantidade de divs e páginas
    $currentDivCount = 0;
    $pageCount = 1;

    echo "<section class='paginaEtiquetas' id='page-$pageCount'>";

    foreach ($dadosEtiquetas as $item) {
        $numero = $item['numero'];
        $quantidade = intval($item['quantidade']);

        // Incluir quantidade atual + números adicionais
        $quantidadeTotal = $quantidade + $numerosAdicionais;

        for ($i = 0; $i < $quantidadeTotal; $i++) {
            if ($currentDivCount >= $maxDivsPerPage) {
                // Fecha a seção atual e abre uma nova
                echo "</section>";
                $pageCount++;
                echo "<section class='paginaEtiquetas' id='page-$pageCount'>";
                $currentDivCount = 0;
            }

            // Cria a div com o número (para os números adicionais, subtrai o índice do número original)
            if ($i < $quantidade) {
                echo "<div class='cardNumber'>$numero</div>";
            } else {
                echo "<div class='cardNumber'>$numero</div>"; // Divs em branco para os números adicionais
            }
            $currentDivCount++;
        }
    }

    // Preencher a última página com divs em branco, se necessário
    while ($currentDivCount < $maxDivsPerPage) {
        echo "<div class='cardNumber'></div>";
        $currentDivCount++;
    }

    echo "</section>";
    ?>
</section>

</body>




<script src="../mobileMenu/js/mobileMenu.js"></script>

<script src="../generalScripts/version.js"></script>

<script src="../generalScripts/backPage.js"></script>


<script src="../generalScripts/print.js"></script>
<script src="../generalScripts/backPage.js"></script>




</html>
