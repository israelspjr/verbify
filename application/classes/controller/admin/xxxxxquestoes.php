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
				$quest->enunciado = Arr::get($_POST, "questao");
				$quest->save();
				
				$texto = (isset($_POST["texto"]) ? $_POST["texto"] : array());
				$valor = Arr::get($_POST, "valor");
				
				foreach($texto as $key => $item){
					if(trim($item) <> ""){
						$resposta = ORM::factory("resposta");
						$resposta->questao_id = $quest->id;
						$resposta->texto = $item;
						$resposta->valor = Arr::get($valor,$key);
						$resposta->ordem = $key;
						$resposta->save();
					}
				}
				$db->commit();
				$this->request->redirect('admin/testes/editar/'.$teste->id);
			} catch (ORM_Validation_Exception $e) {
				$db->rollback();
				$errors = $e->errors('models');
			}
		}
		$this->template->title = $teste->nome;
		$this->template->content = View::factory('admin/teste/questoes', $var)
			->bind('errors', $errors);
	}
	
	public function action_editar()
	{
		$var = array();
		$id = $this->request->param("id");
		$this->validaQuestao($id);

		$questao = ORM::factory("questao", $id);
		$var["teste"] = $questao->teste;
		if(isset($_POST["salvar"])){
			$db = Database::instance();
			$db->begin();			
			try {
				$quest = ORM::factory("questao");
				$quest->teste_id = $teste->id;
				$quest->tipo = Arr::get($_POST, "tipo");
				$quest->enunciado = Arr::get($_POST, "questao");
				$quest->save();
				
				$texto = (isset($_POST["texto"]) ? $_POST["texto"] : array());
				$valor = Arr::get($_POST, "valor");
				
				foreach($texto as $key => $item){
					if(trim($item) <> ""){
						$resposta = ORM::factory("resposta");
						$resposta->questao_id = $quest->id;
						$resposta->texto = $item;
						$resposta->valor = Arr::get($valor,$key);
						$resposta->ordem = $key;
						$resposta->save();
					}
				}
				$db->commit();
				$this->request->redirect('admin/testes/editar/'.$teste->id);
			} catch (ORM_Validation_Exception $e) {
				$db->rollback();
				$errors = $e->errors('models');
			}
		}
		$this->template->title = $questao->teste->nome;
		$this->template->content = View::factory('admin/teste/questoes', $var)
			->bind('errors', $errors);
	}
	
	public function action_excluir()
	{
	}
	
	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p class="p_error">Página não encontrada</p>';
	}

	function validaTeste($id){
		$teste = ORM::factory("teste", $id);
		if(!$teste->loaded()){
			$this->request->redirect("admin/questoes/notfound");
		}
		if($teste->active==0){
			$this->request->redirect("admin/questoes/notfound");
		}
	}
	
	function validaQuestao($id){
		$teste = ORM::factory("questao", $id);
		if(!$teste->loaded()){
			$this->request->redirect("admin/questoes/notfound");
		}
	}
}
?>
