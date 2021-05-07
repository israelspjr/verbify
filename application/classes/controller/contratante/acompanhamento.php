<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_Acompanhamento extends Controller_Contratante_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		//$comprados = $user->conta->acessoscomprados->where('acesso', '=', '1');
		$query = DB::select('candidato_id')->distinct(true)->from('acesso_comprado')
			->join("candidato", "inner")->on("acesso_comprado.candidato_id", "=", "candidato.id")
			->where("conta_id", "=", $user->conta->id)
			->where("candidato.active", "=", "1");
		$comprados = Database::instance()->query(Database::SELECT, $query, TRUE);
		$var["user"] = $user;
		// pagination
		$pagination = new Pagination;
		$pagination->page = (isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1);
		$pagination->rows_per_page = 40;
		$pagination->links_per_page = 20;
		$pagination->offset = ($pagination->page - 1) * $pagination->rows_per_page;
		$pagination->append = preg_replace('/page=[0-9]{1,}&/', '', $_SERVER["QUERY_STRING"]);
		$total = clone $query;
		$pagination->total_rows = count($query->execute());
		$var["minis"] = $query
			->limit($pagination->rows_per_page)
			->offset($pagination->offset)
			->execute();
		$var["pagination"] = $pagination;
		$this->template->title = "Acompanhamento";
		$this->template->content = View::factory('contratante/acompanhamento', $var);
	}
}