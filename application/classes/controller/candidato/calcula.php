<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_Calcula extends Controller_AjaxTemplate {

	public function action_precocreditos()
	{
		$preco = Model_Valor::getPrecoCredito();
		$creditos = (isset($_REQUEST["creditos"]) ? $_REQUEST["creditos"] : 0);
		$total = $preco * $creditos;
		$this->template->content =  Helper::number_format($total);
	}
}