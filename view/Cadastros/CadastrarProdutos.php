<?php

include_once('Cadastros/conexão.php');

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
        header("Location: ../produtos.php");
        exit;
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
    <link rel="stylesheet" href="/tools/scss/main.css">

    <!-- Links externos -->
    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <!-- Cabeçalho (navbar) -->
  <header>
    <!-- Logo da Empresa -->
    <a href="../produtos.php" class="logo"><i class='bx bxs-chevrons-left' ></i></a>
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

</main>

</body>
</html>