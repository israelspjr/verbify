<h2 class="h2_subtitle">Minhas Vagas</h2>
<?
$rows = array();
foreach($vagas as $vaga){
	$count = $vaga->countCandidaturasAtivas();
	$rows[] = '<tr>
		<td><a href="'.URL::site('contratante/minhasvagas/editar/'.$vaga->id).'">'.$vaga->getIntro().'</a></td>
		<td>'.Helper::format_timestamp($vaga->dt_cadastro).'</td>
		<td style="text-align: center;" class="cands">'.($count > 0 ? '<a href="'.URL::site('contratante/minhasvagas/vercandidatos/'.$vaga->id).'">'.$count.'</a>' : $count).'</td>
		<td>
			<a href="'.URL::site('contratante/minhasvagas/editar/'.$vaga->id).'">Editar</a> | 
			<a href="'.URL::site('contratante/minhasvagas/excluir/'.$vaga->id).'">Excluir</a>
		</td>
	</tr>';
}
if(count($vagas) > 0){
	echo '
	<table id="tb_vagas">
		<tr><th>Título</th><th>Data cadastro</th><th>Candidatos</th><th class="th_link">Ações</th></tr>
		'.implode("", $rows).'
	</table>';
}
?>
<div class="dv_btn">
	<input type="button" value="Publicar Nova Vaga" onClick="window.open('<?=URL::site('contratante/minhasvagas/publicar')?>', '_top');" style="padding: 5px;"/>
</div>
