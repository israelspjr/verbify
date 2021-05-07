<?php defined('SYSPATH') or die('No direct script access.');
//error_reporting(E_ALL);

class Controller_Admin_Candidatos extends Controller_Admin_DefaultTemplate {

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
		//$candidatos = ORM::factory("candidato");

		$active = 1;

		$query = DB::select('candidato.*', array(DB::expr('group_concat(tb_testes.id)'), 'testes'))



			->from('candidato')



			->join('teste_executado', 'LEFT')



			->on('candidato.id', '=', 'teste_executado.candidato_id')



			->join('testes', 'LEFT')



			->on('teste_executado.teste_id', '=', 'testes.id')



			->join('candidato_local', 'LEFT')



			->on('candidato.id', '=', 'candidato_local.candidato_id');

			

//			echo $query;



		if(isset($_REQUEST["buscar"])) {

			

			$email =  Arr::get($_REQUEST, "email");

			

			$estado = Arr::get($_REQUEST, "estado");



			$cidade = Arr::get($_REQUEST, "cidade");



			$regiao = Arr::get($_REQUEST, "regioes");



			$idioma = Arr::get($_REQUEST, "idioma");



			$nome = Arr::get($_REQUEST, "nome");



			$conveniado = Arr::get($_REQUEST, "conveniado");



			$conveniado = Arr::get($_REQUEST, "conveniado");



			$testesrealizados = Arr::get($_REQUEST, "testesrealizados");



			$active = (Arr::get($_REQUEST, "active") == 0 ? 0 : 1);

			

			$sexo = Arr::get($_REQUEST, "sexo");

			

			$pais = Arr::get($_REQUEST, "nacionalidade");

			

			if($pais <> '')

				

		//		$query->join('candidato_local', 'INNER')

   		//			  ->on('candidato.id', '=', 'candidato_local.candidato_id');



				$query->where('candidato_local.pais', '=', $pais);









			if($estado <> '')



				$query->where('estado_id', '=',  $estado);



			if($cidade <> '')



				$query->where('cidade_id', '=', $cidade);



			if($regiao <> ''){



				$query->join('candidato_regiao', 'INNER')



				->on('candidato.id', '=', 'candidato_regiao.candidato_id');



				$query->where('candidato_regiao.regiao_id', '=', $regiao);



			}



			if($idioma <> '') {



				$query->join('candidato_idioma', 'INNER')

   					  ->on('candidato.id', '=', 'candidato_idioma.candidato_id');



				$query->where('candidato_idioma.idioma_id', '=', $idioma);



			}



			if($conveniado <> ''){



				if($conveniado == 0)



					$query->where('candidato.conveniado_id', '=', '0');



				else



					$query->where('candidato.conveniado_id', '<>', '0');



			}





			if($testesrealizados <> ''){



				if($testesrealizados == 0)

                  {

				$query->where('testes.idioma_id', '=', $idioma);

		//	$query->where("testes.publicado", "=", "0")  ;

			$query->where("testes.active", "=", "1") ;

//			$query->where("testes.active", "in", "(0001)")    ;

		//			$query->where('teste_executado.divulgar', '=', '0');

                  }

				elseif($testesrealizados == 1)

                  {

				$query->where('testes.idioma_id', '=', $idioma);

	//		$query->where("testes.publicado", "=", "1");

	//		$query->where("testes.active", "=", "1") ;

					$query->where('teste_executado.divulgar', '=', '1');

                  }

			} else {

				

				$query->where('testes.idioma_id', '=', $idioma);

			$query->where("testes.publicado", "=", "1")  ;

			$query->where("testes.active", "=", "1")    ;

			//		$query->where('teste_executado.divulgar', '=', '0');

       	

			}





			$query->where('candidato.nome', 'like', '%'.$nome.'%');



		}

		

		if ($email != '') {

		

		$query->where('candidato.email', 'like','%'.$email.'%'); 

		

		}

		

		if ($sexo != '') {

		$query->where('candidato.sexo', '=', $sexo);	

			

		}



		$query->where('candidato.active', '=', $active);



		$query->group_by('candidato.id')->order_by('candidato.dtcadastro', 'DESC');
		
		$admin = $_SESSION['nomeAdmin'];
	//	var_dump($admin);
	//	$admin = $var->user;
		
		if ($admin == 'admin2') {

			$query->where("dtcadastro", ">", "2020-11-13 12:00:00");
		}
		

	//	echo $query;



		$total = clone $query;

		

		$pagination->total_rows = count($total->execute());







		// get pagina



		$results = $query





			->limit($pagination->rows_per_page)



			->offset($pagination->offset)



			->as_object()



			->execute();







		$var["pagination"] = $pagination;



		$var["table"] = $this->geraTable($results);







		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->find_all();



		$var["estados"] = ORM::factory('estado')->find_all();

		

