<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Contratante_Login extends Controller_DefaultTemplate {

	public function action_index()
	{
		$var = array("email" => "");
		if(isset($_POST["entrar"])){
			$var["email"] = (isset($_POST["email"]) ? trim($_POST["email"]) : "");
			$senha = (isset($_POST["senha"]) ? trim($_POST["senha"]) : "");
			// administrador
			$admin = Session::instance()->get('adm_user', NULL);
			if(!is_null($admin)) {
				$contrat = ORM::factory("contratante")
					->where("email", "=", strtolower($var["email"]))
					->where("active", "=", 1)
					->find();
				if($contrat->loaded()){
					Session::instance()->set('contrat_user', $contrat);
					$contrat->acesso_update();
					$this->request->redirect('contratante/home');
				}
			}
			// contratante
			$contrat = ORM::factory("contratante")
				->where("email", "=", strtolower($var["email"]))
				->where("senha", "=", Auth::instance()->hash($senha))
				->where("active", "=", 1)
				->find();
			if($contrat->loaded()){
				Session::instance()->set('contrat_user', $contrat);
				$contrat->acesso_update();
				$this->request->redirect('contratante/home');
			} else {
				$var["erro"] = 'Erro: Dados incorretos.';
			}
		}
		$this->template->title = "Área do Contratante";
		$this->template->content = View::factory('contratante/login', $var);
		$this->template->styles =	array('assets/css/login-contratante.css' => 'screen');		
	}

	public function action_logout()
	{
		Session::instance()->delete('contrat_user');
		$this->request->redirect('home');
	}

}