<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_ReferenciaRelacionamento extends ORM {

	protected $_table_name = 'referencia_relacionamento';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 			=> 	array('type'=>'int'),
		'descricao'		=> 	array('type'=>'string'),
	);
}
?>