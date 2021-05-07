<?php defined('SYSPATH') or die('No direct script access.');

class Controller_QuemSomos extends Controller_DefaultTemplate {

	public function action_index()
	{
		$this->template->title = 'Home';
		$this->template->content = View::factory('quemsomos');
		$this->template->menuactive = 'quemsomos';
	}

} // End Home
