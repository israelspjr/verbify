<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_MeusCreditos extends Controller_Contratante_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get('contrat_user', NULL);
		if ($user->conta->loaded()){
			$var["saldo"] = $user->conta->saldo;
		} else {
			$var["saldo"] = 0;
		}
		$dias = 5;
		$since = date('Y-m-d', strtotime("now - $dias day"));
		$logs = array();
		$logs[] = array("data" => $since, "descricao" => "Saldo Anterior", "valor" => $user->conta->getSaldo($dias));
		$consumos = $user->conta->getLastxDaysLogs($dias);
		foreach($consumos as $row) {
			$logs[] = array("data" => $row->data, "descricao" => $row->descricao, "valor" => $row->consumo_qtde);
		}
		$logs[] = array("data" => date('Y-m-d'), "descricao" => "SALDO", "valor" => $var["saldo"]);
		$var["logs"] = $logs;
		$var["dias"] = $dias;
		$this->template->title = 'Meus Créditos';
		$this->template->content = View::factory('contratante/meuscreditos', $var);
		$this->template->styles = array('assets/css/extrato.css' => 'screen');
	}

	public function action_comprar()
	{
		$var = array();
		$var["pacotes"] = ORM::factory("pacote")->where('active', '=', '1')->order_by("creditos", "ASC")->find_all();
		$this->template->title = 'Meus Créditos';
		$this->template->content = View::factory('contratante/comprar', $var);
	}

	public function action_pagar(){
		try {
			// calcula valor
			$user = Session::instance()->get('contrat_user', NULL);
			$pacoteid = Arr::get($_POST, "pacote");
			$pacote = ORM::factory("pacote", $pacoteid);
			if(!$pacote->loaded()){
				throw new Exception("Pacote não encontrado.");
			}
			$preco = $pacote->reais;
			$creditos = $pacote->creditos;
			try {
				// gera um registro de pedido para poder baixar para o usuário no retorno
				if( ! $user->conta->loaded()){
					$user->conta->contratante_id = $user->id;
					$user->conta->save();
				}
				$pedido = ORM::factory("pedido");
				$pedido->conta_id = $user->conta->id;
				$pedido->qtde = $creditos;
				$pedido->valor = $preco;
				$pedido->data = date('Y-m-d H:i:s');
				$pedido->tipo = 2;
				$pedido->save();
				require Kohana::find_file('vendor', 'PagSeguroLibrary/PagSeguroLibrary');
				$paymentRequest = new PaymentRequest();
				// Sets the currency
				$paymentRequest->setCurrency("BRL");
				// Add an item for this payment request
				$paymentRequest->addItem($pacote->id, $pacote->creditos.' créditos do Portal ProfCerto', 1, $pacote->reais);
				// Sets a reference code for this payment request, it is useful to identify this payment in future notifications.
				$paymentRequest->setReference($pedido->id);
				//sem envio
				$paymentRequest->setShippingType(3);
				// Sets your customer information.
				if($user->tppessoa == 'PJ') {
					$tel = preg_replace("/[^0-9]/", "", $user->contratantepj->c_tel);
					$nome = substr($user->contratantepj->razao.' - '.$user->contratantepj->c_nome, 0, 50);
					$paymentRequest->setSender($nome, $user->email, substr($tel, 0, 2), substr($tel, 2));
				} else {
					$tel = preg_replace("/[^0-9]/", "", $user->contratantepf->tel);
					$nome = substr($user->contratantepf->nome, 0, 50);
					$paymentRequest->setSender($nome, $user->email, substr($tel, 0, 2), substr($tel, 2));
				}
				$paymentRequest->setRedirectUrl("http://www.profcerto.com.br".URL::site("contratante/meuscreditos/confirmacao"));
				$credentials = PagSeguroConfig::getAccountCredentials();
				$url = $paymentRequest->register($credentials);
				$this->request->redirect($url);
			} catch (PagSeguroServiceException $e) {
				$this->template->content = ($e->getMessage());
			}
		} catch (Exception $e) {
			$this->template->content = '<p class="p_error">'.($e->getMessage()).'</p>';
		}
	}

	public function action_confirmacao(){
		$this->template->title = 'Meus Créditos - Confirmação de Pedido';
		$this->template->content = '<p class="p_success">Seu pedido foi efetuado com sucesso. Seus créditos estarão disponíveis assim que o pagamento for confirmado.</p>';
	}

	public function action_extrato(){
		$user = Session::instance()->get('contrat_user', NULL);
		$var = array();
		$var["mes"] = array(1=>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
		$var["ano"] = Date("Y");
		$var["sel_mes"] = Date("m");
		$var["sel_ano"] = Date("Y");
		if(isset($_POST["pesquisar"])){
			$var["sel_mes"] = Arr::get($_POST, "mes");
			$var["sel_ano"] = Arr::get($_POST, "ano");
			$var["saldoanterior"] = $user->conta->getSaldoAnterior($var["sel_mes"], $var["sel_ano"]);
			$var["logs"] = $user->conta->getMonthLogs($var["sel_mes"], $var["sel_ano"]);
		}
		$this->template->title = 'Meus Créditos - Extrato';
		$this->template->content = View::factory('contratante/extrato', $var);
		$this->template->styles = array('assets/css/extrato.css' => 'screen');
	}
}
?>