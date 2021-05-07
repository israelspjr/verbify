<?php
defined('SYSPATH') or die('No direct script access.');
class FormTestesEn {

	public static function getOpcoesCadastro($tipo, $i, $texto = '', $value = '')
	{
		if($tipo == 1) {
			return FormTestesEn::getOpcoesCertoErrado($i, $texto, $value);
		} elseif($tipo == 2) {
			return FormTestesEn::getOpcoesPerfil($i, $texto, $value);
		} elseif($tipo == 3) {
			return FormTestesEn::getOpcoesEscolha($i, $texto, $value);
		}
	}

	public static function getOpcoesCertoErrado($i, $texto ='', $value = '')
	{
		$html = '
		<div id="dv_resposta'.$i.'" class="resp'.$i.'">
			<div style="float: left;"><input type="text" name="texto_en['.$i.']" value="'.$texto.'" class="iptresposta"/></div>
			<br class="clear"/>
		</div>';
		return $html;
	}

	public static function getOpcoesPerfil($i, $texto ='', $value = '')
	{
		$perfil = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$html = '
		<div id="dv_resposta'.$i.'" class="resp'.$i.'">
			<div style="float: left;"><input type="text" name="texto_en['.$i.']" value="'.$texto.'" class="iptresposta"/></div>
			<br class="clear"/>
		</div>';
		return $html;
	}

	public static function getOpcoesEscolha($i, $texto ='')
	{
		/*$html = '
		<div id="dv_resposta'.$i.'">
			<div style="float: left;">'.Helper::intToChar($i).') <input type="text" name="texto['.$i.']" value="'.$texto.'" class="iptresposta"/></div>
			<br class="clear"/>
		</div>';*/
		$html = '
		<div id="dv_resposta'.$i.'" class="resp'.$i.'">
			<div style="float: left;"><input type="text" name="texto_en['.$i.']" value="'.$texto.'" class="iptresposta"/></div>
			<br class="clear"/>
		</div>';
		return $html;
	}

	// html da exibicao da questao para o admin
	public static function getHtmlAdminShowQuestion($questao)
	{
		$html = '';
		// depende do tipo de questao
		if($questao->topico <> ""){
			$html .= '<h4>'.$questao->topico_en.'</h4>';
		}
		$html .= $questao->enunciado_en.'<div class="dv_alternativas">';
		$respostas = $questao->respostas->order_by("id", "ASC")->find_all();
		if($questao->tipo == 1 OR $questao->tipo == 2 OR $questao->tipo == 3){
			$i =1;
			foreach($respostas as $resp){
				if($questao->tipo == 1 OR $questao->tipo == 2) {
					//$html .= Helper::intToChar($i).') '.$resp->texto.' ('.$resp->valor.')<br />';
					$html .= '<p>'.$resp->texto_en.' ('.$resp->valor.')</p>';
				} else {
					//$html .= Helper::intToChar($i).') '.$resp->texto.' <br />';
					$html .= '<p>'.$resp->texto_en.'</p>';
				}
				$i++;
			}
		}
		elseif($questao->tipo == 4){
			$html .= '<p>GRADE</p>';
		}
		elseif($questao->tipo == 5){
			for($i=1;$i<=$questao->max_check;$i++){
					$html .= '<p>'.$i.')</p>';
			}
		}
		elseif($questao->tipo == 6){
			$html .= '<p>I fully agree</p>';
			$html .= '<p>I partially agree</p>';
			$html .= '<p>I disagree</p>';
		}
		$html .= '</div>';
		return $html;
	}


	public static function getArrayTipoQuestao()
	{
		return array(1 =>"certo/errado", "perfil", "escolhas", "grade", "dissertativa", "concordo/discordo");
	}

	public static function getArrayTipo6()
	{
		return array(1 =>"I fully agree", "I partially agree", "I disagree");
	}

	public static function getRowsGrade()
	{
		return array(
			"Being ethical",
			"Being flexible",
			"Knowing about business",
			"Being well-informed",
			"Having quick thinking",
			"Having systemic view",
			"Having detailed view",
			"Being self-assured",
			"Being a leader",
			"Doing planning",
			"Being a good listener",
			"Being at ease",
			"Influencing people",
		);
	}

	public static function getColsGrade()
	{
		return array(
			1 => "I am always like that",
			"I am almost always like that",
			"Sometimes I am like that",
			"I am rarely like that",
			"I am never like that",
			"I would like to be like that",
			"I do not need to be like that"
		);
	}

	public static function getColsGrade1()
	{
		return array(
			1 => "A", "B", "C", "D", "E", "F", "G"
		);
	}

