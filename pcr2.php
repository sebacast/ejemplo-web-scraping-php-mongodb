<?php 
include_once('funciones/capturas.php');
include_once('funciones/funciones.php');
header("Access-Control-Allow-Origin: *");
require 'vendor/autoload.php'; // incluir lo bueno de Composer
$url = 'https://www.fravega.com';
$rutaf='/audio/auriculares';
//$url = 'https://www.fravega.com/celulares';
    //1 Fravega
    //2 Garbarino
//recorrerCategoria($url,1);
$url2 = 'https://www.garbarino.com';
$rutag='/productos/auriculares/4349';
//recorrerCategoria($url,2);
$vec_prod = capturaFravega($url,$rutaf);
$vec_prod = array_merge($vec_prod,capturaGarbarino($url2,$rutag));

$cliente = new MongoDB\Client("mongodb://localhost:27017");
$colec = $cliente->pruebaDb->productos;

$resultado = $colec->insertMany($vec_prod);

//$colec->insertOne(['name' => 'Bob', 'state' => 'ny']);


//$deleteResult = $colec->deleteOne(['_id' => "5c9d973945af0798d87cf032"]);

//printf("Deleted %d document(s)\n", $deleteResult->getDeletedCount());

//echo "Inserted with Object ID '{$resultado->getInsertedId()}'";
//$conn = conectar_bd();

//$vec_prod = capturaGarbarino($url2);
//recorrerCategoria($vec_prod);

//
//echo json_encode($vec_prod);
//

//$vp json_encode($vec_prod);
//print_r($vp);

//$conn->close();
