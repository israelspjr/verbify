<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_Home extends Controller_Candidato_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$session_tal = Session::instance()->get('talen_user', NULL);
		// verifica se tem currículo completo
		$var["aviso"] = $this->showAviso();
		$var["convites"] = $this->showConvites();
		$var["candidato"] = $session_tal;
		$this->template->title = "Área do Candidato";
		if($this->lang=='en') {
			$this->template->content = View::factory('candidato/en/home', $var);
		} else {
			$this->template->content = View::factory('candidato/home', $var);
		}
	}

	public function showAviso()
	{
		$session_tal = Session::instance()->get('talen_user', NULL);
		if(!$session_tal->is_completed()) {
			$html = __('Complete o seu currículo e fique visível aos contratantes agora mesmo!').' <a href="'.URL::site('candidato/cadastrocv').'">'.__('Clique aqui').'</a>.';
			return $html;
		}
		return;
	}

	public function action_nocompleted()
	{
		$this->template->title = "Área do Candidato";
		$this->template->content = '
		<h2>Página Restrita</h2>
		<p class="p_warning">Esta ação só é possível após você completar o seu currículo. <br />'.$this->showAviso().'</p>';
	}

	public function showConvites(){
		$html = '';
		$user = Session::instance()->get('talen_user', NULL);
		$convites = $user->convites->find_all();
		foreach($convites as $row){
			$escola = $row->contacontratante->contratante->getNome();
			$oteste = $row->teste->nome;
			$teste_id = $row->teste->id;
			// busca convites!!
			$html .= '
			<p class="p_warning">
				<strong>'.$escola.'</strong> gostaria que você realizasse o teste <strong>'.$oteste.'</strong>.
				<a href="'.URL::site("candidato/testes/executar/".$teste_id).'">Clique aqui</a> para efetuar o teste agora.
			</p>';
		}
		return $html;
	}

	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p class="p_error">Página não encontrada</p>';
	}

}