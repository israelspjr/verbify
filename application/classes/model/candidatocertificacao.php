<?php

class Model_CandidatoCertificacao extends ORM
{
	protected $_table_name = 'candidato_certificacao';
	protected $table_columns = array(
		'candidato_id'	=> 	array('type'=>'int'),
		'descricao'		=> array('type'=>'string'),
		'ano'			=> array('type'=>'string'),
		'tipo'			=> array('type'=>'string'),
		'idioma_id'		=> array('type'=>'int'),
	);
	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'idioma' 	=> array('model' => 'idioma', 'foreign_key' => 'idioma_id'),
	);

	public function rules()
	{
		return array(
			'descricao' => array(
				array('not_empty'),
			),
			'ano' => array(
				array('not_empty'),
			),
			'tipo' => array(
				array('not_empty'),
			),
			'idioma_id' => array(
				array('not_empty'),
			),
		);
	}
}
?>
