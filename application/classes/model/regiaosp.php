<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_RegiaoSP extends ORM
{
	protected $_table_name = 'regiao_sp';

	protected $table_columns = array(
		'id' 					=> 	array('type'=>'int'),
		'descricao'		=> 	array('type'=>'string'),
	);
}
?>