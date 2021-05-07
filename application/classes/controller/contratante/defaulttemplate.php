<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contratante_DefaultTemplate extends Controller_Template
{
	public $template = 'templates/defaulttemplate';
	public $auth_required = TRUE;
	public $user;

	public function before()
	{
		parent::before();
		if ($this->auto_render)
		{
			$this->template->title   = '';
			$this->template->content = '';
			$this->template->styles = array();
			$this->template->scripts = array();
			$this->template->header = '';
		}

		$this->user = Session::instance()->get("contrat_user", NULL);
		if($this->auth_required AND is_null($this->user)){
			$this->request->redirect('contratante/login');
		} elseif ($this->user->id == ""){
			$this->request->redirect('contratante/login');
		}
	}

	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'assets/css/sitestyle.css' => 'screen',
				'assets/css/cadastro-candidato.css' => 'screen',
				'assets/css/cadastro-contratante.css' => 'screen',
				'assets/css/login.css' => 'screen',
				'assets/colorbox/colorbox.css' => 'screen',
				'assets/css/contato.css' => 'screen',
				'assets/fancybox/jquery.fancybox.css?v=2.0.6' => 'screen',
				'assets/css/contratante.css' => 'screen',
				'assets/css/menu.css' => 'screen',
				'assets/jqueryui/css/redmond/jquery-ui-1.8.21.custom.css' => 'screen',
			);
			$scripts = array(
				'assets/js/jquery-1.7.2.min.js',
				'assets/js/jquery.maskedinput-1.3.js',
				'assets/fancybox/jquery.fancybox.js',
				'assets/js/scripts.js',
				'assets/colorbox/js/jquery.colorbox-min.js',
				'assets/jqueryui/js/jquery-ui-1.8.21.custom.min.js',
			);
			$this->template->styles = array_merge( $styles, $this->template->styles );
			$this->template->scripts = array_merge( $scripts , $this->template->scripts);

			$var["user"] = $this->user;

			$hello = Helper::hello();
			$this->template->header = View::factory("templates/header")->bind("hello", $hello);
			$this->template->content = '
			<div class="content" style="margin-top: 30px;">
				<div class="dv_quadrado_invisivel vermelho"></div>
				<h2 class="h2_title txt-vermelho" style="margin-top: 83px; font-size: 26pt;">contratante</h2>
				'.View::factory("templates/menucontratante", $var).'
				<div class="clear"></div>
				<div id="content">
					'.$this->template->content.'
				</div>
			</div>';
		}
		parent::after();
	}
}