<?php 

defined('SYSPATH') or die('No direct script access.');

class FormTestes {

	public static function getOpcoesCadastro($tipo, $i, $texto = '', $value = '')
	{
		if($tipo == 1) {
			return FormTestes::getOpcoesCertoErrado($i, $texto, $value);
		} elseif($tipo == 2) {
			return FormTestes::getOpcoesPerfil($i, $texto, $value);
		} elseif($tipo == 3) {
			return FormTestes::getOpcoesEscolha($i, $texto, $value);
		}
	}

	public static function getOpcoesCertoErrado($i, $texto ='', $value = '')
	{
		$html = '
		<div id="dv_resposta'.$i.'" class="resp'.$i.'">';
			//$html.= '<div style="float: left;">'.Helper::intToChar($i).') <input type="text" name="texto['.$i.']" value="'.$texto.'" class="iptresposta"/></div>';
			$html.= '<div style="float: left;"><input type="text" name="texto['.$i.']" value="'.$texto.'" class="iptresposta"/></div>';
			$html.= '<div style="float: left; margin-left: 20px;">
				<label><input type="radio" name="valor['.$i.']" value="C" '.($value == 'C' ? 'checked' : '').'/> Certo</label>
				<label><input type="radio" name="valor['.$i.']" value="E" '.($value == 'E' ? 'checked' : '').'/> Errado</label>
			</div>
			<a style="cursor: pointer; margin-left: 10px;" onclick="$(\'.resp'.$i.'\').remove();">remover</a>
			<br class="clear"/>
		</div>';
		return $html;
	}

	public static function getOpcoesPerfil($i, $texto ='', $value = '')
	{
		$perfil = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$html = '
		<div id="dv_resposta'.$i.'"  class="resp'.$i.'">';
			//$html.= '<div style="float: left;">'.Helper::intToChar($i).') <input type="text" name="texto['.$i.']" value="'.$texto.'" class="iptresposta"/></div>';
			$html.= '<div style="float: left;"><input type="text" name="texto['.$i.']" value="'.$texto.'" class="iptresposta"/></div>';
			$html.= '<div style="float: left; margin-left: 20px;">
				<select name="valor['.$i.']">';
					foreach($perfil as $letra)
						$html .= '<option value="'.$letra.'" '.($letra == $value ? 'selected' : '').'>'.$letra.'</option>';
					$html .= '
				</select>
				<a style="cursor: pointer; margin-left: 10px;" onclick="$(\'.resp'.$i.'\').remove();">remover</a>
			</div>
			<br class="clear"/>
		</div>';
		return $html;
	}

	public static function getOpcoesEscolha($i, $texto ='')
	{
		$html = '
		<div id="dv_resposta'.$i.'"  class="resp'.$i.'">';
			$html .= '<div style="float: left;"><input type="text" name="texto['.$i.']" value="'.$texto.'" class="iptresposta"/></div>';
			$html .= '<a style="cursor: pointer; margin-left: 10px;" onclick="$(\'.resp'.$i.'\').remove();">remover</a><br class="clear"/>
		</div>';
		return $html;
	}

	// html da exibicao da questao para o admin
	public static function getHtmlAdminShowQuestion($questao)
	{
		$html = '';
		// depende do tipo de questao
		if($questao->topico <> ""){
			$html .= '<h4>'.$questao->topico.'</h4>';
		}
		$html .= $questao->enunciado.'<div class="dv_alternativas">';
		$respostas = $questao->respostas->order_by("id", "ASC")->find_all();
		if($questao->tipo == 1 OR $questao->tipo == 2 OR $questao->tipo == 3){
			$i =1;
			foreach($respostas as $resp){
				if($questao->tipo == 1 OR $questao->tipo == 2) {
					//$html .= Helper::intToChar($i).') '.$resp->texto.' ('.$resp->valor.')<br />';
					$html .= '<p>'.$resp->texto.' ('.$resp->valor.')</p>';
				} else {
					//$html .= Helper::intToChar($i).') '.$resp->texto.' <br />';
					$html .= '<p>'.$resp->texto.'</p>';
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
			$html .= '<p>concordo plenamente</p>';
			$html .= '<p>concordo parcialmente</p>';
			$html .= '<p>discordo</p>';
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
		return array(1 =>"concordo plenamente", "concordo parcialmente", "discordo");
	}

	public static function getRowsGrade()
	{
		return array(
			"Ter ética",
			"Ser flexível",
			"Conhecer sobre negócios",
			"Ser bem-informado",
			"Ter raciocínio rápido",
			"Ter visão sistêmica",
			"Ter visão detalhada",
			"Ter segurança",
			"Ser líder",
			"Planejar",
			"Saber ouvir",
			"Ser tranquilo",
			"Influenciar as pessoas",
		);
	}

	public static function getColsGrade()
	{
		return array(
			1 => "Sou assim sempre",
			"Quase sempre sou assim",
			"Sou assim às vezes",
			"Quase nunca sou assim",
			"Nunca sou assim",
			"Gostaria de ser assim",
			"Não preciso ser assim"
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
		$html = '
		<p class="p_pergunta">
			'.$questao->enunciado.'
		</p>
		<div class="dv_alternativas">';
			if($questao->tipo == 1 OR $questao->tipo == 2)
			{
				$respostas = $questao->respostas->order_by("id", "ASC")->find_all();
				foreach($respostas as $row){
					$html .= '<div class="dv_option">
						<label><input type="radio" name="resposta" value="'.$row->id.'" '.($row->id == $valor ? 'checked' : '').'>'.$row->texto.'</label>
					</div>';
				}
			}
			elseif($questao->tipo == 3)
			{
				$respostas = $questao->respostas->order_by("id", "ASC")->find_all();
				foreach($respostas as $row){
					$html .= '<div class="dv_option">
						<label><input type="checkbox" name="resposta[]" value="'.$row->id.'" '.($row->id == $valor ? 'checked' : '').' class="tipo3">'.$row->texto.'</label>
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
				$gradeopts = FormTestes::getRowsGrade();
				$gradecols = FormTestes::getColsGrade();
				$gradecols1 = FormTestes::getColsGrade1();
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
				$respostas = FormTestes::getArrayTipo6();
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