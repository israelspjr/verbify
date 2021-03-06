<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Idioma extends ORM
{
	protected $_table_name = 'idioma';

	protected $table_columns = array(
		'id' 			=> 	array('type'=>'int'),
		'descricao'		=> 	array('type'=>'string'),
		'active'		=>	array('type'=>'int'),
		'is_outro'		=>	array('type'=>'int'),
		'sotaque'       =>  array('type'=>'string'),
	);

	protected $_has_many = array(
		'candidatos' => array(
			'model'   => 'candidato',
			'through' => 'candidato_idioma',
		),
		'testes' => array(
			'model'   => 'teste',
			'foreign_key' => 'idioma_id',
		),
	);
	
	public static function getAll(){
		return ORM::factory("idioma")->where("active", "=", "1")->find_all();
	}

	public static function getAllSemOutros(){
		return ORM::factory("idioma")
			->where("active", "=", "1")
			->where("is_outro", "=", "0")
			->find_all();
	}
}
?>