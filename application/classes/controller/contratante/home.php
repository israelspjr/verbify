<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Contratante_Home extends Controller_Contratante_DefaultTemplate {
	
	public function action_index()
	{
		$var = array();
		$this->template->title = "Área do Contratante";
		$this->template->content = View::factory('contratante/home', $var);
	}

	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p class="p_error">Página não encontrada</p>';
	}
	
}