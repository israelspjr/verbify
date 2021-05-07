<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Contador extends ORM {

	protected $_table_name = 'contador';

	protected $table_columns = array (
		'visitas' 		=> 	array('type'=>'int'),
	);
	
	public function somavisita(){
		$this->visitas = $this->visitas+1;
		$this->update();
	}
}


?>