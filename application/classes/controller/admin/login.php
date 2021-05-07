<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Admin_Login extends Controller_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		if(isset($_POST["entrar"])){
			$var["user"] = (isset($_POST["user"]) ? trim($_POST["user"]) : "");
			$senha = (isset($_POST["senha"]) ? trim($_POST["senha"]) : "");
			$adm = ORM::factory("administrador")
				->where("user", "=", strtolower($var["user"]))
				->where("senha", "=", Auth::instance()->hash($senha))
				->find();
			if($adm->loaded()){
				Session::instance()->set('adm_user', $adm);
				$adm->dt_ultimoacesso = date('Y-m-d H:i:s');
				$adm->save();
				$this->request->redirect('admin/home');
			} else {
				$var["erro"] = 'Erro: Dados incorretos.';
			}
		}
		$this->template->title = "Área do Administrador";
		$this->template->content = View::factory('admin/login', $var);
		$this->template->styles =	array('assets/css/login-admin.css' => 'screen');
	}

	public function action_logout()
	{
		Session::instance()->delete('adm_user');
		$this->request->redirect('admin');
	}

}