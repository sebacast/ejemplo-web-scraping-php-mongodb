<?php 
include_once('simplehtmldom/simple_html_dom.php');
function capturaFravega($url,$ruta){
    $url.=$ruta;
    $url.='/?PageNumber=';
    $vali=1;
    $pag=$url;
    $cp=1;
    $vec_prod = array();
    $c = 0;
    while($vali!=$c){
        $vali=$c;
        $url=$pag;
        $url.=$cp;
	    $html = file_get_html($url);
	    $items = $html->find('div div ul li');
	
	    //$items = $html->find('div[class=shelf-resultado]'); //para buscar por atributo
	    foreach($items as $li) {
    //echo $producto->children(0)->children(0);
    	    foreach ($li->find('div.image a img') as $div) {//imagen del producto
    	        //echo $div;
                //echo $c;
                $div = extraerSRC($div);
        	    $vec_prod[$c]["imagen"] = $div;
                $vec_prod[$c]["tienda"] = 'Fravega';
                $vec_prod[$c]["categoria"] = str_replace("/", "", $ruta);
    	    }
    	    foreach ($li->find('div.wrapData h2 a') as $div) {//titulo del prod
    	        //echo $div;
        	    $vec_prod[$c]["titulo"] = $div->plaintext;
    	    }
            foreach ($li->find('div.wrapData h2 a') as $div) {//link del prod
                //echo $div;
                $vec_prod[$c]["link"] = $div->href;
            }
    	    foreach ($li->find('div.wrapData a span.prodPrice') as $div) {//precio del prod
        	    $c2 = 0;
        	    foreach ($div->children() as $precio) {
                    //echo $precio;
                    $precio = $precio->plaintext;
                    switch ($c2) {
                        case 0: $vec_prod[$c]["precioWeb"] = (intval(preg_replace('/[^0-9]+/', '', $precio)))/100; break;
                        case 1: $vec_prod[$c]["precioOferta"] = (intval(preg_replace('/[^0-9]+/', '', $precio)))/100; break;
                        case 2: $vec_prod[$c]["descuento"] = (intval(preg_replace('/[^0-9]+/', '', $precio)))/100; break;
                        default: break;
                    }
            	    $c2++;
        	    }
        	    $c++;
    	    }
	    }
        $cp++;
    }
	//$vec_prod["paginas"] = contarPaginas($html);
	return $vec_prod;
}

function recorrerCategoria($vec_prod){
    foreach ($vec_prod as $producto) {
        if(!empty($producto["imagen"]) && !empty($producto["titulo"])){
            echo $producto["imagen"]."<br>";
            echo $producto["titulo"]."<br>";
            echo $producto["link"]."<br>";
            echo "$".$producto["precioWeb"]."<br>";
            if(!empty($producto["precioOferta"])){
                echo "$".$producto["descuento"]."<br>";
            }
            if(!empty($producto["precio"][2])){
                echo $producto["precio"][2]."%<br>";
            }
        }
        else{
            echo "vacio";
        }
    }
}
function capturaGarbarino($url,$ruta){
    $url.=$ruta;
    $num = contarPaginasGarbarino($url);
    if($num == 0){
        $num=1;
    }
    $url.='?page=';
    $pag=$url;
    //$cp=1;
    $vec_prod = array();
    $c = 0;
    for($cp=1;$cp<=$num;$cp++){
        $url=$pag;
        $url.=$cp;
        $html = file_get_html($url);
        $items = $html->find('div.itemBox');
    
        //$items = $html->find('div[class=shelf-resultado]'); //para buscar por atributo
        foreach($items as $box) {
    //foreach ($box->children() as $div) {
            foreach ($box->children(1)->find('a img[src]') as $dato){//imagen
                $dato = extraerSRC($dato);
                $vec_prod[$c]["imagen"] = $dato;
                $vec_prod[$c]["tienda"] = 'Garbarino';
                $vec_prod[$c]["categoria"] = str_replace("/", "", $ruta);
                //echo $dato; 

                //PRUEBA DE JSON
                //$vec_prod[$c]["codigo"] = $c;
                ///////////////// 
            }
            foreach ($box->children(2)->find('.itemBox--title') as $dato){//titulo
                //echo $dato; 
                $vec_prod[$c]["titulo"] = $dato->plaintext; 
            }
            foreach ($box->children(1)->find('a') as $dato){//link
                //echo $dato; 
                $dato = "https://www.garbarino.com".$dato->href; 
                $vec_prod[$c]["link"] = $dato;
            }
            foreach ($box->children(2)->find('div.itemBox--price') as $img){//precio
                foreach ($img->find('span.value-item') as $i) {//precio
                    //echo $i;
                    $vec_prod[$c]["precioOferta"] = intval(preg_replace('/[^0-9]+/', '', $i));
                }
                foreach ($img->find('span.value-note del') as $i) {//precio tachado
                    //echo $i;
                    $vec_prod[$c]["precioWeb"] = (intval(preg_replace('/[^0-9]+/', '', $i)));
                }
                foreach ($img->find('span.value-note span') as $i) {//descuento
                //echo $i;
                    $vec_prod[$c]["descuento"] = intval(preg_replace('/[^0-9]+/', '', $i));
                }
                $c++;
            }
        }
        //$cp++;
    }
    //$vec_prod["paginas"] = contarPaginas($html);
    return $vec_prod;
}

function contarPaginasGarbarino($url){
    $html = file_get_html($url);
    $items = $html->find('nav.pagination__container');
    $mayor=0;
    foreach($items as $nav) {
        foreach ($nav->find('li a') as $li) {
            $li = intval($li->plaintext);
            if($li > $mayor){
                $mayor = $li;
            }
            //echo $li;
        }    
    }
return $mayor;
}
function extraerSRC($cadena) {
    preg_match('@src="([^"]+)"@', $cadena, $array);
    $src = array_pop($array);
    return $src;
}
