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


    // Create a SQL query to fetch the data for the specified 'id'
    $sql = "SELECT * FROM pedidos_dados WHERE chaveAcesso = '$id'";
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT * FROM pedidoscadastro WHERE chaveAcesso ='$id'";
    $resultSql1 = mysqli_query($conn,$sql1);

    if($resultSql1 && $resultSql1->num_rows !=0){
        while($row = mysqli_fetch_assoc($resultSql1)){
            $valorTotalSalvoPedido = $row['valor_total'];
            $dataAtual = $row['dataAtual'];
            $cliente = $row['cliente'];
            $idItem = $row['id'];
       
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="nofollow,noindex">
  <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
  <title>Editar Pedidos</title>


  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Scripts -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="../../onLoad/onLoad.js?v=1.7.1"></script>  
</head>

<body id="body" onload="onLoad()" class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
  <!-- Loader -->
    <div class="fixed inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-50" id="preload">
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-500"></div>
    </div>
  <!-- Mobile Menu -->
  <div id="mobileMenu" class="mobileMenuContainer"></div>

  <!-- Resposta PHP -->
  <div id="respostaPHP"></div>

  <!-- Header -->
  <div class="w-full flex justify-between px-3 items-center bg-green-700">
    <button onclick="avisoSalvar()" id="backButton" class="p-2">
      <img src="../../assets/backArrow.svg" alt="Voltar" class="w-6 h-6">
    </button>
    <h1 class="text-xl text-white font-bold">Editar Pedido  <?php echo $cliente ?></h1>
    <button onclick="toggleTheme()" title="Alternar tema" class="text-xl text-yellow-500 hover:text-yellow-400 transition">
      <i class="fas fa-circle-half-stroke"></i>
    </button>
  </div>
<header class="p-4 bg-gray-200 dark:bg-gray-800 shadow-md flex flex-col gap-6">

  <!-- Linha 1: Fornecedor e Produto -->
  <div class="w-full flex flex-col lg:flex-row flex-wrap gap-4">

   <!-- Datas -->
    <div class="flex flex-col gap-2 w-full">

      <label for="dataRetirada" class="text-sm text-gray-700 dark:text-gray-200 mt-2">Data de Retirada</label>
      <input id="dataRetirada" type="date" onchange="salvarLocalStorageDataRetirada()"
        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm">
    </div>
    <!-- Fornecedor -->
    <form method="POST" class="flex gap-2 w-full" id="form-pesquisa2">
      <input id="pesquisaFornecedor" name="pesquisaFornecedor" placeholder="FORNECEDOR"
        class="flex-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm" />
      <select name="fornecedor" id="fornecedor"
        class="w-40 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm">
        <option value=""></option>
      </select>
    </form>

  
    <!-- Produto -->
    <form method="POST" class="flex gap-2 w-full" id="form-pesquisa3">
      <input id="pesquisaProduto" name="pesquisaproduto" placeholder="PRODUTO"
        class="flex-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm" />
      <select onchange="calcularMudancaSelect()" name="produto" id="produto"
        class="w-40 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm">
        <option value=""></option>
      </select>
    </form>
  </div>

  <!-- Linha 2: Valores e botão -->
  <div class="w-full flex flex-col lg:flex-row justify-between items-center gap-4">

    <!-- Bloco: Unitário, Total e Quantidade -->
    <div class="flex flex-col sm:flex-row flex-wrap gap-6 items-center w-full lg:w-auto">
      <!-- Unitário -->
      <div class="flex flex-col items-center">
        <div class="text-sm text-gray-700 dark:text-gray-200">Unit.</div>
        <input id="valorUnit" value="R$ 0,00"
          class="w-24 text-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm">
      </div>

      <!-- Total -->
      <div class="flex flex-col items-center">
        <div class="text-sm text-gray-700 dark:text-gray-200">Total</div>
        <div id="valorTotal" class="text-green-600 font-semibold text-sm">R$ 0,00</div>
      </div>

      <!-- Quantidade -->
      <div class="flex items-center gap-2">
        <div onclick="subtrairValor()" class="cursor-pointer px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded">-</div>
        <input id="quantidade" type="number" value="1"
          class="w-16 text-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded">
        <div onclick="aumentarValor()" class="cursor-pointer px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded">+</div>
      </div>
    </div>

    <!-- Botão Adicionar -->
    <button onclick="salvarEdicao()"
      class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow w-full lg:w-auto justify-center">
      <img src="../../assets/arowDown.svg" alt="Arrow Down" class="h-5">
      ADICIONAR
      <img src="../../assets/arowDown.svg" alt="Arrow Down" class="h-5">
    </button>
  </div>

  <!-- Datas Ocultas -->
  <input type="hidden" id="chaveAcesso" value="<?php echo $id ?>">
  <input type="hidden" id="DataAtual" value="<?php echo $dataAtual ?>">
</header>



    
    
        
     <!-- Cabeçalho da lista de produtos -->
      <div class="w-full px-4 py-2 bg-gray-800 text-white dark:bg-gray-800 border-t border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-200 flex justify-between">
          <div class="w-1/3">FORNECEDOR</div>
          <div class="w-1/6 text-center">RET.</div>
          <div class="w-2/5 flex justify-between">
              <div class="text-center w-1/3">QNT</div>
              <div class="text-center w-1/3">VLR T.</div>
              <div class="text-center w-1/3">MAIS</div>
          </div>
      </div>


    <form  style="height:auto;" id="containerList" class="containerList">
            <!-- aqui entra a lista dos intens no pedido -->
    </form>
   

    
    <div class="containerList">
<?php
if ($result && $result->num_rows != 0) {
    $somaQuantidadeTotal = 0;
    $somaValorTotal = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $fornecedor = $row['fornecedor'];
        $quantidade = $row['quantidade'];
        $valor_unit = $row['valor_unit'];
        $valor_total = $row['valor_total'];
        $dataRetirada = $row['data_retirada'];
        $produto = $row['produto'];
        $idItem = $row['id'];
        $chaveAcesso = $row['chaveAcesso'];
        $somaQuantidadeTotal += $quantidade;

        $valorUnitString = "R$ " . number_format($valor_unit / 100, 2, ",", ".");
        $valorTotalString = "R$ " . number_format($valor_total / 100, 2, ",", ".");
        $somaValorTotal += $valor_total;
        ?>

        <input id="chaveAcesso" type="hidden" value="<?= $chaveAcesso ?>">

        <div id="<?= $idItem ?>" class="w-full px-4 py-2 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 text-sm flex flex-col gap-2">
            <!-- Linha principal alinhada com cabeçalho -->
            <div class="flex justify-between items-center">
                <div class="w-1/3 font-medium text-gray-800 dark:text-white">
                    <?= $fornecedor ?>
                </div>
                <div class="w-1/6 text-center">
                    <input onchange="alterarDataRetirada('<?= $idItem ?>',this)" type="date" value="<?= $dataRetirada ?>" class="w-full text-center bg-transparent border border-gray-300 dark:border-gray-600 rounded px-1 py-1 text-sm">
                </div>
                <div class="w-2/5 flex justify-between items-center text-gray-700 dark:text-gray-200">
                    <div class="w-1/3 text-center">
                        <input type="number"
                            onchange="editarQuantidade('<?= $chaveAcesso ?>','<?= $idItem ?>', this, '<?= $valor_unit ?>')"
                            value="<?= $quantidade ?>"
                            class="w-14 text-center bg-transparent border border-gray-300 dark:border-gray-600 rounded px-1 py-1 text-sm">
                    </div>
                    <div class="w-1/3 text-center font-semibold text-green-600"><?= $valorTotalString ?></div>
                    <div class="w-1/3 text-center">
                        <button onclick="trocarDisplay('info<?= $idItem ?>', 'img<?= $idItem ?>')">
                            <img id="img<?= $idItem ?>" src="../../assets/eye.svg" alt="Ver mais" class="w-5 h-5 mx-auto opacity-60">
                        </button>
                    </div>
                </div>
            </div>

            <!-- Linha secundária: Produto / Unit / Apagar -->
            <div id="info<?= $idItem ?>" style="display:none;" class="flex justify-between items-center bg-gray-50 dark:bg-gray-800 px-2 py-2 rounded">
                <div class="w-1/3 text-gray-700 dark:text-gray-300"><?= $produto ?></div>
                <div class="w-1/6"></div>
                <div class="w-2/5 flex justify-between items-center">
                    <div class="w-1/3 text-center text-gray-500 dark:text-gray-400">Unit <?= $valorUnitString ?></div>
                    <div class="w-1/3 text-center"></div>
                    <div class="w-1/3 text-center">
                        <a onclick="apagarPedido('<?=$idItem?>')">
                            <img src="../../assets/erase.svg" alt="Apagar" class="w-5 h-5 mx-auto hover:opacity-80">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
} else {
    echo '<p class="text-red-600 p-4">Registro não encontrado!</p>';
}
?>

     
    </div>

  <!-- Botão Salvar
  <button onclick="enviarDados()" id="salvarPedido"
    class="fixed bottom-4 right-4 bg-green-600 hover:bg-green-700 text-white p-3 rounded-full shadow-lg z-50">
    <img src="../../assets/save.svg" alt="Salvar" class="w-6 h-6">
  </button> -->

  <!-- Container de Valores Finais -->
  <div id="containerValoresFinais"
    class="w-full mt-6 px-4 py-4 bg-white dark:bg-gray-800 rounded shadow-md text-gray-800 dark:text-white">
    <div id="containerInternoValoresFinais"
      class="flex flex-col sm:flex-row  justify-center items-center flex-row gap-6 text-center">
      <div class="space-y-1">
        <p class="font-semibold text-sm">Nº CAIXAS</p>
        <p id="Ncaixas" class="text-lg font-bold"><?php echo $somaQuantidadeTotal ?></p>
      </div>
      <!-- <div class="space-y-1">
        <p class="font-semibold text-sm">CX. REST.</p>
        <div class="flex justify-center items-center gap-2">
          <p id="CxRest" class="text-lg font-bold">0</p>
          <span class="text-sm">de</span>
          <input id="inputCxRest" type="number"
            class="w-20 px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>
      </div> -->
      <div class="space-y-1">
        <p class="font-semibold text-sm">VALOR TOTAL</p>
        <p id="valorTotalPedido" class="text-lg font-bold">R$ <?php echo number_format($somaValorTotal / 100, 2, ",", ".") ?></p>
      </div>
    </div>
  </div>

  <!-- Scripts -->
       <script src="../../generalScripts/toastify.js?v=1.7.1"></script>

    <script src="../../generalScripts/darkmode.js?v=1.7.1"></script>
 
  <script src="../../generalScripts/backPage.js?v=1.7.1"></script>
  <script src="../../generalScripts/version.js?v=1.7.1"></script>

  <script src="../pedidos/buscaCliente.js?v=1.7.1"></script>
  <script src="../pedidos/pedidos.js?v=1.7.1"></script>

  <script src="../pedidos/buscaFornecedor.js?v=1.7.1"></script>
  <script src="../pedidos/buscaProduto.js?v=1.7.1"></script>


  <script src="../pedidos/aumentarQuantidade.js?v=1.7.1"></script>

  <script src="../pedidos/mostrarInfo.js?v=1.7.1"></script>
  <script src="listarProdutos.js?v=1.7.1"></script>
  <script src="salvarEdicao.js?v=1.7.1"></script>
  <script src="../../generalScripts/deleteDiv.js?v=1.7.1"></script>
  <script src="validarBotaoSalvar.js?v=1.7.1"></script>
  
  <script src="avisoSalvar.js?v=1.7.1"></script>
</body>
</html>
