<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_CurriculoTemplate extends Controller_Candidato_DefaultTemplate
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
		}

		$this->user = Session::instance()->get("talen_user", NULL);
		if($this->auth_required AND is_null($this->user)){
			$this->request->redirect('candidato/login');
		} elseif ($this->user->id == ""){
			$this->request->redirect('candidato/login');
		}
		
		$var["tal"] = $this->user;
	}

	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'assets/css/sitestyle.css' => 'screen',
				'assets/css/cadastro-candidato.css' => 'screen',
				'assets/fancybox/jquery.fancybox.css?v=2.0.6' => 'screen',
				'assets/colorbox/colorbox.css' => 'screen',
				'assets/css/candidato.css' => 'screen',
				'assets/css/login.css' => 'screen',
				'assets/css/contato.css' => 'screen',
				'assets/css/menu.css' => 'screen',
			);
			$scripts = array(
				'assets/js/jquery-1.7.2.min.js',
				'assets/js/jquery.maskedinput-1.3.js',
				'assets/fancybox/jquery.fancybox.js',
				'assets/colorbox/js/jquery.colorbox-min.js',
				'assets/js/scripts.js',
			);
						
			$this->template->styles = array_merge( $this->template->styles, $styles );
			$this->template->scripts = array_merge( $scripts , $this->template->scripts);
			$this->template->content = '<div id="content">'.View::factory("templates/menucurriculo").$this->template->content.'
			</div>';
			
			
		}
		parent::after();
	}	
}