<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_ForgotPass extends Controller_DefaultTemplate {

	public function action_index()
	{
		$var = array();

		if(isset($_POST["enviar"])){
			$email = (isset($_POST["email"]) ? $_POST["email"] : '');
			$candidato = ORM::factory("candidato")
				->where("email", "=", Arr::get($_POST, 'email'))
				->where("active", "=", '1')
				->find();
			if(!$candidato->loaded()){
				$var['erro'] = '<p class="p_error">'.__('cadastro não encontrado').'</p>';
			} else {
				try {
					$forgotkey = Auth::instance()->hash(date('Y-m-d').$candidato->email.$candidato->id);
					$candidato->forgot_key($forgotkey);
					$texto = '<p>Prezad'.($candidato->sexo=='F'?'a':'o').' <strong>'.$candidato->nome.'</strong>,</p>
					<p>Recebemos uma notificação de esquecimento de senha para o seu usuário em nosso portal.</p>
					<p>Caso tenha feito esta solicitação, <a href="http://www.vagasdeprofessores.com.br'.URL::site("candidato/forgotpass/redefinir?key=".$forgotkey).'">clique aqui</a> para alterar sua senha. Caso contrário, ignore este email.</p>';
					$candidato->sendMeEmail(__('Esqueci minha senha'), $texto);
					$this->request->redirect("candidato/forgotpass/success");
				} catch (Exception $e) {
					$var["erro"] = '<p class="erro">Erro: '. $e->getMessage() . '</p>';
				}
			}
			$var["email"] = $email;
		}

		$this->template->title = __('Esqueci minha senha');
		$this->template->content = View::factory('candidato/forgotpass', $var);

	}

	public function action_success()
	{
		$this->template->title = __('Esqueci minha senha');
		$success = '<h2>'.__('Esqueci minha senha').'</h2>
		<div style="margin: 20px 0;">
			<p class="p_success">'.__('Esqueci minha senha mensagem sucesso').'</p>
		</div>';
		$this->template->content = $success;
	}

	public function action_redefinir()
	{
		$var = array();
		$candidato = ORM::factory("candidato")
			->where( "forgotkey"  , "=", $_REQUEST["key"])
			->find();
		if($candidato->loaded()) {
			if(isset($_POST["salvar"]))
			{
				if(strlen($_POST["novasenha"]) < 6) {
					$var["erro"] = 'A senha deve ter no mínimo 6 caracteres';
				} elseif ($_POST["novasenha"] <> $_POST["cnovasenha"]) {
					$var["erro"] = 'Senhas não conferem';
				} else {
					$candidato->alterasenha($_POST["novasenha"]);
					$candidato->forgot_key();
					$this->request->redirect("candidato/forgotpass/alterado");
				}
			}
			$this->template->title = 'Redefinir minha senha';
			$this->template->content = View::factory('candidato/redefinirsenha', $var);
		} else {
			$this->template->title = 'Link inválido';
			$this->template->content = '<p class="p_error">Link inválido.</p>';
		}
	}

	public function action_alterado()
	{
		$this->template->title = 'Senha redefinida com sucesso';
		$success = '<h2>Candidato - Redefinir senha</h2>
		<div style="margin: 20px 0;">
			<p class="p_success">Senha alterada com sucesso. <a href="'.URL::site("candidato").'">Clique aqui</a> e entre no portal agora mesmo.</p>
		</div>';
		$this->template->content = $success;
	}

}
?>