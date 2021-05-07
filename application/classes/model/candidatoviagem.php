<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_CandidatoViagem extends ORM
{
	protected $_table_name = 'candidato_viagens';

	protected $table_columns = array (
		'id' 					=> 	array('type'=>'int'),
		'candidato_id'	=> 	array('type'=>'int'),
		'pais_id'			=> 	array('type'=>'int'),
		'dtde'				=>	array('type'=>'int'),
		'dtate'				=>	array('type'=>'int'),
		'atividade'			=>	array('type'=>'string'),
		'descricao'			=>	array('type'=>'string'),
	);

	public function rules()
	{
		return array(
			'pais_id' => array(
				array('not_empty'),
			),
			'dtde' => array(
				array('not_empty'),
				array('date'),
			),
			'dtate' => array(
				array('not_empty'),
				array('date'),
			),
			'atividade' => array(
				array('not_empty'),
			),
		);
	}

	protected $_belongs_to = array(
		'candidato' => array(
			'model'       => 'candidato',
			'foreign_key' => 'candidato_id',
		),
		'pais' => array(
			'model'       => 'pais',
			'foreign_key' => 'pais_id',
		),
	);
}
?>