<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Resposta extends ORM {

	protected $_table_name = 'respostas';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 			=> 	array('type'=>'int'),
		'questao_id'	=> 	array('type'=>'int'),
		'texto'			=> 	array('type'=>'string'),
		'valor' 		=> 	array('type'=>'char'),
		'ordem' 		=> 	array('type'=>'int'),
	);

	protected $_belongs_to = array(
		'questao' => array('model' => 'questao', 'foreign_key' => 'questao_id'),
	);
}
?>