<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Vagas extends Controller_DefaultTemplate {

	public function action_index()
	{
		$vagas = ORM::factory("vaga")->where('active', '=', '1')->find_all();
		//if($vagas->loaded()){
			$var["vagas"] = $vagas;
			$this->template->title = "Vagas disponíveis";
			$this->template->content = View::factory('candidato/vagadetalheindeed', $var);
		//}
	}
	
	public function action_detalhe()
	{
		$id = $this->request->param("id");
		$vaga = ORM::factory('vaga')->where('active', '=', '1')->where("id", "=", $id)->find();
		if($vaga->loaded()){
			$var["vaga"] = $vaga;
			$this->template->title = $vaga->getTitle();
			$this->template->content = View::factory('candidato/vagadetalhe', $var);
		}
	}
}
?>