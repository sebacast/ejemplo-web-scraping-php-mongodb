<?php 
//include_once('simplehtmldom/simple_html_dom.php');
include_once('funciones/capturas.php');
include_once('funciones/funciones.php');
//header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
?>


<?php
$url = 'https://www.fravega.com';
$ruta = '/audio/auriculares';
//$url = 'https://www.fravega.com/celulares';
    //1 Fravega
    //2 Garbarino
//recorrerCategoria($url,1);
$url2 = 'https://www.garbarino.com/productos/auriculares/4349';
$ruta2 = '/audio/auriculares';
//recorrerCategoria($url,2);
$vec_prod = capturaFravega($url,$ruta);
$vec_prod = array_merge($vec_prod,capturaGarbarino($url2,$ruta2));
//$conn = conectar_bd();

//$vec_prod = capturaGarbarino($url2);
//recorrerCategoria($vec_prod);
echo json_encode($vec_prod);
//$vp json_encode($vec_prod);
//print_r($vp);

//$conn->close();



?>