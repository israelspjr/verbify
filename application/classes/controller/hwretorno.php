<?php defined('SYSPATH') or die('No direct script access.');


class Controller_HwRetorno extends Controller {

	public function action_success()
	{	
		$this->emailcontrole('Vídeo convertido com sucesso');
		try{
			$videoid = Arr::get($_REQUEST, "video_id");
			$videotmp = ORM::factory("videotmp")->where("hw_video_id", "=", $videoid)->find();
			if($videotmp->loaded()){
				$videotmp->status = 1;
				$videotmp->save();
				$html = 'Olá, '.$videotmp->candidato->nome.'. <br /><br />
				O vídeo enviado para o "'.$videotmp->teste->nome.'" foi convertido com sucesso. Entre no ProfCerto agora mesmo e confirme a publicação do teste.<br />';
				$email = new Email;
				$email->sendEmailToUser($videotmp->candidato->email, $videotmp->candidato->nome, 'ProfCerto - Vídeo convertido com sucesso', $html);
			} else {
				throw new Exception("Vídeo '".$videoid."' não encontrado");
			}
		} catch(Exception $e){
			$post = '';
			if(isset($_POST)){
				foreach($_POST as $key => $value){
					$post .= "$key => $value <br />";
				}
			}
			$email = new Email;
			$html = $e->getMessage().'<br />'.$post;
			$email->sendEmailToUser('tiago@vgt.com.br', 'Erro', 'ProfCerto - Conversão do vídeo (erro)', $html);
		}
	}

	public function action_error()
	{
		// email controle
		$this->emailcontrole('Erro na conversão');
		$videotmp = ORM::factory("videotmp", Arr::get($_POST, "my_site_video_id"));
		if($videotmp->loaded()){
			$testenome = $videotmp->teste->nome;
			if($videotmp->tries <= 3){
				HeyWatch::converter($videotmp);
				$videotmp->tries = $videotmp->tries+1;
				$videotmp->save();
				$html = '<p>Reenviando vídeo.</p>';
				$email = new Email;
				$email->sendEmailToUser('tiago@vgt.com.br', $videotmp->candidato->nome, 'ProfCerto - Reenviando vídeo', $html);
			} else {
				$html = '<p>Ocorreu um erro na conversão do vídeo. Por favor, tente novamente.</p>';
				$email = new Email;
				$email->sendEmailToUser($videotmp->candidato->email, $videotmp->candidato->nome, 'ProfCerto - Conversão do vídeo (erro)', $html);
				$videotmp->delete();
			}
		} else {
			$post = '';
			if(isset($_POST)){
				foreach($_POST as $key => $value){
					$post .= "$key => $value <br />";
				}
			}
			$html = '<p>Ocorreu um erro na conversão do vídeo. Vídeo não encontrado.</p>'.$post;
			$email = new Email;
			$email->sendEmailToUser('tiago@vgt.com.br', $videotmp->candidato->nome, 'ProfCerto - Conversão do vídeo (erro)', $html);
		}
	} 
	
	public function action_transfered()
	{
		$this->emailcontrole('Transferência do vídeo concluída');
		try {
			$videotmpid = Arr::get($_POST, "my_site_video_id");
			$videotmp = ORM::factory("videotmp", $videotmpid);
			$videoid = Arr::get($_POST, "video_id");
			if($videotmp->loaded()){
				$videotmp->status = 2;
				$videotmp->hw_video_id = $videoid;
				$videotmp->save();
			} else {
				throw new Exception("Vídeo id: ".$videotmpid." não encontrado. <br />");
			}
		} catch (Exception $e) {
			$post = '';
			if(isset($_POST)){
				foreach($_POST as $key => $value){
					$post .= "$key => $value <br />";
				}
			}
			$html = '<p>'.$e->getMessage().'</p>'.$post;
			$email = new Email;
			$email->sendEmailToUser('tiago@vgt.com.br', 'Paula', 'ProfCerto - Transferência do vídeo (erro)', $html);
		}
	}

	public function emailcontrole($title)
	{
		$post = 'POST<br /><br />';
		if(isset($_POST)){
			foreach($_POST as $key => $value){
				$post .= "$key => $value <br />";
			}
		}
		$server = '<br />Server<br /><br />';
		foreach($_SERVER as $key => $value){
			$server .= "$key => $value <br />";
		}
		$email = new Email;
		$email->sendEmailToUser('tiago@vgt.com.br', 'Tiago', 'ProfCerto - '.$title, $post . $server);
	}
	
}
?>