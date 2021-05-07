<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_EditCurriculo extends Controller_Admin_DefaultTemplate {

	public function action_geral()
	{
		$id = $this->request->param("id");
		$var = array();
		if($_POST) {
		//	$senha = "junior";
		//	$_POST['aprovadoCI'] = (isset($_POST['aprovadoCI']));
			$candidato =  ORM::factory("candidato", $id);
			$candidato->values($_POST, array('email','senha', 'senhatxt', 'nome', 'doctype', 'cpf', 'rg', 'sexo', 'dtnasc', 'nacionalidade', 'comoconheceu', 'tel1', 'pais1', 'tel2', 'pais2',
				'email2', 'skype', 'outrosim', 'blog', 'facebook', 'outrars',
				'endereco', 'numero', 'compl', 'bairro', 'cep', 'cidade', 'estado', 'pais', 'aprovadoCI', 'sotaque', 'obs'));
			$cand_idiomas = (Arr::get($_POST, 'idioma') ? Arr::get($_POST, 'idioma') : array());
			$cand_locomocao = (Arr::get($_POST, 'locomocao') ? Arr::get($_POST, 'locomocao') : array());
			$outroidioma = Arr::get($_POST, 'outroidioma');
			$sotaque = Arr::get($_POST, 'sotaque');
			
			$outralocomocao = Arr::get($_POST, 'outralocomocao');

			$external_values = array(
				'senha' => Arr::get($_POST, 'senhatxt'),
				'idioma' => $cand_idiomas,
				'locomocao' => $cand_locomocao,
			) + Arr::get($_POST, '_external', array());
			
				$senha = Arr::get($_POST, 'senhatxt');
				$email = Arr::get($_POST, 'email');
	
			
			DB::update('candidato')->set(array('senha' => Auth::instance()->hash($senha), 'senhatxt' => $senha))->where('id', '=', $id)->execute();	

			$extra = Validation::factory($external_values)
				->rule('idioma', 'not_empty')
				->rule('idioma', array($candidato, 'validaoutro'), array(':value', ':field', $outroidioma))
				->rule('locomocao', 'not_empty')
				->rule('locomocao', array($candidato, 'validaoutro'), array(':value', ':field', $outralocomocao));

			$db = Database::instance();
			try
			{
				$db->begin();
				$candidato->save($extra);
				$candidato->saveIdiomas($cand_idiomas, $outroidioma);
				$candidato->saveLocomocao($cand_locomocao, $outralocomocao);
				$db->commit();
				
				
				
				$var['success'] = __('Dados salvos com sucesso.');
 			}
			catch (ORM_Validation_Exception $e)
			{
				$db->rollback();
				$errors = $e->errors('models/candidato');
			}
			$values = $_POST;
			$values["senhatxt"] = $candidato->senhatxt;
			$values["senha"] = $candidato->senhatxt;
			$values["paises"] = ORM::factory("pais")->find_all();
		} else {
			$candidatoorm =  ORM::factory("candidato", $id);
			$candidato = $candidatoorm->as_array();
			$candidato["dtnasc"] = Helper::format_date($candidato["dtnasc"] );
			$idiomas = $candidatoorm->candidatoidiomas->find_all();
			foreach($idiomas as $row){
				$candidato["idioma"][$row->idioma->id] = 1;
				if($row->idioma->is_outro == 1){
					$candidato["outralocomocao"] = $row->outro;
				}
			}
			$locomocoes = $candidatoorm->locomocao->find_all();
			foreach($locomocoes as $row){
				$candidato["locomocao"][$row->id] = 1;
			}
			
				
    		$candidato["paises"] = ORM::factory("pais")->find_all();
			
			$values = $candidato;
		}
		
		$idiomas = Model_Idioma::getAll();
		$idiomas_obs = array(9, 10);
		$locomocao = ORM::factory("locomocao")->where("active", "=", "1")->find_all();
		$this->template->title = __('Cadastro do Currículo').' - '.__('Dados Pessoais');
		$this->template->content = $this->getMenuHtml('geral', $id) . View::factory('admin/curriculo/meusdados', $var)
			->set('values', $values)
			->bind('idiomas', $idiomas)
			->bind('idiomas_obs', $idiomas_obs)
			->bind('locomocao', $locomocao)
			->bind('id', $id)
			->bind('errors', $errors);
		$this->template->scripts = array(
			'assets/js/jquery.qtip-1.0.0-rc3.min.js',
			'assets/js/cadastro.js'
		);
	}

	public function action_interesse()
	{
		$id = $this->request->param("id");
		$var = array();
		$user = ORM::factory("candidato", $id);
		if ($_POST)
		{
			$experiencias = Arr::get($_POST, 'experiencia');
			$anos = Arr::get($_POST, 'experiencia_anos');
			$escolas = Arr::get($_POST, 'experiencia_escolas');
			$qual = Arr::get($_POST, 'experiencia_qual');

			foreach($experiencias as $key => $value){
				$m_exp = ORM::factory("experiencia", $key);
				if($m_exp->experiencia == 1 AND $value == 2){
					if($anos[$key] == ""){
						$errors['exp'.$key] = __('Preencha quantos anos de experiência você possui.');
					} elseif($m_exp->escolas == 1 AND $escolas[$key] == ""){
						$errors['exp'.$key] = __('Preencha as escolas em que atuou.');
					}
				} elseif($m_exp->yesorno == 1 AND $value==1){
					if($qual[$key] == ""){
						$errors['exp'.$key] = __('Preencha qual a experiência.');
					}
				}
			}
			if( empty($errors) ){
				$db = Database::instance();
				$db->begin();

				$user->delete_all_interesses();
				try
				{
					foreach($experiencias as $key => $value){
						$candidatoexperiencia = ORM::factory("candidatoexperiencia");
						$candidatoexperiencia->candidato_id = $user->id;
						$candidatoexperiencia->experiencia_id = $key;
						$candidatoexperiencia->valor = $value;
						$candidatoexperiencia->anos = Arr::get($anos, $key);
						$candidatoexperiencia->escolas = Arr::get($escolas, $key);
						$candidatoexperiencia->qual = Arr::get($qual, $key);
						$candidatoexperiencia->save();
					}
					$user->interesse = 1;
					$user->atualizastatus();
					$db->commit();
					// $this->request->redirect('candidato/cadastrocv2');
					$var['success'] = __('Dados salvos com sucesso.');
				}
				catch (Exception $e)
				{
					$db->rollback();
					$errors["geral"] = $e->getMessage();
				}
			}
			$values = $_POST;
		} else {
			$values= array();
			$exps = $user->candidatoexperiencias->find_all();
			foreach($exps as $exp) {
				$values['experiencia'][$exp->experiencia_id] = $exp->valor;
				$values['experiencia_anos'][$exp->experiencia_id] = $exp->anos;
				$values['experiencia_escolas'][$exp->experiencia_id] = $exp->escolas;
				$values['experiencia_qual'][$exp->experiencia_id] = $exp->qual;
			}
		}

		$experiencias = ORM::factory("experiencia")->find_all();

		$this->template->title = __('Cadastro do Currículo').' - '.__('Interesses');
		$this->template->content = $this->getMenuHtml('interesse', $id) .  View::factory('admin/curriculo/interesses', $var)
			->set('values', $values)
			->bind('experiencias', $experiencias)
			->bind('errors', $errors);
	}

	public function action_experiencia()
	{
		$id = $this->request->param("id");
		$var = array();
		$user = ORM::factory("candidato", $id);

		if(isset($_POST["salvar"])){
			$db = Database::instance();
			$db->begin();

			$user->delete_all_viagens();
			$var["viagens"] = array();
			if(isset($_POST["vordem"])) {
				foreach($_POST["vordem"] as $i) {
					try {
						$viagens = ORM::factory("candidatoviagem");
						$viagens->candidato_id = $user->id;
						$viagens->pais_id = $_POST["pais"][$i];
						$viagens->dtde = Helper::format_date_db($_POST["dt_partida"][$i]);
						$viagens->dtate = Helper::format_date_db($_POST["dt_volta"][$i]);
						$viagens->atividade = (isset($_POST["atividade"][$i]) ? $_POST["atividade"][$i] : '');
						$viagens->descricao = $_POST["txt_desc"][$i];
						$viagens->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['viagem'][$i] = $e->errors('models/candidato');
					}
					$var["viagens"][] = $viagens;
				}
			}

			$user->delete_all_certificacoes();
			$var["certificacoes"] = array();
			if(isset($_POST["cordem"])){
				foreach($_POST["cordem"] as $i) {
					try {
						$certs = ORM::factory("candidatocertificacao");
						$certs->candidato_id = $user->id;
						$certs->descricao = $_POST["cert_descricao"][$i];
						$certs->ano = $_POST["cert_ano"][$i];
						$certs->tipo = $_POST["cert_tipo"][$i];
						$certs->idioma_id = $_POST["cert_idioma"][$i];
						$certs->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['certi'][$i] = $e->errors('models/candidato');
					}
					$var["certificacoes"][] = $certs;
				}
			}

			$user->delete_all_graduacoes();
			$var["graduacoes"] = array();
			if(isset($_POST["gordem"])) {
				foreach($_POST["gordem"] as $i) {
					try {
						$grads = ORM::factory("candidatograduacao");
						$grads->candidato_id = $user->id;
						$grads->grauescolar_id = $_POST["escolaridade"][$i];
						$grads->curso_id = $_POST["curso"][$i];
						$grads->situacao = (isset($_POST["situacao"][$i]) ? $_POST["situacao"][$i] : '');
						$grads->dt_inicio = (isset($_POST["grad_dtini"][$i]) ? Helper::format_month_to_datedb($_POST["grad_dtini"][$i]) : '');
						$grads->dt_conclusao = (isset($_POST["grad_dtfim"][$i]) ? Helper::format_month_to_datedb($_POST["grad_dtfim"][$i]) : '0');
						$grads->instituicao = $_POST["instituicao"][$i];
						$grads->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['gradu'][$i] = $e->errors('models/candidato');
					}
					$var["graduacoes"][] = $grads;
				}
			}

			$user->delete_all_expidiomas();
			$var["experiencias_idiomas"] = array();
			if(isset($_POST["epordem_idioma"])){
				foreach($_POST["epordem_idioma"] as $i) {
					try {
						$eprof = ORM::factory("candidatoexpidioma");
						$eprof->candidato_id = $user->id;
						$eprof->funcao = $_POST["funcao_idioma"][$i];
						$eprof->dt_inicio = (isset($_POST["exp_dtinicio_idioma"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtinicio_idioma"][$i]) : '');
						$eprof->dt_fim = (isset($_POST["exp_dtfim_idioma"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtfim_idioma"][$i]) : '');
						$eprof->atualidade = (isset($_POST["atual_idioma"][$i]) ? $_POST["atual_idioma"][$i] : '0');
						$eprof->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['eprof_idioma'][$i] = $e->errors('models/candidato');
					}
					$var["experiencias_idiomas"][] = $eprof;
				}
			}

			$user->delete_all_expprofissionais();
			$var["experiencias"] = array();
			if(isset($_POST["epordem"])){
				foreach($_POST["epordem"] as $i) {
					try {
						$eprof = ORM::factory("candidatoexpprofissional");
						$eprof->candidato_id = $user->id;
						$eprof->funcao = $_POST["funcao"][$i];
						$eprof->dt_inicio = (isset($_POST["exp_dtinicio"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtinicio"][$i]) : '');
						$eprof->dt_fim = (isset($_POST["exp_dtfim"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtfim"][$i]) : '');
						$eprof->atualidade = (isset($_POST["atual"][$i]) ? $_POST["atual"][$i] : '0');
						$eprof->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['eprof'][$i] = $e->errors('models/candidato');
					}
					$var["experiencias"][] = $eprof;
				}
			}

			$user->delete_all_cursos();
			$var["cursoslivres"] = array();
			if(isset($_POST["cursoordem"])){
				foreach($_POST["cursoordem"] as $i) {
					try {
						$cursos = ORM::factory("candidatocursoslivres");
						$cursos->candidato_id = $user->id;
						$cursos->curso = $_POST["cursolivre"][$i];
						$cursos->instituicao = $_POST["cl_instituicao"][$i];
						$cursos->ano = $_POST["cl_ano"][$i];
						$cursos->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['curso'][$i] = $e->errors('models/candidato');
					}
					$var["cursoslivres"][] = $cursos;
				}
			}
			if(isset($errors)) {
				$db->rollback();
			} else {
				$user->expformacao = 1;
				$user->atualizastatus();
				$db->commit();
				$var['success'] = __('Dados salvos com sucesso.');
				//$this->request->redirect('candidato/cadastrocv3');
			}
		} else {
			$var["viagens"] = $user->viagens->order_by('dtde', 'DESC')->find_all();
			$var["certificacoes"] = $user->certificacoes->order_by('ano', 'DESC')->find_all();
			$var["graduacoes"] = $user->graduacoes->order_by('dt_inicio', 'DESC')->find_all();
			$var["experiencias"] = $user->expprofissionais->order_by('dt_inicio', 'DESC')->find_all();
			$var["experiencias_idiomas"] = $user->expidiomas->order_by('dt_inicio', 'DESC')->find_all();
			$var["cursoslivres"] = $user->candidatocursos->order_by('ano', 'DESC')->find_all();
		}

		$var["paises"] = ORM::factory("pais")->order_by("name", "ASC")->find_all();
		$var["grauescolar"] = ORM::factory("grauescolar")->order_by("ordem", "ASC")->find_all();
		$var["cursos"] = ORM::factory("curso")->order_by("descricao", "ASC")->find_all();
		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->order_by("descricao", "ASC")->find_all();

		$this->template->title = __('Cadastro do Currículo').' - '.__('Experiência / Formação');
		$this->template->content = $this->getMenuHtml('experiencia', $id) . View::factory('admin/curriculo/experiencia', $var)
			->set('values', $_POST)
			->bind('pais', $pais)
			->bind('errors', $errors);
	}

	public function action_disponibilidade()
	{
		$id = $this->request->param("id");
		$var = array();
		$user = ORM::factory("candidato", $id);
		$regioes = array();
		$semana = Helper::arr_semana();

		if(isset($_POST["salvar"])){

			$db = Database::instance();
			$db->begin();
			try {
				$loca = ORM::factory("candidatolocalidade", $user->id);
				$loca->candidato_id = $user->id;
				$loca->tipo_disponibilidade = $_POST["tipo"];
				$loca->pais = ($_POST["pais"] == "brasil" ? $_POST["pais"]  : $_POST["outropais"]);
				$loca->estado_id = (isset($_POST["estado"]) ? $_POST["estado"] : 0);
				$loca->cidade_id = (isset($_POST["cidade"]) ? $_POST["cidade"] : 0);
				$loca->sobremim = $_POST["sobremim"];

				// tenta savar as regioes
				if(isset($_POST["regioes"])){
					$loca->regiao_id = 1;
					$regioes = $_POST["regioes"];
					$regioes_atual = Helper::orm_to_array($user->regiao->find_all(), "id");
					foreach($_POST["regioes"] as $regiao){
						if(!in_array($regiao, $regioes_atual)){
							$user->add('regiao', $regiao);
						}
					}
					$removes = $user->regiao->where('id', 'NOT IN', $_POST["regioes"])->find_all();
					foreach($removes as $row)
						$user->remove('regiao', $row);
				} else {
					$loca->regiao_id = 0;
					$removes = $user->regiao->find_all();
					foreach($removes as $row)
						$user->remove('regiao', $row);
				}
				$loca->save();
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('models/candidato');
			}

			if (isset($errors)) {
				$db->rollback();
			} else {
				$user->disponibilidade = 1;
				$user->atualizastatus();
				$db->commit();
				$var['success'] = __('Dados salvos com sucesso.');
				//$this->request->redirect('candidato/referencias');
			}

		} else {
			$regioes = Helper::orm_to_array($user->regiao->find_all(), "id");
			$loca = ORM::factory("candidatolocalidade", $user->id);
		}

		$var["estados"] = ORM::factory('estado')->find_all();
		$var['pais'] = ORM::factory('pais')->find_all();

		$this->template->title = __('Cadastro do Currículo').' - '.__('Disponibilidade');
		$this->template->content = $this->getMenuHtml('disponibilidade', $id) . View::factory('admin/curriculo/disponibilidade', $var)
			->set('values', $_POST)
			->bind('regioes', $regioes)
			->bind('localidade', $loca)
			->bind('errors', $errors);
	}

	public function action_inativar()
	{
		$id = $this->request->param("id");
		$prof = ORM::factory("candidato", $id);
		if($prof->loaded() AND $prof->active==1)
		{
			foreach($prof->candidaturas->find_all() as $cands)
			{
				$cands->delete();
			}
			$prof->active = 0;
			$prof->save();
		}
		$this->request->redirect("admin/candidatos");
	}

	public function action_ativar()
	{
		$id = $this->request->param("id");
		$prof = ORM::factory("candidato", $id);
		if($prof->loaded() AND $prof->active==0)
		{
			$prof->active = 1;
			$prof->save();
		}
		$this->request->redirect("admin/candidatos");
	}

	public function getMenuHtml($active, $id)
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$cand = ORM::factory("candidato", $id);

		$menu = '
		<h2 class="curnome">
			'.$cand->nome.'
		</h2>
		<ul class="curmenu">
			<li><a class="on '.($active == 'geral' ? 'active' : '').'" href="'.URL::site("admin/editcurriculo/geral/".$id).'">Dados Gerais</a></li>
			<li><a class="on '.($active == 'interesse' ? 'active' : '').'" href="'.URL::site("admin/editcurriculo/interesse/".$id).'">Interesse</a></li>
			<li><a class="on '.($active == 'experiencia' ? 'active' : '').'" href="'.URL::site("admin/editcurriculo/experiencia/".$id).'">Experiência / Formação</a></li>
			<li><a class="on '.($active == 'disponibilidade' ? 'active' : '').'" href="'.URL::site("admin/editcurriculo/disponibilidade/".$id).'">Disponibilidade</a></li>
		</ul>
		<div class="clear"></div>';
		return $menu;
	}

}