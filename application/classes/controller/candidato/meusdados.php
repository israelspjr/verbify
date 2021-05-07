<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Candidato_MeusDados extends Controller_Candidato_CurriculoTemplate {



	public function action_index()

	{

		$session_tal = Session::instance()->get('talen_user', NULL);

		$var = array();

		if ($_POST)

		{

			$candidato = ORM::factory('candidato', $session_tal->id);

			$candidato->values($_POST, array('email', 'nome', 'doctype', 'cpf', 'rg', 'sexo', 'dtnasc', 'nacionalidade', 'comoconheceu', 'tel1', 'pais1', 'tel2', 'pais2',

				'email2', 'skype', 'outrosim', 'blog', 'facebook', 'outrars',

				'endereco', 'numero', 'compl', 'bairro', 'cep', 'cidade', 'estado', 'pais','sotaque','valorHora', 'mei', 'sobreMim'));

			$cand_idiomas = (Arr::get($_POST, 'idioma') ? Arr::get($_POST, 'idioma') : array());

			$cand_locomocao = (Arr::get($_POST, 'locomocao') ? Arr::get($_POST, 'locomocao') : array());

			$outroidioma = Arr::get($_POST, 'outroidioma');

	//		$sotaque = Arr::get($_POST, 'sotaque');

	//		var_dump($sotaque);

			$outralocomocao = Arr::get($_POST, 'outralocomocao');



			$external_values = array(

				'idioma' => $cand_idiomas,

				'locomocao' => $cand_locomocao,

			) + Arr::get($_POST, '_external', array());



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

				Session::instance()->set('talen_user', $candidato);

				$this->request->redirect('candidato/cadastrocv');

 			}

			catch (ORM_Validation_Exception $e)

			{

				$db->rollback();

				$errors = $e->errors('models/candidato');

			}

			$values = $_POST;

			$values["paises"] = ORM::factory("pais")->find_all();

		} else {

			$candidato = ORM::factory("candidato", $session_tal->id)->as_array();

			$candidato["dtnasc"] = Helper::format_date($candidato["dtnasc"] );

			$idiomas = $session_tal->candidatoidiomas->find_all();

			foreach($idiomas as $row){

				$candidato["idioma"][$row->idioma->id] = 1;

				if($row->idioma->is_outro == 1){

					$candidato["outralocomocao"] = $row->outro;

				}

			}

			$locomocoes = $session_tal->locomocao->find_all();

			foreach($locomocoes as $row){

				$candidato["locomocao"][$row->id] = 1;

			}

			$values = $candidato;

		}

		$idiomas = Model_Idioma::getAll();

		$idiomas_obs = array(9, 10);

		$locomocao = ORM::factory("locomocao")->where("active", "=", "1")->find_all();

		

		$values["paises"] = ORM::factory("pais")->find_all();



		$this->template->title = __('Cadastro do Currículo').' - '.__('Dados Pessoais');

		$this->template->content = View::factory('candidato/meusdados', $var)

			->set('values', $values)

			->bind('idiomas', $idiomas)

			->bind('idiomas_obs', $idiomas_obs)

			->bind('locomocao', $locomocao)

			->bind('errors', $errors);

		$this->template->scripts = array(

			'assets/js/jquery.qtip-1.0.0-rc3.min.js',

			'assets/js/cadastro.js'

		);

	}

}

?>