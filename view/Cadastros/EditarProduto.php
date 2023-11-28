<?php
    // verificar login
        session_start();
        if (!isset($_SESSION['login'])) 
        {
            header('Location: /index.php'); // Redireciona para a página de login se não estiver logado
            exit();
        }
    // 
?>

<!DOCTYPE html>
<head>
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
    <!-- Head HTML & Navegação + cabeçalho -->
    <?php
        include ('../src/php/_header-nav.php');
    ?>
<body>
    

<main>
  
<?php

include_once('conexão.php');

// Inicializa as variáveis
$nome = $quantidade = $valor = $fornecedores = '';
$idProduto = $idFornecedor = null;

// Verifica se há um ID na URL
if (!empty($_GET['id'])) {
    $idProduto = $_GET['id'];

    // Recupera os dados do produto
    $sqlSelect = "SELECT * FROM produtos WHERE idProd=?";
    
    $stmtSelect = $conexao->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $idProduto);
    $stmtSelect->execute();

    $resultSelect = $stmtSelect->get_result();

    if ($resultSelect->num_rows > 0) {
        $produto_data = $resultSelect->fetch_assoc();
        $nome = $produto_data['descricao'];
        $quantidade = $produto_data['quantidade'];
        $valor = $produto_data['valor'];
    } else {
        // Redireciona se o produto não for encontrado
        header('Location: /produtos.php');
        exit();
    }

    $stmtSelect->close();
}

// Verifica se o formulário de edição foi enviado
if (isset($_POST['editar_produto'])) {
    // Recupera os dados do formulário
    $idProduto = $_POST['idProduto'];
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $fornecedores = $_POST['fornecedores'];

    // Atualiza os dados do Produto na tabela de Produtos
    $sqlUpdateProduto = "UPDATE produtos SET descricao=?, quantidade=?, valor=? WHERE idProd=?";
    $stmtUpdateProduto = $conexao->prepare($sqlUpdateProduto);
    $stmtUpdateProduto->bind_param("ssdi", $nome, $quantidade, $valor, $idProduto);

    if ($stmtUpdateProduto->execute()) {
        // Remove as relações existentes na tabela de junção ProdutosFornecedores
        $sqlDeleteRelacoes = "DELETE FROM produtofornecedor WHERE Produtos_idProd=?";
        $stmtDeleteRelacoes = $conexao->prepare($sqlDeleteRelacoes);
        $stmtDeleteRelacoes->bind_param("i", $idProduto);
        $stmtDeleteRelacoes->execute();

        // Insere as novas relações na tabela de junção ProdutosFornecedores
        $insert_relacao_sql = "INSERT INTO produtofornecedor (Produtos_idProd, Fornecedores_idFor) VALUES (?, ?)";
        $stmtRelacao = $conexao->prepare($insert_relacao_sql);
        $stmtRelacao->bind_param("ii", $idProduto, $idFor);

        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Produto editado com sucesso!',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>";
    } else {
        echo "<div class='erro alert alert-dismissible alert-danger'>
                <strong>Erro ao editar o Produto: </strong>" . $conexao->error .
            "</div>";
    }

    $stmtUpdateProduto->close();
    $stmtDeleteRelacoes->close();
}

?>
    <div id="editar" class="badges-b">
        <a href="../produtos.php"> <span class="badge bg-secondary"><i class='bx bx-arrow-back' ></i> Voltar</span></a>
        <a href="../fornecedores.php"> <span class="badge bg-primary"><i class='bx bx-buildings' ></i> Fornecedores</span></a>
    </div>

    <div class="cadastro card bg-light mb-3">
        <div class="card-header"><strong>Editar Produto</strong></div>
        <div id="wrap" class="form-group card-body">
            <h4 class="card-title">Insira os dados:</h4>
            <p class="card-text">Certifique-se de que os dados estejam corretos.</p>
            <form action="CadastrarProdutos.php" method="POST">
            <input class="form-control" type="text" name="nome" id="nome" value="<?php echo $nome; ?>" placeholder=" Nome do Produto:">
            <input class="form-control" type="number" name="quantidade" id="quantidade" value="<?php echo $quantidade; ?>" placeholder=" Quantidade:">
            <input class="form-control" type="number" step="0.01" min="0" name="valor" id="valor" value="<?php echo $valor; ?>" placeholder=" Preço R$:" aria-label="Valor em R$">
            <input class="form-control" type="text" name="fornecedores" id="fornecedores" value="<?php echo $fornecedores; ?>" placeholder=" Fornecedor:">

                <button class="btn btn-primary" id="submit" type="submit" name="editar_cliente">
                    <i class='bx bx-edit' ></i> Editar
                </button>
            </form>
        </div>
    </div>
</main>

</body>
</html>