<h2 class="h2_subtitle"><? echo __('meus créditos')?></h2>
<div >
	<h3><? echo __('Saldo').': '.$saldo.' '.__('créditos')?></h3>
	<div class="dv_gray_box">
		<input type="button" name="pagseguro" value="<? echo __('Comprar Créditos'); ?>" onClick="window.open('<?=URL::site("candidato/meuscreditos/comprar")?>', '_top')" />
	</div>
	<div>
		<? echo __('Movimentação dos últimos '.$dias.' dias') ?>
		<table id="tb_extrato">
			<tr>
				<th class="data"><? echo __('Data') ?></th>
				<th><? echo __('Histórico') ?></th>
				<th class="valor"><? echo __('Valor')?></th>
			</tr>
			<?
			$i =1;
			foreach($logs as $log) {
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
