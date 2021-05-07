<form method="post" id="frm_addresult">
	<input type="hidden" name="resultado_id" value="<?=$resultado->id?>" />
	<?
	if($teste->tipo == 2){ // análise ?>
		<div>
			<label>Intervalo</label>
			<input type="text" name="min" value="<?=$resultado->min?>"/> -
			<input type="text" name="max" value="<?=$resultado->max?>" />
		</div>
		<div>
			<label>Texto</label><br />
			<textarea name="texto" class="resultado"><?=$resultado->texto?></textarea>
		</div>
		<input type="submit" name="salvar" value="salvar" />
	<? } elseif($teste->tipo == 3){ // perfil ?>
		<div>
			<label>Código / Letra</label>
			<input type="text" name="valor" value="<?=$resultado->letra?>" />
		</div>
		<div>
			<label>Texto</label><br />
			<textarea name="texto" class="resultado"><?=$resultado->texto?></textarea>
		</div>
		<input type="submit" name="salvar" value="salvar" />
		<input type="button" name="voltar" value="cancelar" onClick="window.open('<?=URL::site('admin/testes/resultado/'.$teste->id)?>', '_top')" />
	<? } ?>
</form>
