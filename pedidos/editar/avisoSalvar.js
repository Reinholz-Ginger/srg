
// função aparece um aviso se apertar o botão antes de salvar 
let avisoSalvar = async () => {
    if (await appConfirm("Dados não salvos serão perdidos. Deseja sair?", { title: 'Sair sem salvar' })) {
      window.location.href = '../cadastrodepedidos.php';
    }
    
  }
  

  let avisoSalvar2 = () => {
  }
