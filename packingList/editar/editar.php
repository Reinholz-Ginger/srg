<?php
include '../../generalPhp/conection.php';
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    die( header("Location: ../../index.php"));
   
}

// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the 'id' value from the URL
    $id = $_GET['id'];
    $numeroContainer = $_GET['numero_container'];
    $nome = $_GET['cliente'];
    $numero = $_GET['numero'];

    // Create a SQL query to fetch the data for the specified 'id'
    $sql = "SELECT * FROM pedidos_dados WHERE chaveAcesso = '$id'";
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT * FROM listpack WHERE id ='$id'";
    $resultSql1 = mysqli_query($conn,$sql1);

    if($resultSql1 && $resultSql1->num_rows !=0){
        while($row = mysqli_fetch_assoc($resultSql1)){
            // $valorTotalSalvoPedido = $row['valor_total'];
            $cliente = $row['nome'];
            $dataDoPedido = $row['data_packingList'];
            $idPedido = $row['id'];
        }
    }

    // converte a data para formato brasil 
    $dataOriginal = $dataDoPedido; // Data no formato "aaaa-mm-dd"

    // Converter a data para um objeto DateTime
    $dataConvertida = date_create_from_format('Y-m-d', $dataOriginal);
    
    if ($dataConvertida !== false) {
        // Formatar a data no formato desejado (dd/mm/aa)
        $dataFormatada = date_format($dataConvertida, 'd/m/y');
        
    } 


?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow,noindex">
    <link rel="stylesheet" href="../../index/root.css?v=1.7.0">
    <link rel="stylesheet" href="../../onLoad/onLoad.css?v=1.7.0">
    <link rel="stylesheet" href="../../mobileMenu/css/mobileMenu.css?v=1.7.0">
    <link rel="stylesheet" href="cadastro.css?v=1.7.0">
    <link rel="stylesheet" href="print.css?v=1.7.0">
    <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
    <title>Packing List</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>
<script src="../../onLoad/onLoad.js?v=1.7.0"></script>




<div class="overflow white" id="preload">
    <div class="circle-line">
        <div class="circle-red">&nbsp;</div>
        <div class="circle-blue">&nbsp;</div>
        <div class="circle-green">&nbsp;</div>
        <div class="circle-yellow">&nbsp;</div>
    </div>
</div>




