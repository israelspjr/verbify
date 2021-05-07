<?php defined('SYSPATH') or die('No direct script access.');

// lista, cadastra e edita o teste
class Controller_Admin_TestesIdiomas extends Controller_Admin_DefaultTemplate {
	public function action_index()
	{
		$var = array();
		$var["results"] = ORM::factory("teste")->getTestesAtivosIdiomas();
		$this->template->title = "Testes";
		$this->template->content = View::factory('admin/testesidiomas', $var);
	}

	public function action_cadastro()
	{
		$var = array();
		$tst = ORM::factory("teste");
		if(isset($_POST["salvar"])){
			try
			{
				$tst->nome = Arr::get($_POST, "nome");
				$tst->descricao = Arr::get($_POST, "descricao");
				$tst->idioma_id = Arr::get($_POST, "idioma");
				$tst->tipo = 1;
				$tst->save();
				$this->request->redirect("admin/testesidiomas");
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('models');
			}
		}
		$var["teste"] = $tst;

		$var["idiomas"] = Model_Idioma::getAllSemOutros();

		$this->template->title = "Testes";
		$this->template->content = View::factory('admin/testeidioma/cadastro', $var)
			->bind('errors', $errors);
	}

	public function action_editar()
	{
		$var = array();
		$id = $this->request->param("id");

		$this->validaTeste($id);
		$tst = ORM::factory("teste", $id);

		if(isset($_POST["salvar"])) {
			try
			{
				$tst->nome = Arr::get($_POST, "nome");
				$tst->descricao = Arr::get($_POST, "descricao");
				$tst->idioma_id = (Arr::get($_POST, "idioma") == "" ? 0 : Arr::get($_POST, "idioma"));
				$tst->save();
				$this->request->redirect("admin/testesidiomas");
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('models');
			}
		}
		if(isset($_POST["excluir"])){
			try
			{
				$tst->active = 0;
				$tst->save();
				$this->request->redirect("admin/testesidiomas");
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('models');
			}
		}
		if(isset($_POST["publicar"])){
			try
			{
				$tst->publicado = 1;
				$tst->save();
				$this->request->redirect("admin/testesidiomas");
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('models');
			}
		}
		if(isset($_POST["despublicar"])){
			try
			{
				$tst->publicado = 0;
				$tst->save();
				$this->request->redirect("admin/testesidiomas");
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('models');
			}
		}
		$var["teste"] = $tst;

		$var["idiomas"] = Model_Idioma::getAllSemOutros();

		$this->template->title = $tst->nome;
		$this->template->content = View::factory('admin/testeidioma/edicao', $var)
			->bind('errors', $errors);
	}

	function validaTeste($id)
	{
		$teste = ORM::factory("teste", $id);
		if(!$teste->loaded()){
			$this->request->redirect("admin/testesidiomas/notfound");
		}
		if($teste->active==0){
			$this->request->redirect("admin/testesidiomas/notfound");
		}
	}

	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p class="p_error">Página não encontrada</p>';
	}


	public function action_resultados()
	{
		$var = array();
		$id = $this->request->param("id");

		$this->validaTeste($id);
		$tst = ORM::factory("teste", $id);

		$questoes = $tst->questoes->where("tipo", "=", "2")->find_all()->as_array("id", "id");
		if(count($questoes) > 0){

			$var["respostas"] = ORM::factory("resposta")
				->where("questao_id", "IN", $questoes)
				->group_by("valor")
				->find_all();

			$results = array();

			if(isset($_POST["salvar"])){
				foreach($var["respostas"] as $row){
					try
					{
						$post = Arr::get($_POST, "texto");
						$resultado = ORM::factory("resultado")
							->where("teste_id", "=", $tst->id)
							->where("letra", "=", $row->valor)
							->find();
						if(!$resultado->loaded()){
							$resultado = ORM::factory("resultado");
							$resultado->teste_id = $tst->id;
							$resultado->letra = $row->valor;
						}
						$resultado->texto = Arr::get($post, $row->id);
						// para mostrar no textarea
						$results[$row->valor] = Arr::get($post, $row->id);
						$resultado->save();
					} catch (ORM_Validation_Exception $e) {
						$errors[$row->valor] = $e->errors('models');
					}
				}
				if(!isset($errors)){
					$var["success"] = '<p class="p_success">Resultado salvo com sucesso</p>';
				}
			} else {
				$rs = ORM::factory("resultado")
					->where("teste_id", "=", $tst->id)
					->find_all();
				foreach($rs as $row){
					$results[$row->letra] = $row->texto;
				}
			}
			$this->template->title = $tst->nome;
			$this->template->content = View::factory('admin/testeidioma/respostas', $var)
				->bind('teste', $tst)
				->bind('resultado', $results)
				->bind('errors', $errors);
		} else {
			$this->template->title = $tst->nome;
			$this->template->content = '<p class="p_error">Este teste não possui questões de perfil.</p>';
		}
	}


}
