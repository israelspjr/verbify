<?php defined('SYSPATH') or die('No direct script access.');



class Controller_DefaultTemplate extends Controller_Template {



	public $template = 'templates/defaulttemplate';



	public function before()

	{

		parent::before();



		$lng = Request::instance()->param('lang');

		i18n::$lang = $lng;



		if ($this->auto_render)

		{

			$this->template->title   = '';

			$this->template->content = '';

			$this->template->styles = array();

			$this->template->scripts = array();

			$this->template->header = '';

			$this->template->menuactive = '';

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

				'assets/css/rhinoslider-1.05.css' => 'screen',

				'assets/css/lightboxstyle.css' => 'screen'

			);

			$scripts = array(
			
	//			'assets/js/jquery.min.js',

				'assets/js/jquery-1.7.2.min.js',

				'assets/js/jquery.maskedinput-1.3.js',

				'assets/colorbox/js/jquery.colorbox-min.js',

				'assets/js/easing.js',

				'assets/js/rhinoslider-1.05.min.js',

				'assets/js/mousewheel.js',

				'assets/js/scripts.js',

				'assets/js/cadastro.js',
				
				'assets/js/vendor/jquery.ui.widget.js',
				
				'assets/js/jquery.iframe-transport.js',
				
				'assets/js/jquery.fileupload.js',
				
				

			);



			$this->template->styles = array_merge($styles, $this->template->styles);

			$this->template->scripts = array_merge($scripts, $this->template->scripts);



			$hello = Helper::hello();

			$this->template->header = View::factory("templates/header")

				->bind("hello", $hello)

				->bind("active", $this->template->menuactive);

		}

		parent::after();

	}



}