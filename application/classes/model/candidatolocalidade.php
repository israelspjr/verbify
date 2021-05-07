<?php

class Model_CandidatoLocalidade extends ORM
{
	protected $_table_name = 'candidato_local';
	protected $_primary_key = 'candidato_id';
	
	protected $table_columns = array(
		'candidato_id'				=> 	array('type'=>'int'),
		'tipo_disponibilidade'		=> array('type'=>'string'),
		'pais'						=> array('type'=>'string'),
		'estado_id'					=> array('type'=>'int'),
		'cidade_id'					=> array('type'=>'int'),
		'regiao_id'					=> array('type'=>'int'),
		'sobremim'					=> array('type'=>'string'),
	);
	
	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'estado' => array('model' => 'estado', 'foreign_key' => 'estado_id'),
		'cidade' => array('model' => 'cidade', 'foreign_key' => 'cidade_id'),
		'regiao' => array('model' => 'regiaosp', 'foreign_key' => 'regiao_id'),
	);
	
	public function rules()
	{
		return array(
			'tipo_disponibilidade' => array(
				array('not_empty'),
			),
			'pais' => array(
				array('not_empty'),
			),
			'estado_id' => array(
				array(array($this, 'validaEstadoOuCidade')),
			),
			'cidade_id' => array(
				array(array($this, 'validaEstadoOuCidade')),
			),
			'regiao_id' => array(
				array(array($this, 'validaRegiao')),
			),
		);
	}
	
	public function validaEstadoOuCidade($id){
		if($this->pais == "brasil" AND $id == "0"){
			return false;
		}
		return true;
	}

	public function validaRegiao($id){
		if($this->cidade_id == "7374" AND $id == "0"){
			return false;
		}
		return true;
	}
	
}
?>