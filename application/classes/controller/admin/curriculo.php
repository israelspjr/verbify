<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Curriculo extends Controller_Admin_DefaultTemplate {

	public function action_geral()
	{
		$var = array();
		$id = $this->request->param('id');
		$this->verificaCandidato($id);
		$cand = ORM::factory("candidato", $id);
		$this->template->title = 'Currículo - Dados Gerais';
		$this->template->content = $this->getMenuHtml('geral', $id). $this->getMiniHtml($cand);
	}

	public function action_interesse()
	{
		$id = $this->request->param('id');
		$this->verificaCandidato($id);
		$cand = ORM::factory("candidato", $id);
		$this->template->title = 'Currículo - Interesses';
		$this->template->content = $this->getMenuHtml('interesse', $id) . $this->getInteresseHtml($cand);
		$this->template->styles = array(
			'assets/css/novocurriculo.css' => 'screen'
		);
	}

	public function action_experiencia()
	{
		$var = array();
		$id = $this->request->param('id');
		$this->verificaCandidato($id);
		$cand = ORM::factory("candidato", $id);
		$this->template->title = 'Currículo - Experiência / Formação';
		$this->template->content = $this->getMenuHtml('experiencia', $id) . $this->getExperienciaHtml($cand);
		$this->template->styles = array(
			'assets/css/novocurriculo.css' => 'screen'
		);
	}

	public function action_testes()
	{
		$var = array();
		$id = $this->request->param('id');
		$this->verificaCandidato($id);
		$cand = ORM::factory("candidato", $id);
		$this->template->title = 'Currículo - Testes';
		$this->template->content = $this->getMenuHtml('testes', $id) . $this->getTestesHtml($cand);
		$this->template->styles = array(
			'assets/css/novocurriculo.css' => 'screen'
		);
	}

/*	public function action_referencias()
	{
		$var = array();
		$id = $this->request->param('id');
		$this->verificaCandidato($id);
		$cand = ORM::factory("candidato", $id);
		$this->template->title = 'Currículo - Referências';
		$this->template->content = $this->getMenuHtml('referencias', $id) . $this->getReferenciasHtml($cand);
		$this->template->styles = array(
			'assets/css/novocurriculo.css' => 'screen'
		);
	}*/

	public function action_contato()
	{
		$var = array();
		$id = $this->request->param('id');
		$this->verificaCandidato($id);
		$cand = ORM::factory("candidato", $id);
		$this->template->title = 'Currículo - Contato';
		$this->template->content = $this->getMenuHtml('contato', $id) . $this->getContatoHtml($cand);
		$this->template->styles = array(
			'assets/css/novocurriculo.css' => 'screen'
		);
	}

	public function getErrorMessage()
	{
		return '<p class="p_error">Ocorreu um erro desconhecido. Por favor, entre em contato com a Administração.</p>';
	}

	public function verificaCandidato($id)
	{
		$cand = ORM::factory("candidato")->where("id", "=", $id)->find();
		if(!$cand->loaded()){
			$this->request->redirect("admin/home/notfound");
		}
	}

	public function getMenuHtml($active, $id)
	{
		$cand = ORM::factory("candidato", $id);
	 
		$menu = '<img src="http://www.vagasdeprofessores.com.br/uploads/'.$cand->foto.'" width="80" height="120"">
		<h2 class="curnome">
			'.$cand->nome.'
			<div style="float: right; margin-top: -5px;">
				<input type="button" value="Editar" onClick="window.open(\''.URL::site("admin/editcurriculo/geral/".$id).'\', \'_top\')" />
				'.($cand->active == 1 ? '<input type="button" value="Inativar" onClick="if(confirm(\'Tem certeza que deseja inativar este professor?\')) { window.open(\''.URL::site("admin/editcurriculo/inativar/".$id).'\', \'_top\') }" />' :
				'<input type="button" value="Ativar" onClick="window.open(\''.URL::site("admin/editcurriculo/ativar/".$id).'\', \'_top\');" />').'
			<a href="http://www.companhiadeidiomas.net/cursos/admin/modulos/cadastro/professor/profteste.php?id='.$id.'" target="_blank"><input type="button" value="Exportar para Cursos" /></a>
			</div>
		</h2>
		<ul class="curmenu">
			<li><a class="on '.($active == 'geral' ? 'active' : '').'" href="'.URL::site("admin/curriculo/geral/".$id).'">Dados Gerais</a></li>
			<li><a class="on '.($active == 'interesse' ? 'active' : '').'" href="'.URL::site("admin/curriculo/interesse/".$id).'">Interesse</a></li>
			<li><a class="on '.($active == 'experiencia' ? 'active' : '').'" href="'.URL::site("admin/curriculo/experiencia/".$id).'">Experiência / Formação</a></li>
			<li><a class="on '.($active == 'testes' ? 'active' : '').'" href="'.URL::site("admin/curriculo/testes/".$id).'">Testes</a></li>
		<!--	<li><a class="on '.($active == 'referencias' ? 'active' : '').'" href="'.URL::site("admin/curriculo/referencias/".$id).'">Referências</a></li>-->
			<li><a class="on '.($active == 'contato' ? 'active' : '').'" href="'.URL::site("admin/curriculo/contato/".$id).'">Contato</a></li>
		</ul>
		<div class="clear"></div>';
		return $menu;
	}

	public function getMiniHtml($c)
	{
		$var = array();
		$var["candidato"] = $c;
		// idiomas
		$idiomas = array();
		$cidiomas = $c->candidatoidiomas->find_all();
		foreach($cidiomas as $row){
			$idiomas[] = $row->idioma->descricao;
		}
		
		$var["idiomas"] = $idiomas;
		// locomoção
		$locomos = array();
		$clocomos = $c->locomocao->find_all();
		foreach($clocomos as $row){
			$locomos[] = $row->descricao;
		}
		$var["locomos"] = $locomos;
		// disponibilidade
		$disponibilidades = $c->disponibilidades->find_all();
		$var["loca"] = $c->localidade;
		$tabela = array();
		foreach($disponibilidades as $disp) {
			$tabela[$disp->semana][$disp->hora] = array("value" => $disp->status, "local" => $disp->cidade);
		}
		$var["disponibilidades"] = $tabela;
		$var["semana"] = Helper::arr_semana();
		$var["ead"] = '';
		$ead = array('ambos' => 'EAD e presencial', 'ead' => 'só ferramentas de EAD', 'presencial' => 'só presencial');
		if(array_key_exists($var["loca"]->tipo_disponibilidade, $ead)){
			$var["ead"] = $ead[$var["loca"]->tipo_disponibilidade];
		}
		$html = View::factory("admin/curriculo/mini", $var);
		return $html;
	}

	public function getInteresseHtml($c)
	{
		$var = array();
		$var["candidato"] = $c;
		// interesses
		$var["exps"] = $c->candidatoexperiencias->where('valor', '<>', '0')->find_all();
		$html = View::factory("contratante/curriculo/interesse", $var);
		return $html;
	}

	public function getExperienciaHtml($c)
	{
		$var = array();
		$var["candidato"] = $c;
		// experiências / formações
		$var["viagens"] = 		$c->viagens->order_by('dtde', 'DESC')->find_all();
		$var["certificacoes"] = $c->certificacoes->order_by('ano', 'DESC')->find_all();
		$var["graduacoes"] = 	$c->graduacoes->order_by('dt_inicio', 'DESC')->find_all();
		$var["experiencias"] = 	$c->expprofissionais->order_by('dt_inicio', 'DESC')->find_all();
		$var["cursoslivres"] = 	$c->candidatocursos->order_by('ano', 'DESC')->find_all();
		$html = View::factory("contratante/curriculo/experiencia", $var);
		return $html;
	}

	public function getTestesHtml($c)
	{
		$var = array();
		$var["candidato"] = $c;
		$user = Session::instance()->get("contrat_user", NULL);
		// todos os testes divulgados
		$var["testespublicados"] = $c->getTestesDivulgadosEscola();
		// todos os testes nao divulgados por idioma
		$var["testesoutros"] = $c->getTestesConviteDisponivel();
		$html = View::factory("admin/curriculo/testes", $var);
		return $html;
	}

	public function getReferenciasHtml($c)
	{
		$var = array();
		$var["candidato"] = $c;
		$var["referencias"] = $c->referencias
			->where("status", "=", "1")
			->where("aprovado", "=", "1")
			->find_all();
		$html = View::factory("contratante/curriculo/referencias", $var);
		return $html;
	}

	public function getContatoHtml($c)
	{
		$var = array();
		$var["candidato"] = $c;
		$html = View::factory("contratante/curriculo/contato", $var);
		return $html;
	}
}
