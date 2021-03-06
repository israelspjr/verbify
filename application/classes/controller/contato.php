<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Contato extends Controller_DefaultTemplate {



	public function action_index()

	{

		$var = array();

		if(isset($_POST["enviar"])) {

			$nome = trim(Arr::get($_POST, "nome"));

			$email = trim(Arr::get($_POST, "email"));

			$message = trim(Arr::get($_POST, "message"));

			if($nome == "" OR $email == "" OR $message == ""){

				$var["erro"] = I18n::get('todososcampossaoobrigatorios');

			} elseif(!Valid::email($email)) {

				$var["erro"] = 'Email inválido';

			} else {

				$mail = new Email;

				$subject = "Verbify - Contato";

				$fromemail = $email;

				$fromname = $nome;

				$mail->sendEmailToMe($fromemail, $fromname, $subject, $message);

				$var["success"] = __('obrigado pelo contato');

			}

		}

        $this->template->title = 'Contato';

        $this->template->content = View::factory('contato', $var)

			->set('values', $_POST);

		$this->template->menuactive = 'contato';

	}



	public function action_success()

	{

        $this->template->title = 'Contato - Mensagem enviada';

		$this->template->content = View::factory('contatosuccess');

		$this->template->menuactive = 'contato';

	}

} // End Home

