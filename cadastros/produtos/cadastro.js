    document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("cadastroForm");
   
    
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const produto = document.getElementById("produto").value;
        const valor = document.getElementById("valor").value;

        
     
        
        
        fetch("cadastro.php", {
            method: "POST",
            body: new URLSearchParams({ produto, valor })
        })
        .then(response => response.text())
        .then(data => {
            appAlert(data, { title: 'Cadastro de produto' });
            form.reset();
            listar(1,10)
          
            
        });
   
        
    });

   
  
});
