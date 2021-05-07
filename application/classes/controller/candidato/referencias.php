<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_Referencias extends Controller_Candidato_CurriculoTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);
		$ref = ORM::factory("referencia");
		if(isset($_POST["enviar"])){
			// enviar email
			$db = Database::instance();
			try {
				$db->begin();
				$ref->candidato_id = $user->id;
				$ref->nome = $_POST["nome"];
				$ref->email = $_POST["email"];
				$ref->key = Auth::instance()->hash(time());
				$ref->save();
				$ref->sendEmail();
				$db->commit();
				$var["success"] = "Solicitação enviada com sucesso. Aguardando retorno.";
				$ref = ORM::factory("referencia");
			}
			catch (ORM_Validation_Exception $e)
			{
				$db->rollback();
				$errors = $e->errors('models/candidato');
			}
		}
		$var["ref"] = $ref;
		$var["referencias"] = $user->referencias->where("status", "=", "1")->find_all();
		$this->template->title = __('Cadastro do Currículo').' - '.__('Referências');
		$this->template->content = View::factory('candidato/referencias', $var)
			->bind('ref', $ref)
			->bind('errors', $errors);
	}

	public function action_publicar(){
		$user = Session::instance()->get("talen_user", NULL);
		$id = $this->request->param("id");
		$ref = $user->referencias->where("id", "=", $id)->find();
		if($ref->loaded()){
			$ref->aprovado = 1;
			$ref->save();
		}
		$ref = ORM::factory("referencia");
		$var["referencias"] = $user->referencias->where("status", "=", "1")->find_all();
		$this->template->title = __('Cadastro do Currículo').' - '.__('Referências');
		$this->template->content = View::factory('candidato/referencias', $var)
			->bind('ref', $ref)
			->bind('errors', $errors);
	}

	public function action_excluir(){
		$user = Session::instance()->get("talen_user", NULL);
		$id = $this->request->param("id");
		$ref = $user->referencias->where("id", "=", $id)->find();
		if($ref->loaded()){
			$ref->status = 3;
			$ref->save();
		}
		$user = Session::instance()->get("talen_user", NULL);
		$id = $this->request->param("id");
		$ref = ORM::factory("referencia");
		$var["referencias"] = $user->referencias->where("status", "=", "1")->find_all();
		$this->template->title = __('Cadastro do Currículo').' - '.__('Referências');
		$this->template->content = View::factory('candidato/referencias', $var)
			->bind('ref', $ref)
			->bind('errors', $errors);
	}
}
?>