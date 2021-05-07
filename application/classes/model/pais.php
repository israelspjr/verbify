<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Pais extends ORM
{
	protected $_table_name = 'pais';

	protected $table_columns = array(
		'id' 					=> 	array('type'=>'int'),
		'name'			=> 	array('type'=>'string'),
	);
	
}
?>