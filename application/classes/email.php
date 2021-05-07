<?php

defined('SYSPATH') or die('No direct script access.');

class Email {



	public function avisaConvite($m_cand)

	{

		$toemail = $m_cand->email;

		$toname = $m_cand->nome;

		$subject = 'BUP - Você foi convidado para um teste';

		$html = '<p>Você foi convidado para realizar um teste gratuitamente em nosso portal.</p>

		<p>Entre na sua área restrita em <a href="http://www.vagasdeprofessores.com.br'.URL::base().'">www.vagasdeprofessores.com.br/bup</a> e confira mais detalhes.</p>';



		$this->sendEmailToUser($toemail, $toname, $subject, $html);

	}



	public function avisaConviteDivulgacao($testeex)

	{

		$toemail = $testeex->candidato->email;

		$toname = $testeex->candidato->nome;

		$subject = 'BUP- Você foi convidado para um teste';

		$html = '<p>Alguém interessado em seu perfil gostaria de visualizar o resultado do teste <strong>'.$testeex->teste->nome.'</strong> que você já realizou.</p>

		<p>Entre na sua área restrita em <a href="http://www.vagasdeprofessores.com.br'.URL::base().'">www.vagasdeprofessores.com.br/bup</a> e confira mais detalhes.</p>';

		$this->sendEmailToUser($toemail, $toname, $subject, $html);

	}



	public function avisaPublicacao($convite)

	{

		$contratante = $convite->contacontratante->contratante;

		$candidato = $convite->candidato->codigo;

		$teste = $convite->teste->nome;



		$toemail = $contratante->email;

		$toname = $contratante->getNome();

		$subject = 'BUP - Candidato realizou o teste solicitado';

		$html = '<p>O candidato de código <strong>'.$candidato.'</strong> divulgou o resultado do teste solicitado: <strong>'.$teste.'</strong>.</p>

		<p>Entre na sua área restrita em <a href="http://www.vagasdeprofessores.com.br'.URL::base().'">www.vagasdeprofessores.com.br/bup</a> e confira mais detalhes.</p>';

		$this->sendEmailToUser($toemail, $toname, $subject, $html);

	}



	public function avisaCandidatura($candidatura)

	{

		$contratante = $candidatura->vaga->contratante;

		$candidato = $candidatura->candidato->nome;

		$vaga = $candidatura->vaga->titulo;



		$toemail = $contratante->email;

		$toname = $contratante->getNome();

		$subject = 'BUP- Um professor se interessou por sua vaga';

		$html = '<p>Um candidato se interessou pela vaga <strong>'.$vaga.'</strong> publicada por você.</p>

		<p>Entre na sua área restrita em <a href="http://www.vagasdeprofessores.com.br'.URL::base().'">www.vagasdeprofessores.com.br/bup</a> e confira mais detalhes.</p>';

		$this->sendEmailToUser($toemail, $toname, $subject, $html);

	}



	public function sendEmailToUser($toemail, $toname, $subject, $html, $text = null)

	{

	/*	$imagem1_path= $_SERVER['DOCUMENT_ROOT'].URL::site("assets/img/profcerto.png");

		$imagem1_nome="profcerto.jpg";

		$imagem1_type="image/jpeg";*/



		$texto = $this->putTemplateHtmlLogo($html);

	//	$texto = str_replace('http://www.profcerto.com.br'.URL::site('assets/img/profcerto.png'), 'cid:imagem1', $texto);



		$mail = new PHPMailer;

		$mail->IsHTML(true);

		$mail->IsMail();

		$mail->Encoding = "base64";

		$mail->AddEmbeddedImage($imagem1_path, 'imagem1', $imagem1_nome,'base64', $imagem1_type);

		$mail->Subject = $subject;

		$mail->From = 'atendimento@companhiadeidiomas.com.br';

		$mail->FromName = 'BUP';

		$mail->Sender = 'atendimento@companhiadeidiomas.com.br';

	//	$dev = (preg_match('/^dev.profcerto.com.br/', $_SERVER["SERVER_NAME"]));

//		if($dev) {

//			$toemail = 'paula@vgt.com.br';

//		}

		$mail->AddAddress($toemail, $toname);

		$mail->Body = $texto;

		if(is_null($text))

			$mail->AltBody = $mail->Body;

		else

			$mail->AltBody = $text;

		$mail->Send();

	}



	public function sendEmailToMe($fromemail, $fromname, $subject, $html, $text = null)

	{

		$mail = new PHPMailer;

		$mail->IsHTML(true);

		$mail->IsMail();

		$mail->Subject = $subject;

		$mail->From = $fromemail;

		$mail->FromName = $fromname;

		$mail->Sender=$fromemail;

		$toemail = Model_Administrador::getEmailContato();

//		$dev = (preg_match('/^dev.profcerto.com.br/', $_SERVER["SERVER_NAME"]));

//		if($dev) {

//			$toemail = 'paula@vgt.com.br';

//		}

		$mail->AddAddress($toemail);

		$mail->Body = $html;

		$mail->Send();

	}



	public function putTemplateHtmlLogo($content)

	{

		$msg = '

		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

		<html>

			<head>

				<meta http-equiv="content-type" content="text/html; charset=UTF-8">

			</head>

			<body text="#000000" bgcolor="#ffffff">

				<div style="margin: 10px auto;">

					<a target="_blank" title="BUP" href="http://www.vagasdeprofessores.com.br/bup" style="color: rgb(0, 45, 154); font-family: Verdana,Geneva,sans-serif; font-size: 24px; font-weight: bold; text-decoration: none;">';

//						<img alt="ProfCerto" src="http://www.profcerto.com.br'.URL::site("assets/img/profcerto.png").'" height="60" width="250" border="0">

	$msg .= '</a>

				</div>

				<div style="border: 1px solid #86acc7; padding: 10px 20px; width: 650px;">

					<div>

						'.$content.'

						<p>

							Atenciosamente,<br />

							Equipe Banco único de professores

						</p>

					</div>

				</div>

			</body>

		</html>';

		return $msg;

	}



	public function putTemplateHtml($content)

	{

		$msg = '

		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

		<html>

			<head>

				<meta http-equiv="content-type" content="text/html; charset=UTF-8">

			</head>

			<body text="#000000" bgcolor="#ffffff">

				<div style="border: 1px solid #86acc7; padding: 20px;">

					'.$content.'

					<p>

						Atenciosamente,<br />

						Equipe Banco único de professores

					</p>

				</div>

			</body>

		</html>';

		return $msg;

	}

}

?>