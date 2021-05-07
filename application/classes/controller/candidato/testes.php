<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_Testes extends Controller_Candidato_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);
		// Mostrar só um teste de cada idioma, e aleatoriamente
		$var["lang"] = $this->lang;
		$var["testes"] = $user->getTestesNaoExecutados();
		$var["convites"] = $user->getTestesConvites();
		$this->template->title = __('testes');
		$this->template->content = View::factory('candidato/testes', $var);
	}

	public static function getChamada($teste, $convites, $lang)
	{
		$user = Session::instance()->get("talen_user", NULL);
		$custo = $teste->getConsumoProfessor($user);
		//$lang = $this->request->param("lang");
		if($teste->tipo == 2){
			$html = '<h3>'.$teste->getNome($lang).'</h3>
			'.__('Tipo de teste').': ORAL'
			
//			'.__('Custo').': '.(in_array($teste->id, $convites) ?  __('Você foi convidado a fazer gratuitamente') : $custo.' crédito(s)')

            .'<br />
			<p class="p_enunciado">* '.__('Este teste consiste na inclusão de um vídeo, gravado por você, respondendo na língua relativa ao teste às questões do enunciado.').'<br /></p>
			<input type="button" onClick="window.open(\''.URL::site("candidato/testeoral/index/".$teste->id).'\', \'_top\');" value="'.__('Iniciar').'" />
			';
		} else {
			// verifica se teste ja foi iniciado
			$iniciou = ORM::factory("candidatoresposta")
				->where("candidato_id", "=", $user->id)
				->where("teste_id", "=", $teste->id)
				->count_all();
			$html = '<h3>'.$teste->getNome($lang).'</h3>
			'.__('Número de questões').': '.$teste->questoes->count_all().'<br />';
			if($user->conta->testeExecComprado($teste->id)){
				$html .= __('Situação').': '.__('Disponivel').'<br />'
			    .'<p class="p_enunciado">* '.__('Todas as questões possuem tempo para resposta. Quando o tempo acaba, a quest&atilde;o &eacute; anulada, e passa-se automaticamente para a pr&oacute;xima.').'<br /></p>';
			} elseif($iniciou > 0){
				$html .= __('Situação').': '.__('Incompleto').'<br />';
			} else {
				$html .= __('Custo').': '.(in_array($teste->id, $convites) ? __('Você foi convidado a fazer gratuitamente') : ($custo == 0 ? __('Gratuito') : $custo. ' crédito(s)')).'<br />';
			}
			$html .= '<p class="p_enunciado">'.$teste->getDescricao($lang).'</p>';
			$html .= '<div style="margin: 10px 0;"><input type="button" onClick="window.open(\''.URL::site("candidato/testes/executar/".$teste->id).'\', \'_top\');" value="'.__('Iniciar').'" /></div>';
		}
		return $html;
	}

	public function action_executar()
	{
		$user = Session::instance()->get("talen_user", NULL);
		$var = array();
		$id = $this->request->param("id");

		// se teste existe
		$this->verificaTeste($id);
		$teste = ORM::factory("teste", $id);

		if($teste->tipo == 4){
			$this->request->redirect("candidato/testeoral/index/".$id);
		}

		// se já realizado
		$testeexec = ORM::factory("testeexecutado")
			->where("teste_id", "=", $teste->id)
			->where("candidato_id", "=", $user->id)
			->find();
		if($testeexec->loaded()){
			$this->request->redirect("candidato/testes/jarealizado");
		}

		// se nao foi convidado, e não foi comprado ainda
		$convites = $user->convites->where("teste_id", "=", $id)->count_all();
		if($convites == 0 AND !$user->conta->testeExecComprado($id))
		{
			$custo = $teste->getConsumoProfessor($user);
			if($custo > 0){
				// avisa consumo e debita
				$alert = Session::instance()->get("alertteste[$id]", NULL);
				if(is_null($alert)){
					$this->request->redirect("candidato/testes/avisaconsumo/$id");
				}
			}
			try {
				$user->conta->compraTesteExec($id);
			} catch(exception $e){
				$this->template->title = __('testes');
				$this->template->content = '<p class="p_error">'.$e->getMessage().'</p>
				<div class="dv_btn">
					<input type="button" onClick="window.open(\''.URL::site("candidato/testes").'\', \'_top\');" value="voltar" />
				</div>';
				return;
			}
		}

		$questions = $teste->questoes->count_all();
		$question = $teste->getProximaQuestao($user->id);
		$var["tempo"] = $question->max_tempo;

		if(isset($_POST["gravar"])){
			$qid = $this->request->post("questao_id");
			$questao = ORM::factory("questao", $qid);
			$rq = $questao->candidatosrespostas->where("candidato_id", "=", $user->id)->find();
			$resposta = Arr::get($_POST, "resposta");
			if(!$rq->loaded()){
				try {
					$cresposta = ORM::factory("candidatoresposta");
					$cresposta->candidato_id = $user->id;
					$cresposta->teste_id = $teste->id;
					$cresposta->questao_id = $questao->id;
					$cresposta->setValor($resposta, Arr::get($_POST, "tempoesgotado"));
					$cresposta->validate();
					$cresposta->save();

					$question = $teste->getProximaQuestao($user->id);
					if(!$question->loaded()){
						$testeex = ORM::factory("testeexecutado");
						$testeex->teste_id = $teste->id;
						$testeex->candidato_id = $user->id;
						$testeex->save();
					} else {
						$this->request->redirect('candidato/testes/pausar/'.$teste->id);
					}

				} catch (exception $e){
					$var["error"] = '<p class="p_error">'.$e->getMessage().'</p>';
					$var["tempo"] = (isset($_POST["dtempo"]) ? $_POST["dtempo"] : $question->max_tempo);
				}

			}
		}

		$this->template->title = __('testes');
		if($this->lang == 'en') {
			$this->template->content = View::factory('candidato/testesen/executar2', $var)
				->bind("teste", $teste)
				->bind("question", $question)
				->bind("questions", $questions);
		} else {
			$this->template->content = View::factory('candidato/testes/executar2', $var)
				->bind("teste", $teste)
				->bind("question", $question)
				->bind("questions", $questions);
		}
		$this->template->scripts = array(
			'assets/js/countdown.js',
		);
	}

	public function action_pausar()
	{
		$id = $this->request->param("id");
		// se teste existe
		$this->verificaTeste($id);
		$teste = ORM::factory("teste", $id);
		$lang = $this->lang;
		$this->template->title = $teste->getNome($lang);
		$this->template->content = '
		<h2 class="h2_subtitle">'.$this->template->title.'</h2>
		<form action="'.URL::site('candidato/testes/executar/'.$teste->id).'" method="post">
			<div class="dv_questao" style="height: 80px; text-align: center;">
				<input type="submit" value="'.__('próxima').'" style="padding: 10px 20px;" />
			</div>
		</form>';
	}

	public function action_avisaconsumo()
	{
		$user = Session::instance()->get("talen_user", NULL);
		$id = $this->request->param('id');

		$this->verificaTeste($id);

		if(isset($_POST["ok"])){
			Session::instance()->set("alertteste[$id]", "ok");
			$this->request->redirect("candidato/testes/executar/$id");
		}

		$teste = ORM::factory('teste', $id);
		$this->template->title = $teste->getNome();
		$custo = $teste->getConsumoProfessor($user);
		$this->template->content = '
		<div style="border: 1px solid silver; background: #F0F0F0; width: 400px; margin: 20px auto; text-align: center; padding: 10px; font-size: 16px;">
			<p>'.__('Esta ação vai consumir').' '.$custo.' '.__('créditos').'</p>
			<form method="post">
			<input type="button" name="cancel" value="'.__('cancelar').'" onClick="history.back();" />
			<input type="submit" name="ok" value="ok" />
			</form>
		</div>';
	}

	public function action_terminado()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);
		$id = $this->request->param("id");
		$testeex = $user->testesexecutados->where("teste_id", "=", $id)->find();
		
	   
		
		if($testeex->loaded()){
			$var["teste"] = $testeex;
			$var["html"] = $this->htmlResultados($testeex);
			$this->template->title = __('Teste Concluído');
			$this->template->content = View::factory('candidato/testes/concluido', $var);
		} else {
			$this->request->redirect("candidato/testes");
		}
	}

	public function action_notfound()
	{
		$this->template->title = __('Teste não encontrado');
		$this->template->content = '<p class="p_warning">'.__('Teste não encontrado ou indisponível no momento').'.</p>';
	}

	public function action_jarealizado()
	{
		$this->template->title = __('Teste Concluído');
		$this->template->content = '<p class="p_warning">'.__('Você já realizou este teste').'.</p>';
	}

	public function action_resultados()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);
		
		 $candidato = ORM::factory("candidato")
				->where("id", "=", $user->id)
				->where("active", "=", '1')
				->find();
					
	    $texto = '<p>O candidato <strong>'.$candidato->nome.'</strong> terminou o teste, verifique o resultado no portal</p>';
	
	    $mail = new Email;
	
	//    $mail->sendEmailToUser("claudia.vidigal@companhiadeidiomas.com.br", "Claudia", "Candidato terminou o teste", $texto);
	    $mail->sendEmailToUser("luanda@companhiadeidiomas.com.br", "Luanda", "Candidato terminou o teste", $texto);
	    $mail->sendEmailToUser("eduardo@companhiadeidiomas.com.br", "Eduardo", "Candidato terminou o teste", $texto);
		
		if(isset($_POST["publicar"]) AND isset($_POST["testeex_id"])){
			$testeex = $user->testesexecutados->where("id", "=", $_POST["testeex_id"])->find();
			$testeex->divulgar = 1;
			$testeex->save();
			$convites = $user->convites->where("teste_id", "=", $testeex->teste->id)->find_all();
			foreach($convites as $row){
				$row->avisaPublicacao();
			}
			if($user->conveniado_id <> 0){
				$user->avisaPublicacaoConveniado($testeex->teste);
			}
		}
		if(isset($_POST["despublicar"]) AND isset($_POST["testeex_id"])){
			$testeex = $user->testesexecutados->where("id", "=", $_POST["testeex_id"])->find();
			$testeex->divulgar = 0;
			$testeex->save();
		}
		$id = $this->request->param("id");
		$var["lang"] = $this->lang;
		if($id <> ""){
			$var["testeex"] = $user->testesexecutados->where("teste_id", "=", $id)->find();
			$var["teste"] = $var["testeex"]->teste;
			$this->template->title =  __('testes');
			$this->template->content = View::factory('candidato/testes/verresultado', $var);
		} else {
			$var["testes"] = $user->testesexecutados->find_all();
			$this->template->title = __('testes');
			$this->template->content = View::factory('candidato/testes/resultados', $var);
		}
	}

	public static function htmlResultados($testeex)
	{
		$dvsCE = '';
		$dvs = array();
		$tipos = array();
		$questoes = $testeex->teste->questoes
			->order_by("ordem", "ASC")
			->find_all();
		foreach($questoes as $q) {
			if($q->tipo == 1 AND !in_array(1, $tipos)){
				$dvsCE = $testeex->getResultHtmlTipo1();
				$tipos[] = 1;
			}
			elseif($q->tipo == 2 AND !in_array(2, $tipos))
			{
				$dvs[] = $testeex->getResultHtmlTipo2();
				$tipos[] = 2;
			}
			elseif($q->tipo == 3){
				$dvs[] = $testeex->getResultHtmlTipo3($q);
			}
			elseif($q->tipo == 4){
				$dvs[] = $testeex->getResultHtmlTipo4($q);
			}
			elseif($q->tipo == 5){
				$dvs[] = $testeex->getResultHtmlTipo5($q);
			}
			elseif($q->tipo == 6 AND !in_array(6, $tipos)){
				$dvs[] = $testeex->getResultHtmlTipo6();
				$tipos[] = 6;
			}
		}
		foreach($dvs as $key => $dv){
			if(!$dv){
				unset($dvs[$key]);
			}
		}
		// exibe resultado das questões tipo C/E
		if(in_array(1, $tipos))
			echo '<h2 class="result_sep">'.__('Questões que têm Certo/Errado').'</h2>'.$dvsCE.'<hr />';
		// exibe resultado das outras questões
		if(count($dvs) > 0)
			echo '<h2 class="result_sep">'.__('Questões que não têm Certo/Errado').'</h2>'.implode("<hr />", $dvs);
	}

	public function verificaTeste($id)
	{
		$user = Session::instance()->get("talen_user", NULL);
		// se teste existe
		$teste = ORM::factory("teste")
			->where("id", "=", $id)
			->where("active", "=", "1")
			->where("publicado", "=", "1")
			->find();
		if(!$teste->loaded()){
			$this->request->redirect("candidato/testes/notfound");
		}
		// verifica se é do idioma do candidato e se já foi realizado
		if($teste->idioma_id <> 0){
			$idiomas = $user->idiomas->where("id", "=", $teste->idioma_id)->find();
			if(!$idiomas->loaded()){
				$this->request->redirect("candidato/testes/notfound");
			}
		}
		// verifica se já foi realizado este teste
		$executado = $teste->testesexecutados->where("candidato_id", "=", $user->id)->find();
		if($executado->loaded()){
			$this->request->redirect("candidato/testes/notfound");
		}
		if($teste->idioma_id <> 0){
			// verifica se já existe teste realizado do idioma em menos de um ano
			$executados = $user->testesexecutados->where("dt_execucao", ">", DB::expr("DATE_SUB(CURDATE(), INTERVAL 1 YEAR)"))->find_all();
			foreach($executados as $ex){
				if($ex->teste->idioma_id == $teste->idioma_id AND $ex->teste->tipo == $teste->tipo){
					$this->request->redirect("candidato/testes/notfound");
				}
			}
		}
	}

	public function verificaTesteExecutado($id)
	{
		// se teste existe
		$teste = ORM::factory("teste")
			->where("id", "=", $id)
			->where("active", "=", "1")
			->where("publicado", "=", "1")
			->find();
		if(!$teste->loaded()){
			$this->request->redirect("candidato/testes/notfound");
		}
	}

}
?>
