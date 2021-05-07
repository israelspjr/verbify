<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Video extends ORM {

	protected $_table_name = 'videos';
	protected $table_columns = array (
		'id' 			   => 	array('type'=>'int'),
		'testeex_id' =>	array('type'=>'int'),
		'url'			   =>	array('type'=>'string'),
	);
	protected $_primary_key = 'id';

	protected $_belongs_to = array(
		'testeex_id' => array('model' => 'testeexecutado', 'foreign_key' => 'testeex_id'),
	);
}
?>