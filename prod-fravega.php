<?php 
include_once('funciones/capturas.php');
include_once('funciones/funciones.php');
header("Access-Control-Allow-Origin: *");

require 'vendor/autoload.php'; // incluir lo bueno de Composer
$url = 'https://www.fravega.com';
$con = conectar_bd();
//categorias de fravega
$result = $con->query(
    "select * from categoria_dir where idt = 1"
);
$vec_prod = array();
$v=0;
while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    echo $url.$row["ruta"];
    echo '<br>';
    if($v==0){
        $vec_prod = capturaFravega($url,$row["ruta"]);
        echo'empieza<br>';
        $v++;
    }
    else{
        $vec_prod = array_merge($vec_prod,capturaFravega($url,$row["ruta"]));
        echo 'union de vectores<br>';
    }
    //echo $row["ruta"];
}
//recorrerCategoria($vec_prod);


$cliente = new MongoDB\Client("mongodb://localhost:27017");
$colec = $cliente->pruebaDb->productos;

$resultado = $colec->insertMany($vec_prod);
