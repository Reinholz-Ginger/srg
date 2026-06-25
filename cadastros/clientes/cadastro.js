    document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("cadastroForm");
   
    
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const nome = document.getElementById("nome").value;
       
        
        
        fetch("cadastro.php", {
            method: "POST",
            body: new URLSearchParams({ nome})
        })
        .then(response => response.text())
        .then(data => {
            appAlert(data, { title: 'Cadastro de cliente' });
            form.reset();
            listar(1,10)
          
            
        });
   
        
    });

   
  
});
