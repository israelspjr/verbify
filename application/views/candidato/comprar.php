<?/*<p class="erro">Operação indisponível no momento</p>*/?>
<form method="post" action="<?=URL::site("candidato/meuscreditos/pagar")?>">
	<fieldset style="margin: 10px; padding: 10px; border: 2px solid #7F8E34; color: dimGray;">
		<legend>Selecione o pacote</legend>
		<select name="pacote" style="width: 250px;">
			<? foreach($pacotes as $pack){
				echo '<option value="'.$pack->id.'">'.$pack->creditos.' créditos  -  R$ '.Helper::number_format($pack->reais).'</option>';
			}
			?>
		</select>
		<input type="submit" value="comprar" />
	</fieldset>
</form>
