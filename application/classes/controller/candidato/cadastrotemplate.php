<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Candidato_CadastroTemplate extends Controller_Template
{
	public $template = 'templates/defaulttemplate';
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
			$this->template->styles = array(
				'assets/css/sitestyle.css' => 'screen',
				'assets/css/cadastro-candidato.css' => 'screen',
			);
			$this->template->scripts = array(
				'assets/js/jquery-1.7.2.min.js',
				'assets/js/jquery.maskedinput-1.3.js',
			);
		}

		$this->user = Session::instance()->get("current_candidato", NULL);
		if($this->auth_required AND is_null($this->user)){
			$this->request->redirect('candidato/login');
		} elseif ($this->user->id == ""){
			$this->request->redirect('candidato/login');
		}

		$var["tal"] = $this->user;
	}

}