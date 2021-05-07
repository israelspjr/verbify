<?php

class Model_CandidatoIdioma extends ORM
{
	protected $_table_name = 'candidato_idioma';
	protected $table_columns = array(
		'candidato_id'	=> 	array('type'=>'int'),
		'idioma_id'		=> 	array('type'=>'int'),
		'outro'			=> 	array('type'=>'string'),
	);

	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'idioma' => array('model' => 'idioma', 'foreign_key' => 'idioma_id'),
	);

}
?>
