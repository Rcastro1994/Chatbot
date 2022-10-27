<?php

if($text == "getTIME"){
    $text = "La hora es " . date("g:i a");
}else if($text == "getDATE"){
    $text = "La fecha es " . date("l, F jS, Y");
}else if($text == "getANSIEDAD"){
    $text ='<a>Ingresa al siguiente test: http://localhost/proyecto/test/responderTest&id=2</a>';
}else if($text == "getDIAGNOSTICO"){
    $text ='<a>Pronto te sentiras mejor! Ingresa al siguiente link para ver tu diagnóstico inicial: http://localhost/proyecto/usuario/verGrafico</a>';
}else if($text == "getTEST1"){
    $text ='<a>Ingresa al siguiente test para poder ayudarte: http://localhost/proyecto/test/responderTest&id=4</a>';
}
?>
