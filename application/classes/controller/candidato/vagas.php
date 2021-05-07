<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_Vagas extends Controller_Candidato_DefaultTemplate {

	public function action_index()
	{
		$var = array();

		$user = Session::instance()->get("talen_user", NULL);
		if(!$user->is_completed()){
			$this->incomplete();
			return;
		}

		if(isset($_POST["buscar"])) {

			$estado = Arr::get($_POST, "estado");
			$cidade = Arr::get($_POST, "cidade");
			$regiao = Arr::get($_POST, "regioes");
			$idioma = Arr::get($_POST, "idioma");

			$vagas = ORM::factory('vaga')->where('active', '=', '1');
			if($estado <> '')
				$vagas->where('estado_id', '=',  $estado);
			if($cidade <> '' AND $cidade <> '0')
				$vagas->where('cidade_id', '=', $cidade);
			if($regiao <> '' AND $regiao <> '0')
				$vagas->where('regiao_id', '=', $regiao);
			if($idioma <> '') {
				$vagas->where('idioma_id', '=', $idioma);
			}
			$var['vagas'] = $vagas->find_all();
			$var['count'] = count($var['vagas']);
		}

		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->find_all();
		$var["estados"] = ORM::factory('estado')->find_all();
		$this->template->title = 'Buscar Vagas';
		$this->template->content = View::factory('candidato/vagas', $var)
			->set('values', $_POST);
		$this->template->styles = array('assets/fancybox/jquery.fancybox-1.3.4.css' => 'screen');
		$this->template->scripts = array('assets/fancybox/jquery.fancybox-1.3.4.pack.js');
	}

	public function incomplete(){
		$this->template->title = 'Perfil incompleto';
		$this->template->content = '<p class="p_warning">'.__('Complete o seu perfil para poder candidatar-se às vagas.'). ' <a href="'.URL::site('candidato/cadastrocv').'">'.__('Clique aqui').'</a></p>';
	}
}
?>