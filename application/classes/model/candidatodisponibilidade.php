<?php

class Model_CandidatoDisponibilidade extends ORM
{
	protected $_table_name = 'candidato_disponibilidade';
	protected $table_columns = array(
		'candidato_id'	=> 	array('type'=>'int'),
		'semana'				=> array('type'=>'int'),
		'hora'				=> array('type'=>'int'),
		'status'				=> array('type'=>'int'),
		'cidade'				=> array('type'=>'string'),
	);
	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
	);
}
?>
