<?php
class Model_Banners extends ORM
{
	protected $_db = 'default'; // or any db group defined in database configuration

	protected $_table_name  = 'banners'; // default: accounts
	protected $_primary_key = 'id';      // default: id
	protected $_primary_val = 'banner';      // default: name (column used as primary value)

	protected $_table_columns = array(
		'id' => array('data_type' => 'int', 'is_nullable' => FALSE),
		'banner' => array('data_type' => 'text', 'is_nullable' => FALSE),
		'link' => array('data_type' => 'string', 'is_nullable' => FALSE),
		'descricao' => array('data_type' => 'string', 'is_nullable' => FALSE),
		'language' => array('data_type' => 'string', 'is_nullable' => FALSE),
		'sort' => array('data_type' => 'int', 'is_nullable' => FALSE),
	);
}
?>