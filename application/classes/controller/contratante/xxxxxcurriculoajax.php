<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_CurriculoAjax extends Controller_Contratante_DefaultTemplate {

	public function action_ver()
	{
		$var = array();
		$user = Session::instance()->get("contrat_user", NULL);
		$this->template->title = 'Currículo';
		$this->template->content = View::factory('contratante/curriculo/curriculo', $var);
	}
}
?>