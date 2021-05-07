<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_TemplateHome {

	public function action_index()
	{
		$var = array();
		$this->template->title = 'Home';
		$var['banners'] = ORM::factory('banners')
						->where("language", "=", $this->lang)
						->order_by("sort", "ASC")
						->find_all();
		
		$this->template->content = View::factory('home', $var);
	}

	public function action_maisinfo()
	{
		$page = (isset($_GET["page"]) ? $_GET["page"] : '');
		switch($page) {
			case 2:
				$var["start"] = 2; break;
			case 3:
				$var["start"] = 3; break;
			case 4:
				$var["start"] = 4; break;
			default:
				$var["start"] = 0;
		}
		$this->template->title = 'Home';
		if($this->lang == 'en') {
			$var["maisinfolang"] = View::factory("maisinfo/maisinfo_en");
		} else {
			$var["maisinfolang"] = View::factory("maisinfo/maisinfo_pt");
		}
		$this->template->content = View::factory('maisinfo', $var);
		$this->template->scripts = array('assets/jcarousel/lib/jquery.jcarousel.min.js');
		$this->template->styles = array('assets/jcarousel/skins/tango/skin.css' => 'screen');
	}

	public function action_disal()
	{
		$contador = ORM::factory("contador", 1);
		$contador->somavisita();
		$this->request->redirect("home");
	}

	public function action_linkedin()

	{
		$contador = ORM::factory("contador", 1);
		$contador->somavisita();
		$this->request->redirect("home");
	}



} // End Home
