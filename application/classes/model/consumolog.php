<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_ConsumoLog extends ORM 
{
	protected $_table_name = 'consumo_log';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 				=> 	array('type'=>'int'),
		'conta_id'			=> 	array('type'=>'int'),
		'consumo_qtde'		=> 	array('type'=>'int'),
		'tipo'				=> 	array('type'=>'int'),
		'data'				=> 	array('type'=>'timestamp'),
	);

	protected $_belongs_to = array(
		'conta' => array('model' => 'conta', 'foreign_key' => 'conta_id'),
	);
	
}
?>