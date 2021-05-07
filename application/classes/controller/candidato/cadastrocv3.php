<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_CadastroCv3 extends Controller_Candidato_CurriculoTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);
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
				$this->request->redirect('candidato/referencias');
			}

		} else {
			$regioes = Helper::orm_to_array($user->regiao->find_all(), "id");
			$loca = ORM::factory("candidatolocalidade", $user->id);
		}

		$var["estados"] = ORM::factory('estado')->find_all();
		$this->template->title = __('Cadastro do Currículo').' - '.__('Disponibilidade');
		$this->template->content = View::factory('candidato/cadastrocv3', $var)
			->set('values', $_POST)
			->bind('regioes', $regioes)
			->bind('localidade', $loca)
			->bind('errors', $errors);
	}
}