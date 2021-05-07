<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Resultado extends ORM {

	protected $_table_name = 'resultado';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 		=> 	array('type'=>'int'),
		'teste_id'	=> 	array('type'=>'int'),
		'texto'		=> 	array('type'=>'string'),
		'letra'		=> 	array('type'=>'string'),
	);
	
	protected $_belongs_to = array(
		'teste' => array('model' => 'teste', 'foreign_key' => 'teste_id'),
	);

	public function rules()
	{
		return array(
			'texto' => array(
				array('not_empty'),
			),
			'letra' => array(
				array('not_empty'),
				array(array($this, 'validaLetra')),
			)
		);
	}
	
	function validaLetra($letra){
		if($letra == "")
			return false;		
		if($this->loaded()){
			$exists = $this->where("teste_id", "=", $this->teste_id)->where("letra", "=", $letra)->where("id", "<>", $this->id)->count_all();
		} else {
			$exists = $this->where("teste_id", "=", $this->teste_id)->where("letra", "=", $letra)->count_all();
		}
		return ($exists == 0);
	}
} 
?>