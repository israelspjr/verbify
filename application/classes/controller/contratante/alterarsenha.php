<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_AlterarSenha extends Controller_Contratante_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$values = array();
		if (isset($_POST["salvar"]))
		{
			$values = $_POST;
			$user = Session::instance()->get('contrat_user', NULL);
			if (Auth::instance()->hash($_POST["senha"]) !== $user->senha){
				$var["erro"] = 'Senha atual inválida';
			} elseif (strlen($_POST["novasenha"]) < 6) {
				$var["erro"] = 'A senha deve ter no mínimo 6 caracteres';
			} elseif ($_POST["novasenha"] <> $_POST["cnovasenha"]) {
				$var["erro"] = 'Senhas não conferem';
			} else {
				$user->alterasenha($_POST["novasenha"]);
				Session::instance()->set('contrat_user', $user);
				$var["success"] = 'Senha alterada com sucesso';
				$values = array();
			}
		}
		$this->template->title = 'Alterar Senha';
		$this->template->content = View::factory('contratante/alterarsenha', $var)
			->set('values', $values);
	}
}
?>