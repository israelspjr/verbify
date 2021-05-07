<h2 class="h2_subtitle">Meus créditos</h2>
<div >
	<h3>Saldo: <?=$saldo?> créditos</h3>
	<div class="dv_gray_box">
		<!--<input type="button" name="pagseguro" value="Comprar Créditos" onClick="window.open('<?=URL::site("contratante/meuscreditos/comprar")?>', '_top')" />-->
		<input type="button" name="extrato" value="Extrato" onClick="window.open('<?=URL::site("contratante/meuscreditos/extrato")?>', '_top')" />
	</div>
	<div>
		Movimentação dos últimos <?=$dias?> dias
		<table id="tb_extrato">
			<tr>
				<th class="data">Data</th>
				<th>Histórico</th>
				<th class="valor">Valor</th>
			</tr>
			<?
			$i =1;
			foreach($logs as $log){
				echo '
				<tr class="'.($i%2==1 ? 'impar' : 'par').'">
					<td>'.Helper::format_timestamp($log["data"]).'</td>
					<td>'.$log["descricao"].'</td>
					<td class="valor '.($log["valor"] < 0 ? 'neg' : 'pos').'">'.$log["valor"].' '.($log["valor"] < 0 ? 'D' : 'C').'</td>
				</tr>';
				$i++;
			}
			?>
		</table>
	</div>
</div>
