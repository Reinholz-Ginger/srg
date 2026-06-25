//script responsável por mostrar o produto  na lista de pedidos  abaixo 

//quantidade
 valores = [{}]
//valores que serão usados para fazer a soma total dos valores e quantidade de produtos
var itensParaSoma = []

//variavel que armazena a quantidade de caixas que serão calculadas no pedido
var  caixasTotais = 1400;

var  valorTotalBD;

key =  0

let listar = () => {
   
    fornecedor = document.getElementById("fornecedor").options[0].value;
    fornecedorNumero = document.getElementById("fornecedor").options[0].textContent;
    produto = document.getElementById("produto").options[0].text;
    valorUnit = document.getElementById("valorUnit").value
    valorUnitFormatado = parseFloat(valorUnit.replace("R$", "").replace(",", ""))
    valorTotal = document.getElementById("valorTotal").textContent
    valorTotalFormatado = parseFloat(valorTotal.replace("R$", "").replace(",", ""))
    quantidade = document.getElementById("quantidade").value
    quantidadeFormatada = parseFloat(quantidade.replace("R$", "").replace(",", ""))

    let dataRetirada =  document.getElementById('dataRetirada').value



    if (!fornecedor || produto === "" || fornecedor === " Fornecedor não encontrado " || produto === "Produto não encontrado" || dataRetirada === ''||dataRetirada === undefined) {
        appAlert("Preencha o campo vazio!", { title: 'Campos obrigatórios' });
        
    } else {
        calcularTotal()
        //recuperaos valores a serem mapeados na função adicionarItemPedido()
        valores[0].nome = fornecedor
        valores[0].fornecedorNumero = fornecedorNumero
        valores[0].produto = produto
        valores[0].valorUnit = valorUnitFormatado
        valores[0].valorUnitString = valorUnit
        valores[0].valorTotal = valorTotalFormatado
        valores[0].valorTotalString = valorTotal
        valores[0].quantidade = quantidadeFormatada
        valores[0].id = key++
        valores[0].dataRetirada = dataRetirada

        //recupera os valores para fazer a soma total de caixas e valor total 
        novoDicionarioItens = {}
        novoDicionarioItens['id'] = key 
        novoDicionarioItens['fornecedor'] = fornecedor 
        novoDicionarioItens['produto'] = produto 
        novoDicionarioItens['valorUnit'] = valorUnitFormatado 
        novoDicionarioItens['valorTotal'] = valorTotalFormatado
        novoDicionarioItens['quantidade'] = quantidadeFormatada
        novoDicionarioItens['chaveAcesso'] = chaveAcesso
        novoDicionarioItens['fornecedorNumero'] = fornecedorNumero
        novoDicionarioItens['dataRetirada'] = dataRetirada
        itensParaSoma.push(novoDicionarioItens)
       

        //fazer a soma dos valores e colocar em variáveis 

        var somaQuantidade = 0
        var somaValortotalPedido = 0

        for (var i = 0; i < itensParaSoma.length; i++) {
            somaQuantidade = somaQuantidade + itensParaSoma[i].quantidade
        }

        for (var i = 0; i < itensParaSoma.length; i++) {
            somaValortotalPedido = somaValortotalPedido + itensParaSoma[i].valorTotal
        }
        valorTotalBD = somaValortotalPedido

        //converte o  valor para string e  formata para real brasileiro
        somaValortotalPedidoSTRING = somaValortotalPedido.toString()
        if(somaValortotalPedidoSTRING.length == 2){
            $("#valorTotalPedido").html("R$ 0," + somaValortotalPedidoSTRING)
        }

        if(somaValortotalPedidoSTRING.length>=3){
            valorTotalFormatadoPedido = somaValortotalPedidoSTRING  / 100
            $("#valorTotalPedido").html("R$ " + valorTotalFormatadoPedido.toFixed(2).replace(".", ","))
        }

        
        //calcula o valor das caicas restantes 
        var quantiadeDeCaixasRestantes = caixasTotais - somaQuantidade
        document.getElementById("Ncaixas").innerHTML = somaQuantidade
        document.getElementById("CxRest").innerHTML = quantiadeDeCaixasRestantes

      
        adicionarItemPedido()
        quantidade = document.getElementById("quantidade").value = 1

        document.getElementById("pesquisaFornecedor").value = ""
        document.getElementById("pesquisaProduto").value = ""
        document.getElementById("valorTotal").textContent = valorUnit
        

        document.getElementById("fornecedor").innerHTML = `
        
        <option value=""></option>
        `

        document.getElementById("produto").innerHTML = `
        
        <option value=""></option>
        `
        
        
    }
    // Reatribuir eventos dos botões de aumentar e diminuir quantidade
    quantidade = document.getElementById("quantidade");
    valorUnit = document.getElementById("valorUnit");

    quantidadeInicial = 1;
    quantidadeAtual = quantidadeInicial;

 

  
    
}



