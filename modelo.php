<?php

use \Db\Campo as Campo;

class Noticia extends Db\Entidad{

	public function init(){
		return array(
			'titulo' => new Campo\CampoText,
			'numero' => new Campo\CampoInteger,
			#'fecha' => new Campo\CampoFechaHora
		);
	}
}
