<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pacotes extends Controller_Admin_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		if(isset($_POST["cadastrar"])){
			try {
				$pack = ORM::factory("pacote");
				$reais = Arr::get($_POST, "preco");
				$pack->creditos = Arr::get($_POST, "credito");
				$pack->reais = Helper::number_format_invert($reais);
				$pack->save();
			} catch (ORM_Validation_Exception $e) {
				$var["errors"] = $e->errors('models');
			}
		}
		if(isset($_POST["excluir"])){
			try {
				$id = Arr::get($_POST, "pack_id");
				$pack = ORM::factory("pacote", $id);
				$pack->active = 0;
				$pack->save();
			} catch (ORM_Validation_Exception $e) {
				$var["errors"] = $e->errors('models');
			}
		}
		$var["pacotes"] = ORM::factory("pacote")->where('active', '=', '1')->order_by("creditos", "ASC")->find_all();
		$this->template->title = "Pacotes";
		$this->template->content = View::factory('admin/pacotes', $var);
	}
}
?>