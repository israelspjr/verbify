<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_DefaultTemplate extends Controller_Template
{
	public $template = 'templates/admintemplate';
	public $auth_required = TRUE;
	public $user;
	public $menu, $header;

	public function before()
	{
		parent::before();
		if ($this->auto_render)
		{
			$this->template->title   = '';
			$this->template->content = '';
			$this->template->styles = array();
			$this->template->scripts = array();
		}

		$this->user = Session::instance()->get('adm_user', NULL);
		if($this->auth_required AND is_null($this->user)){
			$this->request->redirect('admin/login');
		} elseif ($this->user->id == ""){
			$this->request->redirect('admin/login');
		}
	}

	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'assets/css/sitestyle.css' => 'screen',
				'assets/fancybox/jquery.fancybox.css?v=2.0.6' => 'screen',
				'assets/css/admin.css' => 'screen',
				'assets/css/dropdownmenu.css' => 'screen',
				'assets/jqueryui/themes/base/jquery.ui.all.css' => 'screen',
				"assets/css/cadastro-candidato.css" => "screen",
				"assets/css/novocurriculo.css" => "screen",
			);
			$scripts = array(
				'assets/js/jquery-1.7.2.min.js',
				'assets/js/jquery.maskedinput-1.3.js',
				//'assets/js/jquery.maskMoney.js',
				'assets/fancybox/jquery.fancybox.js',
				'assets/jqueryui/ui/jquery.ui.core.js',
				'assets/jqueryui/ui/jquery.ui.widget.js',
				'assets/jqueryui/ui/jquery.ui.tabs.js',
			);
			$this->template->styles = array_merge( $styles, $this->template->styles );
			$this->template->scripts = array_merge( $scripts, $this->template->scripts );
		}
		parent::after();
	}
}
?>