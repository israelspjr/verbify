<h2 class="h2_subtitle">Acompanhamento</h2>
<?
if(isset($pagination)){
	echo '<h3>'.($pagination->total_rows ==1 ? '1 professor encontrado.' : "$pagination->total_rows professores encontrados.").'</h3>';
	if($pagination->total_rows > 0){ ?>
		<table id="tb_candidatos">
			<tr>
				<th>Professor</th>
				<th>Idiomas</th>
				<th>Região</th>
				<th class="th_link">Tipo Cadastro</th>
			</tr>
			<? foreach($minis as $row){
				$cand = ORM::factory("candidato", $row["candidato_id"]);
				$idiomas = ucwords(implode(", ", $cand->getArrayIdiomas()));
				echo '
				<tr onClick="window.open(\''.URL::site("contratante/curriculo/geral/".$cand->id).'\', \'_top\')"  class="tr_lista_prof">
					<td>'.($cand->conveniado_id == $user->id ? $cand->nome : $cand->nome).'</td>
					<td>'.$idiomas.'</td>
					<td>'.$cand->getLocalidade().'</td>
					<td class="center">'.($cand->conveniado_id == $user->id ? 'Trabalhe conosco' : 'Portal').'</td>
				</tr>';
			} ?>
		</table>
	<br />
	<? } else {  ?>
		<p>Nenhum professor encontrado</p>
	<? }
}
echo '<div class="dv_paginacao">'.(isset($pagination) ? $pagination->renderFullNav() : '').'</div>';
?>
