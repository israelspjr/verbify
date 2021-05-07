<?php defined('SYSPATH') or die('No direct script access.');

class Controller_PagseguroTeste extends Controller {

	public function action_index()
	{
		require Kohana::find_file('vendor', 'PagSeguroLibrary/PagSeguroLibrary');
		if(!isset($_REQUEST["transaction_id"]) OR $_SERVER["REMOTE_ADDR"] !== "201.93.133.162") {
			echo "Nenhum transaction_id informado ou ip não autorizado";
			exit;
		}
		$transaction_code = $_REQUEST["transaction_id"];

		try {
			$credentials = new AccountCredentials("conrado@profcerto.com.br", "8F8AA2E3A5D94E209293FF90C5B1062F");
			$transaction = TransactionSearchService::searchByCode($credentials, $transaction_code);

			//codigo de referencia no nosso sistema
			$reference = $transaction->getReference();
			$status = $transaction->getStatus()->getValue();
			$payment_method = $transaction->getPaymentMethod();
			$paycode = $payment_method->getCode()->getValue();

 			echo "<h2>Transaction search by code result";
			echo "<h3>Code: " . 		$transaction->getCode()	.'</h3>';
			echo "<h3>Status: " . 		$transaction->getStatus()->getTypeFromValue()	.'</h3>';
			echo "<h4>Reference: " . 	$transaction->getReference() . "</h4>";
			$payment_method = $transaction->getPaymentMethod();
			$paycode = $payment_method->getCode()->getValue();
			echo "<h4>Forma de Pagto: " . 	$paycode . "</h4>";

			if ($transaction->getSender()) {
				echo "<h4>Sender data:</h4>";
				echo  "Name: ".		$transaction->getSender()->getName() 	.'<br>';
				echo  "Email: ". 	$transaction->getSender()->getEmail()	.'<br>';
				if ( $transaction->getSender()->getPhone() ) {
					echo  "Phone: ". $transaction->getSender()->getPhone()->getAreaCode() . " - " . $transaction->getSender()->getPhone()->getNumber();
				}
			}

			if ($transaction->getItems()) {
				echo "<h4>Items:</h4>";
				if (is_array($transaction->getItems())) {
					foreach($transaction->getItems() as $key => $item) {
						echo "Id: ". 				$item->getId()				.'<br>'; // prints the item id, p.e. I39
						echo "Description: ". 		$item->getDescription()		.'<br>'; // prints the item description, p.e. Notebook prata
						echo "Quantidade: ". 		$item->getQuantity()		.'<br>'; // prints the item quantity, p.e. 1
						echo "Amount: ". 			$item->getAmount()			.'<br>'; // prints the item unit value, p.e. 3050.68
						echo "Weight: ".			$item->getWeight()			.'<br>'; // prints the item weight in gramas, p.e. 4250
						echo "Shipping cost: ".     $item->getShippingCost()	.'<br>'; // prints the item unit shipping cost, p.e. 19.35
						echo "<hr>";
					}
				}
			}

			if ($transaction->getShipping()) {
				echo "<h4>Shipping information:</h4>";
				if ($transaction->getShipping()->getAddress()) {
					echo "Postal code: ".	$transaction->getShipping()->getAddress()->getPostalCode().'<br>';
					echo "Street: ".  		$transaction->getShipping()->getAddress()->getStreet().'<br>';
					echo "Number: ". 	 	$transaction->getShipping()->getAddress()->getNumber().'<br>';
					echo "Complement: ". 	$transaction->getShipping()->getAddress()->getComplement().'<br>';
					echo "District: ". 	 	$transaction->getShipping()->getAddress()->getDistrict().'<br>';
					echo "City: ".	 	 	$transaction->getShipping()->getAddress()->getCity().'<br>';
					echo "State: ". 		$transaction->getShipping()->getAddress()->getState().'<br>';
					echo "Country: ". 		$transaction->getShipping()->getAddress()->getCountry().'<br>';
				}
				echo "Shipping type: ".		$transaction->getShipping()->getType()->getTypeFromValue().'<br>';
				echo "Shipping cost: ".	$transaction->getShipping()->getCost().'<br>';
			}

			// atualiza pedido
			$pedido = ORM::factory("pedido", $reference);
			try {
				if(!$pedido->loaded()){
					throw new Exception ("Pedido não encontrado");
				}
				if($pedido->status == 0) {
					$pedido->status = $status;
					$pedido->formapagto = $paycode;
					$pedido->save();
					// if pago, colocar os creditos e gravar data da confirmacao
					if($pedido->status == 3) {
						$pedido->conta->creditar($pedido->qtde, 'Créditos Comprados');
						$pedido->dt_baixa = date('Y-m-d H:i:s');
						$pedido->save();
					}
				}
			} catch (Exception $e) {
				$msg_status = 'Erro: '.$e->getMessage();
				echo '<p class="p_error">'.$msg_status.'</p>';
			}
		} catch (PagSeguroServiceException $e) {
			die($e->getMessage());
		}
	}
}
?>