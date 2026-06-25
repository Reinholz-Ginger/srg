// evita de enviar dois pedidos
let envioEmAndamento = false;
// arraya ser enviado para o banco de dados com

// Ao carregar a página:
const valorSalvo = localStorage.getItem("dataRetirada");
if (valorSalvo) {
  document.getElementById("dataRetirada").value = valorSalvo;
}

function salvarLocalStorageDataRetirada() {
  // Quando o valor mudar e você quiser salvar:
  const dataRetirada = document.getElementById("dataRetirada").value;
  localStorage.setItem("dataRetirada", dataRetirada);
}

function recuperarDados() {
  fornecedor = document.getElementById("fornecedor").options[0].value;
  fornecedorNumero =
    document.getElementById("fornecedor").options[0].textContent;
  produto = document.getElementById("produto").options[0].text;
  valorUnit = document.getElementById("valorUnit").value;
  valorUnitFormatado = parseFloat(valorUnit.replace("R$", "").replace(",", ""));
  valorTotal = document.getElementById("valorTotal").textContent;
  valorTotalFormatado = parseFloat(
    valorTotal.replace("R$", "").replace(",", "")
  );
  quantidade = document.getElementById("quantidade").value;
  quantidadeFormatada = parseFloat(
    quantidade.replace("R$", "").replace(",", "")
  );

  const chaveAcesso = document.getElementById("chaveAcesso").value;
  const DataAtual = document.getElementById("DataAtual").value;

  const dataRetirada = document.getElementById("dataRetirada").value;

  let campovazio = false;

  if (
    !fornecedor ||
    produto === "" ||
    fornecedor === " Fornecedor não encontrado " ||
    produto === "Produto não encontrado" ||
    dataRetirada === "" ||
    dataRetirada === undefined
  ) {
    campovazio = true;
  }

  return {
    fornecedor: fornecedor,
    fornecedorNumero: fornecedorNumero,
    produto: produto,
    valorUnit: valorUnitFormatado,
    valorTotal: valorTotalFormatado,
    quantidade: quantidade,
    dataRetirada: dataRetirada,
    campovazio: campovazio,
    chaveAcesso: chaveAcesso,
    dataAtual: DataAtual,
  };
}

const salvarEdicao = async () => {
  const dadosEnvio = recuperarDados();

  if (dadosEnvio.campovazio) {
    toastifyMessage("Preencha o campo vazio ! ", "error");
    return;
  }

  if (envioEmAndamento) {
    await appAlert("Tentativa de salvamento duplicado.", { title: 'Pedido em andamento' });
    window.location.href = "../cadastrodepedidos.php";
    return;
  }
  envioEmAndamento = true;

  // animação quando os dadso estão sendo enviados para o servidor
  document.getElementById("preload").style.display = "block";

  console.log(dadosEnvio);

  fetch("salvarEdicao.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ itensEnviados: dadosEnvio }),
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("respostaPHP").style.display = "block";
      document.getElementById("respostaPHP").innerHTML = data; // Resposta do PHP
      document.getElementById("preload").style.display = "none";
      setTimeout(() => {
        let envioEmAndamento = false;
        window.location.reload();
      }, 1000);
      toastifyMessage(data);
    })
    .catch((error) => {
      document.getElementById("respostaPHP").innerHTML = "Erro: " + erro; // Exibir mensagem de erro
      document.getElementById("preload").style.display = "none";
      let envioEmAndamento = false;
      toastifyMessage(data, "error");
    });
};

async function editarQuantidade(chaveAcesso, idItem, element, valorUnit) {
  console.log(
    "chave de acesso:",
    chaveAcesso,
    "id item:",
    idItem,
    "valor unit.:",
    valorUnit
  );
  const quantidade = element.value;

  const dados = {
    chaveAcesso: chaveAcesso,
    idItem: idItem,
    valorUnit: valorUnit,
    quantidade: quantidade,
  };
  try {
    const response = await fetch("editarQuantidade.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ dados }),
    });
    if (!response.ok) {
      throw new Error("Erro ao atualizar quantidade");
    }
    const data = await response.json();
    toastifyMessage(data.message);
    setTimeout(() => window.location.reload(), 1000);
  } catch (error) {
    toastifyMessage("Erro ao tentar atualizar quantidade!", "error");
    console.error(error);
  }
}
async function alterarDataRetirada(idItem, element) {
  // na linha do pedido listado
  const dataRetiradaNova = element.value;

  const dados = {
    idItem: idItem,
    dataRetirada: dataRetiradaNova,
  };
  try {
    const response = await fetch("editarDataRetirada.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ dados }),
    });
    if (!response.ok) {
      throw new Error("Erro ao atualizar data");
    }
    const data = await response.json();
    toastifyMessage(data.message);
  } catch (error) {
    toastifyMessage("Erro ao tentar atualizar data!", "error");
    console.error(error);
  }
}

async function apagarPedido(idItem) {
  const confirmacao = await appConfirm(
    "Tem certeza que deseja apagar este item do pedido?",
    { title: 'Apagar item' }
  );
  if (!confirmacao) return;

  const dados = {
    idItem: idItem,
  };

  try {
    const response = await fetch("apagar.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ dados }),
    });
    if (!response.ok) {
      throw new Error("Erro ao apagar o pedido");
    }
    const data = await response.json();
    toastifyMessage(data.message || "Pedido apagado com sucesso!");

    setTimeout(() => window.location.reload(), 1000);
  } catch (error) {
    toastifyMessage("Erro ao tentar apagar o pedido!", "error");
    console.error(error);
  }
}

function calcularValorTotal(){
  
}
