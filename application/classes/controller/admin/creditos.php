<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Creditos extends Controller_Admin_DefaultTemplate {

    public function action_index()
    {
		$var = array();
		
		$opts = array();
		$var['title'] = 'Extrato de Consumo';

		// contratante
		$selcontratante = (Arr::get($_POST, "contratante") <> '' ? Arr::get($_POST, "contratante") : '');
		$contratantes = ORM::factory('contratante')
			->where('active', '=', '1')
			->find_all();
		$opts[] = '<option value="" '.($selcontratante == '' ? 'selected' : '').'>Todos</option>';
		foreach($contratantes as $row)
			$opts[] = '<option value="'.$row->id.'" '.($selcontratante == $row->id ? 'selected' : '').'>'.$row->getNome().'</option>';
		$var['opt_contratantes'] = $opts;
		// mês
		$var["mes"] = array(1=>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
		$var["sel_mes"] = Date("m");
		// ano
		$var["ano"] = Date("Y");
		$var["sel_ano"] = Date("Y");
		if(isset($_POST["pesquisar"])){
			$var["sel_mes"] = Arr::get($_POST, "mes");
			$var["sel_ano"] = Arr::get($_POST, "ano");
		}
		if($selcontratante <> ''){
			$user =  ORM::factory("contratante", $selcontratante);
			$var["saldoanterior"] = $user->conta->getSaldoAnterior($var["sel_mes"], $var["sel_ano"]);
			$var["logs"] = $user->conta->getMonthLogs($var["sel_mes"], $var["sel_ano"]);
		} else {
			$var["logs"] =  $this->getTodosMonthLogs($var["sel_mes"], $var["sel_ano"]);
		}

		$this->template->title = 'Extrato de Consumo';
		$this->template->content = View::factory('admin/creditos/extrato', $var);
		
		
	}

    public function action_cortesia()
    {
		$var = array();
		$opts = array();
		$var['title'] = 'Cadastrar Cortesia';

		// contratante
		$selcontratante = (Arr::get($_POST, "contratante") <> '' ? Arr::get($_POST, "contratante") : '');
		$contratantes = ORM::factory('contratante')
			->where('active', '=', '1')
			->find_all();
		foreach($contratantes as $row)
			$opts[] = '<option value="'.$row->id.'" '.($selcontratante == $row->id ? 'selected' : '').'>'.$row->getNome().'</option>';
		$var['opt_contratantes'] = $opts;

		$benef = ORM::factory("contratante", $selcontratante);
		if(isset($_POST["cortesia"]) AND $benef->loaded()){
			$qtde = Arr::get($_POST, "qtde");
			$descricao = 'Cortesia ProfCerto';
			if(is_numeric($qtde) AND $qtde <> 0){
				$benef->conta->creditar($qtde, $descricao);
				$this->request->redirect("admin/creditos");
			} else {
				$var["error"] = 'Quantidade inválida';
			}
		}

		$this->template->title = 'Cadastrar Cortesia';
		$this->template->content = View::factory('admin/creditos/cortesia', $var);
	}

	public function getTodosMonthLogs($mes, $ano){
		return ORM::factory("consumolog")
			->where(DB::expr('MONTH(data)') , '=', $mes)
			->where(DB::expr('YEAR(data)') , '=', $ano)
			->where('consumo_qtde' , '<>', '0')
			->find_all();
	}
}
?>