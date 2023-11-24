<?php

include_once('conexão.php');

    if(isset($_POST['submit']))
    {

        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];

        // Verifica se a cidade já existe na tabela de cidade
        $select_sql = "SELECT idCid FROM cidade WHERE descricao = '$cidade' AND uf = '$uf'";
        $result = $conexao->query($select_sql);


        if ($result->num_rows > 0) {
            // Se a cidade já existir
            $row = $result->fetch_assoc();
            $idCidade = $row['idCid'];
        } else {
            // Se a cidade não existir
            $insert_sql = "INSERT INTO cidade (descricao, uf) VALUES ('$cidade', '$uf')";
            if ($conexao->query($insert_sql) === TRUE) {
                $idCidade = $conexao->insert_id; // Recupere o ID da nova cidade
            } else {
                echo "Erro ao inserir a cidade: " . $conexao->error;
            }
        }

        // Coloca os dados do Cliente na tabela de Clientes
        $insert_cliente_sql = "INSERT INTO clientes(nome, cidade_idCid) VALUES ('$nome', $idCidade)";
        if ($conexao->query($insert_cliente_sql) === TRUE) {
     echo "Cliente cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o Cliente: " . $conexao->error;
        }

     // Fecha a conexão com o banco de dados
     $conexao->close();
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

    <title>Cadastrar Clientes</title>

    <!-- Icone/Favicon -->
    <link rel="icon favicon" href="/Assets/img/index_favicon.png" type="image/x-icon">

    <!-- Links CSS -->
   <link rel="stylesheet" href="/tools/scss/main.css">
    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <!-- Cabeçalho (navbar) -->
  <header>
    <!-- Logo da Empresa -->
    <a href="../clientes.php" class="logo"><i class='bx bxs-chevrons-left' ></i></a>
</header>

    <br><br><br>

<main>
    
    <div id="wrap">
        <form action="CadastrarCliente.php" method="POST">
            <h2>Cadastrar Cliente:</h2>
            <br>
            <i class='bx bx-rename' ></i>
            <input type="text" name="nome" id="nome" placeholder=" Nome Completo:" requrired>
            <br>
            <i class='bx bxs-component'></i>
            <input type="text" name="cidade" id="cidade" placeholder=" Cidade:">
            <br>
            <i class='bx bx-rename' ></i>
            <input type="text" name="uf" id="uf" placeholder=" UF:">
            <br>
            <button class="button" id="submit" type="submit" name="submit">
                <i class='bx bx-edit' ></i> Cadastar
            </button>
        </form>
    </div>

    <br><br><br>




</main>

</body>
</html>