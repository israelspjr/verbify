<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Pacote extends ORM {

	protected $_table_name = 'pacotes';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id'		=> 	array('type'=>'integer'),
		'creditos'	=> 	array('type'=>'integer'),
		'reais'		=> 	array('type'=>'decimal'),
		'active'	=> 	array('type'=>'boolean'),
	);
	
	public function rules()
	{
		return array(
			'creditos' => array(
				array('numeric'),
				array(array($this, 'pack_available')),
			),
			'reais' => array(
				array('decimal')
			)
		);
	}
	
	public function pack_available($valor){
		if($this->loaded()){
			return ($this->where('creditos', '=', $valor)->where('id', '<>', $this->id)->count_all() == 0 ? true : false);
		} else {
			return ($this->where('creditos', '=', $valor)->count_all() == 0 ? true : false);
		}
	}
}
?>