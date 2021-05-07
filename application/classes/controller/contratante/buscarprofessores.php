<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_BuscarProfessores extends Controller_Contratante_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		if(isset($_REQUEST["buscar"])) {
		
			$estado = Arr::get($_REQUEST, "estado");
			$cidade = Arr::get($_REQUEST, "cidade");
			$regiao = Arr::get($_REQUEST, "regioes");
			$idioma = Arr::get($_REQUEST, "idioma");
			$conveniado = Arr::get($_REQUEST, "conveniado");

			// pagination
			$pagination = new Pagination;
			$pagination->page = (isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1);
			$pagination->rows_per_page = 40;
			$pagination->links_per_page = 20;
			$pagination->offset = ($pagination->page - 1) * $pagination->rows_per_page;
			$pagination->append = preg_replace('/page=[0-9]{1,}&/', '', $_SERVER["QUERY_STRING"]);
			
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
			if($estado <> '')
				$cands->where('estado_id', '=',  $estado);
			if($cidade <> '')
				$cands->where('cidade_id', '=', $cidade);
			if($regiao <> ''){
				$cands->join('candidato_regiao', 'INNER')
				->on('candidato.id', '=', 'candidato_regiao.candidato_id');
				$cands->where('candidato_regiao.regiao_id', '=', $regiao);
			}
			if($idioma <> '') {
				$cands->join('candidato_idioma', 'INNER')
					->on('candidato.id', '=', 'candidato_idioma.candidato_id')
					->where('candidato_idioma.idioma_id', '=', $idioma);
			}
			if($conveniado <> ''){
				$conv_id = ($conveniado == 0 ? 0 : $user->id);
				$cands->where('candidato.conveniado_id', '=', $conv_id);
			}
			$cands->group_by('candidato.id');
			//->where("status", "=", "1");
			$total = clone $cands;
			$pagination->total_rows = count($total->execute());
			$var["cands"] = $cands
				->limit($pagination->rows_per_page)
				->offset($pagination->offset)
				->as_object()
				->execute();
			$var["pagination"] = $pagination;
		}
		$var["user"] = $user;
		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->find_all();
		$var["estados"] = ORM::factory('estado')->find_all();
		$this->template->title = 'Buscar Professores';
		$this->template->content = View::factory('contratante/buscarprofessores', $var)
			->set('values', $_REQUEST);
	}
}
?>