<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Recomendacoes extends Controller_DefaultTemplate {

	public function action_index()
	{
		$key = $this->request->query('key');
		$ref = ORM::factory("referencia")->where("key", "=", $key)->find();
		if(!$ref->loaded()){
			$this->request->redirect("recomendacoes/notfound");
		} elseif($ref->status == 1){
			$this->request->redirect("recomendacoes/done");
		}
		
		if(isset($_POST["enviar"])){
			$ref->relacionamento_id = $_POST["relacionamento"];
			$ref->mensagem = $_POST["mensagem"];
			if($ref->relacionamento_id == ""){
				$errors["relacionamento_id"] = 'Campo Obrigatório';
			}
			if($ref->mensagem == ""){
				$errors["mensagem"] = 'Campo Obrigatório';
			}
			if(!isset($errors)){
				$ref->key = '';
				$ref->ts_mensagem = date('Y-m-d');
				$ref->status = 1;
				$ref->save();
				$ref->sendEmailProfessor();
				// send email para o professor
				$this->request->redirect("recomendacoes/success");
			}
		}
		
		$var["ref"] = $ref;
		$var["relacionamentos"] = ORM::factory("referenciarelacionamento")->find_all();
		$this->template->title = 'Recomendação';
		$this->template->styles = array(
			'assets/css/recomendacoes.css' => 'screen'
		);
		$this->template->content = View::factory('recomendacoes', $var)
			->bind("errors", $errors);
	}
	
	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p>Página não encontrada</p>';
	}

	public function action_done()
	{
		$this->template->title = 'Recomendação já realizada';
		$this->template->content = '<p>Recomendação já realizada</p>';
	}
	
	public function action_success()
	{
		$this->template->title = 'Recomendação enviada com sucesso';
		$this->template->content = '<p class="p_success">Obrigado por sua recomendação.</p>';
	}
	
} // End Home
