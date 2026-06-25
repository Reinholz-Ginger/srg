




// evita de enviar dois pedidos 
let envioEmAndamento = false;
// arraya ser enviado para o banco de dados com

const enviarDados = async () => {

  if (envioEmAndamento) {
    await appAlert("Tentativa de salvamento duplicado.", { title: 'Pedido em andamento' });
    window.location.href="../cadastrodepedidos.php"
    return;
}
envioEmAndamento = true;

  // animação quando os dadso estão sendo enviados para o servidor 
  document.getElementById('preload').style.display='block'
  document.getElementById('salvarPedido').style.display = 'none'

  let dataAtualizada = document.getElementById('dataAtual').value

  // Criar um dicionário de cliente
  const dicionarioCliente = {};
  dicionarioCliente['cliente'] = clienteBD;
  dicionarioCliente['dataAtual'] = dataAtualizada //dataBD;
  dicionarioCliente['valortotalPedido'] = valorTotalBD;

  // Adicionar o dicionário do cliente à lista itensParaSoma
   itensParaSoma.push(dicionarioCliente);
  itensEnviados = itensParaSoma

  console.log(itensEnviados)




fetch('cadastroPedido.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({ itensEnviados: itensEnviados })
})
  .then(response => response.text())
  .then(data => {
    document.getElementById("respostaPHP").style.display = "block";
    document.getElementById("respostaPHP").innerHTML = data; // Resposta do PHP
    document.getElementById('preload').style.display='none'
    setTimeout(()=>{
      let envioEmAndamento = false;
      window.location.href="../cadastrodepedidos.php"
    },1000)
  })
  .catch(error => {
    document.getElementById("respostaPHP").innerHTML = "Erro: " + erro; // Exibir mensagem de erro
    document.getElementById('preload').style.display='none'
    let envioEmAndamento = false;

  });

}




