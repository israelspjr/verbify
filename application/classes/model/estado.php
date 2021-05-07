<?
class Model_Estado extends ORM
{
	protected $_db = 'default'; // or any db group defined in database configuration

	protected $_table_name  = 'estados'; // default: accounts
	protected $_primary_key = 'vc_uf';      // default: id
	protected $_primary_val = 'vc_estado';      // default: name (column used as primary value)

	protected $_table_columns = array(
		'vc_uf'			=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'vc_estado' => array('data_type' => 'string', 'is_nullable' => TRUE),		
	);
	
	protected $_has_many = array(
		'cidades' => array(
			'model'   => 'cidade',
			'foreign_key' => 'vc_uf',
		),
	);
}
?>