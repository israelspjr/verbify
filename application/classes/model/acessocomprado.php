<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_AcessoComprado extends ORM {

	protected $_table_name = 'acesso_comprado';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'conta_id' 		=> 	array('type'=>'int'),
		'candidato_id'	=> 	array('type'=>'int'),
		'teste_id'		=> 	array('type'=>'int'),
		'acesso'		=> 	array('type'=>'int'),
		'data'			=> 	array('type'=>'datetime'),
		'tipo'			=> 	array('type'=>'int'), // 0: acesso nivel; 1: acesso teste
	);

	protected $_belongs_to = array(
		'contacontratante'	=> array('model' => 'contratante', 'foreign_key' => 'conta_id'),
		'candidato'			=> array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'testeexecutado'	=> array('model' => 'testeexecutado', 'foreign_key' => 'testeex_id'),
	);
}
?>