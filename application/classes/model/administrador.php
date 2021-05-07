<?php defined('SYSPATH') or die('No direct access allowed.');



class Model_Administrador extends ORM {



	protected $_table_name = 'administrador';

	protected $_primary_key = 'id';



	protected $table_columns = array (

		'id' 				=> 	array('type'=>'int'),

		'user'				=> 	array('type'=>'string'),

		'senha'				=> 	array('type'=>'string'),

		'dt_ultimoacesso'	=> 	array('type'=>'datetime'),

		'email'				=> 	array('type'=>'string'),

		'name'				=> 	array('type'=>'string'),

	);



	public static function getEmailContato(){

		return 'atendimento@companhiadeidiomas.com.br';

	}	

}

?>	