	public static function getHtmlCandidatoShowNextQuestion($questao, $i, $valor)
	{
		$enunciado = ($questao->enunciado_en <> '' ? $questao->enunciado_en : $questao->enunciado);
		$html = '
		<p class="p_pergunta">
			'.nl2br($enunciado).'
		</p>
		<div class="dv_alternativas">';
			if($questao->tipo == 1 OR $questao->tipo == 2)
			{
				$respostas = $questao->respostas->order_by("id", "ASC")->find_all();
				foreach($respostas as $row) {
					$texto = ($row->texto_en <> '' ? $row->texto_en : $row->texto);
					$html .= '<div class="dv_option">
						<label><input type="radio" name="resposta" value="'.$row->id.'" '.($row->id == $valor ? 'checked' : '').'>'.$texto.'</label>
					</div>';
				}
			}
			elseif($questao->tipo == 3)
			{
				$respostas = $questao->respostas->order_by("id", "ASC")->find_all();
				foreach($respostas as $row) {
					$texto = ($row->texto_en <> '' ? $row->texto_en : $row->texto);
					$html .= '<div class="dv_option">
						<label><input type="checkbox" name="resposta[]" value="'.$row->id.'" '.($row->id == $valor ? 'checked' : '').' class="tipo3">'.$texto.'</label>
					</div>';
				}
				$html .='
				<script>
				$(".tipo3").click(function() {
					var bol = $(".tipo3:checked").length >= '.$questao->max_check.';
					$(".tipo3").not(":checked").attr("disabled",bol);
				});
				</script>';
			}
			elseif($questao->tipo == 4)
			{
				$gradeopts = FormTestesEn::getRowsGrade();
				$gradecols = FormTestesEn::getColsGrade();
				$gradecols1 = FormTestesEn::getColsGrade1();
				$tds_header1 = '';
				$tds_header2 = '';

				foreach($gradecols as $key => $col)
				{
					$tds_header1 .= '<td class="'.($key<=5 ? "td_verde" : "td_azul").'">'.$gradecols1[$key].'</td>';
					$tds_header2 .= '<td class="'.($key<=5 ? "td_verde" : "td_azul").'">'.$col.'</td>';
				}
				$header = "<tr><td></td>$tds_header1</tr>
				<tr><td></td>$tds_header2</tr>";
				$rows = array();
				foreach($gradeopts as $key => $row){
					$tds_row = '';
					foreach($gradecols as $key2 => $col){
						$valor0 = Arr::get($valor, "0");
						$valor1 = Arr::get($valor, "1");
						if($key2 <= 5)
							$tds_row .= '<td class="td_verde"><input type="radio" name="resposta[0]['.$key.']" class="rdo1" value="'.$key2.'" '.((isset($valor0[$key]) AND $key2 == $valor0[$key]) ? "checked" : "").' /></td>';
						else
							$tds_row .= '<td class="td_azul"><input type="radio" name="resposta[1]['.$key.']" class="rdo2" value="'.$key2.'" '.((isset($valor1[$key]) AND $key2 == $valor1[$key]) ? "checked" : "").' /></td>';
					}
					$rows[] = "<tr><td>$row</td>$tds_row</tr>";
				}

				$html .= '
				<table class="tb_grade">
					'.$header.'
					'.implode("", $rows).'
				</table>
				<script>
					$(function(){
						$(".rdo1:checked").each(function(){
							if($(this).val() < 3){
								$(this).parents("tr").find(".rdo2").attr("disabled", "true").prop("checked",false);
							} else {
								$(this).parents("tr").find(".rdo2").removeAttr("disabled");
							}
						});
					});

					$(".rdo1").click(function() {
						if($(this).val() < 3){
							$(this).parents("tr").find(".rdo2").attr("disabled", "true").prop("checked",false);
						} else {
							$(this).parents("tr").find(".rdo2").removeAttr("disabled");
						}
					});
				</script>';
			}
			elseif($questao->tipo == 5)
			{
				for($i=0;$i<$questao->max_check;$i++){
					$html .= '
					<div class="dv_option">
						<input type="text" name="resposta['.$i.']" value="'.(isset($valor[$i]) ? $valor[$i] : '').'" />
					</div>';
				}
			}
			elseif($questao->tipo == 6)
			{
				$respostas = FormTestesEn::getArrayTipo6();
				foreach($respostas as $id => $texto){
					$html .= '<div class="dv_option">
						<label><input type="radio" name="resposta" value="'.$id.'" '.($id == $valor ? 'checked' : '').'>'.$texto.'</label>
					</div>';
				}
			}
			$html .= '
		</div>';
		return $html;
	}
}