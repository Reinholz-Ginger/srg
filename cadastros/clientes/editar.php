<?php
include '../../generalPhp/conection.php';
include '../../protect.php';



// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the 'id' value from the URL
    $id = $_GET['id'];

    // Create a SQL query to fetch the data for the specified 'id'
    $sql = "SELECT nome FROM clientes WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and data was found
    if ($row = mysqli_fetch_assoc($result)) {
        $nome = $row['nome'];
        
        
        
    } else {
        echo 'Registro não encontrado!';
    }
} else {
    echo 'ID não fornecido na URL!';
}
?>

<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon" />
  <title>Editar Cliente</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <script>
    document.documentElement.classList.add('dark');
  </script>
  <script src="../../onLoad/onLoad.js?v=1.7.1"></script>
  <script src="../../generalScripts/version.js?v=1.7.1"></script>
  <script src="../../generalScripts/backPage.js?v=1.7.1"></script>
  <script src="../../mobileMenu/js/mobileMenu.js?v=1.7.1"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center p-4">

  <form action="atualizar.php" method="POST" class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md space-y-4">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />

    <h1 class="text-xl font-bold text-center">Editar Cliente</h1>

    <div class="flex flex-col">
      <label for="nome" class="mb-1 font-medium">NOME</label>
      <input
        placeholder="NOME"
        type="text"
        id="nome"
        name="nome"
        value="<?php echo htmlspecialchars($nome); ?>"
        required
        class="px-3 py-2 rounded bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
      />
    </div>

    <button
      type="submit"
      value="Atualizar"
      class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition"
    >
      SALVAR
      <img src="../../assets/save.svg" alt="Salvar" class="w-5 h-5" />
    </button>
  </form>

</body>
</html>

