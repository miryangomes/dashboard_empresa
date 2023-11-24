<?php

include_once('/xampp/htdocs/Assets/sql/connection/config.php');

if(isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $fornecedores = $_POST['fornecedores'];

    // Validar os dados aqui, se necessário

    $insert_produto_sql = "INSERT INTO produtos (descricao, quantidade, valor) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($insert_produto_sql);
    $stmt->bind_param("sdd", $nome, $quantidade, $valor);

    if ($stmt->execute()) {
        $idProduto = $conexao->insert_id;

        // Inserir as relações na tabela de junção ProdutosFornecedores
        foreach ($fornecedores as $idFornecedor) {
            $insert_relacao_sql = "INSERT INTO produtofornecedor (Produtos_idProd, Fornecedores_idFor) VALUES (?, ?)";
            $stmt = $conexao->prepare($insert_relacao_sql);
            $stmt->bind_param("ii", $idProduto, $idFornecedor);

            if (!$stmt->execute()) {
                echo "Erro ao inserir a relação Produto-Fornecedor: " . $conexao->error;
            }
        }

        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o produto: " . $conexao->error;
    }
}

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Processar o formulário e inserir dados no banco de dados
        
        // Redirecionar após o processamento
        header("Location: #");
        exit;
    }

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

    <title>Cadastrar Produto</title>

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
     
            <li><a href="#" class="active">Cadastrar</a>
                <ul class="submenu">
                    <li><a href="CadastrarProdutos.php"  class="active">Produtos</a></li>
                    <li><a href="CadastrarFornecedor.php">Fornecedores</a></li>
                    <li><a href="CadastrarCliente.php">Clientes</a></li>
                </ul>
            </li>

            <li><a href="/Home/Venda.php">Vendas</a></li>
        </ul> 
    </nav>
</header>

    <br><br><br>

<main>
    
    <div id="wrap">
        <form action="CadastrarProdutos.php" method="POST">
            <h2>Cadastrar produto:</h2>
            <br>
            <i class='bx bx-rename' ></i>
            <input type="text" name="nome" id="nome" placeholder=" Nome do Produto:" required>
            <br>
            <i class='bx bxs-component'></i>
            <input type="number" name="quantidade" id="quantidade" placeholder=" Quantidade:" required>
            <br>
            <i class='bx bx-purchase-tag-alt'></i>
            <input type="number" step="0.01" min="0" name="valor" id="valor" placeholder=" Preço:" required>
            <br>
            <i class='bx bxs-package'></i>
            <input type="text" name="fornecedores" id="fornecedores" placeholder=" Fornecedor:">
            <br>

            <button class="button" id="submit" type="submit" name="submit">
                <i class='bx bx-edit' ></i> Cadastar
            </button>
        </form>
    </div>

    <br><br><br>

    
    <div id="saida">
        <h2>Produtos Cadastrados:</h2>
        <br>
        <table border="0" width="100%" height="5%">
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

    <!-- <script src="/Assets/js/script_produtos.js"></script> -->
    

</main>

</body>
</html>