<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_ForgotPass extends Controller_DefaultTemplate {

	public function action_index()
	{	
		$var = array();

		if(isset($_POST["enviar"])){
			$email = (isset($_POST["email"]) ? $_POST["email"] : '');
			$contratante = ORM::factory("contratante")
				->where("email", "=", Arr::get($_POST, 'email'))
				->where("active", "=", '1')
				->find();
			if(!$contratante->loaded()){
				$var['erro'] = '<p class="p_error">cadastro não encontrado</p>';
			} else {
				try {
					$forgotkey = Auth::instance()->hash(date('Y-m-d').$contratante->email.$contratante->id);
					$contratante->forgot_key($forgotkey);
					$texto = '<p>Prezado(a), </p>
					<p>Recebemos uma notificação de esquecimento de senha para o seu usuário em nosso portal.</p>
					<p>Caso tenha feito esta solicitação, <a href="http://www.profcerto.com.br'.URL::site("contratante/forgotpass/redefinir?key=".$forgotkey).'">clique aqui</a> para alterar sua senha. Caso contrário, ignore este email.</p>';
					
					$email = new Email();
					$email->sendEmailToUser($contratante->email, $contratante->getNome(), 'ProfCerto - Esqueci Senha', $texto);					
					$this->request->redirect("contratante/forgotpass/success");
				} catch (Exception $e) {
					$var["erro"] = '<p class="erro">Erro: '. $e->getMessage() . '</p>';
				}
			}
			$var["email"] = $email;
		}
		
		$this->template->title = 'Esqueci minha senha';
		$this->template->content = View::factory('contratante/forgotpass', $var);
		
	}
	
	public function action_success()
	{
		$this->template->title = 'Esqueci minha senha';
		$success = '<div style="text-align: center; margin: 20px 0;"><p class="success">Um e-mail foi enviado com as instruções para a alteração da senha de acesso.</p></div>';
		$this->template->content = $success;
	}
	
	public function action_redefinir()
	{
		$var = array();
		$contratante = ORM::factory("contratante")
			->where( "forgotkey"  , "=", $_REQUEST["key"])
			->find();
		if($contratante->loaded()) {
			if(isset($_POST["salvar"]))
			{
				if(strlen($_POST["novasenha"]) < 6) {
					$var["erro"] = 'A senha deve ter no mínimo 6 caracteres';
				} elseif ($_POST["novasenha"] <> $_POST["cnovasenha"]) {
					$var["erro"] = 'Senhas não conferem';
				} else {
					$contratante->alterasenha($_POST["novasenha"]);
					$contratante->forgot_key();
					$this->request->redirect("contratante/forgotpass/alterado");
				}
			}
			$this->template->title = 'Redefinir minha senha';
			$this->template->content = View::factory('contratante/redefinirsenha', $var);
		} else {
			$this->template->title = 'Link inválido';
			$this->template->content = '<p class="p_error">Link inválido.</p>';
		}
	}

	public function action_alterado()
	{
		$this->template->title = 'Senha redefinida com sucesso';
		$success = '<p class="success">Senha alterada com sucesso. <a href="'.URL::site("contratante").'">Clique aqui</a> e entre no portal agora mesmo.</p>';
		$this->template->content = $success;
	}
	
}
?>