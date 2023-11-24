<?php

include_once('../assets/sql/connection/config.php');

    if(isset($_POST['submit']))
    {
        // print_r($_POST['nome']);

        $nome = $_POST['nome'];

        $result = mysqli_query($conexao ,"INSERT INTO fornecedores(descricao) VALUES ('$nome')");
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Processar o formulário e inserir dados no banco de dados
        
        // Redirecionar após o processamento
        header("Location: #");
        exit;
    }

    $sql = "SELECT * FROM fornecedores ORDER BY idFor DESC";
    $result = $conexao->query($sql);

    if(!empty($_GET['id']))
    {
     $id =$_GET['id'];

     $sqlSelect = "SELECT * FROM fornecedores WHERE idFor=$id";

     $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
         $sqlDelete = "DELETE FROM fornecedores WHERE idFor=$id";
         $resultDelete = $conexao->query($sqlDelete);
         echo '<script>window.location.href = window.location.href;</script>';
        }
        header('Location: CadastrarFornecedor.php');
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
    <link rel="stylesheet" href="../tools/scss/main.css">

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
         <li><a href="/index.html">Ínicio</a></li>
     
            <li><a href="#" class="active">Cadastrar</a>
                <ul class="submenu">
                    <li><a href="CadastrarProdutos.php">Produtos</a></li>
                    <li><a href="#" class="active">Fornecedores</a></li>
                    <li><a href="CadastrarCliente.php">Clientes</a></li>
                </ul>
            </li>

            <li><a href="Venda.php">Vendas</a></li>
        </ul> 
    </nav>
</header>

    <br><br><br>

<main>
    
    <div id="wrap">
        <form action="CadastrarFornecedor.php" method="POST">
            <h2>Cadastrar Fornecedor:</h2>
            <br>
            <i class='bx bxs-package'></i>
            <input type="text" name="nome" id="nome" placeholder=" Nome:" requrired>
            <br>
       
                <button class="button" id="submit" type="submit" name="submit">
                <i class='bx bx-edit' ></i> Cadastar
                </button>
        </form>
    </div>

    <br><br><br>

    <div id="saida">
        <h2>Fornecedores Cadastrados:</h2>
        <br>
        <table border="0" width="100%" height="5%">
            <tr>
                <td width="30px">
                    id
                </td>
                <td>
                    Nome
                </td>
                <td>EXCLUIR</td>
            </tr>
            <tbody>
                <?php 
                    while($forn_data = mysqli_fetch_assoc($result))
                    {
                        echo "<tr>";
                        echo "<td>".$forn_data['idFor']."</td>";  
                        echo "<td>".$forn_data['descricao']."</td>"; 
                        echo "<td> <a href='CadastrarFornecedor.php?id=$forn_data[idFor]'><button class=button ><i class='bx bx-x-circle'></i></button></a> </td>";
                    }
                ?>
            </tbody>
        </table>
    </div>

</main>



</body>
</html>