<h2>Cadastrar Teste</h2>
<form method="post" id="frm_teste">
	<div>
		<div id="tabs" style="margin: 10px 0;">
			<ul>
				<li><a href="#tabs-1">Português</a></li>
				<li><a href="#tabs-2">Inglês</a></li>
			</ul>
			<div id="tabs-1">
				<label class="lbl_left">Nome</label><input type="text" name="nome" value="<?=$teste->nome?>" />
				<?=(Arr::get($errors, "nome") ? '<label class="error">'.Arr::get($errors, "nome").'</label>' : '');?>
				<label class="lbl_left">Sobre o teste</label>
				<textarea name="descricao"><?=$teste->descricao;?></textarea>
			</div>
			<div id="tabs-2">
				<label class="lbl_left">Nome</label><input type="text" name="nome_en" value="<?=$teste->nome_en?>" />
				<?=(Arr::get($errors, "nome_en") ? '<label class="error">'.Arr::get($errors, "nome_en").'</label>' : '');?>
				<label class="lbl_left">Sobre o teste</label>
				<textarea name="descricao_en"><?=$teste->descricao_en;?></textarea>
			</div>
		</div>
	</div>
	<div class="dv_btn">
		<input type="submit" name="salvar" value="salvar" />
		<input type="button" name="cancelar" value="voltar" onClick="window.open('<?=URL::site('admin/testes')?>', '_top')" />
	</div>
</form>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
</script>
<!-- <label>Vigência</label><input type="text" name="vigencia" /> -->
