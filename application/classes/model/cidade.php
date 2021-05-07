<?
class Model_Cidade extends ORM
{
	protected $_db = 'default'; // or any db group defined in database configuration

	protected $_table_name  = 'cidade'; // default: accounts
	protected $_primary_key = 'dc_codig';      // default: id
	protected $_primary_val = 'vc_cidade';      // default: name (column used as primary value)

	protected $_table_columns = array(
		'dc_codig'   	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'vc_cidade'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'vc_uf'    			=> array('data_type' => 'string', 'is_nullable' => TRUE),
	);

	protected $_belongs_to = array(
		'estado' => array('model' => 'estado', 'foreign_key' => 'vc_uf'),
	);
	
	public function getCidadeUf(){
		return ucwords($this->vc_cidade).' - '.$this->vc_uf;
	}
}
?>