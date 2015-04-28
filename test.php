<?php
require 'vendor/autoload.php';
require 'modelo.php';

$m = new ModeloEjemplo();

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

#echo $m[0]->titulo . "\n";

foreach($m as $k => $v){
	echo $v->titulo . "\n";
}