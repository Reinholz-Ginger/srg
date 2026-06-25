
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


    function salvarInspecao() {
        // Cria um objeto FormData com os dados do formulário
        var formData = $('.formCadastroInspecao').serialize();
    
        // Faz a requisição AJAX para salvar os dados
        $.ajax({
            type: 'POST',
            url: 'salvarInspecao.php',
            data: formData,
            success: function(response) {
                // Manipula a resposta do servidor
                toastifyMessage('Inspeção salva com sucesso!');
                console.log(response);
                setTimeout(()=>{

                    window.location.reload();
                },1000)
            },
            error: function(xhr, status, error) {
                // Manipula erros
                console.error('Erro ao salvar inspeção:', error);
            }
        });
    }


    async function deletarInspecao(id) {
        if (await appConfirm('Tem certeza que deseja deletar esta inspeção?', { title: 'Deletar inspeção' })) {
            $.ajax({
                url: 'deletarInspecao.php', // O arquivo PHP que processará a exclusão
                type: 'POST',
                data: { id: id },
                success: async function(response) {
                    await appAlert(response, { title: 'Inspeção' }); // Mensagem do servidor (sucesso ou erro)
                    // Remover a inspeção deletada da interface, se necessário
                    listar(1,10)// Supondo que cada inspeção tenha um ID HTML correspondente
                },
                error: async function(xhr, status, error) {
                    console.error('Erro ao deletar a inspeção:', error);
                    await appAlert('Houve um erro ao tentar deletar a inspeção.', { title: 'Erro' });
                }
            });
        }
    }

function fecharDivEdicao(){
    document.getElementById('divEditarInspecao').style.display = 'none';
}

 function editarInspecao(id, nome, numeroContainer, data) {

        console.log(id,nome,numeroContainer,data)
        // Exibir o formulário de edição
        document.getElementById('divEditarInspecao').style.display = 'block';
    
        // Preencher os campos do formulário com os dados da inspeção
        $('#editarNome').val(nome);
        $('#editarNumero_container').val(numeroContainer);
        $('#editarData').val(data);
    
        // Adicionar o ID ao formulário de edição
        $('#divEditarInspecao').data('id', id);
    }


function salvarEdicaoInspecao() {
        // Obter o ID da inspeção a partir do div de edição
        var id = $('#divEditarInspecao').data('id');
    
        // Obter os valores dos campos do formulário
        var nome = $('#editarNome').val();
        var numeroContainer = $('#editarNumero_container').val();
        var dataInspecao = $('#editarData').val();
    
        // Enviar os dados via AJAX para o servidor
        $.ajax({
            url: 'editarInspecao.php', // O arquivo PHP que processará a edição
            type: 'POST',
            data: {
                id: id,
                nome: nome,
                numero_container: numeroContainer,
                data_inspecao: dataInspecao
            },
            success: async function(response) {
                await appAlert(response, { title: 'Inspeção' }); // Mensagem do servidor (sucesso ou erro)
              
                $('#divEditarInspecao').hide(); // Esconder o formulário de edição
                window.location.reload();
            },
            error: async function(xhr, status, error) {
                console.error('Erro ao editar a inspeção:', error);
                await appAlert('Houve um erro ao tentar editar a inspeção.', { title: 'Erro' });
            }
        });
    }
        
    
   




