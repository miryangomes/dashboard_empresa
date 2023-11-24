<?php

include_once('/xampp/htdocs/Assets/sql/connection/config.php');

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

    $sql = "SELECT clientes.*, cidade.* 
    FROM clientes 
    LEFT JOIN cidade ON clientes.cidade_idCid = cidade.idCid
    ORDER BY clientes.idCli DESC";

    $result = $conexao->query($sql);
  
    if(!empty($_GET['id']))
    {
     $id =$_GET['id'];

     $sqlSelect = "SELECT * FROM clientes WHERE idCli=$id";

     $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
         $sqlDelete = "DELETE FROM clientes WHERE idCli=$id";
         $resultDelete = $conexao->query($sqlDelete);
         echo '<script>window.location.href = window.location.href;</script>';
        }
        header('Location: CadastrarCliente.php');
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
                    <li><a href="CadastrarProdutos.php">Produtos</a></li>
                    <li><a href="CadastrarFornecedor.php">Fornecedores</a></li>
                    <li><a href="CadastrarCliente.php" class="active">Clientes</a></li>
                </ul>
            </li>

            <li><a href="/Home/Venda.php">Vendas</a></li>
        </ul> 
    </nav>
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

    <div id="saida">
        <h2>Clientes Cadastrados:</h2>
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
                    Cidade.
                </td>
                <td>
                    UF.
                </td>
                <td width="100px">
                    EXCLUIR
                </td>
            </tr>
            <tbody>
                <?php 
                    while($client_data = mysqli_fetch_assoc($result))
                    {
                        echo "<tr>";
                        echo "<td>".$client_data['idCli']."</td>";
                        echo "<td>".$client_data['nome']."</td>";
                        echo "<td>".$client_data['descricao']."</td>";  
                        echo "<td>".$client_data['uf']."</td>"; 
                        echo "<td> <a href='CadastrarCliente.php?id=$client_data[idCli]'><button class=button ><i class='bx bx-x-circle'></i></button></td></a>";    
                    }
                ?>  
            </tbody>
            
        </table>
    </div>
    




</main>

</body>
</html>