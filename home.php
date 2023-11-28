<!DOCTYPE html>
<head>
    <title>Sistema de Estoque</title>
</head>
<body>


<?php
    include_once('view/Cadastros/conexão.php'); 

    $sql = "SELECT p.descricao, SUM(v.quantidade) AS total
    FROM sistema.vendas v
    INNER JOIN produtos p
    ON v.produto_idProd = p.idProd
    GROUP BY p.descricao;";

    $sqlpivot = 
    "SELECT c.nome, 
    SUM(CASE WHEN ci.descricao = 'Tarumã' THEN v.quantidade ELSE 0 END) AS 'Tarumã',
    SUM(CASE WHEN ci.descricao = 'Assis' THEN v.quantidade ELSE 0 END) AS 'Assis'
    FROM vendas v
    INNER JOIN clientes c
    ON c.idCli = v.cliente_idCli
    INNER JOIN cidade ci
    ON ci.idCid = c.cidade_idCid
    GROUP BY c.nome;
    ";

    $result = $conexao->query($sql);

    $resultpivot = $conexao->query($sqlpivot);
?>

    <!-- Head HTML & Navegação + cabeçalho -->
    <?php
        include ('view/src/php/_header-nav.php');
    ?>

    <main>
        <?php
         echo '<h2 class="title-c" name="welcome">Bem-vindo '.$_SESSION['login'].'</h2>';
        ?>

    <h2 class="title-c" name="welcome"><i class='bx bx-tachometer' ></i> Dashboard:</h2>    

<div id="dashboard">
            <div>
                <table border="0" width="50%" height="5%" class="dash table table-hover">
                <h4>Total de vendas por produto:</h4>
                    <thead>
                        <tr class="table-primary">
                            <td>
                                Produtos
                            </td>
                            <td>
                                Vendas
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($venda_data = mysqli_fetch_assoc($result))
                            {
                                echo "<tr>";
                                echo "<td>".$venda_data['descricao']."</td>";
                                echo "<td>".$venda_data['total']."</td>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div>
                <table border="0" width="50%" height="5%" class="table table-hover">
                <h4>Total de vendas por pessoas por cidades:</h4>
                    <thead>
                        <tr class="table-warning">
                            <td>
                                Pessoas
                            </td>
                            <td>
                                Tarumã
                            </td>
                            <td>
                                Assis
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($pessoas_data = mysqli_fetch_assoc($resultpivot))
                            {
                                echo "<tr>";
                                echo "<td>".$pessoas_data['nome']."</td>";
                                echo "<td>".$pessoas_data['Tarumã']."</td>";
                                echo "<td>".$pessoas_data['Assis']."</td>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    
</body>
</html>