<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BuscaSimples extends Controller_DefaultTemplate {

	public function action_index()
	{	
		$var = array();
		$var["search"] = "";
		$var["count"] = 0;
		if(isset($_POST["search"]) and trim($_POST["search"])<>""){
			$search = trim($_POST["search"]);
			$var["count"] = ORM::factory("candidato")
				->where("nome", "like", "%$search%")
				->count_all();
			$var["search"] = $search;
			// faz a busca e retorna quantidade
		}
        $this->template->title = 'Busca Simples';
        $this->template->content = View::factory('buscasimples', $var);
	}
}
?>