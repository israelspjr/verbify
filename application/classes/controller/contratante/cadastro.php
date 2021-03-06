<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_Cadastro extends Controller_DefaultTemplate {

	public function action_index()
	{
		if(Helper::isEscolaLogged()){
			$this->request->redirect("contratante");
		}

		if (isset($_POST["email"]))
		{
			$errors = array();
			$tipopessoa = (Arr::get($_POST, 'tipopessoa') =='PF' ? 'PF' : 'PJ');

			// contratante
			$contratante = ORM::factory('contratante');
			$contratante->email = Arr::get($_POST, 'email');
			$contratante->senha = Arr::get($_POST, 'senha');
			$contratante->tppessoa = $tipopessoa;
			$contratante->foto = Arr::get($_POST, 'foto');

			$contratante->estado_id = Arr::get($_POST, 'estado_id');
			$contratante->cidade_id = Arr::get($_POST, 'cidade_id');
			$contratante->endereco = Arr::get($_POST, 'endereco');
			$contratante->numero = Arr::get($_POST, 'numero');
			$contratante->compl = Arr::get($_POST, 'compl');
			$contratante->bairro = Arr::get($_POST, 'bairro');
			$contratante->cep = Arr::get($_POST, 'cep');
			$contratante->interesse_convenio = ((Arr::get($_POST, 'conveniado')=="1") ? 1 : 0);

            //Marcelo - Carambola
            //27/04/2014
            //Adicionar proviniencia para contratante
            $contratante->comoconheceu = Arr::get($_POST, 'comoconheceu');

			$external_values = array(
				'senha' => Arr::get($_POST, 'senha'),
			) + Arr::get($_POST, '_external', array());
			$extra = Validation::factory($external_values)->rule('csenha', 'matches', array(':validation', ':field', 'senha'));

			try {
				$contratante->check($extra);
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('models/contratante');
			}

			if ($tipopessoa == 'PF') {
				// check pessoa física
				$contratantepf = ORM::factory('contratantepf');
				$contratantepf->nome = Arr::get($_POST, 'nome');
				$contratantepf->cpf = Arr::get($_POST, 'cpf');
				$contratantepf->tel = Arr::get($_POST, 'tel');
				try {
					$contratantepf->check();
				} catch (ORM_Validation_Exception $e) {
					$errors = array_merge($errors, $e->errors('models/contratante'));
				}
			} else {
				// check pessoa jurídica
				$contratantepj = ORM::factory('contratantepj');
				$contratantepj->razao = Arr::get($_POST, 'razao');
				$contratantepj->nomefantasia = Arr::get($_POST, 'nomefantasia');
				$contratantepj->franquia = Arr::get($_POST, 'franquia');
				$contratantepj->franquia_descr = Arr::get($_POST, 'franquia_descr');
				$contratantepj->cnpj = Arr::get($_POST, 'cnpj');
				$contratantepj->c_nome = Arr::get($_POST, 'contato');
				$contratantepj->c_tel = Arr::get($_POST, 'c_tel');
				$contratantepj->c_cargo = Arr::get($_POST, 'cargo');
				try {
					$contratantepj->check();
				} catch (ORM_Validation_Exception $e) {
					$errors = array_merge($errors, $e->errors('models/contratante'));
				}
			}

			if(empty($errors)) {
				$db = Database::instance();
				$db->begin();
				try {
					$contratante->senhatxt = Arr::get($_POST, 'senha');
					$contratante->save();
					$contratante->conta->contratante_id = $contratante->id;
					$contratante->conta->save();
					if ($tipopessoa == 'PF') {
						$contratantepf->contratante_id =  $contratante->id;
						$contratantepf->save();
					} else {
						$contratantepj->contratante_id = $contratante->id;
						$contratantepj->save();
					}
					$db->commit();
					if(Arr::get($_POST, 'conveniado')=="1")
						$contratante->sendInteresseConvenio();
					$this->request->redirect('contratante/cadastro/success');
				} catch (ORM_Validation_Exception $e) {
					$db->rollback();
					$errors = $e->errors('models/contratante');
				}
			}
		}

        $values = $_POST;

        if(isset($_GET['origem']))

        {

            $origem = $_GET['origem'] . "_BANNER";

                        

            Session::instance()->set('origem_contratante', $origem);



            $values_temp = array("comoconheceu" => Session::instance()->get('origem_contratante'));



            $values = Arr::merge($values, $values_temp);

        }

        elseif($_POST == NULL)

        {

            $values = array("comoconheceu" => Session::instance()->get('origem_contratante'));

        }

		$var["estados"] = ORM::factory('estado')->find_all();
		$this->template->title = 'Cadastro do Contratante';
		$this->template->content = View::factory('contratante/cadastro', $var)
			->set('values', $values)
			->bind('errors', $errors);
		$this->template->styles = array(
			'assets/css/cadastro-contratante.css' => 'screen',
		);
		$this->template->menuactive = 'escola';
	}

	public function action_success() {
		$this->template->title = 'Cadastro do Contratante - Sucesso';
		$this->template->content = View::factory('contratante/cadastrosuccess');
		$this->template->menuactive = 'escola';
	}

}
?>