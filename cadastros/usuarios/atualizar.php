<?php include '../../protect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="apagar.css?v=1.7.1">
    <link rel="stylesheet" href="../../index/root.css?v=1.7.1">
   <title>Registro atualizado</title>
</head>
<body>


         <div class ="popUpContainer">

            <?php
               include '../../generalPhp/conection.php';
            

               //recebe os dados pelo metodo post

               $id=$_POST['id'];
               $usuario=$_POST['usuario'];
               $senha=$_POST['senha'];

              

               //consulta sql

               $sql = " UPDATE usuarios SET usuario='$usuario', senha='$senha' WHERE id='$id'";

               if(mysqli_query($conn,$sql)){
                  echo"  <img src='../../assets/refresh.svg' alt='delete  image'> ";
                  echo "<h3>Registro atualizado  com sucesso </h3>";
                  echo "<div class='listButton'>";
                  echo "<a href='cadastrodeusuarios.php'>Lista de Usuários</a>";
                  echo "</div>";
               }else{
               echo" Erro ao atualizar produto" . msqli_error($conn);
               }

               mysqli_close($conn)
            ?>

         </div>
   
</body>
</html>
