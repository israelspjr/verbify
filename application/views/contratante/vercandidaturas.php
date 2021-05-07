<h2><?=$vaga->titulo?></h2>
<table class="tb_geral">
	<tr><th>Candidato</th><th>Data candidatura</th><th>Visualizado</th><th class="th_link">Ações</th></tr>
	<? foreach($candidaturas as $row){
		echo '<tr>
			<td><a href="'.URL::site("contratante/minhasvagas/vercurriculo/".$row->id).'">'.$row->candidato->nome.'</a></td>
			<td>'.Helper::format_timestamp($row->dt_cadastro).'</td>
			<td>'.($row->visualizado == 0 ? 'não' : 'sim').'</td>
			<td><a href="'.URL::site("contratante/minhasvagas/descartarcandidatura/".$row->id).'">Descartar</a></td>
		</tr>';
	} ?>
</table>
<div class="dv_btn">
	<input type="button" name="cancelar" value="voltar" onclick="window.open('<?=URL::site('contratante/minhasvagas')?>', '_self')" />
</div>
