<?php defined('SYSPATH') or die('No direct script access.');







class Controller_Contratante_Curriculo extends Controller_Contratante_DefaultTemplate {







	public function action_geral()



	{



		$var = array();



		$user = Session::instance()->get("contrat_user", NULL);



		$id = $this->request->param('id');







		$this->setBack();







		$this->verificaCandidato($id);



		$conta = $user->conta;



		$temacesso = $conta->acessoscomprados



			->where('candidato_id', '=', $id)



			->where('acesso', '=', '1')



			->where('conta_id', '=', $user->conta->id)



			->count_all();



		$ok = 0;



		// se não tem acesso ainda



		if(! $temacesso ){



			if(isset($_POST["ok"]) AND Arr::get($_POST, "id") == $id AND Arr::get($_POST, "tipo") == 1){



				Session::instance()->set("alertmini[$id]", "ok");



			}



			$alert = Session::instance()->get("alertmini[$id]", NULL);



			// se não foi avisado, avisa



			$consumo = $conta->getConsumoSoma($id, 1);



			if(is_null($alert) AND $consumo > 0){



				$html = $this->getAvisaConsumo($id, 1);



			// se já foi avisado, debita



			} else {



				try {



					$cand = $user->conta->compra(1, $id);



					$ok = 1;



				} catch(exception $e){



					// se der erro, mostrar erro



					$html = '<p class="p_error">'.$e->getMessage().'</p>';



					$var["errors"] = $e->getMessage();



				}



			}



		} else {



			$ok = 1;



			$cand = ORM::factory("candidato", $id);



		}







		$this->template->title = 'Currículo - Dados Gerais';



		if($ok == 0){



			$this->template->content = $this->getMenuHtml('geral', $id).$html;



		} else {



			$this->template->content = $this->getMenuHtml('geral', $id). $this->getMiniHtml($cand);



		}



		$this->template->styles = array(



			'assets/css/novocurriculo.css' => 'screen'



		);



	}







	public function action_interesse()



	{



		$var = array();



		$user = Session::instance()->get("contrat_user", NULL);



		$id = $this->request->param('id');







		$this->verificaCandidato($id);



		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '2')->count_all();







		$ok = 0;



		// se não tem acesso ainda



		if(! $temacesso ){



			if(isset($_POST["ok"]) AND Arr::get($_POST, "id") == $id AND Arr::get($_POST, "tipo") == 2){



				Session::instance()->set("alertcompleto[$id]", "ok");



			}



			$alert = Session::instance()->get("alertcompleto[$id]", NULL);



			// se não foi avisado, avisa



			$consumo = $user->conta->getConsumoSoma($id, 2);



			if(is_null($alert) AND $consumo > 0){



				$html = $this->getAvisaConsumo($id, 2);



			// se já foi avisado, debita



			} else {



				try {



					$cand = $user->conta->compra(2, $id);



					$ok = 1;



				} catch(exception $e){



					// se der erro, mostrar erro



					$html = '<p class="p_error">'.$e->getMessage().'</p>';



					$var["errors"] = $e->getMessage();



				}



			}



		} else {



			$ok = 1;



			$cand = ORM::factory("candidato", $id);



		}







		$this->template->title = 'Currículo - Interesses';



		if($ok == 0){



			$this->template->content = $this->getMenuHtml('interesse', $id) . $html;



		} else {



			$this->template->content = $this->getMenuHtml('interesse', $id) . $this->getInteresseHtml($cand);



		}



		$this->template->styles = array(



			'assets/css/novocurriculo.css' => 'screen'



		);



	}




