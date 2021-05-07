<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_AjaxForms extends Controller_AjaxTemplate {

	public function action_cidades()
	{
		$selcidade = (isset($_REQUEST["cidade"]) ?  $_REQUEST["cidade"] : '');
		$name = (isset($_REQUEST["name"]) ?  $_REQUEST["name"] : 'cidade');
		$html = '<select name="'.$name.'" class="ipt">
			<option value=""></option>';
		if(isset($_REQUEST["estado"])){
			$cidades = ORM::factory("estado", $_REQUEST["estado"])->cidades->find_all();
			foreach($cidades as $cid)
				$html .= '<option value="'.$cid->dc_codig.'" '.($selcidade == $cid->dc_codig ? 'selected' : '').'>'.ucwords($cid->vc_cidade).'</option>';
		}
		$html .= '</select>';
		$this->template->content = $html;
	}

	public function action_cidadesbusca()
	{
		$selcidade = (isset($_REQUEST["cidade"]) ?  $_REQUEST["cidade"] : '');
		$name = (isset($_REQUEST["name"]) ?  $_REQUEST["name"] : 'cidade');
		$html = '<select name="'.$name.'" class="ipt">
			<option value="">Indiferente</option>';
		if(isset($_REQUEST["estado"])){
			$cidades = ORM::factory("estado", $_REQUEST["estado"])->cidades->find_all();
			foreach($cidades as $cid)
				$html .= '<option value="'.$cid->dc_codig.'" '.($selcidade == $cid->dc_codig ? 'selected' : '').'>'.ucwords($cid->vc_cidade).'</option>';
		}
		$html .= '</select>';
		$this->template->content = $html;
	}
	
	public function action_regioesbusca()
	{
		$selregiao = (isset($_REQUEST["regiao"]) ?  $_REQUEST["regiao"] : '');
		$html = '<select name="regioes" class="ipt">
			<option value="">Indiferente</option>';
		$regioes = ORM::factory("regiaosp")->find_all();
		foreach($regioes as $reg)
			$html .= '<option value="'.$reg->id.'" '.($selregiao == $reg->id ? 'selected' : '').'>'.ucwords($reg->descricao).'</option>';
		$html .= '</select>';
		$this->template->content = $html;
	}	
	
	public function action_regioes()
	{
		$selregiao = (isset($_REQUEST["regiao"]) ?  $_REQUEST["regiao"] : '');
		$html = '<select name="regioes" class="ipt">';
		$regioes = ORM::factory("regiaosp")->find_all();
		foreach($regioes as $reg)
			$html .= '<option value="'.$reg->id.'" '.($selregiao == $reg->id ? 'selected' : '').'>'.ucwords($reg->descricao).'</option>';
		$html .= '</select>';
		$this->template->content = $html;
	}
}
?>