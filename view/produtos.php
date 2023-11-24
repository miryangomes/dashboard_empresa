<?php
    include_once('Cadastros/conexão.php');

    $sql = "SELECT * FROM produtos ORDER BY idProd DESC";
    $result = $conexao->query($sql);

    if(!empty($_GET['id']))
    {
     $id =$_GET['id'];

     $sqlSelect = "SELECT * FROM produtos WHERE idProd=$id";

     $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
         $sqlDelete = "DELETE FROM produtos WHERE idProd=$id";
         $resultDelete = $conexao->query($sqlDelete);
         echo '<script>window.location.href = window.location.href;</script>';
        }
        header('Location: CadastrarProdutos.php');
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Estoque</title>

    <!-- Icone da página -->
    <link rel="icon favicon" href="Assets/img/index_favicon.png" type="image/x-icon">

    <!-- Link CSS -->
    <link rel="stylesheet" href="/tools/scss/main.css">
    
    <!-- Link boxicons -->
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

<div class="info">
<h2 class="title">Produtos Cadastrados:</h2>

<div class="register">
        <a href="Cadastros/CadastrarProdutos.php"><i class='bx bxs-add-to-queue' ></i> Novo Produto</a>
    </div>
    <div id="saida">
            <br>
            <table border="0" width="50%" height="5%">
                <tr>
    
                    <td width="30px">
                        id
                    </td>
                    <td>
                        Nome
                    </td>
                    <td>
                        Quant.
                    </td>
                    <td>
                        Preço
                    </td>
                </tr>
                <tbody>
                    <?php
                        while($product_data = mysqli_fetch_assoc($result))
                        {
                            echo "<tr>";
                            echo "<td>".$product_data['idProd']."</td>";
                            echo "<td>".$product_data['descricao']."</td>";
                            echo "<td>".$product_data['quantidade']."</td>";
                            echo "<td>".$product_data['valor']."</td>";
                            echo "<td> <a href='CadastrarProdutos.php?id=$product_data[idProd]'><button class=button ><i class='bx bx-x-circle'></i></button></td></a>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
</div>
</body>
</html>