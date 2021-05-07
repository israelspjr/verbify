<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BuscaAvancada extends Controller_DefaultTemplate {

	public function action_index()
	{	
		$var = array();
		$var["count"] = 0;
		if(isset($_POST["buscar"])) {
			$estado = Arr::get($_POST, "estado");
			$cidade = Arr::get($_POST, "cidade");
			$regiao = Arr::get($_POST, "regioes");
			$idioma = Arr::get($_POST, "idioma");
			$semana = Arr::get($_POST, "semana");
			$horade = Arr::get($_POST, "horade");
			$horaate = Arr::get($_POST, "horaate");

			// hora e semana
			if($horade<>'' AND $horaate<>'' AND ($horaate > $horade)){
				$subquery = DB::select('candidato_id', array('COUNT("candidato_id")', 'total'))->distinct(TRUE)
					->from('candidato_disponibilidade')
					->where('status', '=', '0')
					->where('hora', 'BETWEEN', array($horade, ($horaate-1)));
				if($semana<>'')
					$subquery->where('semana', '=', $semana);
				$subquery->group_by('candidato_id', 'semana')->having('total', '=', ($horaate-$horade));
			} elseif($semana <> ''){
				$subquery = DB::select('candidato_id')->distinct(TRUE)
					->from('candidato_disponibilidade')
					->where('status', '=', '0')
					->where('semana', '=', $semana);
			}
			
			$cands = ORM::factory('candidato')->where('active', '=', '1')
				->join('candidato_local', 'INNER')
				->on('candidato.id', '=', 'candidato_local.candidato_id');
			if($estado <> '')
				$cands->where('estado_id', '=',  $estado);
			if($cidade <> '')
				$cands->where('cidade_id', '=', $cidade);
			if($regiao <> '')
				$cands->where('regiao_id', '=', $regiao);
			if($idioma <> '') {
				$cands->join('candidato_idioma', 'INNER')
					->on('candidato.id', '=', 'candidato_idioma.candidato_id')
					->where('candidato_idioma.idioma_id', '=', $idioma);
			}
			if(isset($subquery)) {
				$cands->join(array($subquery, 'disponibilidade'), 'INNER')
					->on('candidato.id', '=', 'disponibilidade.candidato_id');
			}
			$var['count'] = $cands->count_all();
		}
		$var["semana"] = Helper::arr_semana();
		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->find_all();
		$var["estados"] = ORM::factory('estado')->find_all();
		$this->template->title = 'Busca Avançada';
        $this->template->content = View::factory('buscaavancada', $var)
			->set('values', $_POST);
	}
}
?>