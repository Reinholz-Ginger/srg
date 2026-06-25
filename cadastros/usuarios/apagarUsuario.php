<?php
include '../../generalPhp/conection.php';

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
   die( header("Location: ../../index.php"));
   
}

// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the 'id' value from the URL
    $id = $_GET['id'];

    // Create a SQL query to fetch the data for the specified 'id'
    $sql = "SELECT usuario,senha FROM usuarios WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and data was found
    if ($row = mysqli_fetch_assoc($result)) {
        $usuario = $row['usuario'];
        $senha = $row['senha'];
        
        
    } else {
        echo 'Registro não encontrado!';
    }
} else {
    echo 'ID não fornecido na URL!';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index/root.css?v=1.7.1">
    <link rel="stylesheet" href="editar.css?v=1.7.1">
    <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <title>Apagar Usuários</title>
</head>
<body>
    <form action="apagar.php" method="get">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">

        <div class="inputBox">

            
            <label for="valor">SENHA</label>
            <input placeholder="INSIRA A SENHA" type="text" id="senha" name="senha" value=""  required>
            </div>
       
        

        <a href="apagar.php?id=<?php echo $id; ?>&senha=<?php echo $senha; ?>">Excluir</a>

        <a  href="cadastrodeusuarios.php">CANCELAR<img style="width:30px;" src="../../assets/delete.svg" alt=""></a>
      

    </form>
</body>
</html>
