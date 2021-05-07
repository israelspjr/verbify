<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Contratante_MeusDados extends Controller_Contratante_DefaultTemplate {

	public function action_index()
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$values = array();
		$errors = array();
		$contratante = ORM::factory("contratante", $user->id);

		if ($_POST){
			$tipopessoa = (Arr::get($_POST, 'tipopessoa') =='PF' ? 'PF' : 'PJ');
			// contratante
			try {
				$contratante->email = Arr::get($_POST, 'email');
				$contratante->tppessoa = $tipopessoa;
				$contratante->estado_id = Arr::get($_POST, 'estado_id');
				$contratante->cidade_id = Arr::get($_POST, 'cidade_id');
				$contratante->endereco = Arr::get($_POST, 'endereco');
				$contratante->numero = Arr::get($_POST, 'numero');
				$contratante->compl = Arr::get($_POST, 'compl');
				$contratante->bairro = Arr::get($_POST, 'bairro');
				$contratante->cep = Arr::get($_POST, 'cep');
				$contratante->check();
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('models/contratante');
			}
			try {
				if ($tipopessoa == 'PF') {
					// check pessoa física
					$contratantepf = $contratante->contratantepf;
					$contratantepf->nome = Arr::get($_POST, 'nome');
					$contratantepf->cpf = Arr::get($_POST, 'cpf');
					$contratantepf->tel = Arr::get($_POST, 'tel');
					$contratantepf->check();
				} else {
					// check pessoa jurídica
					$contratantepj = $contratante->contratantepj;
					$contratantepj->razao = Arr::get($_POST, 'razao');
					$contratantepj->nomefantasia = Arr::get($_POST, 'nomefantasia');
					$contratantepj->franquia = Arr::get($_POST, 'franquia');
					$contratantepj->franquia_descr = Arr::get($_POST, 'franquia_descr');
					$contratantepj->cnpj = Arr::get($_POST, 'cnpj');
					$contratantepj->c_nome = Arr::get($_POST, 'c_nome');
					$contratantepj->c_tel = Arr::get($_POST, 'c_tel');
					$contratantepj->c_cargo = Arr::get($_POST, 'c_cargo');
					$contratantepj->check();
				}
			} catch (ORM_Validation_Exception $e) {
				$errors = array_merge($errors, $e->errors('models/contratante'));
			}
			if (empty($errors)) {	
				$db = Database::instance();
				$db->begin();
				try {
					$contratante->save();
					if ($tipopessoa == 'PF') {
						$contratantepf->contratante_id =  $contratante->id;
						$contratantepf->save();
						if($contratante->contratantepj->loaded())
							$contratante->contratantepj->delete();
					} else {
						$contratantepj->contratante_id = $contratante->id;
						$contratantepj->save();
						if($contratante->contratantepf->loaded())
							$contratante->contratantepf->delete();
					}
					$db->commit();
					Session::instance()->set('contrat_user', $contratante);
					$var['success'] = 'Dados salvos com sucesso.';					
				} catch (ORM_Validation_Exception $e) {
					$db->rollback();
					$errors = array_merge($errors, $e->errors('models/contratante'));
				}
			}
			$values = $_POST;

		} else {
			$contratante = ORM::factory("contratante", $user->id);
			if($contratante->tppessoa == 'PF' ){
				$outros = $contratante->contratantepf;
			} else {
				$outros = $contratante->contratantepj;
			}
			$values = array_merge($contratante->as_array(), $outros->as_array());
			$values["tipopessoa"] = $values["tppessoa"];
		}

		$var["estados"] = ORM::factory('estado')->find_all();
		$this->template->title = 'Meu Cadastro';
		$this->template->content = View::factory('contratante/meusdados', $var)
			->set('values', $values)
			->bind('errors', $errors);
		$this->template->styles = array(
			'assets/css/cadastro-contratante.css' => 'screen',
		);
	}

}