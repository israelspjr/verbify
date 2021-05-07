<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Admin_Home extends Controller_Admin_DefaultTemplate {
	
	public function action_index()
	{
		$var = array();
		$this->template->title = "Administração";
		$this->template->content = View::factory('admin/home', $var);
	}

	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p class="p_error">Página não encontrada</p>';
	}
	
}