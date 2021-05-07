<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AjaxTemplate extends Controller_Template
{
	public $template = 'templates/ajax';
	public $auth_required = FALSE;
	public $user;
	public $lang;

	public function before()
	{
		parent::before();

		$lng = Request::instance()->param('lang');
		i18n::$lang = $lng;
		$this->lang = $lng;

		if ($this->auto_render)
		{
			$this->template->title   = '';
			$this->template->content = '';
			$this->template->styles = array();
			$this->template->scripts = array(
				'assets/js/jquery-1.7.2.min.js',
				'assets/js/jquery.maskedinput-1.3.js',
			);
		}
		$this->user = Session::instance()->get("talen_user", NULL);
		if($this->auth_required AND is_null($this->user)){
			$this->request->redirect('talento/login');
		}
		$var["tal"] = $this->user;
	}

	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'assets/fancybox/jquery.fancybox.css?v=2.0.6' => 'screen',
			);
			$scripts = array(
				'assets/js/jquery-1.7.2.min.js',
				'assets/js/jquery.maskedinput-1.3.js',
				'http://releases.flowplayer.org/js/flowplayer-3.2.11.min.js',
			);
			$this->template->styles = array_merge( $styles, $this->template->styles );
			$this->template->scripts = array_merge( $scripts , $this->template->scripts);
		}
		parent::after();
	}

}