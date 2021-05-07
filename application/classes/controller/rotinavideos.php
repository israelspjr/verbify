<?php defined('SYSPATH') or die('No direct script access.');

class Controller_RotinaVideos extends Controller {

	public function action_index()
	{
		// se o vídeo foi enviado há mais de 3h e não foi convertido
		$videos = ORM::factory("videotmp")->where(DB::expr('DATE_ADD(data, INTERVAL 3 HOUR)'), '<', DB::expr('NOW()'))->where('status','<>','1')->find_all();
		$html = count($videos).' vídeos a serem enviados<br />';
		if (count($videos) <> 0){
			foreach($videos as $video)
			{
				if($video->status == 0 OR $video->status == 2){
					$html .= "ID: ".$video->id." - Teste ".$video->teste->nome." - Candidato: ".$video->candidato->nome." <br/>";
					HeyWatch::converter($video);
				}
			}
		
			//$email = new Email;
			//$email->sendEmailToUser('tiago@vgt.com.br', 'Tiago', 'Rotina PROFCERTO', $html);
			echo $html;
		}
	}
}
?>
