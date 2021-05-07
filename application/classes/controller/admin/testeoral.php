<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_TesteOral extends Controller_Admin_DefaultTemplate {

	public function action_index()
	{
		$this->request->redirect("admin/testeoral/cadastrar");
	}

	public function action_cadastrar()
	{
		$var = array();
		$teste = ORM::factory("teste");
		if(isset($_POST["salvar"])){
			try
			{
				$teste->nome = Arr::get($_POST, 'nome');
				$teste->enunciado = Arr::get($_POST, 'enunciado');
				$teste->enunciado_en = Arr::get($_POST, 'enunciado_en');
				$teste->idioma_id = Arr::get($_POST, "idioma");
				$teste->tipo = 2;
				$teste->publicado = 0;
				$teste->save();
				$teste = ORM::factory("teste");
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('models');
			}
		}
		$var["teste"] = $teste;
		$var["idiomas"] = Model_Idioma::getAllSemOutros();
		$var["testes"] = ORM::factory("teste")->getTestesOralAtivos();
		$this->template->title = "Teste Oral";
		$this->template->content = View::factory('admin/testeoral/index', $var)
			->bind('errors', $errors);
	}

	public function action_editar()
	{
		$var = array();

		$id = $this->request->param("id");
		$teste = ORM::factory("teste", $id);

		if(!$teste->loaded())
			$this->request->redirect("admin/testeoral/cadastrar");

		if(isset($_POST["salvar"])){
			try
			{
				$teste->nome = Arr::get($_POST, 'nome');
				$teste->enunciado = Arr::get($_POST, 'enunciado');
				$teste->enunciado_en = Arr::get($_POST, 'enunciado_en');
				$teste->idioma_id = Arr::get($_POST, "idioma");
				$teste->tipo = 2;
				$teste->save();
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('models');
			}
		}
		$var["teste"] = $teste;
		$var["idiomas"] = Model_Idioma::getAllSemOutros();
		$var["testes"] = ORM::factory("teste")->getTestesOralAtivos();
		$this->template->title = "Teste Oral";
		$this->template->content = View::factory('admin/testeoral/index', $var)
			->bind('errors', $errors);
	}

	public function action_excluir()
	{
		$id = $this->request->param("id");
		$teste = ORM::factory("teste", $id);
		if($teste->loaded()){
			$teste->active = 0;
			$teste->save();
		}
		$this->request->redirect("admin/testeoral/cadastrar");
	}

	public function action_publicar()
	{
		$id = $this->request->param("id");
		$teste = ORM::factory("teste", $id);
		if($teste->loaded()){
			$teste->publicado = 1;
			$teste->save();
		}
		$this->request->redirect("admin/testeoral/cadastrar");
	}

	public function action_despublicar()
	{
		$id = $this->request->param("id");
		$teste = ORM::factory("teste", $id);
		if($teste->loaded()){
			$teste->publicado = 0;
			$teste->save();
		}
		$this->request->redirect("admin/testeoral/cadastrar");
	}
}