<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Convite extends ORM {

	protected $_table_name = 'convite';
	protected $_primary_key = 'id';

	protected $table_columns = array (
		'id'	 		=> 	array('type'=>'int'),
		'candidato_id'	=> 	array('type'=>'int'),
		'conta_id'		=> 	array('type'=>'int'),
		'teste_id'		=> 	array('type'=>'int'),
		'consumo'		=> 	array('type'=>'int'),
	);

	protected $_belongs_to = array(
		'candidato'			=> array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'contacontratante'	=> array('model' => 'conta', 'foreign_key' => 'conta_id'),
		'teste'				=> array('model' => 'teste', 'foreign_key' => 'teste_id'),
	);
	
	public function avisaPublicacao(){
		// envia email e delete
		$email = new Email();
		$email->avisaPublicacao($this);
		$this->delete();
	}
}
?>