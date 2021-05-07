<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Conversao extends ORM {

	protected $_table_name = 'conversao';
	protected $_primary_key = 'dt_cadastro';

	protected $table_columns = array (
		'real' 		=> 	array('type'=>'decimal'),
		'dt_cadastro'	=> 	array('type'=>'datetime'),
	);

	public function rules()
	{
		return array(
			'real' => array(
				array('not_empty'),
				array('numeric'),
			)
		);
	}

}
?>