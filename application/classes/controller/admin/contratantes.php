<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Contratantes extends Controller_Admin_DefaultTemplate {

	public function action_index()
	{
		$var = array();
		// pagination
		$pagination = new Pagination;
		$pagination->page = (isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1);
		$pagination->rows_per_page = 100;
		$pagination->links_per_page = 20;
		$pagination->offset = ($pagination->page - 1) * $pagination->rows_per_page;
		$pagination->append = preg_replace('/page=[0-9]{1,}&/', '', $_SERVER["QUERY_STRING"]);

		// count total
		$contratantes = ORM::factory("contratante")->where("active", "=", "1");
		if(isset($_REQUEST["nome"])) {
			$contratantes->join('contratante_pf', 'left')->on("contratante_pf.contratante_id", "=", "contratante.id")
				->join('contratante_pj', 'left')->on("contratante_pj.contratante_id", "=", "contratante.id")
				->where_open()
				->where('nome', 'like', '%'.$_REQUEST["nome"].'%')
				->or_where('razao', 'like', '%'.$_REQUEST["nome"].'%')
				->or_where('nomefantasia', 'like', '%'.$_REQUEST["nome"].'%')
				->where_close();
		}
		$contratantes->order_by("dtcadastro");
		$total = clone $contratantes;
		$pagination->total_rows = $total->count_all();

		// get pagina
		$results = $contratantes
			->limit($pagination->rows_per_page)
			->offset($pagination->offset)->find_all();

		$var["pagination"] = $pagination;
		$var["table"] = $this->geraTable($results);

		$this->template->title = "Contratantes";
		$this->template->content = View::factory('admin/contratantes', $var);
	}

	public function action_dados()
	{
		$var = array();
		$id = $this->request->param('id');
		$var["contrat"] = ORM::factory("contratante", $id);
		$this->template->title = 'Currículo - Interesses';
		$this->template->content = View::factory('admin/dadoscontratantes', $var);
	}

	public function action_conveniar()
	{
		$var = array();
		$id = $this->request->param('id');
		$contrat = ORM::factory("contratante", $id);
		$contrat->conveniado = 1;
		$contrat->codigo = ($contrat->codigo == '' ? Helper::geraSenha(8, 8) : $contrat->codigo);
		$contrat->save();
		$this->request->redirect('admin/contratantes/dados/'.$contrat->id);
	}

	public function action_desconveniar()
	{
		$var = array();
		$id = $this->request->param('id');
		$contrat = ORM::factory("contratante", $id);
		$contrat->conveniado = 0;
		$contrat->save();
		$this->request->redirect('admin/contratantes/dados/'.$contrat->id);
	}

	public function geraTable($results)
	{
		$table = '';
		if(count($results) > 0) {
			$trs = array();
			$i = 0;
			foreach($results as $row){
				$i++;
				if ($row->tppessoa =='PF')
					$trs[] = '<tr class="'.($i%2==0 ? "tr_even" : "tr_odd").'">
						<td><a href="'.URL::site("admin/contratantes/dados/".$row->id).'">'.$row->contratantepf->nome.'</a></td>
						<td>'.$row->email.'</td>
						<td>'.Helper::format_timestamp($row->dtcadastro).'</td>
					</tr>';
				else
					$trs[] = '<tr class="'.($i%2==0 ? "tr_even" : "tr_odd").'">
						<td><a href="'.URL::site("admin/contratantes/dados/".$row->id).'">'.($row->contratantepj->nomefantasia <> "" ? $row->contratantepj->nomefantasia.' / ' : '').$row->contratantepj->razao.'</a></td>
						<td>'.$row->email.'</td>
						<td>'.Helper::format_timestamp($row->dtcadastro).'</td>
					</tr>';
			}
			$table = '
			<table class="tb_lista">
				<tr>
					<th>Razão Social / Nome</th>
					<th>Email</th>
					<th>Dt Cadastro</th>
				</tr>
				'.implode("", $trs).'
			</table>';
		}
		return $table;
	}
}