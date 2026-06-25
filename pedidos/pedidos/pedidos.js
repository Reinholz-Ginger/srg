
//div  que será escondida
const div = document.getElementById('searchClient')
//select com o  valor do nome do cliente
const select = document.getElementById('select')
//input que receberá o valor 
const input = document.getElementById('clienteInput')

const data = document.getElementById("dataAtual")

var chaveAcesso = ""
var clienteBD = ""
var dataBD = ""




let ContinuarParaPedidos = () => {

    const primeiroOption = select.options[0]
    const clientePedido = primeiroOption.value

    if (!clientePedido || clientePedido == "Cliente não encontrado") {
        appAlert("Selecione um cliente.", { title: 'Cliente obrigatório' });
    } else {
        div.style.display = 'none'
        input.value = clientePedido
        dataAtual = data.value
        // Exemplo de uso:
        const chaveGerada = gerarChaveUnica();
        chaveAcesso = chaveGerada

        clienteBD = clientePedido
        dataBD = dataAtual
    }


}


let alterarValorDataAtual =  () =>{
    dataBD =   document.getElementById('dataAtual').value
}

//gera  uma chave unica para ser a chave que irá identificar o pedido ao cliente na hora de  mostrar no banco de dados 
function gerarChaveUnica() {
    const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}|;:,.<>?';
    const comprimentoChave = 15;
    let chave = '';

    // Adicione a data e hora com segundos atuais ao início da chave
    const dataHoraAtual = new Date();
    const segundos = dataHoraAtual

    chave += dataHoraAtual.toISOString().replace(/ /g, "-") + segundos;

    // Gere os caracteres restantes da chave como antes
    for (let i = 0; i < comprimentoChave - chave.length; i++) {
        const indiceAleatorio = Math.floor(Math.random() * caracteres.length);
        chave += caracteres.charAt(indiceAleatorio);
    }
    chaveFormatada = chave.toString().replace(/ /g, "-")
    return chaveFormatada;
}



