<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_VideoTmp extends ORM {

	protected $_table_name = 'videos_tmp';
	protected $table_columns = array (
		'id' 			      => 	array('type'=>'int'),
		'teste_id'		  =>	array('type'=>'int'),
		'candidato_id'	=>	array('type'=>'int'),
		'url'			      =>	array('type'=>'string'),
		'status'		    =>	array('type'=>'int'),
		'tries'			    =>	array('type'=>'int'),
		'data'			    =>	array('type'=>'datetime'),
	);
	protected $_primary_key = 'id';

	protected $_belongs_to = array(
		'teste' => array('model' => 'teste', 'foreign_key' => 'teste_id'),
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
	);
}
?>