<?
class Model_Curso extends ORM
{
	protected $_db = 'default'; // or any db group defined in database configuration

	protected $_table_name  = 'curso'; // default: accounts
	protected $_primary_key = 'id';      // default: id
	protected $_primary_val = 'descricao';      // default: name (column used as primary value)

	protected $_table_columns = array(
		'id'   			=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'descricao'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'ordem'     => array('data_type' => 'int', 'is_nullable' => TRUE),
	);
	
	public function rules()
	{
		return array(
			'descricao' => array(
				array('not_empty'),
			),
		);
	}
}
?>