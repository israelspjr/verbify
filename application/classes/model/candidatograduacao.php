<?php

class Model_CandidatoGraduacao extends ORM
{
	protected $_table_name = 'candidato_graduacao';
	protected $table_columns = array(
		'candidato_id'	=> 	array('type'=>'int'),
		'grauescolar_id'	=> 	array('type'=>'int'),
		'curso_id'			=> 	array('type'=>'int'),
		'situacao'			=> 	array('type'=>'int'),
		'dt_inicio'			=> 	array('type'=>'date'),
		'dt_conclusao'	=> 	array('type'=>'date'),
		'instituicao'		=> 	array('type'=>'string'),
	);

	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'curso' => array('model' => 'curso', 'foreign_key' => 'curso_id'),
		'grau' => array('model' => 'grauescolar', 'foreign_key' => 'grauescolar_id'),
	);

	public function rules()
	{
		return array(
			'grauescolar_id' => array(
				array('not_empty'),
			),
			'curso_id' => array (
				array(array($this, 'validaCurso')),
			),
			'situacao' => array(
				array('not_empty'),
			),
			'dt_inicio' => array(
				/*	array('not_empty'),*/
				array('date'),
			),
			'dt_conclusao' => array(
				/*array(array($this, 'validaDataConclusao')),*/
			),
			'instituicao' => array(
			/*	array('not_empty'),*/
			),
		);
	}	
	
	public function validaCurso($curso){
		if($this->grauescolar_id == 1 OR $this->grauescolar_id == 2)
			$this->curso_id = 0;
		else
			if($curso == "0")
				return false;
		return true;
	}

	public function validaDataConclusao($dt_conclusao) {
		if($this->situacao == "3" AND $dt_conclusao=="0") 
			return Valid::date($dt_conclusao);
		return true;
	}
	
	public function getSituacao(){
		if($this->situacao == 3) return 'Concluído';
		if($this->situacao == 1) return 'Cursando';
		if($this->situacao == 2) return 'Trancado';
	}
}
?>