    	$var["pais"] = ORM::factory("pais")->find_all();



		$var["active"] = $active;

		

		$var['sexo'] = $sexo;







		$this->template->title = "Candidatos";



		$this->template->content = View::factory('admin/candidatos', $var)



			->set('values', $_REQUEST);



	}







	public function geraTable($results){



		$arr = array();

        $idi = Arr::get($_REQUEST, "idioma");

        

        if ($idi ==  "")

        {

		$testes = ORM::factory("teste")





			->where("publicado", "=", "1")

			->where("active", "=", "1")

			->order_by("consumo", "ASC")

			->order_by("idioma_id", "DESC")



			->find_all();

        }

        else

        {

		$testes = ORM::factory("teste")





			->where("publicado", "=", "1")

			->where("active", "=", "1")

			->where("idioma_id", "=", $idi)



			->or_where("idioma_id", "=", "0")

			->where("publicado", "=", "1")

			->where("active", "=", "1")



			->order_by("consumo", "ASC")



			->order_by("idioma_id", "DESC")



			->find_all();

        }

		

//		var_dump ($testes);

      

		foreach($testes as $row){

		    $arr[$row->id] = $row->nome;



		}

		

	//	var_dump ($arr);



		$table = '';



		if(count($results) > 0) {



			$trs = array();



			$i = 0;



			foreach($results as $row){

				

				$i++;



				$testesexecs = explode(",", $row->testes);



				$tr_testes = array();



				foreach($arr as $key => $value){

					if(in_array($key, $testesexecs))

                    {

echo "<pre>";

				  $testeex = ORM::factory("testeexecutado")->where("teste_id", "=", $key)->where("candidato_id", "=", $row->id)->find();

		          $results2 = $testeex->teste->questoes->count_all();

				  

				  $qs1 = $testeex->teste->questoes->where("tipo", "=", "1")->count_all();

				  

				  if ($qs1 >0) {

				  



				  

				  $questoes = $testeex->teste->questoes->where("tipo", "=", "1")->find_all()->as_array("id", "id");

				  $acertos = $testeex->teste->candidatosrespostas

				->where("resposta", "=", "C")

				->where("candidato_id", "=", $testeex->candidato_id)

				->where("questao_id", "IN", $questoes)

				->count_all();

				  

				  $per = round(($acertos/$results2)*100,2);

				  

				  }

	  

/*				  <td class='td_teste checked'>*/

                  $tr_testes[] = "<td><span style='float: right;'><strong>".$per."% </strong><br>(".$acertos."/" .$results2.")</span></td>";



echo "</pre>";

					}



                    else

                    {



						$tr_testes[] = '<td class="td_teste"></td>';



					}



				}



				if($row->conveniado_id <> 0) {



					$conv = ORM::factory("contratante", $row->conveniado_id);



				}

				

				

				$trs[] = '



				<tr class="'.($i%2==0 ? "tr_even" : "tr_odd").'" style="cursor: pointer;" onClick="window.open(\''.URL::site("admin/curriculo/geral/".$row->id).'\', \'_top\')">



					<td class="td_nome">'.$row->nome ."</td>";

//                    .'<br />'

					

                    $trs[] .= "<td><a href='mailto:"



                    .$row->email

                    ."' />" .$row->email ."</a></td>";

					

					if ($row->aprovadoCI == 0) {

					$trs[] .= '<td></td>'; 	

					} elseif ($row->aprovadoCI == 1) {

					$trs[] .= '<td style="text-align: center;" class="td_teste checked"></td>';

					} elseif ($row->aprovadoCI == 2) {

					$trs[] .= '<td style="text-align: center;" class="td_teste reprovado" title='.$row->obs.'></td>';

					}

					

				//	.($row->aprovadoCI == 0 ? '' : '<td style="text-align: center;" class="td_teste checked">')

					

				$trs[] .= '<td style="text-align: center;">'.Helper::format_timestamp($row->dtcadastro).'</td>



					<td style="text-align: center;">'.($row->status == 0 ? 'Incompleto' : 'Completo').'</td>'



//					<td>'.($row->conveniado_id <> 0 ? $conv->getNome() : '').'</td>

					.implode("", $tr_testes).'



				</tr>';



			}



			$tr_testes = array();



			foreach($arr as $value){



				$tr_testes[] = '<th class="th_teste">'.$value.'</th>';



			}



			$table = '



			<table class="tb_lista" id="tb_candidatos">



				<tr>



					<th>Nome</th>

					

					<th>Email</th>

					

					<th style="text-align:: center;">Aprovado CI</th>



					<th>Dt Cadastro</th>



					<th>Perfil</th>'



//					<th>Convênio</th>

			

					.implode($tr_testes).'



				</tr>



				'.implode("", $trs).'



			</table>';



		}



		return $table;



	}



}

