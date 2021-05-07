<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_ExcluirCreditos extends Controller_Admin_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		$var["tipo"] = Arr::get($_POST, 'tpconta', 'C');
		// pagination
		$pagination = new Pagination;
		$pagination->page = (isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1);
		$pagination->rows_per_page = 20;
		$pagination->links_per_page = 20;
		$pagination->offset = ($pagination->page - 1) * $pagination->rows_per_page;
		$pagination->append = preg_replace('/page=[0-9]{1,}&/', '', $_SERVER["QUERY_STRING"]);

		// count total
		$contas = ORM::factory("conta");
		$nome = Arr::get($_REQUEST, "nome");
		if($var["tipo"] == "C")
		{
			$contas->join('contratante', 'left')->on("conta.contratante_id", "=", "contratante.id")
				->join('contratante_pf', 'left')->on("contratante_pf.contratante_id", "=", "contratante.id")
				->join('contratante_pj', 'left')->on("contratante_pj.contratante_id", "=", "contratante.id")
				->where_open()
				->where('nome', 'like', '%'.$nome.'%')
				->or_where('razao', 'like', '%'.$nome.'%')
				->where_close()
				->where("contratante.active", "=", "1")
				->order_by("razao")->order_by("nomefantasia");
		} else {
			$contas->join('candidato', 'left')->on("conta.candidato_id", "=", "candidato.id")
				->where('nome', 'like', '%'.$nome.'%')
				->where("candidato.active", "=", "1");
		}
		$contas->where("conta.active", "=", "1")->order_by("nome");
		$total = clone $contas;
		$pagination->total_rows = $total->count_all();

		// get pagina
		$results = $contas
			->limit($pagination->rows_per_page)
			->offset($pagination->offset)->find_all();
		$var["table"] = $this->geraTable($results);
		$var["pagination"] = $pagination;
		$this->template->title = 'Excluir Créditos';
		$this->template->content = View::factory('admin/creditos/retirar', $var);
	}

	private function geraTable($results)
	{
		$table = '';
		if(count($results) > 0)
		{
			$i = 0;
			$trs = array();
			foreach($results as $row)
			{
				$i++;
				$trs[] = '<tr class="'.($i%2==0 ? "tr_even" : "tr_odd").'">
					<td><a href="'.URL::site("admin/excluircreditos/conta/".$row->id).'">'.$row->getNome().'</a></td>
					<td>'.$row->saldo.'</td>
				</tr>';
				$table = '
				<table class="tb_lista">
					<tr>
						<th>Nome / Razão Social</th>
						<th>Saldo</th>
					</tr>
					'.implode("", $trs).'
				</table>';
			}
		}
		return $table;
	}

	public function action_conta()
	{
		$id = $this->request->param("id");
		$conta = ORM::factory("conta", $id);
		if(!$conta->loaded())
		{
			$this->request->redirect("admin/creditos/retirar");
		}
		if (HTTP_Request::POST == $this->request->method()) {
			try {
				$qtde = abs((int)Arr::get($_POST, "qtde", 0));
				if($qtde == 0)
					throw new Exception ('Quantidade inválida');
				if($conta->saldo < $qtde)
					throw new Exception ('Saldo indisponível');
				$conta->creditar($qtde*(-1), 'Estorno de créditos');
			} catch(exception $e) {
				$var["erro"] = $e->getMessage();
			}
		}
		$conta = ORM::factory("conta", $id);
		$var["saldo"] = $conta->saldo;
		$logs = array();
		$consumos = $conta->consumologs->where('consumo_qtde' , '<>', '0')->order_by("data", "DESC")->limit(20)->find_all();
		foreach($consumos as $row) {
			$logs[] = array("data" => $row->data, "descricao" => $row->descricao, "valor" => $row->consumo_qtde);
		}
		$var["logs"] = $logs;
		$var["conta"] = $conta;

		$this->template->title = 'Excluir Créditos';
		$this->template->content = View::factory('admin/creditos/retirarconta', $var);
	}
}
?>