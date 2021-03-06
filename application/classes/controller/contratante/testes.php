<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Contratante_Testes extends Controller_Contratante_AjaxTemplate {



	public function action_resultado()

	{

		$user = Session::instance()->get("contrat_user", NULL);

		$teste_id = $this->request->query('teste_id');

		$candidato_id = $this->request->query('candidato_id');



		$testeex = ORM::factory("testeexecutado")->where("teste_id", "=", $teste_id)->where("candidato_id", "=", $candidato_id)->find();

		$candidato = $testeex->candidato;

		if(!$candidato->loaded() OR !$testeex->loaded()){

			$this->request->redirect("contratante/testes/notfound");

		}

		$temacesso = $user->conta->testeAcessoComprado($testeex->id);

		if(!$temacesso){

			// verifica se foi avisado

			$alert = Session::instance()->get("alertteste[".$testeex->id."]", NULL);

			$consumo = $user->conta->getConsumoTeste($testeex);

			if(is_null($alert) AND $consumo > 0) {

				$this->request->redirect("contratante/testes/aviso/".$testeex->id);

			}

			try {

				$user->conta->compraTeste($testeex->id);

			} catch(exception $e){

				$var["errors"] = $e->getMessage();

			}

		}

		if(isset($var["errors"])){

			print_r($var["errors"]);

		} else {

			$var["candidato"] = $candidato;

			$var["testeex"] = $testeex;

			$var["teste"] = $testeex->teste;

			// $var["resultado"] = Controller_Contratante_Testes::htmlResultados($testeex);

			$this->template->styles = array('assets/css/contratante/resultado.css' => 'screen');

			$this->template->scripts = array('assets/js/flowplayer-3.2.11.min.js');

			$this->template->content = View::factory('contratante/curriculo/resultado', $var);

		}

	}



	public function action_convidar()

	{

		$var = array();

		$user = Session::instance()->get("contrat_user", NULL);

		$teste_id = $this->request->query('teste_id');

		$candidato_id = $this->request->query('candidato_id');

		$teste = ORM::factory("teste", $teste_id);

		$candidato = ORM::factory("candidato", $candidato_id);

		// se teste nao encontrado, redireciona

		if(!$candidato->loaded() OR !$teste->loaded() OR $teste->active == 0 OR $teste->publicado == 0){

			$this->request->redirect("contratante/testes/notfound");

		}

		// se teste j?? executado

		$te = $this->getTesteExecutado($candidato, $teste);

		if($te->loaded()){

			// se teste est?? divulgado

			if($te->divulgar == 1) {

				echo $te->teste->id. '1';

				//$this->request->redirect("contratante/testes/resultado/".$te->teste->id);

			} else {

				$this->request->redirect("contratante/testes/dontshow");

			}

		} else {

			// se teste nao executado, convida

			try {

				$user->conta->convidaTeste($candidato, $teste);

				$var["success"] = 'Convite enviado com sucesso.';

			} catch(exception $e) {

				$var["errors"] = $e->getMessage();

			}

		}

		$this->template->content = View::factory('contratante/curriculo/convite', $var);

	}



	public function action_aviso()

	{

		$user = Session::instance()->get("contrat_user", NULL);

		$id = $this->request->param('id');

		$testeex = ORM::factory('testeexecutado', $id);

		if(isset($_POST["ok"])){

			Session::instance()->set("alertteste[$id]", "ok");

			$this->request->redirect("contratante/testes/resultado?teste_id=".$testeex->teste_id."&candidato_id=".$testeex->candidato_id);

		}

		$var["consumo"] = $user->conta->getConsumoTeste($testeex);

		$var["pagina"] = $_SERVER["REQUEST_URI"];

		$this->template->content = View::factory("contratante/curriculo/aviso", $var);

	}



	public function action_notfound()

	{

		$this->template->content = '<p>Registro n??o encontrado</p>';

	}



	public function action_dontshow()

	{

		$this->template->content = '<p>O candidato prefere ser avaliado pelo pr??prio contratante</p>';

	}



	public static function htmlResultados($testeex){

		$result = $testeex->getResultado();

		if($testeex->teste->tipo == 1){

			$results = $testeex->teste->questoes->count_all();

			return '

			<div class="dv_myresult">

				'.$result.' acertos de '.$results.' quest??es

			</div>';

		} elseif($testeex->teste->tipo == 2){

			$results = $testeex->teste->resultados->order_by("min", "ASC")->order_by("letra", "ASC")->find_all();

			$html = '<div class="dv_myresult">Pontua????o: '.$result.'</div>';

			foreach($results as $row){

				$html .= '

				<div class="dv_result_box '.(($result >= $row->min AND $result <= $row->max) ? 'myresult' : '').'">

					<h3>De '.$row->min.' a '.$row->max.' pontos</h3>

					<div>'.$row->texto.'</div>

				</div>';

			}

			return $html;

		}  elseif($testeex->teste->tipo == 3){

			$html = '<div class="dv_myresult">

			Suas respostas: <br />';

			$max = 0;

			$predominante = array();

			foreach($result as $row){

				$html .= $row["resposta"].' - '.$row["total"].';<br /> ';

				if($row["total"] > $max){

					$max = $row["total"];

					$predominante[] = $row["resposta"];

				}

			}

			$html .= '</div>';

			$results = $testeex->teste->resultados->order_by("min", "ASC")->order_by("letra", "ASC")->find_all();

			foreach($results as $row){

				$html .= '

				<div class="dv_result_box '.(in_array($row->letra, $predominante) ? 'myresult' : '').'">

					<h3>Resposta predominante: '.$row->letra.'</h3>

					<div>'.$row->texto.'</div>

				</div>';

			}

			return $html;

		}

	}



	public function getTesteExecutado($candidato, $teste)

	{

		if($teste->idioma_id == 0){

			$te = $candidato->testesexecutados->where("teste_id", "=", $teste->id)->find();

		} else {

			$testes = ORM::factory("teste")

				->where("idioma_id", "=", $teste->idioma_id)

				->where("tipo", "=", $teste->tipo)

				->find_all()

				->as_array("id", "id");

			$te = $candidato->testesexecutados->where("teste_id", "IN", $testes)->find();

		}

		return $te;

	}

}

