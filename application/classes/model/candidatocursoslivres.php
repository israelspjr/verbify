<?php

class Model_CandidatoCursosLivres extends ORM
{
	protected $_table_name = 'candidato_cursos';
	protected $table_columns = array(
		'candidato_id'	=> 	array('type'=>'int'),
		'curso'				=> 	array('type'=>'string'),
		'instituicao'		=> 	array('type'=>'string'),
		'ano'					=> 	array('type'=>'string'),
	);

	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
	);
	
	public function rules()
	{
		return array(
			'curso' => array(
				array('not_empty'),
			),
			'instituicao' => array(
				array('not_empty'),
			),
			'ano' => array(
				array('not_empty'),
			),
		);
	}
}
?>