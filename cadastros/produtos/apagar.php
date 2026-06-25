<?php include '../../protect.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apagar Registro</title>
    <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center p-4">

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-8 max-w-md w-full text-center space-y-6">
        <?php
        include '../../generalPhp/conection.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
                $sql = "DELETE FROM produtos WHERE id='$id'";
                if (mysqli_query($conn, $sql)) {
                    echo "<img src='../../assets/fileDeleted.svg' alt='Deletado' class='mx-auto w-16 h-16'>";
                    echo "<h2 class='text-xl font-semibold'>Registro deletado com sucesso</h2>";
                    echo "<a href='cadastrodeproduto.php' class='inline-block px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition'>Lista de Produtos</a>";
                } else {
                    echo "<h2 class='text-red-500 font-semibold'>Erro ao deletar: " . mysqli_error($conn) . "</h2>";
                }
                mysqli_close($conn);
                exit;
            }

            // Exibe confirmação
            echo "<img src='../../assets/delete.svg' alt='Confirmação' class='mx-auto w-16 h-16'>";
            echo "<h2 class='text-xl font-semibold'>Deseja realmente apagar esse registro?</h2>";
            echo "<div class='flex justify-center gap-4 mt-4'>";
            echo "  <a href='apagar.php?id=$id&confirm=yes' class='px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium'>Sim</a>";
            echo "  <a href='cadastrodeproduto.php' class='px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg font-medium'>Cancelar</a>";
            echo "</div>";

        } else {
            echo '<h2 class="text-red-500 font-semibold">ID não fornecido na URL!</h2>';
        }
        ?>
    </div>
    
</body>
</html>
