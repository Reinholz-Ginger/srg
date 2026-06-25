<?php include '../../protect.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
   <title>Registro atualizado</title>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-4">

   <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 w-full max-w-md text-center space-y-4">
      <?php
         include '../../generalPhp/conection.php';

         $id = $_POST['id'];
         $numero = $_POST['numero'];
         $nome = $_POST['nome'];

         $sql = "UPDATE fornecedores SET numero='$numero', nome='$nome' WHERE id='$id'";

         if (mysqli_query($conn, $sql)) {
            echo "<img src='../../assets/refresh.svg' alt='Atualizado' class='mx-auto w-16 h-16'>";
            echo "<h3 class='text-lg font-semibold'>Registro atualizado com sucesso</h3>";
            echo "<div>";
            echo "<a href='cadastrodeFornecedor.php' class='inline-block mt-4 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition'>Lista de Fornecedores</a>";
            echo "</div>";
         } else {
            echo "<h3 class='text-red-500 font-semibold'>Erro ao atualizar fornecedor: " . mysqli_error($conn) . "</h3>";
         }

         mysqli_close($conn);
      ?>
   </div>

</body>
</html>
