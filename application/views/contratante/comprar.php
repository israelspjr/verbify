<form method="post" id="frm_busca_red" action="<?=URL::site("contratante/meuscreditos/pagar")?>">
	<fieldset>
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