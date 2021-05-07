<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_ContratantePF extends ORM {

	protected $_table_name = 'contratante_pf';
	protected $_primary_key = 'contratante_id';

	protected $table_columns = array (
		'contratante_id' 		=> 	array('type'=>'int'),
		'nome' 						=> 	array('type'=>'string'),
		'cpf' 							=> 	array('type'=>'string'),
		'tel' 								=> 	array('type'=>'string'),
	);
	
	protected $_belongs_to = array(
		'contratante' => array('model' => 'contratante', 'foreign_key' => 'contratante_id'),
	);

	public function filters()
	{
		return array(
			TRUE => array( array('trim') ),
			'cpf' => array(array( array('Helper', 'onlyNumeric') )),
		);
	}

	public function rules()
	{
		return array (
			'nome' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 200)),
				array('regex', array(':value', '/^[a-zA-ZÀ-Üà-ü]+( [a-zA-ZÀ-Üà-ü]+)+$/')),
			),
			'cpf' => array(
				array('not_empty'),
				array(array('Helper', 'is_cpf')),
				array(array($this, 'cpf_available')),
			),
			'tel' => array(
				array('not_empty'),
			),
		);
	}
	
	public function cpf_available($cpf)
	{
		if($this->loaded())
			return !ORM::factory('contratantepf')->where('cpf', '=', $cpf)->where('contratante_id', '<>', $this->contratante_id)->loaded();
		else
			return !ORM::factory('contratantepf', array('cpf' => $cpf))->loaded();
	}
}
?>