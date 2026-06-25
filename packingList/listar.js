
//jquery responsável por mostrar os fornecedores em lista 

var qnt_result_pg = 10; //quantidade de registro por página
var pagina = 1; //página inicial


$(document).ready(function () {
    listar(pagina, qnt_result_pg);
   
});

function listar(pagina, qnt_result_pg) {
    //varia´veis que serão enviadas pelo metodo post para o php 
    var dados = {
        pagina: pagina,
        qnt_result_pg: qnt_result_pg
    }
    $.post('listar.php', dados , function(retorna){
        //seletor id no html
        $("#containerList").html(retorna);
    });

    }






    function salvarPackingList() {
        // Cria um objeto FormData com os dados do formulário
        var formData = $('.formCadastroPackingList').serialize();
    
        // Faz a requisição AJAX para salvar os dados
        $.ajax({
            type: 'POST',
            url: 'salvarPackingList.php',
            data: formData,
            success: async function(response) {
                // Manipula a resposta do servidor
                await appAlert('Packing List salvo com sucesso!', { title: 'Packing List' });
                console.log(response);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                // Manipula erros
                console.error('Erro ao salvar inspeção:', error);
            }
        });
    }


    async function deletarPackingList(id) {
        if (await appConfirm('Tem certeza que deseja deletar este Packing List?', { title: 'Deletar Packing List' })) {
            $.ajax({
                url: 'deletarPackingList.php', // O arquivo PHP que processará a exclusão
                type: 'POST',
                data: { id: id },
                success: async function(response) {
                    await appAlert(response, { title: 'Packing List' }); // Mensagem do servidor (sucesso ou erro)
                    // Remover a inspeção deletada da interface, se necessário
                  window.location.reload()// Supondo que cada inspeção tenha um ID HTML correspondente
                },
                error: async function(xhr, status, error) {
                    console.error('Erro ao deletar a Packing List:', error);
                    await appAlert('Houve um erro ao tentar deletar a Packing List.', { title: 'Erro' });
                }
            });
        }
    }

function fecharDivEdicao(){
    document.getElementById('divEditarPackingList').style.display = 'none';
}

 function editarPackingList(id, nome, numeroContainer, data) {

        console.log(id,nome,numeroContainer,data)
        // Exibir o formulário de edição
        document.getElementById('divEditarPackingList').style.display = 'block';
    
        // Preencher os campos do formulário com os dados da inspeção
        $('#editarNome').val(nome);
        $('#editarNumero_container').val(numeroContainer);
        $('#editarData').val(data);
    
        // Adicionar o ID ao formulário de edição
        $('#divEditarPackingList').data('id', id);
    }


function salvarEdicaoPackingList() {
        // Obter o ID da inspeção a partir do div de edição
        var id = $('#divEditarPackingList').data('id');
    
        // Obter os valores dos campos do formulário
        var nome = $('#editarNome').val();
        var numeroContainer = $('#editarNumero_container').val();
        var dataPackingList = $('#editarData').val();
    
        // Enviar os dados via AJAX para o servidor
        $.ajax({
            url: 'editarPackingList.php', // O arquivo PHP que processará a edição
            type: 'POST',
            data: {
                id: id,
                nome: nome,
                numero_container: numeroContainer,
                data_PackingList: dataPackingList
            },
            success: async function(response) {
                await appAlert(response, { title: 'Packing List' }); // Mensagem do servidor (sucesso ou erro)
              
                $('#divEditarPackingList').hide(); // Esconder o formulário de edição
                window.location.reload();
            },
            error: async function(xhr, status, error) {
                console.error('Erro ao editar a Packing  List:', error);
                await appAlert('Houve um erro ao tentar editar a PackingList.', { title: 'Erro' });
            }
        });
    }
        
    
   




