<?
class Model_GrauEscolar extends ORM
{
  protected $_db = 'default'; // or any db group defined in database configuration
 
  protected $_table_name  = 'grauescolar'; // default: accounts
  protected $_primary_key = 'id';      // default: id
  protected $_primary_val = 'descricao';      // default: name (column used as primary value)
 
  // default for $_table_columns: use db introspection to find columns and info
  // see http://v3.kohanaphp.com/guide/api/Database_MySQL#list_columns for all possible column attributes
  protected $_table_columns = array(
    'id'   			=> array('data_type' => 'int', 'is_nullable' => FALSE),
    'descricao'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
    'ordem'     => array('data_type' => 'int', 'is_nullable' => TRUE),
  );
}
?>