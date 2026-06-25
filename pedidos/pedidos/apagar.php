<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="apagar.css?v=1.7.2">
    <link rel="stylesheet" href="../../index/root.css?v=1.7.2">
    <title>Apagar Registro</title>
</head>
<body>

    <div class="popUpContainer">
        <!-- The confirmation messages will be displayed here -->
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
            $id = $_GET['id'];

            // Check if a confirmation action was triggered
            if (isset($_GET['confirm'])) {
                if ($_GET['confirm'] === 'yes') {
                    // The user confirmed to delete, proceed with the deletion
                    $sql = "DELETE FROM produtos WHERE id='$id'";
                    if (mysqli_query($conn, $sql)) {
                        echo"  <img src='../../assets/fileDeleted.svg' alt='delete  image'> ";
                        echo "<h3>Registro deletado com sucesso</h3>";
                        echo "<div class='listButton'>";
                        echo "<a href='cadastrodepedidos.php'>Lista de Pedidos</a>";
                        echo "</div>";
                    } else {
                        echo "Erro ao atualizar registro: " . mysqli_error($conn);
                    }
                    mysqli_close($conn);
                    exit; // Stop execution after deletion
                }
            }

            // If no confirmation action was triggered, show the confirmation dialog
            echo"  <img src='../../assets/delete.svg' alt='delete  image'> ";
            echo "<h3>Deseja realmente apagar esse registro?</h3> ";
            echo"<div class='deleteButtons'>";
            echo "<div class='yesButton'>";
            echo "<a href='apagar.php?id=$id&confirm=yes'>Sim</a>  ";
            echo "</div>";
            echo "<div class='cancelButton'>";
            echo "<a href='cadastrodepedidos.php'>Cancelar</a>";
            echo "</div>";
            echo"</div>";
        } else {
            echo '<h3>ID não fornecido na URL!</h3>';
        }
        ?>
    </div>
    
</body>
</html>