public function action_competencia()



	{



		$var = array();



		$user = Session::instance()->get("contrat_user", NULL);



		$id = $this->request->param('id');

		$this->verificaCandidato($id);

	    $temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '2')->count_all();

		$ok = 0;

		// se não tem acesso ainda

		if(! $temacesso ){

			if(isset($_POST["ok"]) AND Arr::get($_POST, "id") == $id AND Arr::get($_POST, "tipo") == 2){

				Session::instance()->set("alertcompleto[$id]", "ok");
			}

    		$alert = Session::instance()->get("alertcompleto[$id]", NULL);

			// se não foi avisado, avisa

			$consumo = $user->conta->getConsumoSoma($id, 2);

			if(is_null($alert) AND $consumo > 0){

				$html = $this->getAvisaConsumo($id, 2);

			// se já foi avisado, debita

			} else {

				try {

					$cand = $user->conta->compra(2, $id);
					$ok = 1;

				} catch(exception $e){

					// se der erro, mostrar erro

					$html = '<p class="p_error">'.$e->getMessage().'</p>';

					$var["errors"] = $e->getMessage();
				}
			}

		} else {

			$ok = 1;
			$cand = ORM::factory("candidato", $id);
		}

		$this->template->title = 'Currículo - Competência';

	//	if($ok == 0){



	//		$this->template->content = $this->getMenuHtml('competencia', $id) . $html;



	//	} else {

			$cand = ORM::factory("candidato", $id);
			$this->template->content = $this->getMenuHtml('competencia', $id) . $this->getCompetenciaHtml($cand);



	//	}



		$this->template->styles = array(

			'assets/css/novocurriculo.css' => 'screen'
		);
	}


	public function action_experiencia()



	{



		$var = array();



		$user = Session::instance()->get("contrat_user", NULL);



		$id = $this->request->param('id');







		$this->verificaCandidato($id);



		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '2')->count_all();







		$ok = 0;



		// se não tem acesso ainda



		if(! $temacesso ){



			if(isset($_POST["ok"]) AND Arr::get($_POST, "id") == $id AND Arr::get($_POST, "tipo") == 2){



				Session::instance()->set("alertcompleto[$id]", "ok");



			}



			$alert = Session::instance()->get("alertcompleto[$id]", NULL);



			// se não foi avisado, avisa



			$consumo = $user->conta->getConsumoSoma($id, 2);



			if(is_null($alert) AND $consumo > 0){



				$html = $this->getAvisaConsumo($id, 2);



			// se já foi avisado, debita



			} else {



				try {



					$cand = $user->conta->compra(2, $id);



					$ok = 1;



				} catch(exception $e){



					// se der erro, mostrar erro



					$html = '<p class="p_error">'.$e->getMessage().'</p>';



					$var["errors"] = $e->getMessage();



				}



			}



		} else {



			$ok = 1;



			$cand = ORM::factory("candidato", $id);



		}







		$this->template->title = 'Currículo - Experiência / Formação';



		if($ok == 0){



			$this->template->content = $this->getMenuHtml('experiencia', $id) . $html;



		} else {


	//		$cand = ORM::factory("candidato", $id);
			$this->template->content = $this->getMenuHtml('experiencia', $id) . $this->getExperienciaHtml($cand);



		}



		$this->template->styles = array(



			'assets/css/novocurriculo.css' => 'screen'



		);



	}







	public function action_testes()



	{



		$var = array();



		$user = Session::instance()->get("contrat_user", NULL);



		$id = $this->request->param('id');







		$this->verificaCandidato($id);



		$cand = ORM::factory("candidato", $id);



		



		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '2')->count_all();







		$ok = 0;



		// se não tem acesso ainda



		if(! $temacesso ){



			if(isset($_POST["ok"]) AND Arr::get($_POST, "id") == $id AND Arr::get($_POST, "tipo") == 2){



				Session::instance()->set("alertcompleto[$id]", "ok");



			}



			$alert = Session::instance()->get("alertcompleto[$id]", NULL);



			// se não foi avisado, avisa



			$consumo = $user->conta->getConsumoSoma($id, 2);



			if(is_null($alert) AND $consumo > 0){



				$html = $this->getAvisaConsumo($id, 2);



			// se já foi avisado, debita



			} else {



				try {



					$cand = $user->conta->compra(2, $id);



					$ok = 1;



				} catch(exception $e){



					// se der erro, mostrar erro



					$html = '<p class="p_error">'.$e->getMessage().'</p>';



					$var["errors"] = $e->getMessage();



				}



			}



		} else {



			$ok = 1;



		}



		if($ok == 0){



			$this->template->content = $this->getMenuHtml('testes', $id) . $html;



		} else {



		}



		



		$this->template->title = 'Currículo - Testes';



		$this->template->content = $this->getMenuHtml('testes', $id) . $this->getTestesHtml($cand);



		$this->template->styles = array(



			'assets/css/novocurriculo.css' => 'screen'



		);







	}







	public function action_referencias()



	{



		$var = array();



		$user = Session::instance()->get("contrat_user", NULL);



		$id = $this->request->param('id');







		$this->verificaCandidato($id);



		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '4')->count_all();







		$ok = 0;



		// se não tem acesso ainda



		$cand = ORM::factory("candidato", $id);



		$count = $cand->referencias->where("status", "=", "1")->where("aprovado", "=", "1")->count_all();







		if($count == 0){



			$html = '<p class="p_error">Nenhuma referência cadastrada</p>';



			$this->template->content = $this->getMenuHtml('referencias', $id) . $html;



		} else {



			if(! $temacesso ){



				if(isset($_POST["ok"]) AND Arr::get($_POST, "id") == $id AND Arr::get($_POST, "tipo") == 4){



					Session::instance()->set("alertreferencia[$id]", "ok");



				}



				$alert = Session::instance()->get("alertreferencia[$id]", NULL);



				// se não foi avisado, avisa



				$consumo = ORM::factory('consumocredito', 4);



				if(is_null($alert) AND $consumo->consumo > 0){



					$html = $this->getAvisaConsumo($id, 4);



				// se já foi avisado, debita



				} else {



					try {



						$cand = $user->conta->compra(4, $id);



						$ok = 1;



					} catch(exception $e){



						// se der erro, mostrar erro



						$html = '<p class="p_error">'.$e->getMessage().'</p>';



						$var["errors"] = $e->getMessage();



					}



				}



			} else {



				$ok = 1;



				$cand = ORM::factory("candidato", $id);



			}







			$this->template->title = 'Currículo - Referências';



			if($ok == 0){



				$this->template->content = $this->getMenuHtml('referencias', $id) . $html;



			} else {



				$this->template->content = $this->getMenuHtml('referencias', $id) . $this->getReferenciasHtml($cand);



			}



		}



		$this->template->styles = array(



			'assets/css/novocurriculo.css' => 'screen'



		);



	}







	public function action_contato()



	{



		$var = array();



		$user = Session::instance()->get("contrat_user", NULL);



		$id = $this->request->param('id');







		$this->verificaCandidato($id);



		$temacesso = $user->conta->acessoscomprados->where('candidato_id', '=', $id)->where('acesso', '=', '3')->count_all();







		$ok = 0;



		// se não tem acesso ainda



		if(! $temacesso ){



			if(isset($_POST["ok"]) AND Arr::get($_POST, "id") == $id AND Arr::get($_POST, "tipo") == 3){



				Session::instance()->set("alertcontato[$id]", "ok");



			}



			$alert = Session::instance()->get("alertcontato[$id]", NULL);







			// se não foi avisado, avisa



			$consumo_qtde = $user->conta->getValorConsumoContato($id);







			if(is_null($alert) AND $consumo_qtde > 0){



				$html = $this->getAvisaConsumo($id, 3);



			// se já foi avisado, debita



			} else {



				try {



					$cand = $user->conta->compra(3, $id);



					$ok = 1;



					Session::instance()->set("alertcontato[$id]", NULL);



				} catch(exception $e){



					// se der erro, mostrar erro



					$html = '<p class="p_error">'.$e->getMessage().'</p>';



					$var["errors"] = $e->getMessage();



				}



			}



		} else {



			$ok = 1;



			$cand = ORM::factory("candidato", $id);



		}







		$this->template->title = 'Currículo - Contato';



		if($ok == 0){



			$this->template->content = $this->getMenuHtml('contato', $id) . $html;



		} else {



			$this->template->content = $this->getMenuHtml('contato', $id) . $this->getContatoHtml($cand);



		}



		$this->template->styles = array(



			'assets/css/novocurriculo.css' => 'screen'



		);



	}







	public function getErrorMessage()



	{



		return '<p class="p_error">Ocorreu um erro desconhecido. Por favor, entre em contato com a Administração.</p>';



	}







	public function getAvisaConsumo($id, $tipo)



	{



		$user = Session::instance()->get("contrat_user", NULL);



		$this->verificaConsumo($tipo);



		$valor = $user->conta->getConsumoSoma($id, $tipo);



		return '



		<div class="dv_avisoconsumo">



			<p>Esta ação vai consumir '.$valor.' créditos. Deseja continuar?</p>



			<form method="post">



				<input type="hidden" name="id" value="'.$id.'" />



				<input type="hidden" name="tipo" value="'.$tipo.'" />



				<input type="button" name="cancel" value="cancelar" onClick="history.back();" />



				<input type="submit" name="ok" value="continuar" />



			</form>



		</div>';



	}







	public function verificaCandidato($id)



	{



		$cand = ORM::factory("candidato")->where("id", "=", $id)->where("status", "=", "1")->where("active", "=", "1")->find();



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







	public function getMenuHtml($active, $id)



	{



		$user = Session::instance()->get("contrat_user", NULL);



		$acesso = $user->conta->getAcessoComprado($id);



		$back = $this->getBack();







		$menu = '



		<ul class="curmenu">



			<li><a class="'.($acesso >= 1 ? 'on' : 'off').' '.($active == 'geral' ? 'active' : '').'" href="'.URL::site("contratante/curriculo/geral/".$id).'">Dados Gerais</a></li>



			<li><a class="'.($acesso >= 2 ? 'on' : 'off').' '.($active == 'interesse' ? 'active' : '').'" href="'.URL::site("contratante/curriculo/interesse/".$id).'">Interesse</a></li>



			<li><a class="'.($acesso >= 2 ? 'on' : 'off').' '.($active == 'experiencia' ? 'active' : '').'" href="'.URL::site("contratante/curriculo/experiencia/".$id).'">Experiência / Formação</a></li>
			
			<li><a class="'.($acesso >= 2 ? 'on' : 'off').' '.($active == 'competencia' ? 'active' : '').'" href="'.URL::site("contratante/curriculo/competencia/".$id).'">Competências</a></li>



			<li><a class="'.($acesso >= 2 ? 'on' : 'off').' '.($active == 'testes' ? 'active' : '').'" href="'.URL::site("contratante/curriculo/testes/".$id).'">Testes</a></li>



			<li><a class="'.($acesso >= 2 ? 'on' : 'off').' '.($active == 'referencias' ? 'active' : '').'" href="'.URL::site("contratante/curriculo/referencias/".$id).'">Referências</a></li>



			<li><a class="'.($acesso >= 3 ? 'on' : 'off').' '.($active == 'contato' ? 'active' : '').'" href="'.URL::site("contratante/curriculo/contato/".$id).'">Contato</a></li>



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



		$ead = array('ambos' => 'EAD e presencial', 'ead' => 'só ferramentas de EAD', 'presencial' => 'só presencial');



		if(array_key_exists($var["loca"]->tipo_disponibilidade, $ead)){



			$var["ead"] = $ead[$var["loca"]->tipo_disponibilidade];



		}



		$html = View::factory("contratante/curriculo/mini", $var);







		$back = $this->getBack();



		return $html.$back;



	}







	public function getInteresseHtml($c)



	{



		$var = array();



		$var["candidato"] = $c;







		// interesses



		$var["exps"] = $c->candidatoexperiencias->where('valor', '<>', '0')->find_all();







		$html = View::factory("contratante/curriculo/interesse", $var);







		$back = $this->getBack();



		return $html.$back;



	}



	public function getCompetenciaHtml($c)
	{
	//	echo $c;

		$var = array();

		$var["candidato"] = $c;
		
	//	$var["referencias"] = $c->referencias



//			->where("status", "=", "1")



//			->where("aprovado", "=", "1")



//			->find_all();

	//	$var["comp"] = $c->candidatoexperiencias->where('valor', '<>', '0')->find_all();
		$var["comp"] = $c->candidatoexperiencias->find_all();
		
		$html = View::factory("contratante/curriculo/competencia", $var);

		$back = $this->getBack();

		return $html.$back;
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







		$back = $this->getBack();



		return $html.$back;



	}







	public function getTestesHtml($c)



	{



		$var = array();



		$var["candidato"] = $c;







		$user = Session::instance()->get("contrat_user", NULL);



		$acessos = $user->conta->getTestesComprados($c->id);







		// todos os testes divulgados



		$var["testespublicados"] = $c->getTestesDivulgadosEscola();



		// todos os testes nao divulgados por idioma



		$var["testesoutros"] = $c->getTestesConviteDisponivel();







		$html = View::factory("contratante/curriculo/testes", $var);







		$back = $this->getBack();



		return $html.$back;



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







		$back = $this->getBack();



		return $html.$back;



	}







	public function getContatoHtml($c)



	{



		$var = array();



		$var["candidato"] = $c;







		$html = View::factory("contratante/curriculo/contato", $var);







		$back = $this->getBack();



		return $html.$back;



	}







	public function setBack()



	{



		$busca = '/(buscarprofessores|acompanhamento|vercandidatos)/';



		$curriculo = '/curriculo/';



		$subject = (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '');







		if(preg_match($busca, $subject)) {



			Session::instance()->set("back", $subject);



		} elseif(!preg_match($curriculo, $subject)){



			Session::instance()->set("back", '');



		}



	}







	public function getBack()



	{



		$back = Session::instance()->get("back", NULL);



		if(!is_null($back))



			return '<div class="lnk_voltar"><a href="'.$back.'"> << voltar >></a></div>';



	}



}

?>