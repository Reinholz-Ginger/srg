<?php include '../protect.php'; ?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apagar Registro</title>
    <link rel="stylesheet" href="apagar.css">
    <link rel="stylesheet" href="../onLoad/onLoad.css">
    <link rel="stylesheet" href="../index/root.css">
    <script src="../onLoad/onLoad.js"></script>

       <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>
<body onload="onLoad()" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center">

    <div id="preload" class="absolute inset-0 z-50 flex items-center justify-center bg-white dark:bg-gray-900">
        <div class="circle-line">
            <div class="circle-red">&nbsp;</div>
            <div class="circle-blue">&nbsp;</div>
            <div class="circle-green">&nbsp;</div>
            <div class="circle-yellow">&nbsp;</div>
        </div>
    </div>

    <div class="popUpContainer bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 text-center max-w-md w-full space-y-6">
        <?php
        include '../generalPhp/conection.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
                $sqlDeleteItens = "DELETE FROM pedidos_dados WHERE chaveAcesso='$id'";
                if (mysqli_query($conn, $sqlDeleteItens)) {
                    $sqlDeleteCadastro = "DELETE FROM pedidoscadastro WHERE chaveAcesso='$id'";
                    if (mysqli_query($conn, $sqlDeleteCadastro)) {
                        echo "<img src='../assets/fileDeleted.svg' alt='Registro deletado' class='mx-auto w-24 h-24'>";
                        echo "<h3 class='text-xl font-semibold'>Registro deletado com sucesso</h3>";
                        echo "<div class='mt-4'>";
                        echo "<a href='cadastrodepedidos.php' class='bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow'>Lista de Pedidos</a>";
                        echo "</div>";
                    } else {
                        echo "<p class='text-red-500'>Erro ao excluir da tabela pedidoscadastro: " . mysqli_error($conn) . "</p>";
                    }
                } else {
                    echo "<p class='text-red-500'>Erro ao excluir da tabela pedidos_dados: " . mysqli_error($conn) . "</p>";
                }
                mysqli_close($conn);
                exit;
            }   

            // Se não confirmou ainda
            echo "<img src='../assets/delete.svg' alt='Confirmar exclusão' class='mx-auto w-24 h-24'>";
            echo "<h3 class='text-xl font-semibold'>Deseja realmente apagar esse registro?</h3>";
            echo "<div class='flex justify-center gap-4 mt-6'>";
            echo "<a href='apagar.php?id=$id&confirm=yes' class='bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded shadow'>Sim</a>";
            echo "<a href='cadastrodepedidos.php' class='bg-gray-300 hover:bg-gray-400 text-gray-800 dark:text-gray-900 px-5 py-2 rounded shadow'>Cancelar</a>";
            echo "</div>";
        } else {
            echo "<h3 class='text-lg text-red-500 font-medium'>Chave de acesso não fornecida na URL!</h3>";
        }
        ?>
    </div>

</body>
</html>
