<?php include '../../protect.php'; ?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
   <title>Registro Atualizado</title>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center p-4">

   <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center max-w-md w-full space-y-4">
      <?php
      include '../../generalPhp/conection.php';

      $id = $_POST['id'];
      $nome = $_POST['nome'];

      // Consulta SQL
      $sql = "UPDATE clientes SET nome='$nome' WHERE id='$id'";

      if (mysqli_query($conn, $sql)) {
         echo "<img src='../../assets/refresh.svg' alt='Atualizado' class='mx-auto w-12 h-12'>";
         echo "<h3 class='text-lg font-semibold'>Registro atualizado com sucesso!</h3>";
         echo "<a href='cadastrodecliente.php' class='inline-block mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition'>Voltar para Lista</a>";
      } else {
         echo "<h3 class='text-red-500 font-semibold'>Erro ao atualizar cliente: " . mysqli_error($conn) . "</h3>";
      }

      mysqli_close($conn);
      ?>
   </div>

</body>

</html>
