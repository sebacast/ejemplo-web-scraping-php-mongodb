<?php
require 'vendor/autoload.php'; // incluir lo bueno de Composer

$cliente = new MongoDB\Client("mongodb://localhost:27017");
$coleccion = $cliente->pruebaDb->pruebaCol;

$resultado = $coleccion->insertOne( [ 'codigo' => 3, 'nombre' => 'mongo' , 'autor' => 'seba' ] );

echo "ID '{$resultado->getInsertedId()}'";
?>