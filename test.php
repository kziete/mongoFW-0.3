<?php
require 'vendor/autoload.php';
require 'config.php';
require 'modelo.php';

$m = new Noticia();

$a = $m->crear(array(
	'titulo' => "chao"
));


#$a->titulo = "Hola";
$a->numero = 123;
#$a->fecha = "2015-03-01 00:00:00";
//$a->asd = "asd";




#echo $a->titulo . "\n";

#echo $a->numero > 1;
#$a->grabar();

#echo "el Id:"  .$a->id . "\n";

#echo $m[0]->titulo . "\n";

foreach($m->filter(['numero__like' => 1]) as $k => $v){
	echo $v->titulo . "\n";
}