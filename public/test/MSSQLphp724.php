<?php

try
{

    //$servidor = "DESKTOP-MHNOLJ2";
    $servidor = "localhost";
    $instancia = "SQLEXPRESS2017";
    $porta = 1433;
    $database = "master";
    $usuario = "sa";
    $senha = "masterkey";
    
    $conexao = new PDO( "sqlsrv:Server={$servidor}\\{$instancia},{$porta};Database={$database}", $usuario, $senha );
}
catch ( PDOException $e )
{
    echo "Drivers disponiveis: " . implode( ",", PDO::getAvailableDrivers() );
    echo "\nErro: " . $e->getMessage();
    exit;
}

$query = $conexao->prepare( "select @@version" );
$query->execute();

$resultado = $query->fetchAll();

echo $resultado['0']['0'];

unset( $conexao );
unset( $query );