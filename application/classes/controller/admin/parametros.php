<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Parametros extends Controller_Admin_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		if(isset($_POST["salvar"])) {
			$reais = Arr::get($_POST, "reais");
			$consumos = Arr::get($_POST, "consumo");
			$consumo_conveniados = Arr::get($_POST, "consumo_conveniado");
			$consumotestes = Arr::get($_POST, "consumoteste");
			$consumo_teste_conveniados = Arr::get($_POST, "consumo_teste_conveniado");
			$consumotesteprof = Arr::get($_POST, "consumotesteprof");
			$consumo_teste_profconveniado = Arr::get($_POST, "consumo_teste_profconveniado");
			
			$db = Database::instance();
			$db->begin();
			$var["conversao"] = ORM::factory("conversao")->order_by("dt_cadastro", "DESC")->find();
			$reais = Helper::number_format_invert($reais);
			if($var["conversao"]->real <> $reais){
				try {
					$new_conv = ORM::factory("conversao");
					$new_conv->real =$reais;
					$new_conv->save();
					$var["conversao"] = $new_conv;
				} catch (ORM_Validation_Exception $e) {
					$errors = $e->errors('models/consumocredito');
				}
			}

			if(!isset($errors)){
				foreach($consumos as $id => $value){
					try {
						$m_con = ORM::factory("consumocredito", $id);
						$m_con->consumo = (is_numeric($value) ? $value : 0);
						$m_con->consumo_conveniado = (is_numeric($consumo_conveniados[$id]) ? $consumo_conveniados[$id] : 0);
						$m_con->save();
					} catch (ORM_Validation_Exception $e) {
						$errors[$id] = $e->errors('models/consumocredito');
					}
					$var["consumos"][] = $m_con;
				}
				foreach($consumotestes as $id => $value){
					try {
						$m_con = ORM::factory("teste", $id);
						$m_con->consumo = (is_numeric($value) ? $value : 0);
						$m_con->consumo_conveniado = (is_numeric($consumo_teste_conveniados[$id]) ? $consumo_teste_conveniados[$id] : 0);
						$m_con->consumo_professor = (is_numeric($consumotesteprof[$id]) ? $consumotesteprof[$id] : 0);
						$m_con->consumo_professor_conveniado = (is_numeric($consumo_teste_profconveniado[$id]) ? $consumo_teste_profconveniado[$id] : 0);
						$m_con->save();
					} catch (ORM_Validation_Exception $e) {
						$errors["teste"][$id] = $e->errors('models/consumocredito');
					}
					$var["testes"][] = $m_con;
				}
			}
			if(isset($errors)){
				$db->rollback();
			} else {
				$db->commit();
				$var['success'] = 'Dados salvos com sucesso.';
			}
		} else {
			$var["conversao"] = ORM::factory("conversao")->order_by("dt_cadastro", "DESC")->find();
			$var["consumos"] = ORM::factory("consumocredito")->find_all();
			$var["testes"] = Model_Teste::getTestesCadastrados();
		}
		$this->template->title = "Parâmetros";
		$this->template->content = View::factory('admin/parametros', $var)
			->bind('errors', $errors);
	}

	public function action_descontos()
	{
		$var = array();
		if(isset($_POST["salvar"])) {
			$desconto = ORM::factory("contatodesconto", Arr::get($_POST, "id"));
			$desconto->minimo = Arr::get($_POST, "minimo");
			$desconto->consumo = Arr::get($_POST, "consumo");
			$desconto->save();
		}
		$var["padrao"] = ORM::factory("consumocredito", 3);
		$var["descontos"] = ORM::factory("contatodesconto")->order_by("minimo", "ASC")->find_all();
		$this->template->title = "Parâmetros";
		$this->template->content = View::factory('admin/descontos', $var);
	}

	public function action_excluirdescontos(){
		$id = $this->request->param("id");
		$desconto = ORM::factory("contatodesconto", $id);
		$desconto->delete();
		$this->request->redirect("admin/parametros/descontos");
	}
}