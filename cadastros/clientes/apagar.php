<?php include '../../protect.php'; ?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
  <title>Apagar Registro</title>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center p-4">

  <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md text-center max-w-md w-full space-y-6">
    <?php
    include '../../generalPhp/conection.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
            $sql = "DELETE FROM clientes WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                echo "<img src='../../assets/fileDeleted.svg' alt='Deletado' class='mx-auto w-14 h-14'>";
                echo "<h3 class='text-lg font-semibold'>Registro deletado com sucesso.</h3>";
                echo "<a href='cadastrodecliente.php' class='inline-block px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition'>Voltar à Lista</a>";
            } else {
                echo "<h3 class='text-red-500 font-semibold'>Erro ao deletar registro: " . mysqli_error($conn) . "</h3>";
            }
            mysqli_close($conn);
            exit;
        }

        // Confirmação
        echo "<img src='../../assets/delete.svg' alt='Confirmar Exclusão' class='mx-auto w-14 h-14'>";
        echo "<h3 class='text-lg font-semibold'>Deseja realmente apagar esse registro?</h3>";
        echo "<div class='flex justify-center gap-4'>";
        echo "<a href='apagar.php?id=$id&confirm=yes' class='px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded'>Sim</a>";
        echo "<a href='cadastrodecliente.php' class='px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded'>Cancelar</a>";
        echo "</div>";
    } else {
        echo "<h3 class='text-red-500 font-semibold'>ID não fornecido na URL!</h3>";
    }
    ?>
  </div>

</body>
</html>
