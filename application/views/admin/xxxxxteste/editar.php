<h2>Alterar Teste</h2>
<div id="dv_teste_editar">
	<form method="post" id="frm_teste">
		<input type="hidden" name="teste_id" value="<?=$teste->id?>" />
		<div>
			<label class="lbl_left">Nome</label><input type="text" name="nome" value="<?=$teste->nome?>" />
			<?=(Arr::get($errors, "nome") ? '<label class="error">'.Arr::get($errors, "nome").'</label>' : '');?>
			<label class="lbl_left">Sobre o teste</label>
			<textarea name="descricao"><?=$teste->descricao?></textarea>
		</div>
		<div class="dv_btn">
			<input type="button" name="questoes" value="adicionar questão" onClick="window.open('<?=URL::site('admin/questoes/cadastrar/'.$teste->id)?>', '_top')" />
			<input type="submit" name="salvar" value="salvar" />
			<?
			if($teste->publicado == 0){
				echo '<input type="submit" name="publicar" value="publicar" />';
			} else {
				echo '<input type="submit" name="despublicar" value="despublicar" />';
			} ?>
			<input type="button" name="cancelar" value="cancelar" onClick="window.open('<?=URL::site('admin/testes')?>', '_top')" />
		</div>
	</form>
	<div id="lst_quest"></div>
</div>
<script type="text/javascript">
	$(function(){
		function carregaQuestoes(){
			$.post('<? echo URL::site("admin/cadastroforms/carregaquestoes") ?>',
				{ teste_id: <?=$teste->id?>},
				function(data) {
					$("#lst_quest").html(data);
				}
			);
		}
		carregaQuestoes();
	});
</script>