<?php

     include '../../generalPhp/conection.php';
     include '../../protect.php';
     
    
    
     if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $valorUsuario = $_POST["valor"];
        $produto = $_POST["produto"];
    
        // Remova todos os pontos de milhares e substitua a vírgula pelo ponto (formato decimal correto)
        $valor = str_replace(',', '.', str_replace('.', '', $valorUsuario));
    
        $sql = "INSERT INTO produtos (valor, produto) VALUES ('$valor', '$produto')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Produto cadastrado com sucesso!";
        } else {
            echo "Erro no cadastro: " . $conn->error;
        }
    
        $conn->close();
    }
    
?>
