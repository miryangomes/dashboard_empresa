<?php 

    // verificar login
        session_start();
        if (!isset($_SESSION['login'])) 
        {
            header('Location: /index.php'); // Redireciona para a página de login se não estiver logado
            exit();
        }
    // 
    
  include_once('Cadastros/conexão.php'); 

  $idProd = $client_data['idProd'];

$sql = "SELECT produtos.*, GROUP_CONCAT(fornecedores.descricao) AS fornecedores
        FROM produtos
        LEFT JOIN produtofornecedor ON produtos.idProd = produtofornecedor.Produtos_idProd
        LEFT JOIN fornecedores ON produtofornecedor.Fornecedores_idFor = fornecedores.idFor
        WHERE produtos.idProd = ?
        GROUP BY produtos.idProd";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idProd);
$stmt->execute();
$result = $stmt->get_result();



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
      header('Location: produtos.php');
    }

    $pagina = 1;

    if (isset($_GET['pagina'])) {
        $pagina = filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT);
    }

    if (!$pagina) {
        $pagina = 1;
    }

    $limite = 5;
    $inicio = ($pagina * $limite) - $limite;

    if(!empty($_GET['search']))
    {
        $searchTerm = $_GET['search'];
        $sql = "SELECT produtos.* 
                FROM produtos
                WHERE idProd LIKE '%$searchTerm%'
                OR descricao LIKE '%$searchTerm%'
                OR quantidade LIKE '%$searchTerm%'
                OR valor LIKE '%$searchTerm%'
                ORDER BY idProd DESC";

        $result = $conexao->query($sql);
    }
    else
    {
        // Se não houver pesquisa, execute a consulta original
        $sql = "SELECT produtos.* 
                FROM produtos 
                ORDER BY idProd DESC";

        $result = $conexao->query($sql);
    }

    // Obtenha o total de registros
    $totalRegistrosQuery = $conexao->query("SELECT COUNT(*) as count FROM ($sql) as subquery");
    $totalRegistros = $totalRegistrosQuery->fetch_assoc()["count"];

    $totalPaginas = ceil($totalRegistros / $limite);

    // Consulta paginada
    $sqlPaginado = "$sql LIMIT $inicio, $limite";
    $result = $conexao->query($sqlPaginado);

    if (!$result) 
    {
        echo "Erro na consulta: " . $conexao->error;
    }

    
?>

<!DOCTYPE html>
<head>
    <title>Sistema de Estoque</title>
</head>
<body>
    <!-- Head HTML & Navegação + cabeçalho -->
    <?php
        include ('src/php/_header-nav.php');
    ?>

<div class="info">
    <h2 class="title-c">Produtos Cadastrados:</h2>


    
    <div class="tools">
    <form class="d-flex" onsubmit="return false;">
        <input id="pesquisar" class="form-control me-sm-2" type="search" placeholder="Pesquisar">
        <button id="btnPesquisar" class="btn btn-secondary my-2 my-sm-0" type="button" onclick="searchData()"><i class='bx bx-search-alt'></i></button>
    </form>
       <div class="badges-a">
           <a href="Cadastros/CadastrarProdutos.php"> <span class="badge bg-success"><i class='bx bxs-objects-horizontal-left'></i> Novo Produto</span></a>
           <a href="venda.php"> <span class="badge bg-primary"><i class='bx bx-cart-add' ></i> Vendas</span></a>
       </div>
    </div>

    <div id="saida">
            <br>
            <table border="0" width="50%" height="5%" class="table table-hover">

                <thead>
                    <tr class="table-dark">
                        <th scope="col" width="30px">
                            id
                        </th>
                        <td>
                            Nome
                        </td>
                        <td>
                            Quantidade
                        </td>
                        <td>
                            Valor R$
                        </td>
                        <td>
                            Fornecedor
                        </td>
                        <td width="150px">
                            Ações
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        while ($product_info = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $product_info['idProd'] . "</td>";
                            echo "<td>" . $product_info['descricao'] . "</td>";
                            echo "<td>" . $product_info['quantidade'] . " unit.</td>";
                            echo "<td>R$ " . $product_info['valor'] . "</td>";
                            echo "<td>" . $product_info['fornecedores'] . "</td>";
                            echo "<td> 
                                    <a href='Cadastros/EditarProduto.php?id={$product_info['idProd']}'><button class='btn btn-secondary btn-sm'><i class='bx bxs-edit'></i></button></a>
                                    <button class='btn btn-primary btn-sm'><i class='bx bx-info-circle'></i></button>
                                    <a href='produtos.php?id={$product_info['idProd']}'><button class='btn btn-danger btn-sm'><i class='bx bxs-trash-alt'></i></button></a>
                                  </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
    
            </table>
        </div>
        <!-- Exibe os botões de navegação -->
        <?php
                echo '<ul class="pages pagination pagination-sm">';
                echo '<li class="page-item ' . ($pagina == 1 ? 'disabled' : '') . '">';
                echo '<a class="page-link" href="?pagina=' . max($pagina - 1, 1) . '">&laquo;</a>';
                echo '</li>';

                for ($i = 1; $i <= $totalPaginas; $i++) {
                    echo '<li class="page-item ' . ($pagina == $i ? 'active' : '') . '">';
                    echo '<a class="page-link" href="?pagina=' . $i . '">' . $i . '</a>';
                    echo '</li>';
                }

                echo '<li class="page-item ' . ($pagina == $totalPaginas ? 'disabled' : '') . '">';
                echo '<a class="page-link" href="?pagina=' . min($pagina + 1, $totalPaginas) . '">&raquo;</a>';
                echo '</li>';
                echo '</ul>';
            ?>
    </div>


    <script>
        var search = document.getElementById('pesquisar');

        search.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        });

        function searchData() {
            var searchTerm = search.value;
            window.location.href = 'produtos.php?search=' + searchTerm;
        }
    </script>

</body>
</html>