<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Valor extends ORM
{
	protected $_table_name = 'conversao';

	protected $table_columns = array(
		'real' 					=> 	array('type'=>'decimal'),
		'dt_cadastro'		=> 	array('type'=>'timestamp'),
	);
	
	public static function getPrecoCredito(){
		// $max = ORM::factory('valor')->order_by('dt_cadastro', 'DESC')->find();
		return 0.2;
	}
	
	public static function getVendaMinima(){
		return 10;
	}
}
?>