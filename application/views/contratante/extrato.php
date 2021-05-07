<h2 class="h2_subtitle">Extrato</h2>
<form method="post">
	<div style="float:left; margin-right: 20px;">
		Mês:
		<select name="mes">
			<? foreach($mes as $key => $value){
				echo '<option value="'.$key.'" '.($sel_mes == $key ? 'selected' : '').'>'.$value.'</option>';
			}?>
		</select>
	</div>
	<div style="float:left; margin-right: 20px;">
		Ano:
		<select name="ano">
			<? for($i=$ano-1;$i<=$ano;$i++){
				echo '<option value="'.$i.'" '.($sel_ano == $i ? 'selected' : '').'>'.$i.'</option>';
			}
			?>
		</select>
	</div>
	<div style="float:left;">
		<input type="submit" name="pesquisar" value="pesquisar" />
	</div>
	<div style="clear: both"></div>
</form>
<div style="margin-top: 20px;">
	<? if(isset($logs)){ ?>
		<h3>Extrato de <?=$mes[$sel_mes]."/".$sel_ano?></h3>
		<? if(count($logs) > 0){ ?>
			<table id="tb_extrato">
				<tr>
					<th class="data">Data</th>
					<th>Histórico</th>
					<th class="valor">Valor</th>
				</tr>
				<tr>
					<td></td>
					<td>SALDO ANTERIOR</td>
					<td class="valor <?=($saldoanterior < 0 ? 'neg' : 'pos')?>"><?=$saldoanterior.' '.($saldoanterior < 0 ? 'D' : 'C')?></td>
				</tr>
				<?
				$i =1;
				$saldo = $saldoanterior;
				foreach($logs as $log){
					$saldo = $saldo + $log->consumo_qtde;
					echo '
					<tr class="'.($i%2==1 ? 'impar' : 'par').'">
						<td>'.Helper::format_timestamp($log->data).'</td>
						<td>'.$log->descricao.'</td>
						<td class="valor '.($log->consumo_qtde < 0 ? 'neg' : 'pos').'">'.$log->consumo_qtde.' '.($log->consumo_qtde < 0 ? 'D' : 'C').'</td>
					</tr>';
					$i++;
				}
				?>
				<tr class="<?=($i%2==1 ? 'impar' : 'par')?>">
					<td></td>
					<td>SALDO</td>
					<td  class="valor <?=($saldo < 0 ? 'neg' : 'pos')?>"><?=$saldo.' '.($saldo < 0 ? 'D' : 'C')?></td>
				</tr>
			</table>
		<? } else {
			echo 'Nenhuma transação efetuada no período.';
		}
	}?>
</div>