<body id="body" onload="onLoad()">

    <section class="headerPrint" >

    <div class="logoGinger">
        <img src="../../assets/logoLogin.png" alt="Logo Reinholz Ginger">
    </div>

    <div class="dadosEmpresa">
        <p id="nomeEmpresa">REINHOLZ GINGER COMERCIO DE RAIZES LTDA</p>
        <p> <img src="../../assets/cnpj.svg"> 50.688.819/0001-61</p>
        <p> <img src="../../assets/local.svg"> AE ZONA RURAL, S/N GALO-DOMINGOS MARTINS ES- CEP:29260-000</p>
        <p><img src="../../assets/email.svg"> reinholzginger0@outlook.com</p>
    </div>

    <!-- <div class="dadosPedidos">
    <div> N&deg; PEDIDO <STRONg> <?php echo $id ?></STRONg></div>
    <div> EMISSÃO: <strong><?php echo date('d/m/y',strtotime($dataAtual)) ?></strong></div>
    </div> -->


    </section>

    <h3 class="packingListH3">PACKING LIST</h3>

    <!--Menu mobile   -->

    <div style="z-index:99999999;" id="mobileMenu" class="mobileMenuContainer ">
        <button style="width: 50px;" onclick="openMenu()" id="mobileMenuButtonClose" class="mobileMenuButtonClose">
            <img style="width:35px" src="../../assets/x.svg" alt="Menu mobile da página">
        </button>
            <div class="mobileMenuButtons">
                <a href="../../main.php">
                    <div class="menuButtonsMobile">
                        <button class="categorieButtonMobile">
                            <div class="divImgCategorieButtonMobile"><img style="width:20px" src="../../assets/mobileIcons/icon _home_.svg" alt="icone fornecedor"></div>
                            <div class="divNameCategorieButtonMobile"><h2>INÍCIO</h2></div>
                        </button>
                    </div>
                </a>

                <a href="../../cadastros/cadastros.php">
                    <div class="menuButtonsMobile">
                        <button class="categorieButtonMobile">
                            <div class="divImgCategorieButtonMobile"><img  style="width:20px" src="../../assets/mobileIcons/icon _book_-1.svg" alt="icone fornecedor"></div>
                            <div class="divNameCategorieButtonMobile"><h2>CADASTROS</h2></div>
                        </button>
                    </div>
                </a>
                <a href="../../pedidos/cadastrodepedidos.php">
                    <div class="menuButtonsMobile">
                        <button class="categorieButtonMobile">
                            <div class="divImgCategorieButtonMobile"><img  style="width:20px" src="../../assets/mobileIcons/icon _list_-1.svg" alt="icone fornecedor"></div>
                            <div class="divNameCategorieButtonMobile"><h2>PEDIDOS</h2></div>
                        </button>
                    </div>
                </a>
                <a href="../../relatorios/relatorios.php">
                    <div class="menuButtonsMobile">
                        <button class="categorieButtonMobile">
                            <div class="divImgCategorieButtonMobile"><img  style="width:20px" src="../../assets/mobileIcons/icon _pie chart_-1.svg" alt="icone fornecedor"></div>
                            <div class="divNameCategorieButtonMobile"><h2>RELATÓRIOS</h2></div>
                        </button>
                    </div>
                </a>
                <a href="../../inspessao/cadastro.php">
                    <div class="menuButtonsMobile">
                        <button class="categorieButtonMobile">
                            <div class="divImgCategorieButtonMobile"><img  style="width:20px" src="../../assets/mobileIcons/icon _magnifying glass_-1.svg" alt="icone fornecedor"></div>
                            <div class="divNameCategorieButtonMobile"><h2>INSPEÇÃO</h2></div>
                        </button>
                    </div>
                </a>
                <a href="../../packingList/cadastropackinglist.php">
                    <div class="menuButtonsMobile">
                        <button class="categorieButtonMobile">
                            <div class="divImgCategorieButtonMobile"><img  style="width:20px" src="../../assets/mobileIcons/icon _check_-1.svg" alt="icone fornecedor"></div>
                            <div class="divNameCategorieButtonMobile"><h2>PACKING LIST</h2></div>
                        </button>
                    </div>
                </a>
             

            </div>   

    </div>
    <div id="respostaPHP">
        
    </div>

    <header>

        <a href="../cadastropackinglist.php"><button id="backButton" class="backButton">
                <img src="../../assets/backArrow.svg" alt="Botão para voltar a página anterior">
            </button>
        </a>

        <button onclick="openMenu()" id="mobileMenuButton" class="mobileMenuButton">
            <img src="../../assets/menu_mobile.svg" alt="Menu mobile da página">
        </button>

        <div class="cabeçalhoNome" >
                <img src="../../assets/categories/packing_list.svg" alt=""> 
                <p> Nº ID <?php echo $idPedido ?></p> 
                <p> Nº  Cont. <?php echo $numeroContainer ?></p> 
                <p class="nomeCliente"><?php echo strtoupper($cliente);?> </p> 
                <p>  <?php echo $dataFormatada ;?></p>
        </div> 



        <form method="POST" class="inputSearchHeader" id="form-pesquisa2" action="">
            <h2 style="color:white;">FORNECEDOR</h2>
            <input id="chaveAcesso" type="hidden" value= "<?php echo $id;?>">
            <select placeholder="FORNECEDOR" name="fornecedor" id="fornecedor">

                <?php
                $stmt = $conn->prepare("SELECT * FROM fornecedores ORDER BY nome ASC");
                $stmt->execute();
                $result = $stmt->get_result();

                if(($result) AND ($result->num_rows!=0)){
                    while($row = mysqli_fetch_assoc($result)){
                        $fornecedor = $row['nome'];
                       echo' <option value="'.$fornecedor.'">'.strtoupper($fornecedor).'</option>';
                    }
                }
               
            }
            ?>

            </select>
        </form>

       <div  class="paletContainer">
            <div>
                <input id="palet" placeholder="PALET" type="number" require>
            </div>
            <div>
                <input id="quantidade" placeholder=" QUANTIDADE" type="number" require>
            </div>
       </div>

      

        <button onclick="enviarDados()"><img style="height: 30px;" src="../../assets/arowDown.svg"
                alt="Arrow Down ">ADICIONAR <img style="height: 30px;" src="../../assets/arowDown.svg"
                alt="Arrow Down "></button>



      




    </header>

    
    
    <!-- cabeçalho da lista de produtos -->
    <div class="cabeçalhoProdutos">
        <div id="plt">PLT</div>
        <div  style="width:8%" id="numeroFornecedor">N&deg; For.</div>
        <div id="fornecedorCabeçalho" class="fornecedor">FORNECEDOR</div>
        <div id="quantidadeC">QNT </div>
        <div onclick="imprimir()"  id="vazioDiv"> <img style="width:15px;" src="../../assets/printwhite.svg" alt=""></div>
    </div>


    <div  id="containerList" class="containerList">
            <!-- aqui entra a lista dos intens no pedido -->
    </div>
   





<div id="containerValoresFinais"   class="containerValoresFinais">
    <div id="containerInternoValoresFinais"  class="containerInternoValoresFinais">
        <div id="" class="headValores">
            <p>N° TOTAL DE  CAIXAS</p>
            <p id="Ncaixas"></p>
        </div>
        <span class="barraMeio"></span>
        <div id="" class="headValores">
            <p>CAIXAS RESTANTES</p>
            <div class="CxDiv">
                <p id="CxRest">0</p> de
                <input onchange="Listar()" id="inputCxRest" type="number">
            </div>
        </div>
    
    </div>
</div>



<footer>
    <p id="data-footer"> </p>
</footer>
</body>

<script src="../../mobileMenu/js/mobileMenu.js?v=1.7.0"></script>

<script src="../../generalScripts/version.js?v=1.7.0"></script>

<script src="../../generalScripts/backPage.js?v=1.7.0"></script>
<script src="../../generalScripts/print.js?v=1.7.0"></script>





<script>
    let imprimir= () =>{
window.print();
    }
</script>





<!-- 
lista o produto adicionado na lista do pedido -->
<script src="cadastro.js?v=1.7.0"></script>
<script src="apagar.js?v=1.7.0"></script>
<script src="listarProdutos.js?v=1.7.0"></script>



</html>



