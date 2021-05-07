<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_ContratantePJ extends ORM {

	protected $_table_name = 'contratante_pj';
	protected $_primary_key = 'contratante_id';

	protected $table_columns = array(
		'contratante_id' 	=> 	array('type'=>'int'),
		'razao' 			=> 	array('type'=>'string'),
		'nomefantasia' 		=> 	array('type'=>'string'),
		'cnpj' 				=> 	array('type'=>'string'),
		'c_nome' 			=> 	array('type'=>'string'),
		'c_tel' 			=> 	array('type'=>'string'),
		'c_cargo' 			=> 	array('type'=>'string'),
		'franquia' 			=> 	array('type'=>'boolean'),
		'franquia_descr' 	=> 	array('type'=>'string'),
	);
	
	protected $_belongs_to = array(
		'contratante' => array('model' => 'contratante', 'foreign_key' => 'contratante_id'),
	);
	
	public function filters()
	{
		return array(
			TRUE => array( array('trim') ),
			'cnpj' => array(array( array('Helper', 'onlyNumeric') )),
			'c_tel' => array(array( array('Helper', 'onlyNumeric') )),
		);
	}

	public function rules()
	{
		return array(
			'razao' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 200)),
			),
			'cnpj' => array(
				array('not_empty'),
				array(array('Helper', 'is_cnpj')),
				array(array($this, 'cnpj_available')),
			),
			'c_nome' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 200)),
			),
			'c_tel' => array(
				array('not_empty'),
			),
			'c_cargo' => array(
				array('not_empty'),
			),
			'franquia' => array(
				array('not_empty'),
				array(array($this, 'verificaFranquiaDescricao')),
			),
		);
	}
	
	public function cnpj_available($cnpj)
	{
		if($this->loaded())
			return !ORM::factory('contratantepj')->where('cnpj', '=', $cnpj)->where('contratante_id', '<>', $this->contratante_id)->loaded();
		else
			return !ORM::factory('contratantepj', array('cnpj' => $cnpj))->loaded();
	}
	
	public function verificaFranquiaDescricao($franquia)
	{
		if($franquia == '1' AND $this->franquia_descr == ""){
			return false;
		}
	}
}
?>