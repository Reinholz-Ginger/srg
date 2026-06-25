<?php
include '../../generalPhp/conection.php';
include '../../protect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT produto, valor FROM produtos WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $produto = $row['produto'];
        $valor = $row['valor'];
        $valorFormatado = number_format($valor / 100, 2, ',', '.');
    } else {
        echo 'Registro não encontrado!';
        exit;
    }
} else {
    echo 'ID não fornecido na URL!';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Produto</title>
  <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center p-4">

  <form action="atualizar.php" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 w-full max-w-md space-y-5">
    <h1 class="text-xl font-semibold text-center mb-4">Editar Produto</h1>

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div>
      <label for="produto" class="block mb-1 text-sm font-medium">Produto</label>
      <input type="text" id="produto" name="produto" required
             value="<?php echo $produto; ?>"
             class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>

    <div>
      <label for="valor" class="block mb-1 text-sm font-medium">Valor</label>
      <input type="text" id="valor" name="valor"
             value="R$ <?php echo $valorFormatado; ?>"
             onkeypress="$(this).mask('R$ ###.###.##',{ reverse: true })"
             required
             class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>

    <button type="submit"
            class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
      SALVAR
      <img src="../../assets/save.svg" alt="Salvar" class="w-5 h-5">
    </button>
  </form>

</body>
</html>
