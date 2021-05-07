<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_ConsumoCredito extends ORM {

	protected $_table_name = 'consumo_credito';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 		=> 	array('type'=>'int'),
		'descricao'	=> 	array('type'=>'string'),
		'consumo'	=> 	array('type'=>'int'),
		'consumo_conveniado'	=> 	array('type'=>'int'),
	);

	public function rules()
	{
		return array(
			'consumo' => array(
				array('not_empty'),
				array('numeric'),
			)
		);
	}

}
?>