<?php 
include_once('funciones/capturas.php');
include_once('funciones/funciones.php');
header("Access-Control-Allow-Origin: *");

require 'vendor/autoload.php'; // incluir autoload de mongo driver
$url = 'https://www.garbarino.com';
$con = conectar_bd();
//categorias de garbarino
$result = $con->query(
    "select * from categoria_dir where idt = 2"
);
$vec_prod = array();
$v=0;
while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    echo $url.$row["ruta"];
    echo '<br>';
    if($v==0){
        $vec_prod = capturaGarbarino($url,$row["ruta"]);
        echo'empieza<br>';
        $v++;
    }
    else{
        $vec_prod = array_merge($vec_prod,capturaGarbarino($url,$row["ruta"]));
        echo 'union de vectores<br>';
    }
    //echo $row["ruta"];
}
//recorrerCategoria($vec_prod);


$cliente = new MongoDB\Client("mongodb://localhost:27017");
$colec = $cliente->pruebaDb->productos;

$resultado = $colec->insertMany($vec_prod);
