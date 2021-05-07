<h2><? echo $conta->getNome() ?></h2>
<h3>Saldo: <? echo $conta->saldo . ($conta->saldo < 0 ? ' D' : ' C') ?></h3>
<? echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : '') ?>
<form action="" method="post">
	<fieldset style="padding: 10px; margin: 10px 0 20px 0;">
		<div style="margin-right: 20px;">
			Quantidade de créditos:
			<input type="text" name="qtde" />
			<input type="submit" name="cortesia" value="estornar" />
		</div>
	</fieldset>
</form>
<div>
	<h4>Últimas 20 movimentações</h4>
	<br />
	<? if(count($logs) > 0) { ?>
		<table id="tb_extrato" class="tb_lista">
			<tr>
				<th class="data">Data</th>
				<th>Histórico</th>
				<th class="valor">Valor</th>
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
	<? } else {
		echo '<p>Nenhuma entrada registrada</p>';
	}?>
</div>
<style>
	.neg{ color: red; }
	.pos{ color: blue; }
</style>