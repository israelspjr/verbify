<h2><?=$teste->nome?></h2>
<?=(Arr::get($errors, "outros")<>"" ? '<p class="p_error">'.Arr::get($errors, "outros").'</p>' : '')?>

<div id="dv_frm">
	<form method="post" id="frm_addresult">
		<? if($teste->tipo == 2){ // análise ?>
			<div>
				<label>Intervalo</label>
				<input type="text" name="min" value="<?=Arr::get($values, "min")?>" /> -
				<input type="text" name="max" value="<?=Arr::get($values, "max")?>" />
				<?=(Arr::get($errors, "min")<>"" ? '<p class="p_error">'.Arr::get($errors, "min").'</p>' : '')?>
				<?=(Arr::get($errors, "max")<>"" ? '<p class="p_error">'.Arr::get($errors, "max").'</p>' : '')?>
			</div>
			<div>
				<label>Texto</label><br />
				<textarea name="texto" class="resultado"><?=Arr::get($values, "texto")?></textarea>
				<?=(Arr::get($errors, "texto")<>"" ? '<p class="p_error">'.Arr::get($errors, "texto").'</p>' : '')?>
			</div>
		<? } elseif($teste->tipo == 3){ // perfil ?>
			<div>
				<label>Código / Letra</label>
				<input type="text" name="valor" value="<?=Arr::get($values, "valor")?>" />
				<?=(Arr::get($errors, "letra")<>"" ? '<p class="p_error">'.Arr::get($errors, "letra").'</p>' : '')?>
			</div>
			<div>
				<label>Texto</label><br />
				<textarea name="texto" class="resultado"><?=Arr::get($values, "texto")?></textarea>
				<?=(Arr::get($errors, "texto")<>"" ? '<p class="p_error">'.Arr::get($errors, "texto").'</p>' : '')?>
			</div>
		<? } ?>
		<input type="submit" name="salvar" value="salvar" />
		<? if(Arr::get($values, "resultado_id")<>""){ ?>
			<input type="button" name="voltar" value="cancelar" onClick="window.open('<?=URL::site('admin/testes/resultado/'.$teste->id)?>', '_top')" />
			<input type="hidden" name="resultado_id" value="<?=Arr::get($values, "resultado_id")?>" />
		<? } else { ?>
			<input type="button" name="voltar" value="voltar" onClick="window.open('<?=URL::site('admin/testes')?>', '_top')" />
		<?} ?>
	</form>
</div>
<div id="lst_result"></div>
<script type="text/javascript">
$(function(){
	carregaResultados();
});

function carregaResultados(){
	$.post('<? echo URL::site("admin/cadastroforms/carregaresultados") ?>',
		{ teste_id: <?=$teste->id?>},
		function(data) {
			$("#lst_result").html(data);
		}
	);
}

function editar(id){
	$.post('<? echo URL::site("admin/cadastroforms/editresultado") ?>',
		{ id: id },
		function(data) {
			$("#dv_frm").html(data);
		}
	);
}

function excluir(id){
	$.post('<? echo URL::site("admin/cadastroforms/deleteresultado") ?>',
		{ id: id },
		function(data) {
			carregaResultados();
		}
	);
}
</script>