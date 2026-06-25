<?php include '../../protect.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registro Atualizado</title>
   <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
   <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center p-4">

   <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 max-w-md w-full text-center space-y-6">
      <?php
         include '../../generalPhp/conection.php';

         $id = $_POST['id'];
         $valorUsuario = $_POST['valor'];
         $produto = $_POST['produto'];

         $valor = str_replace(',', '.', str_replace('.', '', $valorUsuario));

         $sql = "UPDATE produtos SET valor='$valor', produto='$produto' WHERE id='$id'";

         if(mysqli_query($conn, $sql)) {
            echo "<img src='../../assets/refresh.svg' alt='Atualizado' class='mx-auto w-16 h-16'>";
            echo "<h2 class='text-xl font-semibold'>Registro atualizado com sucesso</h2>";
            echo "<a href='cadastrodeproduto.php' class='inline-block mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition'>Lista de Produtos</a>";
         } else {
            echo "<h2 class='text-xl font-semibold text-red-500'>Erro ao atualizar produto: " . mysqli_error($conn) . "</h2>";
         }

         mysqli_close($conn);
      ?>
   </div>

</body>
</html>
