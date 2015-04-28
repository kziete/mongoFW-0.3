<?php
require 'vendor/autoload.php';
require 'Modelo.php';

$a = ModeloEjemplo::crear();


$a->titulo = "Hola";
$a->numero = 123;
$a->fecha = "2015-03-01 00:00:00";
//$a->asd = "asd";

#echo $a->titulo . "\n";

echo $a->numero < 1;
#$a->grabar();
