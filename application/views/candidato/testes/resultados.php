<h2 class="h2_subtitle"><? echo __('resultados'); ?></h2>
<?
if(count($testes) == 0){
	echo '<p class="p_warning">'.__('Nenhum teste executado até o momento').'</p>';
} else {

$user = Session::instance()->get("talen_user", NULL);
//$id = $this->request->param("id");
$teste_id2 = $_REQUEST['teste_id2'];

//echo $user->id;
//echo $teste_id2;

$dataAtual1 = date("y-m-d h:i:s");
	$dataAtual2 = strtotime("-1 year", strtotime($dataAtual1));
	$dataAtual3 = date("Y-m-d h:i:s", $dataAtual2);
	$dataAtual = strtotime($dataAtual3);
//	echo "<br>".$dataAtual;



if ($_REQUEST['deletar'] == 1) {
	
	
	$teste2 = DB::delete("teste_executado")
			->where('candidato_id' , '=', $user->id)
			->where('teste_id', '=', $teste_id2)
			->execute();
			
	$teste2 = DB::delete("candidato_resposta")
			->where('candidato_id' , '=', $user->id)
			->where('teste_id', '=', $teste_id2)
			->execute();
			
	echo "<font color='#FF0000' >Teste deletado com sucesso</font>";		
	echo '<meta http-equiv="refresh" content="2; url='.URL::site("candidato/testes/resultados/".$row->teste->id).'" />';

}

//var_dump($row);
	$html = '
	<div id="dv_testes">
		<ul class="ul_testes">';
		foreach($testes as $row){
			
			
$valorData = DB::select('dt_execucao', 'teste_id', 'candidato_id')
			->from('teste_executado')
			->where('candidato_id' , '=', $user->id)
			->where('teste_id' , '=', $row->teste->id)
			->execute();
			
				foreach($valorData as $row2) {
			
$dt_execucao = strtotime($row2['dt_execucao']);

	if ($dt_execucao < $dataAtual) {
		$podeExcluir = 1;
	} else {
//		$podeExcluir = 1;
	}
				}
							
			$html .= '
			<li>
				<h3 class="teste_title">'.$row->teste->getNome($lang).'</h3>
				'.__('Número de questões').': '.$row->teste->questoes->count_all().'<br>
				'.__('Situação').': '.__($row->getSituacao()).'<br />
				<div class="dv_btn" style="margin-top: 10px;">
					<form method="post">
						<input type="hidden" name="testeex_id" value="'.$row->id.'" />';
						if($row->teste->tipo == 2){
							$html .= '
							<input name="ver_resultado" type="button" value="'.__('Ver Vídeo').'" onClick="window.open(\''.URL::site("candidato/testes/resultados/".$row->teste->id).'\', \'_top\')" />';
						} else {
							$html .= '
							<input name="ver_resultado" type="button" value="'.__('Ver Resultado').'" onClick="window.open(\''.URL::site("candidato/testes/resultados/".$row->teste->id).'\', \'_top\')" />';
						}
					/*	$html .= '
						'.($row->divulgar == 0 ? '<input name="publicar" type="submit" value="'.__('Publicar').'" />' :
						'<input name="despublicar" type="submit" value="'.__('Despublicar').'" />').'';*/
						
						if ($podeExcluir == 1) {
						
						$html .= '<input name="submit" type="submit" value="'.__('Excluir').'" >
						<input type="hidden" name="deletar" value="1">
						<input type="hidden" name="teste_id2" value="'.$row->teste->id.'">';
						}
						
						$html .='		</form>
				</div>
			</li>';
		}
		$html .= '</ul>
	</div>';
	echo $html;
}
?>