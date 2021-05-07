<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Admin_TesteOral extends Controller_Admin_DefaultTemplate {
	
	public function action_index()
	{
		$this->request->redirect("admin/testeoral/cadastrar");
	}

	public function action_cadastrar()
	{
		$var = array();
		
		$var["form"] = $this->formCadastro();
		if(isset($_POST["cadastrar"])){
			$teste = ORM::factory("teste");
			$teste->nome = $_POST["nome"];
			$teste->enunciado = $_POST["enunciado"];
			$teste->tipo = 4;
			$teste->publicado = 0;
			$teste->save();
		}
		
		$var["testes"] = ORM::factory("teste")->getTestesOralAtivos();
		$this->template->title = "Teste Oral";
		$this->template->content = View::factory('admin/testeoral/index', $var);
	}

	public function action_editar()
	{
		$var = array();

		$id = $this->request->param("id");
		$teste = ORM::factory("teste", $id);
		
		if($teste->loaded()){
			$var["form"] = $this->formEdicao($teste);
		} else {
			$this->request->redirect("admin/testeoral/cadastrar");
		}
		if(isset($_POST["salvar"])){
			$teste->nome = $_POST["nome"];
			$teste->enunciado = $_POST["enunciado"];
			$teste->tipo = 4;
			$teste->save();
		}
		
		$var["testes"] = ORM::factory("teste")->getTestesOralAtivos();
		$this->template->title = "Teste Oral";
		$this->template->content = View::factory('admin/testeoral/index', $var);
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
	
	public function formCadastro()
	{
		return '<form method="post" id="frm_testeoral">
			<label>Nome</label>
			<input type="text" name="nome" />
			<label>Enunciado</label>
			<textarea name="enunciado"></textarea>
			<div class="dv_btn">
				<input type="submit" name="cadastrar" value="cadastrar" />
			</div>
		</form>';
	}
	
	public function formEdicao($teste)
	{
		return '<form method="post" id="frm_testeoral">
			<input type="hidden" name="id" value="'.$teste->id.'" />
			<label>Nome</label>
			<input type="text" name="nome" value="'.$teste->nome.'" />
			<label>Enunciado</label>
			<textarea name="enunciado">'.$teste->enunciado.'</textarea>
			<div class="dv_btn">
				<input type="submit" name="salvar" value="salvar" />
				<input type="button" name="cancelar" value="cancelar" onClick="window.open(\''.URL::site("admin/testeoral/cadastrar").'\', \'_top\')" />
			</div>
		</form>';
	}
}