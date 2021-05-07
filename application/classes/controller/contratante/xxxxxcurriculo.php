<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_Curriculo extends Controller_Contratante_DefaultTemplate {

	public function action_ver()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');
		$acesso = $user->conta->getAcessoComprado($id);
		
		if($acesso == 3){
			$this->request->redirect("contratante/curriculo/contato/$id");
		} elseif($acesso == 2){
			$this->request->redirect("contratante/curriculo/completo/$id");
		} else {
			$this->request->redirect("contratante/curriculo/mini/$id");
		}
	}
	
	public function action_mini()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');

		$idiomas = array();
		$locomos = array();

		$this->verificaCandidato($id);

		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '1')->count_all();
		if(! $temacesso){
			// verifica se foi avisado
			$alert = Session::instance()->get("alertmini[$id]", NULL);
			if(is_null($alert)){
				$this->miniaviso($id);
				return;
			}
			try {
				$cand = $user->conta->compra(1, $id);
			} catch(exception $e){
				$cand = ORM::factory("candidato");
				$var["errors"] = $e->getMessage();
			}
		} else {
			$cand = ORM::factory("candidato", $id);
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
		$this->template->content = View::factory('contratante/minicurriculo', $var);
		$this->template->styles = array(
			'assets/jqueryui/css/redmond/jquery-ui-1.8.21.custom.css' => 'screen', 
			'assets/css/minicurriculo.css' => 'screen',
			'assets/css/curriculocompleto.css' => 'screen',
		);
		$this->template->scripts = array('assets/jqueryui/js/jquery-ui-1.8.21.custom.min.js');
	}
	
	public function miniaviso($id)
	{
		$user = Session::instance()->get("contrat_user", NULL);
		
		$this->verificaCandidato($id);
		$this->verificaConsumo(1);

		if(isset($_POST["ok"])){
			Session::instance()->set("alertmini[$id]", "ok");
			$this->request->redirect("contratante/curriculo/mini/$id");
		}
		
		$consumo = ORM::factory('consumocredito', 1);
		$this->template->content = 'Esta ação vai consumir '.$consumo->consumo.' créditos
		<div>
			<form method="post">
			<input type="button" name="cancel" value="cancelar" onClick="history.back();" />
			<input type="submit" name="ok" value="ok" />
			</form>
		</div>';
	}
	
	public function action_completo()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');

		$this->verificaCandidato($id);

		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '2')->count_all();
		if(! $temacesso){
			// verifica se foi avisado
			$alert = Session::instance()->get("alertcompl[$id]", NULL);
			if(is_null($alert)){
				$this->request->redirect("contratante/curriculo/completoaviso/$id");
			}
			try {
				$cand = $user->conta->compra(2,  $id);
			} catch(exception $e){
				$cand = ORM::factory("candidato");
				$var["errors"] = $e->getMessage();
			}
		} else {
			$cand = ORM::factory("candidato", $id);
		}
		$var["candidato"] = $cand;
		
		if(!isset($var["errors"])){
			
			// mini currículo
			$idiomas = array();
			$cidiomas = $cand->candidatoidiomas->find_all();
			foreach($cidiomas as $row){
				$idiomas[] = $row->idioma->descricao;
			}
			$var["idiomas"] = $idiomas;

			$locomos = array();
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
			$var["ead"] = $ead[$var["loca"]->tipo_disponibilidade];
			
			// interesses
			$var["exps"] = $cand->candidatoexperiencias->where('valor', '<>', '0')->find_all();
			
			// experiências / formações
			$var["viagens"] = $cand->viagens->order_by('dtde', 'DESC')->find_all();
			$var["certificacoes"] = $cand->certificacoes->order_by('ano', 'DESC')->find_all();
			$var["graduacoes"] = $cand->graduacoes->order_by('dt_inicio', 'DESC')->find_all();
			$var["experiencias"] = $cand->expprofissionais->order_by('dt_inicio', 'DESC')->find_all();
			$var["cursoslivres"] = $cand->candidatocursos->order_by('ano', 'DESC')->find_all();
		}
		
		// testes
		$var = array_merge($var, $this->getTestes($cand));
		
		Session::instance()->set("alertcompl[$id]", NULL);

		$this->template->title = 'Currículo Completo';
		$this->template->content = View::factory('contratante/curriculo', $var);
		$this->template->styles = array(
			'assets/jqueryui/css/redmond/jquery-ui-1.8.21.custom.css' => 'screen', 
			'assets/css/minicurriculo.css' => 'screen',
			'assets/css/curriculocompleto.css' => 'screen',
		);
		$this->template->scripts = array('assets/jqueryui/js/jquery-ui-1.8.21.custom.min.js');
	}
	
	public function action_completoaviso()
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');
		
		$this->verificaCandidato($id);
		$this->verificaConsumo(2);
		
		if(isset($_POST["ok"])){
			Session::instance()->set("alertcompl[$id]", "ok");
			$this->request->redirect("contratante/curriculo/completo/$id");
		}
		
		$consumo = ORM::factory('consumocredito', 2);
		$this->template->content = 'Esta ação vai consumir '.$consumo->consumo.' créditos
		<div>
			<form method="post">
			<input type="button" name="cancel" value="cancelar" onClick="history.back();" />
			<input type="submit" name="ok" value="ok" />
			</form>
		</div>';
	}	
	
	public function action_contato()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');

		$this->verificaCandidato($id);

		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '3')->count_all();
		if(! $temacesso){
			// verifica se foi avisado
			$alert = Session::instance()->get("alertcontt[$id]", NULL);
			if(is_null($alert)){
				$this->request->redirect("contratante/curriculo/contatoaviso/$id");
			}
			try {
				$cand = $user->conta->compra(3, $id);
			} catch(exception $e){
				$cand = ORM::factory("candidato");
				$var["errors"] = $e->getMessage();
			}
		} else {
			$cand = ORM::factory("candidato", $id);
		}
		$var["candidato"] = $cand;
		
		if(!isset($var["errors"])){
			// mini currículo
			$idiomas = array();
			$cidiomas = $cand->candidatoidiomas->find_all();
			foreach($cidiomas as $row){
				$idiomas[] = $row->idioma->descricao;
			}
			$var["idiomas"] = $idiomas;

			$locomos = array();
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
			$var["ead"] = $ead[$var["loca"]->tipo_disponibilidade];
			
			// interesses
			$var["exps"] = $cand->candidatoexperiencias->where('valor', '<>', '0')->find_all();
			
			// experiências / formações
			$var["viagens"] = $cand->viagens->order_by('dtde', 'DESC')->find_all();
			$var["certificacoes"] = $cand->certificacoes->order_by('ano', 'DESC')->find_all();
			$var["graduacoes"] = $cand->graduacoes->order_by('dt_inicio', 'DESC')->find_all();
			$var["experiencias"] = $cand->expprofissionais->order_by('dt_inicio', 'DESC')->find_all();
			$var["cursoslivres"] = $cand->candidatocursos->order_by('ano', 'DESC')->find_all();
		}
		
		// testes
		$var = array_merge($var, $this->getTestes($cand));

		Session::instance()->set("alertcontt[$id]", NULL);

		$this->template->title = 'Currículo Contato';
		$this->template->content = View::factory('contratante/curriculocontato', $var);
		$this->template->styles = array(
			'assets/jqueryui/css/redmond/jquery-ui-1.8.21.custom.css' => 'screen', 
			'assets/css/minicurriculo.css' => 'screen',
			'assets/css/curriculocompleto.css' => 'screen',
		);
		$this->template->scripts = array('assets/jqueryui/js/jquery-ui-1.8.21.custom.min.js');
	}
	
	public function action_contatoaviso()
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param('id');

		$this->verificaCandidato($id);
		$this->verificaConsumo(3);

		if(isset($_POST["ok"])){
			Session::instance()->set("alertcontt[$id]", "ok");
			$this->request->redirect("contratante/curriculo/contato/$id");
		}
		$consumo = ORM::factory('consumocredito', 3);
		
		$this->template->content = 'Esta ação vai consumir '.$consumo->consumo.' créditos
		<div>
			<form method="post">
			<input type="button" name="cancel" value="cancelar" onClick="history.back();" />
			<input type="submit" name="ok" value="ok" />
			</form>
		</div>';
	}

	public function getTestes($cand)
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$acessos = $user->conta->getTestesComprados($cand->id);
		$arr["testes"] = ORM::factory("teste")->getTestesCadastrados();
		$arr["testespublicados"] = Helper::objectToArray($cand->getTestesDivulgados(), 'teste_id');
		$arr["testescomprados"] = Helper::objectToArray($acessos, 'teste_id');
		return $arr;
	}
	
	public function verificaCandidato($id)
	{
		$cand = ORM::factory("candidato")->where("id", "=", $id)->where("status", "=", "1")->find();
		if(!$cand->loaded()){
			$this->request->redirect("contratante/home/notfound");			
		}	
	}

	public function verificaConsumo($id)
	{
		$consumo = ORM::factory("consumocredito", $id);
		if(!$consumo->loaded()){
			$this->request->redirect("contratante/home/notfound");
		}	
	}
	
}
?>