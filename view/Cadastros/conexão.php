<?php

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = 'Miryan<3';
    $dbName = 'sistema';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // if($conexao->connect_errno)
    // {
    //     echo "Erro na conexão.";
    // }
    // else
    // {
    //    echo "Conexão feita com Sucesso.";
    // }

?>