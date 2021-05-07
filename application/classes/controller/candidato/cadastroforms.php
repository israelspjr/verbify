<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_CadastroForms extends Controller_AjaxTemplate {

	public function action_viagens()
	{
		$var = array();
		$var["paises"] = ORM::factory("pais")->order_by("name", "ASC")->find_all();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$this->template->content = View::factory('candidato/cv/formviagens', $var);
	}

	public function action_certificacoes()
	{
		$var = array();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->order_by("descricao", "ASC")->find_all();
		$this->template->content = View::factory('candidato/cv/formcertificacoes', $var);
	}

	public function action_graduacoes()
	{
		$var = array();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$var["grauescolar"] = ORM::factory("grauescolar")->order_by("ordem", "ASC")->find_all();
		$var["cursos"] = ORM::factory("curso")->order_by("descricao", "ASC")->find_all();
		$this->template->content = View::factory('candidato/cv/formgraduacoes', $var);
	}

	public function action_outrocurso()
	{
		$var = array();
		try {
			$outro = ORM::factory("curso");
			$outro->descricao = $_REQUEST["outrocurso"];
			$outro->save();
			$this->template->content = '<option value="'.$outro->id.'" selected>'.$outro->descricao.'</option>';
		} catch (ORM_Validation_Exception $e) {
			$this->template->content = '';
		}
	}

	public function action_expprofissional()
	{
		$var = array();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$this->template->content = View::factory('candidato/cv/formexpprofissional', $var);
	}

	public function action_expidioma()
	{
		$var = array();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$this->template->content = View::factory('candidato/cv/formexpidioma', $var);
	}

	public function action_cursos()
	{
		$var = array();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$this->template->content = View::factory('candidato/cv/formcurso', $var);
	}

	public function action_cidades()
	{
		$selcidade = (isset($_REQUEST["cidade"]) ?  $_REQUEST["cidade"] : '');
		$html = '<select name="cidade" class="ipt">
			<option value="0"></option>';
		if(isset($_REQUEST["estado"])){
			$cidades = ORM::factory("estado", $_REQUEST["estado"])->cidades->find_all();
			foreach($cidades as $cid)
				$html .= '<option value="'.$cid->dc_codig.'" '.($selcidade == $cid->dc_codig ? 'selected' : '').'>'.ucwords($cid->vc_cidade).'</option>';
		}
		$html .= '</select>';
		$this->template->content = $html;
	}

	public function action_regioes()
	{
		$selregiao = (isset($_REQUEST["regioes"]) ?  $_REQUEST["regioes"] : array());
		$regioes = ORM::factory("regiaosp")->find_all();
		$chks = array();
		foreach($regioes as $reg)
			$chks[] = '<label><input type="checkbox" name="regioes[]" value="'.$reg->id.'" '.(in_array($reg->id, $selregiao) ? 'checked' : '').'>'.ucwords($reg->descricao).'</label>';
		$this->template->content = View::factory("candidato/cv/regioes")->bind("chks", $chks);
	}

	public function action_regioesbusca()
	{
		$selregiao = (isset($_REQUEST["regiao"]) ?  $_REQUEST["regiao"] : '');
		$html = '<select name="regioes" class="ipt">
			<option value=""></option>';
		$regioes = ORM::factory("regiaosp")->find_all();
		foreach($regioes as $reg)
			$html .= '<option value="'.$reg->id.'" '.($selregiao == $reg->id ? 'selected' : '').'>'.ucwords($reg->descricao).'</option>';
		$html .= '</select>';
		$this->template->content = $html;
	}

}