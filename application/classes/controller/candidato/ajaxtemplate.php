<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_AjaxTemplate extends Controller_Template
{
	public $template = 'templates/ajaxcontratante';
	public $auth_required = TRUE;
	public $user;
	public $menu, $header;
	public $lang;

	public function before()
	{
		if (in_array($this->request->action(), array('candidatarse')))
        {
            $this->template = 'templates/ajax';
        }
		parent::before();

		$lng = Request::instance()->param('lang');
		i18n::$lang = $lng;
		$this->lang = $lng;

		if ($this->auto_render)
		{
			$this->template->title   = '';
			$this->template->content = '';
			$this->template->styles = array();
			$this->template->scripts = array();
		}

		$this->user = Session::instance()->get("talen_user", NULL);
		if($this->auth_required AND is_null($this->user)){
			$this->request->redirect('candidato/login');
		} elseif ($this->user->id == ""){
			$this->request->redirect('candidato/login');
		}
	}

	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'assets/css/sitestyle.css' => 'screen',
			);
			$scripts = array(
				'assets/js/jquery-1.7.2.min.js',
			);
			$this->template->styles = array_merge( $styles, $this->template->styles );
			$this->template->scripts = array_merge( $scripts , $this->template->scripts);
		}
		parent::after();
	}
}