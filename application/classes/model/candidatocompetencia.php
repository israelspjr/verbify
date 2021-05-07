<?php



class Model_CandidatoCompetencia extends ORM

{

	protected $_table_name = 'candidato_competencia';

	protected $table_columns = array(

		'candidato_id'	=> 	array('type'=>'int'),

		'competencia_id'	=> 	array('type'=>'int'),

		'escola_id' 		=> 	array('type'=>'int'),

		'valor'				=> 	array('type'=>'double'),
	);



	protected $_belongs_to = array(

		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),

		'competencia' => array('model' => 'competencia', 'foreign_key' => 'competencia_id'),

	);



}

?>

