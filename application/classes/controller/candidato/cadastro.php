<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Candidato_Cadastro extends Controller_DefaultTemplate {



	public function action_index()

	{

		if(Helper::isProfessorLogged()){

			$this->request->redirect("candidato");

		}

		if ($_POST)

		{

			$candidato = ORM::factory('candidato')

				->values($_POST, array('email', 'senha', 'nome', 'doctype', 'cpf', 'rg', 'sexo', 'dtnasc', 'nacionalidade', 'comoconheceu', 'tel1', 'pais1', 'tel2', 'pais2',	'email2', 'skype', 'outrosim', 'blog', 'facebook', 'outrars', 'endereco', 'numero', 'compl', 'bairro', 'cep', 'cidade', 'estado', 'pais', 'foto', 'valorHora'));

			$cand_idiomas = Arr::get($_POST, 'idioma');

			$cand_locomocao = Arr::get($_POST, 'locomocao');

			$outroidioma = Arr::get($_POST, 'outroidioma');

			$outralocomocao = Arr::get($_POST, 'outralocomocao');

//			$valorHora = Arr::get($_POST, 'valorHora');

			$external_values = array(

				'senha' => Arr::get($_POST, 'senha'),

				'idioma' => $cand_idiomas,

				'locomocao' => $cand_locomocao,

			) + Arr::get($_POST, '_external', array());



			$extra = Validation::factory($external_values)

				->rule('idioma', 'not_empty')

				->rule('idioma', array($candidato, 'validaoutro'), array(':value', ':field', $outroidioma))

				->rule('locomocao', 'not_empty')

				->rule('locomocao', array($candidato, 'validaoutro'), array(':value', ':field', $outralocomocao))

				->rule('csenha', 'matches', array(':validation', ':field', 'senha'));



			$cod = Cookie::get('conveniado');

			$contratante = ORM::factory("contratante")->where("codigo", "=", $cod)->where("conveniado", "=", "1")->find();

			$db = Database::instance();

			try

			{

				$db->begin();

				$candidato->hash_codigo();

				if($contratante->loaded()){

					$candidato->conveniado_id = $contratante->id;

				}

				$candidato->senhatxt = Arr::get($_POST, 'senha');

				$candidato->save($extra);

				$candidato->saveIdiomas($cand_idiomas, $outroidioma);

				$candidato->saveLocomocao($cand_locomocao, $outralocomocao);

				$conta = ORM::factory("conta");

				$conta->candidato_id = $candidato->id;

				$conta->save();

				$db->commit();



				// grava sessao

				//$this->request->redirect('candidato/cadastro/success');

				$senha = Arr::get($_POST, 'senha');

				$email = Arr::get($_POST, 'email');

				$tal = ORM::factory("candidato")

				->where("email", "=", strtolower($email))

				->where("senha", "=", Auth::instance()->hash($senha))

				->where("active", "=", 1)

				->find();

			if($tal->loaded()){

				Session::instance()->set('talen_user', $tal);

				$tal->acesso_update();

				$this->request->redirect('candidato/home');

			} else {

				$var["erro"] = 'Erro: Dados incorretos.';

			}

			

			}

			catch (ORM_Validation_Exception $e)

			{

				$db->rollback();

				$errors = $e->errors('models/candidato');

			}

		}



		if(isset($_POST["entrar"])){

			$var["email"] = (isset($_POST["email"]) ? trim($_POST["email"]) : "");

			$senha = (isset($_POST["senha"]) ? trim($_POST["senha"]) : "");

			$tal = ORM::factory("candidato")

				->where("email", "=", strtolower($var["email"]))

				->where("senha", "=", Auth::instance()->hash($senha))

				->where("active", "=", 1)

				->find();

			if($tal->loaded()){

				Session::instance()->set('talen_user', $tal);

				$tal->acesso_update();

				$this->request->redirect('candidato/home');

			} else {

				$var["erro"] = 'Erro: Dados incorretos.';

			}

		}



		$idiomas = ORM::factory("idioma")->where("active", "=", "1")->find_all();

		$idiomas_obs = array(9, 10);

		$locomocao = ORM::factory("locomocao")->where("active", "=", "1")->find_all();

		

		$values = $_POST;

		$values["paises"] = ORM::factory("pais")->find_all();

	

        if(isset($_GET['origem']))

        {

            $origem = $_GET['origem'] . '_BANNER';

            

            Session::instance()->set('origem_candidato', $origem);



            $values_temp = array("comoconheceu" => Session::instance()->get('origem_candidato'));



            $values = Arr::merge($values, $values_temp);

        }

        elseif($_POST == NULL)

        {

            $values = array("comoconheceu" => Session::instance()->get('origem_candidato'));

        }



		$this->template->title = 'Professor';

		$this->template->content = View::factory('candidato/cadastro')

			->set('values', $values)

			->bind('idiomas', $idiomas)

			->bind('idiomas_obs', $idiomas_obs)

			->bind('locomocao', $locomocao)

			->bind('errors', $errors);

		$this->template->menuactive = 'professor';

	}



	public function action_success(){

		$this->template->title = 'Professor - Cadastro efetuado';

		$this->template->content = View::factory('candidato/cadastrosuccess');

		$this->template->menuactive = 'professor';

	}



	public function action_conveniado()

	{

		$id = $this->request->param('id');

		Cookie::set('conveniado', $id);

		$this->request->redirect('candidato/cadastro');

	}

} // End candidate Home

