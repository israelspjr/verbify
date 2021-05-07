<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_CadastroForms extends Controller_AjaxTemplate {

	// lista de questões
	public function action_carregaquestoes()
	{
		$html = '';
		$teste_id = (isset($_POST["teste_id"]) ? $_POST["teste_id"] : 0);
		$this->validaTeste($teste_id);

		$teste = ORM::factory("teste", $teste_id);
		$questoes = $teste->questoes->find_all();
		if(count($questoes) > 0){
			foreach($questoes as $que){
				$html .= '
				<div class="quest">
					<div class="acoes">
						<a href="'.URL::site('admin/questoes/editar/'.$que->id).'">Editar</a> |
						<a href="'.URL::site('admin/questoes/excluir/'.$que->id).'" onClick="if(!confirm(\'Você tem certeza que deseja excluir esta questão?\')){ return false; }">Excluir</a>
					</div>
					<div id="tabs" style="margin-top: 10px;">
						<ul>
							<li><a href="#tabs-1">Português</a></li>
							<li><a href="#tabs-2">Inglês</a></li>
						</ul>
						<div id="tabs-1">
							'.FormTestes::getHtmlAdminShowQuestion($que).'
						</div>
						<div id="tabs-2">
							'.FormTestes::getHtmlAdminShowQuestionIngles($que).'
						</div>
					</div>
				</div>
				<script type="text/javascript">
				$(function(){
					$( "#tabs" ).tabs();
				});
				</script>	';
			}
		} else {
			$html = '<p class="p_warning">Nenhuma questão cadastrada</p>';
		}
		$this->template->content = $html;
	}

	// lista de questões
	public function action_carregaquestoesidiomas()
	{
		$html = '';
		$teste_id = (isset($_POST["teste_id"]) ? $_POST["teste_id"] : 0);
		$this->validaTeste($teste_id);

		$teste = ORM::factory("teste", $teste_id);
		$questoes = $teste->questoes->find_all();
		if(count($questoes) > 0){
			foreach($questoes as $que){
				$html .= '
				<div class="quest">
					<div class="acoes">
						<a href="'.URL::site('admin/questoesidiomas/editar/'.$que->id).'">Editar</a> |
						<a href="'.URL::site('admin/questoesidiomas/excluir/'.$que->id).'" onClick="if(!confirm(\'Você tem certeza que deseja excluir esta questão?\')){ return false; }">Excluir</a>
					</div>
					'.FormTestes::getHtmlAdminShowQuestion($que).'
				</div>';
			}
		} else {
			$html = '<p class="p_warning">Nenhuma questão cadastrada</p>';
		}
		$this->template->content = $html;
	}

	function validaTeste($id)
	{
		$teste = ORM::factory("teste", $id);
		if(!$teste->loaded()){
			$this->request->redirect("admin/cadastroforms/notfound");
		}
		if($teste->active==0){
			$this->request->redirect("admin/cadastroforms/notfound");
		}
	}

	public function action_notfound()
	{
		$this->template->title = 'Página não encontrada';
		$this->template->content = '<p class="p_error">Página não encontrada</p>';
	}

	public function action_respostas()
	{
		$var = array();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$tipo = (isset($_POST["tipo"]) ? $_POST["tipo"] : 1);
		$i = $var["i"];
		$questao = ORM::factory("questao");
		$this->template->content = FormTestes::getOpcoesCadastro($tipo, $i);
	}

	public function action_respostasen()
	{
		$var = array();
		$var["i"] = (isset($_POST["posicao"]) ? $_POST["posicao"] : 1);
		$tipo = (isset($_POST["tipo"]) ? $_POST["tipo"] : 1);
		$i = $var["i"];
		$questao = ORM::factory("questao");
		$this->template->content = FormTestesEn::getOpcoesCadastro($tipo, $i);
	}
	/*
	public function getOpcoes($tipo, $i, $value = '')
	{
		if($tipo == 1){
			$html = '
			<label><input type="radio" name="valor['.$i.']" value="C" '.($value == 'C' ? 'checked' : '').'/>Certo</label>
			<label><input type="radio" name="valor['.$i.']" value="E" '.($value == 'E' ? 'checked' : '').'/>Errado</label>';
		} elseif($tipo == 2) {
			$options = array();
			for($j=1;$j<=10;$j++){
				$options[] = '<option value="'.$j.'" '.($value==$j ? 'selected' : '').'>'.$j.'</option>';
			}
			$html = 'Peso <select name="valor['.$i.']">'.implode("", $options).'</select>';
		} elseif($tipo == 3) {
			$html = 'Letra <input type="text" name="valor['.$i.']" maxlength="1" value="'.$value.'">';
		}
		return $html;


					<option value="1">certo/errado</option>
					<option value="2">perfil</option>
					<option value="3">escolhas</option>
					<option value="4">grade</option>
					<option value="5">dissertativa</option>
					<option value="6">concordo/discordo</option>

	}


	public function action_deletequestao()
	{
		$id = (isset($_POST["id"]) ? $_POST["id"] : 0);
		$questao = ORM::factory("questao", $id);
		$questao->delete();
		$this->template->content = '';
	}

	public function action_editquestao()
	{
		$id = (isset($_POST["id"]) ? $_POST["id"] : 0);
		$questao = ORM::factory("questao", $id);
		$respostas = $questao->respostas->order_by("id", "ASC")->find_all();
		$html = '';
		foreach($respostas as $row) {
			$html .= '
			<div id="dv_resposta'.$row->ordem.'">
				<div style="float: left;">Resposta '.$row->ordem.') <input type="text" name="texto['.$row->ordem.']" value="'.$row->texto.'" class="iptresposta"/></div>
				<div style="float: left; margin-left: 20px;">'.$this->getOpcoes($questao->teste->tipo, $row->ordem, $row->valor).'</div>
				<br class="clear"/>
			</div>';
		}
		$var["questao"] = $questao;
		$var["respostas"] = $html;
		$this->template->content = View::factory('admin/teste/editquestao', $var);
	}


	public function action_carregaresultados()
	{
		$html = '';
		$teste_id = (isset($_POST["teste_id"]) ? $_POST["teste_id"] : 0);
		$teste = ORM::factory("teste", $teste_id);
		$resultados = $teste->resultados->order_by("min","ASC")->order_by("letra","ASC")->find_all();
		if(count($resultados) > 0){
			foreach($resultados as $row){
				$html .= '
				<div class="dv_resultado">
					<div class="acoes">
						<a href="#" onClick="editar('.$row->id.');">Editar</a> |
						<a href="#" onClick="excluir('.$row->id.');">Excluir</a>
					</div>
					'.$row->regex.'<br />
					'.$row->texto.'
				</div>';
			}
		} else {
			$html = '<p class="nenhum">Nenhuma questão cadastrada</p>';
		}
		$this->template->content = $html;
	}

	public function action_deleteresultado()
	{
		$id = (isset($_POST["id"]) ? $_POST["id"] : 0);
		$resultado = ORM::factory("resultado", $id);
		$resultado->delete();
		$this->template->content = '';
	}

	public function action_editresultado()
	{
		$id = (isset($_POST["id"]) ? $_POST["id"] : 0);
		$var["resultado"] = ORM::factory("resultado", $id);
		$var["teste"] = $var["resultado"]->teste;
		$this->template->content = View::factory('admin/teste/editresultado', $var);
	}
	*/
}
?>