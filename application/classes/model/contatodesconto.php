<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_ContatoDesconto extends ORM {

	protected $_table_name = 'contato_desconto';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id'		=> 	array('type'=>'integer'),
		'minimo'	=> 	array('type'=>'integer'),
		'consumo'	=> 	array('type'=>'decimal'),
	);
}
?>