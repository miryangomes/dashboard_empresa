<?php

    if(isset($_POST['submit']))
    {
        // print_r($_POST['nome']);

        include_once('C:/xampp/htdocs/Assets/sql/connection/config.php');

        $dtvenda = $_POST['dtvenda'];
        $dtVcto = $_POST['dtVcto'];
        $dtPgto = $_POST['dtPgto'];
        $valor = $_POST['valor'];
        $valorPg = $_POST['valorPg'];

        $result = mysqli_query($conexao ,"INSERT INTO vendas(dataVenda,dataVcto,dataPgto,valor,valorPg) VALUES ('$dtvenda', '$dtVcto','$dtPgto','$valor','$valorPg')");
        

        
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Processar o formulário e inserir dados no banco de dados
        
        // Redirecionar após o processamento
        header("Location: #");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Fornecedor</title>

    <!-- Icone/Favicon -->
    <link rel="icon favicon" href="/Assets/img/index_favicon.png" type="image/x-icon">

    <!-- Links CSS -->
    <!-- global/style -->
    <link rel="stylesheet" href="/Assets/css/style.css">

    <!-- navbar -->
    <link rel="stylesheet" href="/Assets/css/navbar.css">

    <!-- sistema -->
    <link rel="stylesheet" href="/Assets/css/sistema.css">

    <!-- botões -->
    <link rel="stylesheet" href="/Assets/css/buttons.css">

    <!-- Links externos -->
    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <!-- Cabeçalho (navbar) -->
  <header>
    <!-- Logo da Empresa -->
    <a href="#" class="logo">Empresa.</a>

    <!-- Seções -->
    <nav class="navbar">
        <ul class="menu">
         <li><a href="/index.php">Ínicio</a></li>
     
            <li><a href="#">Cadastrar</a>
                <ul class="submenu">
                    <li><a href="CadastrarProdutos.php">Produtos</a></li>
                    <li><a href="CadastrarFornecedor.php" >Fornecedores</a></li>
                    <li><a href="CadastrarCliente.php">Clientes</a></li>
                </ul>
            </li>

            <li><a href="#" class="active" >Vendas</a></li>
        </ul> 
    </nav>
</header>

    <br><br><br>

<main>
    
    <div id="wrap">
        <form action="Venda.php" method="POST">
            <h2>Cadastrar Venda:</h2>
            <br>
            <i class='bx bxs-package'></i>
            <input type="text" name="cliente" id="cliente" placeholder=" Cliente:" required>
            <br>
            <br>
            <i class='bx bxs-package'></i>
            <input type="date" name="dtvenda" id="dtvenda" placeholder=" Data da Venda:" required>
            <br>
            <br>
            <i class='bx bxs-package'></i>
            <input type="date" name="dtVcto" id="dtVcto" placeholder=" Vencimento:" required>
            <br>
            <br>
            <i class='bx bxs-package'></i>
            <input type="date" name="dtPgto" id="dtPgto" placeholder=" Data do Pagamento:" required>
            <br>
            <br>
            <i class='bx bx-purchase-tag-alt'></i>
            <input type="number" name="valor" step="0.01" min="0" id="valor" placeholder=" Valor:" required>
            <br>
            <br>
            <i class='bx bx-purchase-tag-alt'></i>
            <input type="number" name="valorPg" step="0.01" min="0" id="valorPg" placeholder=" Valor Pago:" required>
            <br>
       
                <button class="button" id="submit" type="submit" name="submit">
                <i class='bx bx-edit' ></i> Cadastar
                </button>
        </form>
    </div>
</main>

</body>
</html>