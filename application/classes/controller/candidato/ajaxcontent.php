<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_AjaxContent extends Controller_Candidato_AjaxTemplate {
	
	public function action_candidatarse(){

		$user = Session::instance()->get("talen_user", NULL);
		if(!$user->is_completed()){
			$this->incomplete();
			return;
		}

		$id = $this->request->param("id");
		$candidatura = ORM::factory("candidatura");
		if($candidatura->jaCandidatado($user->id, $id)){
			$content = '<p class="p_error">Você já se candidatou a esta vaga</p>';
		} else {
			try {
				$candidatura->candidato_id = $user->id;
				$candidatura->vaga_id = $id;
				$candidatura->save();
				$email = new Email;
				$email->avisaCandidatura($candidatura);
				$content = '<p class="p_sucess">Candidatura efetuada com sucesso!</p>';
			} catch (ORM_Validation_Exception $e) {
				$content = $e->errors('models/candidato');
			}
		}
		$this->template->content = $content;
	}

	public static function incomplete(){
		$this->template->title = 'Perfil incompleto';
		$this->template->content = '<p class="p_warning">Complete o seu perfil para poder candidatar-se às vagas. <a href="'.URL::site('candidato/cadastrocv').'">Clique aqui.</a></p>';
	}

}