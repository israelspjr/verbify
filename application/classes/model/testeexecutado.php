<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_TesteExecutado extends ORM {

	protected $_table_name = 'teste_executado';
	protected $table_columns = array (
		'teste_id' 			=> 	array('type'=>'int'),
		'candidato_id'		=>	array('type'=>'int'),
		'dt_execucao'		=>	array('type'=>'timestamp'),
		'divulgar'			=>	array('type'=>'int'),
	);

	protected $_belongs_to = array(
		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),
		'teste' 	=> array('model' => 'teste', 'foreign_key' => 'teste_id'),
	);

	protected $_has_one = array(
		'video' => array(
			'model'   => 'video',
			'foreign_key' => 'testeex_id',
		),
	);

	public function getResultHtmlTipo1()
	{
		$html = FALSE;
		$qs1 = $this->teste->questoes->where("tipo", "=", "1")->count_all();
		if($qs1 > 0){
			$questoes = $this->teste->questoes->where("tipo", "=", "1")->find_all()->as_array("id", "id");
			$acertos = $this->teste->candidatosrespostas
				->where("resposta", "=", "C")
				->where("candidato_id", "=", $this->candidato_id)
				->where("questao_id", "IN", $questoes)
				->count_all();
			$qua = array();
			$resps = $this->teste->candidatosrespostas->where("candidato_id", "=", $this->candidato_id)->find_all();
			foreach($resps as $q){
				if($q->questao->tipo == 1){
					$qua[] = '<span class="'.($q->resposta == '?' ? 'span_0' : 'span_'.$q->resposta).'">'.$q->questao->ordem.'</span>';
				}
			}
			$html = '
			<div class="dv_myresult">
				<div class="result">
					'.__('Percentual de acerto').': '.round($acertos/$qs1*100).'% ('.$acertos.'/'.$qs1.')
					<div style="float: right;">
						<span class="span_C">'.__('certa').'</span>
						<span class="span_E">'.__('errada').'</span>
						<span class="span_0">'.__('não respondida').'</span>
					</div>
					<div class="clear"></div>
				</div>
				<div class="dv_quadrados">'.implode("", $qua).'
					<div class="clear"></div>
				</div>
			</div>';
		}
		return $html;
	}

	public function getResultHtmlTipo2()
	{
		$html = FALSE;
		$qs2 = $this->teste->questoes->where("tipo", "=", "2")->count_all();
		if($qs2 > 0){
			$query = DB::select('resposta', array(DB::expr('COUNT(resposta)'), 'total'))
				->from('candidato_resposta')
				->join('questoes')
				->on('candidato_resposta.questao_id', '=', 'questoes.id')
				->where('questoes.tipo', '=', '2')
				->where('candidato_id', '=', $this->candidato_id)
				->where('candidato_resposta.teste_id', '=', $this->teste_id)
				->group_by('resposta')
				->order_by('total', 'DESC')
				->order_by('resposta', 'ASC');
			$respostas = DB::query(Database::SELECT, $query)->execute();

			$query_count = DB::select(array('COUNT("resposta")', 'total'))
				->from('candidato_resposta')
				->join('questoes')
				->on('candidato_resposta.questao_id', '=', 'questoes.id')
				->where('questoes.tipo', '=', '2')
				->where('candidato_id', '=', $this->candidato_id)
				->where('candidato_resposta.teste_id', '=', $this->teste_id)
				->execute()->get('total', 0);

			$html = '<div class="dv_myresult">
			'.__('Perfil').':
			<div class="result">';
			$max = 0;
			$predominante = array();
			$nao = '';
			foreach($respostas as $row){
				if($row["resposta"] == "?"){
					$nao .= '<p class="p_perfil">'.ucfirst(__('não respondida')).' - '.round($row["total"]/$query_count*100).'%; </p>';
				} else {
					$html .= '<p class="p_perfil">'.$row["resposta"].' - '.round($row["total"]/$query_count*100).'%; </p>';
					if($row["total"] > $max){
						$max = $row["total"];
						$predominante = array();
						$predominante[] = $row["resposta"];
					} elseif($row["total"] == $max){
						$predominante[] = $row["resposta"];
					}
				}
			}
			$html .= $nao;
			$results = $this->teste->resultados->order_by("letra", "ASC")->find_all();
			foreach($results as $row){
				$html .= '
				<div class="dv_result_box '.(in_array($row->letra, $predominante) ? 'myresult' : 'hide').'">
					<h3>Resposta predominante: '.$row->letra.'</h3>
					<div>'.$row->texto.'</div>
				</div>';
			}
			$html .= '</div>
			</div>';
		}
		return $html;
	}

	public function getResultHtmlTipo3($q)
	{
		$resposta = $q->candidatosrespostas->where("candidato_id", "=", $this->candidato_id)->find();
		$html = FALSE;
		$html = '
		<div class="dv_myresult">
			'.$q->enunciado.' <br />
			<div class="result">'.(($resposta->resposta == "?" AND $resposta->respostatexto == "") ? __('não respondida') : $resposta->respostatexto).'</div>
		</div>';
		return $html;
	}

	public function getResultHtmlTipo4($q)
	{
		$resposta = $q->candidatosrespostas->where("candidato_id", "=", $this->candidato_id)->find();
		$arr = json_decode($resposta->respostatexto);

		$gradeopts = FormTestes::getRowsGrade();
		$gradecols = FormTestes::getColsGrade();
		$tds_header = '';
		foreach($gradecols as $key => $col)
		{
			$tds_header .= '<td class="'.($key<=5 ? "td_verde" : "td_azul").'">'.$col.'</td>';
		}
		$header = "<tr><td></td>$tds_header</tr>";
		$rows = array();
		foreach($gradeopts as $key => $row){
			$tds_row = '';
			foreach($gradecols as $key2 => $col){
				if($key2 <= 5)
					$tds_row .= '<td class="td_verde">'.($arr[0][$key] == $key2 ? '<img src="'.URL::site("assets/img/check2.png").'">' : '').'</td>';
				else
					$tds_row .= '<td class="td_azul">'.($arr[1][$key] == $key2 ? '<img src="'.URL::site("assets/img/check2.png").'">' : '').'</td>';
			}
			$rows[] = "<tr><td>$row</td>$tds_row</tr>";
		}
		$html = '
		<div class="dv_myresult">
			<div class="result">
				<table class="tb_grade">
					'.$header.'
					'.implode("", $rows).'
				</table>
			</div>
		</div>';
		return $html;
	}

	public function getResultHtmlTipo5($q)
	{
		$resposta = $q->candidatosrespostas->where("candidato_id", "=", $this->candidato_id)->find();
		$arr = json_decode($resposta->respostatexto);
		$rs = array();
		if(count($arr) > 1){
			foreach($arr as $key => $value){
				$key++;
				$rs[] = '<div class="result">'.$key.') '.$value.'</div>';
			}
		} else {
			if(is_array($arr)){
				foreach($arr as $key => $value){
					$key++;
					$rs[] = '<div class="result">'.$value.'</div>';
				}
			} else {
				$rs[] = '<div class="result">não respondida</div>';
			}
		}
		$html = '
		<div class="dv_myresult">
			'.$q->enunciado.'
			'.implode("", $rs).'
		</div>';
		return $html;
	}

	public function getResultHtmlTipo6()
	{
		$dv_concorda = '';
		$dv_parcialmente = '';
		$dv_discorda = '';

		$questoes = $this->teste->questoes->where("tipo", "=", "6")->find_all()->as_array("id", "id");

		// concorda
		$concorda = $this->teste->candidatosrespostas
			->where("resposta", "=", "1")
			->where("candidato_id", "=", $this->candidato_id)
			->where("questao_id", "IN", $questoes)
			->find_all();
		if(count($concorda) > 0){
			$dv_concorda = 'O candidato concorda plenamente com as seguintes afirmações:';
			foreach($concorda as $row){
				$dv_concorda .= '<div class="result">'.$row->questao->enunciado.'</div>';
			}
		}

		// parcialmente
		$parcialmente = $this->teste->candidatosrespostas
			->where("resposta", "=", "2")
			->where("candidato_id", "=", $this->candidato_id)
			->where("questao_id", "IN", $questoes)
			->find_all();
		if(count($parcialmente) > 0){
			$dv_parcialmente = 'O candidato concorda parcialmente com as seguintes afirmações: <br />';
			foreach($parcialmente as $row){
				$dv_parcialmente .= '<div class="result">'.$row->questao->enunciado.'</div>';
			}
		}

		// discorda
		$discorda = $this->teste->candidatosrespostas
			->where("resposta", "=", "3")
			->where("candidato_id", "=", $this->candidato_id)
			->where("questao_id", "IN", $questoes)
			->find_all();
		if(count($discorda) > 0){
			$dv_discorda = 'O candidato discorda das seguintes afirmações: <br />';
			foreach($discorda as $row){
				$dv_discorda .= '<div class="result">'.$row->questao->enunciado.'</div>';
			}
		}

		$html = '
		<div class="dv_myresult">
			'.$dv_concorda.'
			'.$dv_parcialmente.'
			'.$dv_discorda.'
		</div>';

		return $html;
	}

	public function getSituacao() {
		return ($this->divulgar == 0 ? 'Não publicado' : 'Publicado');
	}

}
?>