<?php defined('SYSPATH') or die('No direct access allowed.');



class Model_Competencia extends ORM

{

	protected $_table_name = 'competencia';

	protected $_primary_key = 'id';



	protected $table_columns = array(

		'id' 					=> 	array('type'=>'bigint'),

		'descricao'			=> 	array('type'=>'string'),

		'categoria'	    	=> 	array('type'=>'int'),

		'descricaoLonga'	=> 	array('type'=>'string'),

	);

}

?>

