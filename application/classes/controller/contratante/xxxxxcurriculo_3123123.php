<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_Curriculo extends Controller_Contratante_DefaultTemplate {

	public function action_ver()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');
		
		$this->verificaCandidato($id);
		/*
		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '1')->count_all();
		if(! $temacesso){
		} else {
			$cand = ORM::factory("candidato", $id);
		}
		$var["candidato"] = $cand;
		*/
		$this->template->title = 'Currículo';
		$this->template->content = View::factory('contratante/curriculo/curriculo', $var);
	}
	
	public function verificaCandidato($id)
	{
		$cand = ORM::factory("candidato")->where("id", "=", $id)->where("status", "=", "1")->find();
		if(!$cand->loaded()){
			$this->request->redirect("contratante/home/notfound");			
		}	
	}	
}