<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_Curriculum extends Controller_Contratante_CurriculoTemplate {

	public function action_mini()
	{
		$var = array();	
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');

		$idiomas = array();
		$locomos = array();

		$this->verificaCandidato($id);

		$cand = ORM::factory("candidato", $id);
		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '1')->count_all();
		if(! $temacesso){
		}
		$var["candidato"] = $cand;

		$cidiomas = $cand->candidatoidiomas->find_all();
		foreach($cidiomas as $row){
			$idiomas[] = $row->idioma->descricao;
		}
		$var["idiomas"] = $idiomas;

		$clocomos = $cand->locomocao->find_all();
		foreach($clocomos as $row){
			$locomos[] = $row->descricao;
		}
		$var["locomos"] = $locomos;

		
		$disponibilidades = $cand->disponibilidades->find_all();
		$var["loca"] = $cand->localidade;
		$tabela = array();
		foreach($disponibilidades as $disp) {
			$tabela[$disp->semana][$disp->hora] = array("value" => $disp->status, "local" => $disp->cidade);
		}
		$var["disponibilidades"] = $tabela;
		$var["semana"] = Helper::arr_semana();
		
		$ead = array('ambos' => 'EAD e presencial', 'ead' => 'só ferramentas de EAD', 'presencial' => 'só presencial');
		
		if(array_key_exists($var["loca"]->tipo_disponibilidade, $ead)){
			$var["ead"] = $ead[$var["loca"]->tipo_disponibilidade];
		}
		Session::instance()->set("alertmini[$id]", NULL);
		
		$this->template->title = 'Mini Currículo';
		$this->template->content = View::factory('contratante/curriculo/minitmp', $var);		
	}
	
	public function verificaCandidato($id)
	{
		$cand = ORM::factory("candidato")->where("id", "=", $id)->where("status", "=", "1")->find();
		if(!$cand->loaded()){
			$this->request->redirect("contratante/home/notfound");			
		}	
	}
	
}
?>