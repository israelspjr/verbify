<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_Candidaturas extends Controller_Candidato_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);
		if(isset($_POST["excluir"])){
			if(!isset($_POST["vaga"])){
				$errors = '<p class="p_error">Nenhuma candidatura selecionada</p>';
			} else {
				foreach($_POST["vaga"] as $id => $value){
					$tmp = $user->candidaturas->where("id", "=", $id)->find();
					$tmp->delete();
				}
				$errors = '<p class="p_error">Nenhuma candidatura selecionada</p>';				
			}
		}
		$var["canduras"] = $user->candidaturas->find_all();
		$this->template->title = 'Candidaturas';
		$this->template->content = View::factory('candidato/candidaturas', $var);
	}
}
?>