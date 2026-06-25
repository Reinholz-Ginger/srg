    document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("cadastroForm");
   
    
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const numero = document.getElementById("numero").value;
        const nome = document.getElementById("nome").value;
        
        fetch("cadastroFornecedor.php", {
            method: "POST",
            body: new URLSearchParams({ numero, nome })
        })
        .then(response => response.text())
        .then(data => {
            appAlert(data, { title: 'Cadastro de fornecedor' });
            form.reset();
            carregarFornecedores(1,10)
          
            
        });
   
        
    });

   
  
});
