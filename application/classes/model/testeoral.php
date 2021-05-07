<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_TesteOral extends ORM {

	protected $_table_name = 'teste_oral';
	protected $table_columns = array (
		'teste_id' 			=> 	array('type'=>'int'),
		'enunciado'			=>	array('type'=>'text'),
		'publicado'			=>	array('type'=>'int'),
		'consumo'			=>	array('type'=>'int'),
		'dt_public'			=>	array('type'=>'timestamp'),
	);
	protected $_primary_key = 'teste_id';

	protected $_has_one = array(
		'videotmp' => array(
			'model'   => 'videotmp',
			'foreign_key' => 'teste_id',
		),
	);

	public function getPublicado(){
		if($this->publicado == 1)
			return Helper::format_date($this->dt_public);
		else
			return __('Não');
	}
}
?>