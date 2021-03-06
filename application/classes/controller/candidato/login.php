<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Candidato_Login extends Controller_DefaultTemplate {

	public function action_index()
	{
		$var = array("email" => "");
		$var["email"] = (isset($_POST["email"]) ? trim($_POST["email"]) : "");
		$senha = (isset($_POST["senha"]) ? trim($_POST["senha"]) : "");
		if(isset($_POST["entrar"])){
			// administrador
			$admin = Session::instance()->get('adm_user', NULL);
			if(!is_null($admin)) {
				$tal = ORM::factory("candidato")
					->where("email", "=", strtolower($var["email"]))
					->where("active", "=", 1)
					->find();
				if($tal->loaded()){
					Session::instance()->set('talen_user', $tal);
					$tal->acesso_update();
					$this->request->redirect('candidato/home');
				}
			}
			// professor
			$tal = ORM::factory("candidato")
				->where("email", "=", strtolower($var["email"]))
				->where("senha", "=", Auth::instance()->hash($senha))
				->where("active", "=", 1)
				->find();
			if($tal->loaded()){
				Session::instance()->set('talen_user', $tal);
		//		$tal->acesso_update();
				$this->request->redirect('candidato/home');
			} else {
				$var["erro"] = 'Erro: Dados incorretos.';
			}
		}
		$this->template->title = "Área do Candidato";
		$this->template->content = View::factory('candidato/login', $var);
	}
	
	public function action_logout()
	{
		Session::instance()->delete('talen_user');
		$this->request->redirect('home');
	}
}