<!DOCTYPE html>
<head>
    <title>Sistema de Estoque</title>
</head>
<body>

    <!-- Head HTML & Navegação + cabeçalho -->
    <?php
        include ('view/src/php/_header-nav.php');
    ?>

    <main>
        <?php
         echo '<h2 name="welcome">Bem-vindo '.$_SESSION['login'].'</h2>';
        ?>
    </main>
    
</body>
</html>