let adicionarItemPedido = () => {
    Item = document.getElementById("containerList")
    return (Item.innerHTML += valores.map((x) => {
        let { nome, produto, id, valorUnit, valorTotal, valorUnitString, valorTotalString, quantidade,dataRetirada } = x
        return`

<div id="${id}" class="w-full px-4 py-2 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 text-sm flex flex-col gap-2">

  <!-- Linha principal: FORNECEDOR / RET. / QNT / VLR T. / MAIS -->
  <div class="flex justify-between items-center">
    <div class="w-1/3 font-medium text-gray-800 dark:text-white">
      ${nome}
    </div>
    <div class="w-1/6 text-center text-gray-600 dark:text-gray-300">
      ${dataRetirada.split('-').reverse().join('/')}
    </div>
    <div class="w-2/5 flex justify-between items-center text-gray-700 dark:text-gray-200">
      <div class="w-1/3 text-center font-semibold">${quantidade}</div>
      <div class="w-1/3 text-center font-semibold text-green-600">${valorTotalString}</div>
      <div class="w-1/3 text-center">
        <img src="../../assets/eye.svg" alt="Ícone olho" class="w-5 h-5 mx-auto opacity-40 pointer-events-none">
      </div>
    </div>
  </div>

  <!-- Linha secundária: Produto / Unit / Apagar -->
  <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-800 px-2 py-2 rounded">
    <div class="w-1/3 text-gray-700 dark:text-gray-300">
      ${produto}
    </div>
    <div class="w-1/6"></div>
    <div class="w-2/5 flex justify-between items-center">
      <div class="w-1/3 text-center text-gray-500 dark:text-gray-400">Unit ${valorUnitString}</div>
      <div class="w-1/3 text-center"></div>
      <div class="w-1/3 text-center">
        <button onclick="apagarItem(${id})" id="verMais${id}">
          <img src="../../assets/erase.svg" alt="Apagar" class="w-5 h-5 mx-auto">
        </button>
      </div>
    </div>
  </div>

</div>


            
            `
    }))
    
}



var apagarItem = (id) => {
    //pega o id da  div 
    let div = document.getElementById(id)

    //seleciona o dicionario do  array a ser apagado usando como parametro o id da div 
    itensParaSoma.splice(id,1)
   

    // faz todo o calculo novamente para as quantidades 
    var somaQuantidade = 0
    var somaValortotalPedido = 0

    for (var i = 0; i < itensParaSoma.length; i++) {
        somaQuantidade = somaQuantidade + itensParaSoma[i].quantidade
    }

    for (var i = 0; i < itensParaSoma.length; i++) {
        somaValortotalPedido = somaValortotalPedido + itensParaSoma[i].valorTotal
    }
    
    valorTotalBD = somaValortotalPedido

    //converte o  valor para string e  formata para real brasileiro
    somaValortotalPedidoSTRING = somaValortotalPedido.toString()
    if(somaValortotalPedidoSTRING.length == 2){
        $("#valorTotalPedido").html("R$ 0," + somaValortotalPedidoSTRING)
    }

    if(somaValortotalPedidoSTRING.length>=3){
        valorTotalFormatadoPedido = somaValortotalPedidoSTRING  / 100
        $("#valorTotalPedido").html("R$ " + valorTotalFormatadoPedido.toFixed(2).replace(".", ","))
    }

    
    //calcula o valor das caicas restantes 
    var quantiadeDeCaixasRestantes = caixasTotais - somaQuantidade
    document.getElementById("Ncaixas").innerHTML = somaQuantidade
    document.getElementById("CxRest").innerHTML = quantiadeDeCaixasRestantes
    
    // remove a div do html 
    div.remove()
}

