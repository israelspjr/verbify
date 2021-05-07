<h2 class="h2_subtitle"><? echo __('candidaturas')?></h2>
<?
if(count($canduras) > 0){
	foreach($canduras as $row){
		$trs[] = '
		<tr class="dv_cands">
			<td>
				<div class="dv_vaga">
					<div class="dv_vaga_info" style="padding: 0;">
						<div class="titulovaga" style="float: left;">
							<label><input type="checkbox" name="vaga['.$row->id.']" value="1" /></label>
						</div>
						<div style="float: left;">
							'.$row->vaga->getIntro().'
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</td>
			<td class="min">'.($row->visualizado == 1 ? 'Sim' : 'Não').'</td>
			<td class="min">'.Helper::format_timestamp($row->dt_cadastro).'</td>
		</tr>';
	}
	?>
	<form method="post" id="frm_candidaturas">
		<table id="tb_candis">
			<tr>
				<th>Vaga</th>
				<th>Visualizado</th>
				<th>Data Candidatura</th>
			</tr>
			<?=implode("", $trs)?>
		</table>
		<div class="dv_btn">
			<input type="submit" name="excluir" value="excluir selecionados">
		</div>
	</form>
	<?
} else {
	echo __('Nenhuma candidatura');
}
?>