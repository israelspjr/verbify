<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Pedido extends ORM
{
	protected $_table_name = 'pedido';

	protected $table_columns = array(
		'id' 			=> 	array('type'=>'int'),
		'conta_id'		=> 	array('type'=>'int'),
		'qtde'			=> 	array('type'=>'int'),
		'valor'			=> 	array('type'=>'decimal'),
		'data'			=> 	array('type'=>'timestamp'),
		'status'		=> 	array('type'=>'int'),
		'formapagto'	=> 	array('type'=>'int'),
		'dt_baixa'		=> 	array('type'=>'timestamp'),
		'tipo'			=> 	array('type'=>'int'),
	);

	protected $_belongs_to = array(
		'conta' => array('model' => 'conta', 'foreign_key' => 'conta_id'),
	);

	public function getPSStatus() {
		switch($this->status){
			case 1:
				return "Aguardando pagamento";
			case 2:
				return "Em análise";
			case 3:
				return "Paga";
			case 4:
				return "Disponível";
			case 5:
				return "Em disputa";
			case 6:
				return "Devolvida";
			case 7:
				return "Cancelada";
			default:
				return "Inválido";
		}
	}

	public function getPSMetodoPagto() {
		switch ($this->formapagto){
			case 101:
				return "Cartão de crédito Visa";
			case 102:
				return "Cartão de crédito MasterCard";
			case 103:
				return "Cartão de crédito American Express";
			case 104:
				return "Cartão de crédito Diners";
			case 105:
				return "Cartão de crédito Hipercard";
			case 106:
				return "Cartão de crédito Aura";
			case 107:
				return "Cartão de crédito Elo";
			case 201:
				return "Boleto Bradesco";
			case 202:
				return "Boleto Santander";
			case 301:
				return "Débito online Bradesco";
			case 302:
				return "Débito online Itaú";
			case 303:
				return "Débito online Unibanco";
			case 304:
				return "Débito online Banco do Brasil";
			case 305:
				return "Débito online Banco Real";
			case 306:
				return "Débito online Banrisul";
			case 401:
				return "Saldo PagSeguro";
			case 501:
				return "Oi Paggo";
			default:
				return "Inválido";
		}
	}

	
}
?>