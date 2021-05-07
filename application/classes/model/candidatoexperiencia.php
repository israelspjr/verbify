<?php

class Model_CandidatoExperiencia extends ORM
{
	protected $_table_name = 'candidato_experiencia';
	protected $table_columns = array(
		'candidato_id'	=> 	array('type'=>'int'),
		'experiencia_id'	=> 	array('type'=>'int'),
		'valor'				=> 	array('type'=>'int'),
		'anos'				=> 	array('type'=>'int'),
		'escolas'			=> 	array('type'=>'string'),
		'qual'					=> 	array('type'=>'string'),
	);

	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'experiencia' => array('model' => 'experiencia', 'foreign_key' => 'experiencia_id'),
	);

}
?>
