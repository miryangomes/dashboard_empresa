<?php

    if(isset($_POST['submit']))
    {
        // print_r($_POST['nome']);

        include_once('../assets/sql/connection/config.php');

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
   <link rel="stylesheet" href="../tools/scss/main.css">

    <!-- Links externos -->
    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
 <!-- Cabeçalho dá página ----------------------------------------------------->
   <header>
        <a href="/index.php" class="logo">Informática.</a>
    </header>

    <div class="navigation">
        <ul>
            <li>
                <a href="/view/clientes.php">
                    <span class="icon"><i class='bx bxs-user-detail'></i></span>
                    <span class="title">Clientes</span>
                </a>
            </li>
            <li>
                <a href="/view/produtos.php">
                    <span class="icon"><i class='bx bxs-component'></i></span>
                    <span class="title">Produtos</span>
                </a>
            </li>
            <li>
                <a href="/view/fornecedores.php">
                    <span class="icon"><i class='bx bx-collection' ></i></span>
                    <span class="title">Fornecedores</span>
                </a>
            </li>
            <li>
                <a href="/view/venda.php">
                    <span class="icon"><i class='bx bx-store'></i></span>
                    <span class="title">Vendas</span>
                </a>
            </li>
           <li>
                <a href="/index.php?logout">
                    <span class="icon"><i class='bx bx-log-out'></i></span>
                    <span class="title">Sair</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="toggle" onclick="toggleMenu();"></div>
    <script type="text/javascript">
        function toggleMenu() {
            // Seleciona o elemento HTML com a classe 'navigation'
            let navigation = document.querySelector('.navigation');
            
            // Seleciona o elemento HTML com a classe 'toggle'
            let toggle = document.querySelector('.toggle');
            
            // Alterna a classe 'active' no elemento 'navigation'
            navigation.classList.toggle('active');
            
            // Alterna a classe 'active' no elemento 'toggle'
            toggle.classList.toggle('active');
        }
    </script>

    <br><br><br>

<main>
    
    <div id="wrap">
        <form action="Venda.php" method="POST">
            <h2>Fazer Venda:</h2>
            <br>
            <i class='bx bxs-package'></i>
            <input type="text" name="cliente" id="cliente" placeholder=" Cliente:" required>
            <br>
            <br>
            <label for="dtvenda"> Data da Venda:</label><br>
            <input type="date" name="dtvenda" id="dtvenda" placeholder=" Data da Venda:" required>
            <br>
            <br>
            <label for="dtVcto">Vencimento:</label><br>
            <input type="date" name="dtVcto" id="dtVcto" placeholder=" Vencimento:" required>
            <br>
            <br>
            <label for="dtPgto"> Data do Pagamento:</label><br>
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