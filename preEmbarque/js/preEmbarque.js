//jquery responsável por mostrar os fornecedores em lista

var qnt_result_pg = 10; //quantidade de registro por página
var pagina = 1; //página inicial

$(document).ready(function () {
  listar(pagina, qnt_result_pg);
});

function listar(pagina, qnt_result_pg) {
  //variaveis que serão enviadas pelo metodo post para o php
  var dados = {
    pagina: pagina,
    qnt_result_pg: qnt_result_pg,
  };
  $.post("./php/listar.php", dados, function (retorna) {
    //seletor id no html
    $("#containerList").html(retorna);
  });
}

async function salvarPreEmbarque() {//salva o pre embarque na página inicial dos pre embarques 
  const form = document.getElementById("cadastroForm");

  const inputs = form.querySelectorAll("input");
  let formData = new FormData();

  for (const e of inputs) {
    if (e.value.trim() === "") {
      toastifyMessage(`O campo ${e.name} é obrigatório`, "error");
      return;
    }
    formData.append(e.name, e.value);
  }

  try {
    const response = await fetch("./php/salvarPreEmbarque.php", {
      method: "POST",
      body: formData,
    });
    if (!response.ok) {
      throw new Error("Não foi possível salvar!");
    }

    const data = await response.text();

    toastifyMessage("Pré-embarque salvo com sucesso!");
    form.reset();
    listar(1, 10);
  } catch (error) {
    console.log(error);
    toastifyMessage("Não foi possível salvar o Pré-embarque!", "error");
  } finally {
  }
}

async function deletar(id) {
  if (await appConfirm("Tem certeza que deseja deletar este pré-embarque?", { title: 'Deletar pré-embarque' })) {
    $.ajax({
      url: "./php/deletarPreEmbarque.php", // O arquivo PHP que processará a exclusão
      type: "POST",
      data: { id: id },
      success: function (response) {
        toastifyMessage(response)
        listar(1, 10); // Supondo que cada inspeção tenha um ID HTML correspondente
      },
      error: function (xhr, status, error) {
        console.error("Erro ao deletar a pre embarque:", error);
        toastifyMessage("Houve um erro ao tentar deletar a inspeção.",'error');
      },
    });
  }
}

function fecharDivEdicao() {
  document.getElementById("divEditarInspecao").style.display = "none";
}

function editarPreEmbarque(id, nome, numeroContainer, data) {
  console.log(id, nome, numeroContainer, data);
  // Exibir o formulário de edição
  document.getElementById("divEditarInspecao").style.display = "block";

  // Preencher os campos do formulário com os dados da inspeção
  $("#editarNome").val(nome);
  $("#editarNumero_container").val(numeroContainer);
  $("#editarData").val(data);

  // Adicionar o ID ao formulário de edição
  $("#divEditarInspecao").data("id", id);
}

function salvarEdicaoPreEmbarque() {
  // Obter o ID da inspeção a partir do div de edição
  var id = $("#divEditarInspecao").data("id");

  // Obter os valores dos campos do formulário
  var nome = $("#editarNome").val();
  var numeroContainer = $("#editarNumero_container").val();
  var dataInspecao = $("#editarData").val();

  // Enviar os dados via AJAX para o servidor
  $.ajax({
    url: "./php/editarPreEmbarque.php", // O arquivo PHP que processará a edição
    type: "POST",
    data: {
      id: id,
      nome: nome,
      numero_container: numeroContainer,
      data: dataInspecao,
    },
    success: function (response) {
      toastifyMessage(response); // Mensagem do servidor (sucesso ou erro)

      $("#divEditarInspecao").hide(); // Esconder o formulário de edição
     listar(1,10)
    },
    
    error: function (xhr, status, error) {
      console.error("Erro ao editar a inspeção:", error);
      toastifyMessage("Houve um erro ao tentar editar a inspeção.",'error');
    },
  });
}
