<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CadastroTMP extends Controller_DefaultTemplate {

	public function action_index()
	{
		$error = array();		
		if(isset($_POST["cadastrar"])){
		
			$empresa = Arr::get($_POST, "empresa");
			$nome = Arr::get($_POST, "nome");
			$telefone = Arr::get($_POST, "telefone");
			$email = Arr::get($_POST, "email");
			
			if(!Valid::not_empty($empresa))
				$error["empresa"] = "Campo obrigatório";
			if(!Valid::not_empty($nome))
				$error["nome"] = "Campo obrigatório";
			if(!Valid::not_empty($telefone))
				$error["telefone"] = "Campo obrigatório";
			if(!Valid::not_empty($email))
				$error["email"] = "Campo obrigatório";
			else
				if(!Valid::email(Arr::get($_POST, "email")))
					$error["email"] = "Email inválido";
			if(empty($error)){
				$message = "
				Empresa: $empresa<br />
				Nome: $nome<br />
				Telefone: $telefone<br />
				Email: $email<br />";
				$mail = new PHPMailer;
				$mail->IsHTML(true);
				$mail->IsMail();
				$mail->Subject = "ProfCerto - Cadastro";
				$mail->From = $email;
				$mail->FromName = $nome;
				$mail->Sender = $email;
				$mail->AddAddress(Model_Administrador::getEmailCadastro());
				$mail->Body = $message;
				$mail->Send();
				$this->request->redirect('cadastrotmp/success');
			
				// send email e redirect to success
			}
		}
        $this->template->title = 'Cadastro';
        $this->template->content = View::factory('cadastrotmp')
			->bind("values", $_POST)
			->bind("error", $error);
	}
	
	public function action_success()
	{	
        $this->template->title = 'Cadastro';
		$this->template->content = '
		<div class="content" style="margin-top: 30px;">
			<div class="dv_quadrado_invisivel" style="background: #EE4237"></div>
			<h2 class="h2_title txt-vermelho">cadastro</h2>
			<div class="clear"></div>
			<p class="p_success">Mensagem enviada com sucesso</p>
			<div class="dv-btn">
				<input type="button" value="voltar" onClick="window.open(\''.URL::site('cadastrotmp').'\', \'_top\');" />
			</div>
		</div>';
	}
	
}
?>