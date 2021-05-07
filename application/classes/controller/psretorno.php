<?php defined('SYSPATH') or die('No direct script access.');

class Controller_PsRetorno extends Controller_DefaultTemplate {

	public function action_index()
	{
		require Kohana::find_file('vendor', 'PagSeguroLibrary/PagSeguroLibrary');

		$credentials = PagSeguroConfig::getAccountCredentials();
		$code = (isset($_REQUEST['notificationCode']) && trim($_REQUEST['notificationCode']) !== ""  ? trim($_REQUEST['notificationCode']) : null);
		$type = (isset($_REQUEST['notificationType']) && trim($_REQUEST['notificationType']) !== ""  ? trim($_REQUEST['notificationType']) : null);
		if ( $code && $type === 'transaction') {
			try{
				//Obtendo o objeto Transaction a partir do código de notificação
				$transaction = NotificationService::checkTransaction(
					$credentials,
					$code // código de notificação
				);
				//codigo da transacao no pagseguro
				$tcode = $transaction->getCode();
				//codigo de referencia no nosso sistema
				$reference = $transaction->getReference();
				$status = $transaction->getStatus()->getValue();
				$payment_method = $transaction->getPaymentMethod();
				$paycode = $payment_method->getCode()->getValue();
				// atualiza pedido
				$pedido = ORM::factory("pedido", $reference);
				try {
					if(!$pedido->loaded()){
						throw new Exception ("Pedido não encontrado");
					}
					$pedido->status = $status;
					$pedido->formapagto = $paycode;
					$pedido->save();
					// if pago, colocar os creditos e gravar data da confirmacao
					if($pedido->status == 3) {
						$pedido->conta->creditar($pedido->qtde, 'Créditos Comprados');
						$pedido->dt_baixa = date('Y-m-d H:i:s');
						$pedido->save();
					}
					$msg_status = 'Status atualizado com sucesso';
					$msg = 'Data: '.$transaction->getDate().'<br />
					Transaction ID: '.$transaction->getCode().'<br />
					Id Pedido: '.$reference.'<br />
					Status: '.$pedido->getPSStatus().'<br />
					Método de Pagamento: '. $pedido->getPSMetodoPagto().'<br />
					Valor bruto da transação: '.$transaction->getGrossAmount().'<br />
					-------------------------------------------------------------<br />
					Nome: '.$pedido->conta->getNome().'<br />
					Créditos: '.$pedido->qtde.'<br />
					-------------------------------------------------------------<br />
					'.$msg_status.'<br />';
					$mail = new Email;
					$toemail = 'conrado@profcerto.com.br';
					$toname = 'Administrador Profcerto';
					$subject = 'Retorno Pagseguro';
					$mail->sendEmailToUser($toemail, $toname, $subject, $msg);
				} catch (Exception $e) {
					$msg_status = 'Erro: '.$e->getMessage();
					$this->template->title = 'Retorno Pagseguro';
					$this->template->content = '<p class="p_error">'.$msg_status.'</p>';
				}
			} catch (PagSeguroServiceException $e) {
				$this->template->title = 'Retorno Pagseguro';
				$this->template->content = '<p class="p_error">'.$e->getMessage().'</p>';
			}
		}
	}
}
?>