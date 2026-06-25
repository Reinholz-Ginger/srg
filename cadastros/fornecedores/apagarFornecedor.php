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
<body class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white px-4">

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md max-w-md w-full text-center space-y-4">
        <?php
        include '../../generalPhp/conection.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
                $sql = "DELETE FROM fornecedores WHERE id='$id'";
                if (mysqli_query($conn, $sql)) {
                    echo "<img src='../../assets/fileDeleted.svg' alt='Registro deletado' class='w-16 mx-auto'>";
                    echo "<h3 class='text-xl font-semibold'>Registro deletado com sucesso</h3>";
                    echo "<a href='cadastrodeFornecedor.php' class='inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md'>Lista de Fornecedores</a>";
                } else {
                    echo "<p class='text-red-600 font-medium'>Erro ao deletar fornecedor: " . mysqli_error($conn) . "</p>";
                }
                mysqli_close($conn);
                exit;
            }

            // Confirmação
            echo "<img src='../../assets/delete.svg' alt='Confirmação de exclusão' class='w-16 mx-auto'>";
            echo "<h3 class='text-xl font-semibold'>Deseja realmente apagar esse registro?</h3>";
            echo "<div class='flex justify-center gap-4 mt-6'>";
            echo "<a href='apagarFornecedor.php?id=$id&confirm=yes' class='bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md'>Sim</a>";
            echo "<a href='cadastrodeFornecedor.php' class='bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md'>Cancelar</a>";
            echo "</div>";
        } else {
            echo "<h3 class='text-red-600 font-semibold'>ID não fornecido na URL!</h3>";
        }
        ?>
    </div>

</body>
</html>
