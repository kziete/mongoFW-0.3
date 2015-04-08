<?php
function mi_autocargador($clase) {
    include __DIR__ . '/core/' . str_replace('\\', '/', $clase ). '.php';
}

spl_autoload_register('mi_autocargador');


require 'Modelo.php';

$a = ModeloEjemplo::crear();


$a->titulo = "Hola";
$a->numero = 123;
$a->fecha = "2015-03-01 00:00:00";
//$a->asd = "asd";

#echo $a->titulo . "\n";
$a->grabar();
