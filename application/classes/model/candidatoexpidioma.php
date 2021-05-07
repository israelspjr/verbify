<?php

class Model_CandidatoExpIdioma extends ORM
{
	protected $_table_name = 'candidato_expidioma';
	protected $table_columns = array(
		'candidato_id'	=> 	array('type'=>'int'),
		'funcao'				=> 	array('type'=>'string'),
		'dt_inicio'			=> 	array('type'=>'date'),
		'dt_fim'				=> 	array('type'=>'date'),
		'atualidade'		=> 	array('type'=>'bool'),
	);

	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
	);

	public function rules()
	{
		return array(
			'funcao' => array(
				array('not_empty'),
			),
			'dt_inicio' => array(
				array('not_empty'),
				array('date'),
			),
			'dt_fim' => array(
				array( array($this, 'validaDataConclusao') ),
			),
		);
	}

	public function validaDataConclusao($dt_conclusao) {
		if($this->atualidade == "0" AND $dt_conclusao=="0") 
			return Valid::date($dt_conclusao);
		return true;
	}
	
}
?>
