<h2><?=$title?></h2>
<form method="post">
	<fieldset style="padding: 10px;">
		<div style="float:left; margin-right: 20px;">
			Escola:
			<select name="contratante">
				<?=implode('', $opt_contratantes)?>
			</select>
		</div>
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
		<p>&nbsp;</p>
		<div style="float:left; margin-right: 20px;">
			<input type="checkbox" name="mais" id="mais"> Mostrar escolas que compram mais
		</div>
			<div style="float:left; margin-right: 20px;">
			<input type="checkbox" name="ultima" id="ultima"> Mostrar última vez que a escola comprou
		</div>
		
	</fieldset>
</form>

<div style="margin-top: 20px;">
	<?if(isset($logs)){ ?>
		<h3>Extrato de <?=$mes[(int)$sel_mes]."/".$sel_ano?></h3>
		<? if(count($logs) > 0){ ?>
			<table id="tb_extrato" class="tb_lista">
				<tr>
					<th>Conta</th>
					<th class="data">Data</th>
					<th>Histórico</th>
					<th class="valor">Crédito</th>
					<th class="valor">Débito</th>
					<th class="valor">Saldo</th>
				</tr>
				<?
				$i =1;
				$saldo = 0;
				$saldoN = 0;
				$saldoP = 0;
				foreach($logs as $log){
					$saldo = $saldo + $log->consumo_qtde;
					echo '
					<tr class="'.($i%2==1 ? 'impar' : 'par').'">
						<td>'.$log->conta->getNome().'</td>
						<td>'.Helper::format_timestamp($log->data).'</td>
						<td>'.$log->descricao.'</td>';
					if ($log->consumo_qtde > 0) {
						echo '<td class="valor pos">'.$log->consumo_qtde.'  </td>';
						$saldoP = $saldoP + $log->consumo_qtde;
					} else {						
						echo '<td></td>';
					}
					
					if ($log->consumo_qtde < 0) {
						echo '<td class="valor neg">'.$log->consumo_qtde.' </td>';
						$saldoN = $saldoN + $log->consumo_qtde;
					} else {
						echo '<td></td>';
					}
					
					echo ' <td>';
					echo ($saldoP + $saldoN);
					echo ' </td>
					</tr>';
					$i++;
				}
				?>
				<tr class="<?=($i%2==1 ? 'impar' : 'par')?>">
					<td colspan="3"><strong>TOTAL</strong></td>
					<td><strong><?php echo $saldoP; ?></strong></td>
					<td><strong><?php echo $saldoN; ?></strong></td>
					<td  class="valor <?=($saldo < 0 ? 'neg' : 'pos')?>"><strong><?=$saldo.' '.($saldo < 0 ? 'D' : 'C')?></strong></td>
				</tr>
			</table>
		<? } else {
			echo '<p class="p_error">Nenhuma transação efetuada no período.</p>';
		}
	}?>
</div>
<div style="margin: 10px 0;">
	<input type="submit" name="cortesia" value="cadastrar cortesia" onClick="window.open('<?=URL::site('admin/creditos/cortesia')?>', '_top')" />
</div>


<div style="margin-top: 20px;display:none;" id="others" >
<h2>Outros Filtros</h2>
<div>
Escolas que compram mais créditos
<br>
<table id="tb_extrato2" class="tb_lista">
<tr>
<th>Conta</th>
<th>Crédito</th>
</tr>
<tr>
<td><?php 
			$var2 = array();
			$opts2 = array();
			$conta_id3 = array(); 
			$saldo = DB::select('conta_id', array('SUM("consumo_qtde")', 'saldo'))
			->from("consumo_log")
			->where('consumo_qtde' , '>', '0')
			->group_by('conta_id')
			->order_by('saldo','desc')
			->execute();
			
			foreach($saldo as $row) {
			$opts2[] = $row['saldo'];
			$conta_id3[] = $row['conta_id'];
			$var2['saldo'] = $opts2;
			$var2['conta_id'] = $conta_id3;
			}

function getNomeE($conta_id2){
			return ORM::factory('conta')
			->where('active', '=', '1')
			->where('id', '=', $conta_id2)
			->find_all();
	}	

$total = 0;

for ($i=0;$i<count($var2['conta_id']);$i++) {
$ve = getNomeE($var2['conta_id'][$i]);

	foreach($ve as $row2) {
	echo $row2->getNome()."</td><td> ";
	}
	$total = $total + $var2['saldo'][$i];
	
echo $var2['saldo'][$i]."</td></tr><tr><td>";;
}

?>
<strong>TOTAL</strong></td><td><strong><?php if ($total <> 0) {echo $total;};?></strong></td>
</tr>
</table>
</div>
</div>

<div style="margin-top: 20px;display:none;" id="others2" >
<h2>Outros Filtros</h2>
<div>
A última vez que a escola comprou crédito
<br>
<table id="tb_extrato3" class="tb_lista">
<tr>
<th>Conta</th>
<th>Crédito</th>
<th>Data</th>
</tr>
<tr>
<td><?php 
			$var2 = array();
			$opts2 = array();
			$conta_id3 = array(); 
			$data = array();
			$saldo = DB::select('conta_id', 'consumo_qtde', 'descricao', 'data')
			->from("consumo_log")
			->where('descricao' , '=', 'Créditos comprados')
			->group_by('conta_id')
			->order_by('data','asc')
			->execute();
			
			foreach($saldo as $row) {
			$opts2[] = $row['consumo_qtde'];
			$conta_id3[] = $row['conta_id'];
			$data[] = $row['data'];
			$var2['saldo'] = $opts2;
			$var2['conta_id'] = $conta_id3;
			$var2['data'] = $data;
			}

$total = 0;

for ($i=0;$i<count($var2['conta_id']);$i++) {
$ve = getNomeE($var2['conta_id'][$i]);

	foreach($ve as $row2) {
	echo $row2->getNome()."</td><td> ";
	}
//	$total = $total + $var2['saldo'][$i];
	
echo $var2['saldo'][$i]."</td><td>". $var2['data'][$i]."</td></tr><tr><td>";;
}

?>
<strong>TOTAL</strong></td><td><strong><?php if ($total <> 0) {echo $total;};?></strong></td>
</tr>
</table>
</div>
</div>

<script>
$(document).ready(function() {
	$('#mais').click(function () {
$("#mais").attr("checked") ? $("#others").css("display","block") : $("#others").css("display","none");
	})
}); 

$(document).ready(function() {
	$('#ultima').click(function () {
$("#ultima").attr("checked") ? $("#others2").css("display","block") : $("#others2").css("display","none");
	})
}); 

</script>
