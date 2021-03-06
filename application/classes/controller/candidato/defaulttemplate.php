<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Candidato_DefaultTemplate extends Controller_Template

{

	public $template = 'templates/defaulttemplate';

	public $auth_required = TRUE;

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

			$this->template->scripts = array();

			$this->template->header = '';

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

				'assets/css/cadastro-candidato.css' => 'screen',

				'assets/css/cadastro-contratante.css' => 'screen',

				'assets/fancybox/jquery.fancybox.css?v=2.0.6' => 'screen',

				'assets/colorbox/colorbox.css' => 'screen',

				'assets/css/login.css' => 'screen',

				'assets/css/contato.css' => 'screen',

				'assets/css/candidato.css' => 'screen',

				'assets/css/menu.css' => 'screen',

			);

			$scripts = array(

				'assets/js/jquery-1.7.2.min.js',

				'assets/js/jquery.maskedinput-1.3.js',

				'assets/fancybox/jquery.fancybox.js',

				'assets/colorbox/js/jquery.colorbox-min.js',

				'assets/js/scripts.js',

				'assets/js/jquery.tools.min.js',

				'http://releases.flowplayer.org/js/flowplayer-3.2.11.min.js',
				
				'assets/js/vendor/jquery.ui.widget.js',
				
				'assets/js/jquery.iframe-transport.js',
				
				'assets/js/jquery.fileupload.js',
				
				'assets/js/jquery.ajaxform.js',

			);

			$this->template->styles = array_merge( $styles, $this->template->styles );

			$this->template->scripts = array_merge( $scripts , $this->template->scripts);



			$hello = Helper::hello();

			$this->template->header = View::factory("templates/header")->bind('hello', $hello);

			$this->template->content = '

			<div class="content" style="margin-top: 30px;">

				<div class="dv_quadrado_invisivel verde"></div>

				<h2 class="h2_title txt-verde">'.__('professor').'</h2>

				'.View::factory("templates/menucandidato").'

				<div class="clear"></div>

				<div id="content">

					'.$this->template->content.'

				</div>

			</div>';

		}

		parent::after();

	}

}