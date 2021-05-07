<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Questoes extends Controller_Admin_DefaultTemplate {

	public function action_cadastrar()
	{
		$var = array();
		$id = $this->request->param("id");
		$this->validaTeste($id);

		$teste = ORM::factory("teste", $id);
		$var["teste"] = $teste;

		if(isset($_POST["salvar"])){
			$db = Database::instance();
			$db->begin();
			try {
				$quest = ORM::factory("questao");
				$quest->teste_id = $teste->id;
				$quest->tipo = Arr::get($_POST, "tipo");
				/* ALTERAÇÃO YUKI */
				if($quest->tipo == 3 OR $quest->tipo == 5) {
				  $quest->max_check = Arr::get($_POST, "max_check");
				}
				/* FIM ALTERAÇÃO YUKI */
				$quest->topico = Arr::get($_POST, "topico");
				$quest->enunciado = Arr::get($_POST, "questao");
				$quest->topico_en = Arr::get($_POST, "topico_en");
				$quest->enunciado_en = Arr::get($_POST, "questao_en");
				$quest->max_tempo = Arr::get($_POST, "max_tempo");
				$quest->save();

				$texto = (isset($_POST["texto"]) ? $_POST["texto"] : array());
				$valor = Arr::get($_POST, "valor");
				$texto_en = (isset($_POST["texto_en"]) ? $_POST["texto_en"] : array());

				foreach($texto as $key => $item){
					if(trim($item) <> ""){
						$resposta = ORM::factory("resposta");
						$resposta->questao_id = $quest->id;
						$resposta->texto = $item;
						$resposta->texto_en = Arr::get($texto_en, $key);
						$resposta->valor = Arr::get($valor,$key);
						$resposta->ordem = $key;
						$resposta->save();
					}
				}
				$teste->reordenarQuestoes();
				$db->commit();
				$this->request->redirect('admin/testes/editar/'.$teste->id);
			} catch (ORM_Validation_Exception $e) {
				$db->rollback();
				$errors = $e->errors('models');
			}
		}

		$this->template->title = $teste->nome;
		$this->template->content = View::factory('admin/teste/cadastroquestao', $var)
			->bind('errors', $errors);

	}

	public function action_editar()
	{
		$var = array();
		$id = $this->request->param("id");
		$this->validaQuestao($id);

		$questao = ORM::factory("questao", $id);
		$teste = $questao->teste;
		$var["questao"] = $questao;
		$var["teste"] = $teste;
		$var["respostas"] = $questao->respostas->find_all();
		// print_r($var["respostas"]);

		if(isset($_POST["salvar"]))
		{
			$db = Database::instance();
			$db->begin();
			try {
				$questao->teste_id = $teste->id;
				$questao->tipo = Arr::get($_POST, "tipo");
				/* ALTERAÇÃO YUKI */
				if($questao->tipo == 3 OR $questao->tipo == 5) {
				  // $questao->max_check = (isset(Arr::get($_POST, "max_check")) ? Arr::get($_POST, "max_check") : 1);
				  $questao->max_check = Arr::get($_POST, "max_check");
				}
				/* FIM YUKI */
				$questao->topico = Arr::get($_POST, "topico");
				$questao->enunciado = Arr::get($_POST, "questao");
				$questao->topico_en = Arr::get($_POST, "topico_en");
				$questao->enunciado_en = Arr::get($_POST, "questao_en");
				$questao->max_tempo = Arr::get($_POST, "max_tempo");
				$questao->save();

				$texto = (isset($_POST["texto"]) ? $_POST["texto"] : array());
				$valor = Arr::get($_POST, "valor");
				$texto_en = (isset($_POST["texto_en"]) ? $_POST["texto_en"] : array());

				$questao->deleterespostas();
				foreach($texto as $key => $item){
					if(trim($item) <> ""){
						$resposta = ORM::factory("resposta", $key);
						$resposta->questao_id = $questao->id;
						$resposta->texto = $item;
						$resposta->texto_en = Arr::get($texto_en, $key);
						$resposta->valor = Arr::get($valor,$key);
						$resposta->ordem = $key;
						$resposta->save();
					}
				}
				$teste->reordenarQuestoes();
				$db->commit();
				$this->request->redirect('admin/testes/editar/'.$teste->id);
			} catch (ORM_Validation_Exception $e) {
				$db->rollback();
				$errors = $e->errors('models');
			}
		}
		$this->template->title = $teste->nome;
		$this->template->content = View::factory('admin/teste/edicaoquestao', $var)
			->bind('errors', $errors);
	}

	public function action_excluir()
	{
		$var = array();
		$id = $this->request->param("id");
		$this->validaQuestao($id);

		$questao = ORM::factory("questao", $id);
		$testeid = $questao->teste_id;
		$questao->delete();

		$questao->teste->reordenarQuestoes();

		$this->request->redirect('admin/testes/editar/'.$testeid);
	}

	function validaTeste($id)
	{
		$teste = ORM::factory("teste", $id);
		if(!$teste->loaded()){
			$this->request->redirect("admin/questoes/notfound");
		}
		if($teste->active==0){
			$this->request->redirect("admin/questoes/notfound");
		}
	}

	function validaQuestao($id)
	{
		$teste = ORM::factory("questao", $id);
		if(!$teste->loaded()){
			$this->request->redirect("admin/questoes/notfound");
		}
	}

	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p class="p_error">Página não encontrada</p>';
	}

}
?>