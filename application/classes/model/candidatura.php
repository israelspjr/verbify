<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Candidatura extends ORM {

	protected $_table_name = 'candidatura';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id' 				=> 	array('type'=>'int'),
		'vaga_id' 			=> 	array('type'=>'int'),
		'candidato_id'		=> 	array('type'=>'int'),
		'dt_cadastro'		=> 	array('type'=>'datetime'),
	);

	protected $_belongs_to = array(
		'vaga' => array('model' => 'vaga', 'foreign_key' => 'vaga_id'),
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
	);

	public function jaCandidatado($user, $vaga)
	{
		$count = $this->where("candidato_id", "=", $user)->where("vaga_id", "=", $vaga)->count_all();
		return $count;
	}

}
?>