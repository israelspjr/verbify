<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_BuscarCadastrados extends Controller_Contratante_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		// pagination
		$pagination = new Pagination;
		$pagination->page = (isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1);
		$pagination->rows_per_page = 40;
		$pagination->links_per_page = 20;
		$pagination->offset = ($pagination->page - 1) * $pagination->rows_per_page;
		$pagination->append = preg_replace('/page=[0-9]{1,}&/', '', $_SERVER["QUERY_STRING"]);
		// busca
		$cands = DB::select('candidato.*', array(DB::expr('group_concat(tb_testes.nome ORDER BY tb_testes.nome ASC SEPARATOR \'<br /> \')'), 'testes'))
			->from('candidato')
			
			->join('teste_executado', 'LEFT')
			->on('candidato.id', '=', 'teste_executado.candidato_id')
			->on('teste_executado.divulgar', '=', DB::expr("1"))
			->join('testes', 'LEFT')
			->on('teste_executado.teste_id', '=', 'testes.id')
			->join('candidato_local', 'INNER')
			->on('candidato.id', '=', 'candidato_local.candidato_id')
			
			->where('candidato.active', '=', '1');
		$cands->where('candidato.conveniado_id', '=', $user->id);
		$cands->group_by('candidato.id');
		$total = clone $cands;
		$pagination->total_rows = count($total->execute());
		$var["cands"] = $cands
			->limit($pagination->rows_per_page)
			->offset($pagination->offset)
			->as_object()
			->execute();
		$var["pagination"] = $pagination;
		// fim busca
		$var["user"] = $user;
		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->find_all();
		$var["estados"] = ORM::factory('estado')->find_all();
		$this->template->title = 'Buscar Professores';
		$this->template->content = View::factory('contratante/buscarcadastrados', $var)
			->set('values', $_REQUEST);
	}
}
?>