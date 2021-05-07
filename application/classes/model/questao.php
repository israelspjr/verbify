<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Questao extends ORM {

	protected $_table_name = 'questoes';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id'				=> 	array('type'=>'int'),
		'teste_id'		=> 	array('type'=>'int'),
		'ordem'			=> 	array('type'=>'int'),
		'topico'			=> 	array('type'=>'string'),
		'enunciado' 	=> 	array('type'=>'string'),
		'tipo' 			=> 	array('type'=>'int'),
		'max_check' 	=> 	array('type'=>'int'),
		'max_tempo' 	=> 	array('type'=>'int'),
		'topico_en' 	=> 	array('type'=>'string'),
		'enunciado_en' => 	array('type'=>'string'),
	);

	protected $_belongs_to = array(
		'teste' => array('model' => 'teste', 'foreign_key' => 'teste_id'),
	);

	protected $_has_many = array(
		'respostas' => array(
			'model'   => 'resposta',
			'foreign_key' => 'questao_id',
		),
		'candidatosrespostas' => array(
			'model'   => 'candidatoresposta',
			'foreign_key' => 'questao_id',
		),
	);

	public function rules()
	{
		return array(
			'teste_id' => array(
				array('not_empty'),
			),
			'enunciado' => array(
				array('not_empty'),
			),
			'enunciado_en' => array(
				array('not_empty'),
			),
		);
	}

	public function deleterespostas()
	{
		DB::delete('respostas')
			->where('questao_id','=', $this->id)
			->execute();
	}
}
?>