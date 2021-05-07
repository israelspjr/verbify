<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Experiencia extends ORM
{
	protected $_table_name = 'experiencia';
	protected $_primary_key = 'id';

	protected $table_columns = array(
		'id' 					=> 	array('type'=>'bigint'),
		'descricao'			=> 	array('type'=>'string'),
		'experiencia'		=> 	array('type'=>'int'),
		'escolas'			=> 	array('type'=>'int'),
		'yesorno'			=> 	array('type'=>'int'),
	);
}
?>
