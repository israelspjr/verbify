<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Locomocao extends ORM
{
	protected $_table_name = 'locomocao';

	protected $table_columns = array(
		'id' 				=> 	array('type'=>'int'),
		'descricao'		=> 	array('type'=>'string'),
		'active'			=>	array('type'=>'int'),
		'is_outro'		=>	array('type'=>'int'),
	);

	protected $_has_many = array(
		'candidatos' => array(
			'model'   => 'candidato',
			'through' => 'candidato_locomocao',
		),
	);

}
?>