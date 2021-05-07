<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_MinhasVagas extends Controller_Contratante_DefaultTemplate {

	public function action_index()
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$var = array();
		$var["vagas"] = $user->vagas->where("active", "=", "1")->find_all();
		$this->template->title = 'Minhas Vagas';
		$this->template->content = View::factory('contratante/minhasvagas', $var);
		$this->template->styles = array('assets/css/contratante/vagas.css' => 'screen');
	}
	
	public function action_publicar()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		if(isset($_POST["publicar"])){
			$values = $_POST;
			$db = Database::instance();
			try {
				$vaga = ORM::factory("vaga");
				$vaga->contratante_id = $user->id;
				/*
				$vaga->titulo = Arr::get($_POST, "titulo");
				$vaga->exibir = Arr::get($_POST, "exibir_nome");
				$vaga->descricao = Arr::get($_POST, "descricao");
				$vaga->horario = Arr::get($_POST, "horario");
				$vaga->salario = Arr::get($_POST, "salario");
				*/
				$vaga->idioma_id = Arr::get($_POST, "idioma");
				$vaga->estado_id = Arr::get($_POST, "estado");
				$vaga->cidade_id = Arr::get($_POST, "cidade");
				$regiao = Arr::get($_POST, "regioes");
				$vaga->regiao_id = $regiao;
				$vaga->bairro = Arr::get($_POST, "bairro");
				$vaga->nvagas = Arr::get($_POST, "nvagas");

				$local = Arr::get($_POST, "local");
				$vaga->setLocal($local);
				$values["locale"] = $vaga->na_escola;
				$values["localc"] = $vaga->in_company;

				$tipo = Arr::get($_POST, "tipo");
				$vaga->setTipo($tipo);
				$values["tipoc"] = $vaga->criancas;
				$values["tipot"] = $vaga->adolescentes;
				$values["tipoa"] = $vaga->adultos;
				
				if($vaga->cidade_id == 7374){
					$extra = Validation::factory(array('regiao_id' => $regiao, 'local' => $local, 'tipo' => $tipo))
						->rule('regiao_id', 'not_empty')
						->rule('local', 'not_empty')
						->rule('tipo', 'not_empty');
				} else {
					$extra = Validation::factory(array('local' => $local,'tipo' => $tipo))
						->rule('local', 'not_empty')
						->rule('tipo', 'not_empty');
				}
				$vaga->save($extra);
				
				$this->request->redirect('contratante/minhasvagas');
				
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('models/vaga');
			}
		}
		$var["estados"] = ORM::factory('estado')->find_all();
		$var["idiomas"] = ORM::factory('idioma')->find_all();
		$var["nome"] = $user->getNome();
		$this->template->title = 'Publicar Vaga';
		$this->template->content = View::factory('contratante/publicarvaga', $var)
			->bind("values", $values)
			->bind("errors", $errors);
		$this->template->styles = array('assets/css/contratante/vagas.css' => 'screen');			
	}
	
	public function action_editar()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param("id");
		
		$this->verificaVaga($id);

		$vaga = ORM::factory("vaga", $id);
		if(isset($_POST["salvar"])){
			$values = $_POST;
			try {
				$vaga->contratante_id = $user->id;
				/*
				$vaga->titulo = Arr::get($_POST, "titulo");
				$vaga->exibir = Arr::get($_POST, "exibir_nome");
				$vaga->descricao = Arr::get($_POST, "descricao");
				$vaga->horario = Arr::get($_POST, "horario");
				$vaga->salario = Arr::get($_POST, "salario");
				*/
				$vaga->idioma_id = Arr::get($_POST, "idioma");
				$vaga->estado_id = Arr::get($_POST, "estado");
				$vaga->cidade_id = Arr::get($_POST, "cidade");
				if(isset($_POST["regioes"])){
					$vaga->regiao_id = Arr::get($_POST, "regioes");
				}
				$vaga->bairro = Arr::get($_POST, "bairro");
				$vaga->nvagas = Arr::get($_POST, "nvagas");
				$local = Arr::get($_POST, "local");
				$vaga->setLocal($local);
				$values["locale"] = $vaga->na_escola;
				$values["localc"] = $vaga->in_company;

				$tipo = Arr::get($_POST, "tipo");
				$vaga->setTipo($tipo);
				$values["tipoc"] = $vaga->criancas;
				$values["tipot"] = $vaga->adolescentes;
				$values["tipoa"] = $vaga->adultos;
				
				$extra = Validation::factory(array('local' => $local,'tipo' => $tipo))
					->rule('local', 'not_empty')
					->rule('tipo', 'not_empty');
				$vaga->save($extra);

				$var["success"] = "Dados salvos com sucesso";
				
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('models/vaga');
				$errors["vaga"] = "Verifique os campos obrigatórios";
			}
		} else {
			$values = $vaga->as_array();
			$values["regioes"] = $vaga->regiao_id;
			
			$values["locale"] = $vaga->na_escola;
			$values["localc"] = $vaga->in_company;
			$values["tipoc"] = $vaga->criancas;
			$values["tipot"] = $vaga->adolescentes;
			$values["tipoa"] = $vaga->adultos;
			
			$values["idioma"] = $values["idioma_id"]; 
			$values["estado"] = $values["estado_id"]; 
			$values["cidade"] = $values["cidade_id"]; 
			$values["exibir_nome"] = $values["exibir"];
		}
		$var["estados"] = ORM::factory('estado')->find_all();
		$var["idiomas"] = ORM::factory('idioma')->find_all();
		$var["nome"] = $user->getNome();
		$this->template->title = 'Editar Vaga';
		$this->template->content = View::factory('contratante/editarvaga', $var)
			->bind("values", $values)
			->bind("errors", $errors);
		$this->template->styles = array('assets/css/contratante/vagas.css' => 'screen');
	}

	public function action_excluir()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param("id");

		$this->verificaVaga($id);
		
		$vaga = ORM::factory("vaga", $id);
		$vaga->active = 0;
		$vaga->save();
		$this->request->redirect("contratante/minhasvagas");
	}
	
	public function action_vercandidatos()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param("id");

		$this->verificaVaga($id);

		$vaga = ORM::factory("vaga", $id);
		$candidaturas = $vaga->getCandidaturasAtivas();
		$this->template->title = 'Ver Candidatos';
		$var["vaga"] = $vaga;
		$var["candidaturas"] = $candidaturas;
		$this->template->content = View::factory('contratante/vercandidaturas', $var);
	}
	
	public function action_vercurriculo()
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param("id");

		$this->verificaCandidatura($id);

		$candidatura = ORM::factory("candidatura", $id);
		$candidatura->visualizado = 1;
		$candidatura->save();
		$this->request->redirect("contratante/curriculo/geral/".$candidatura->candidato->id);
	}
	
	public function action_descartarcandidatura()
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$id = $this->request->param("id");

		$this->verificaCandidatura($id);

		$candidatura = ORM::factory("candidatura", $id);
		$candidatura->visualizado = 1;
		$candidatura->descartado = 1;
		$candidatura->save();
		$this->request->redirect("contratante/minhasvagas/vercandidatos/".$candidatura->vaga->id);
	}

	public function verificaVaga($id)
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$vaga = $user->vagas->where("id", "=", $id)->find();
		if(!$vaga->loaded()){
			$this->request->redirect("contratante/home/notfound");			
		}
	}

	public function verificaCandidatura($id)
	{
		$user = Session::instance()->get("contrat_user", NULL);
		$candidatura = ORM::factory("candidatura", $id);
		if(!$candidatura->loaded()){
			$this->request->redirect("contratante/home/notfound");			
		}
		$this->verificaVaga($candidatura->vaga->id);
	}

}
?>