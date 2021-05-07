<h2>Alterar Teste</h2>
<form method="post" id="frm_teste">
	<div>
		<label class="lbl_left">Nome</label><input type="text" name="nome" value="<?=$teste->nome?>" />
		<?=(Arr::get($errors, "nome") ? '<label class="error">'.Arr::get($errors, "nome").'</label>' : '');?>
		<label class="lbl_left">Sobre o teste</label>
		<textarea name="descricao"><?=$teste->descricao;?></textarea>
		<label class="lbl_left">Idioma</label>
		<select id="idioma" name="idioma">
			<? foreach($idiomas as $idioma)
				echo '<option  value="'.$idioma->id.'" '.($teste->idioma_id == $idioma->id ? "selected" : "").'>'.ucfirst($idioma->descricao).'</option>';
			?>
		</select>
	</div>
	<div class="dv_btn">
		<input type="button" name="adicionar" value="adicionar questão" onClick="window.open('<?=URL::site("admin/questoesidiomas/cadastrar/".$teste->id)?>', '_top')" />
		<input type="submit" name="salvar" value="salvar" />
		<?
		if($teste->publicado == 0)
			echo '<input type="submit" name="publicar" value="publicar" />';
		else
			echo '<input type="submit" name="despublicar" value="despublicar" />';
		?>
		<input type="submit" name="excluir" value="excluir" onClick="if(!confirm('Tem certeza que deseja excluir este teste?')){ return false; }"/>
		<input type="button" name="resultados" value="cadastrar resultados" onClick="window.open('<?=URL::site("admin/testesidiomas/resultados/".$teste->id)?>', '_top');" />
		<input type="button" name="cancelar" value="voltar" onClick="window.open('<?=URL::site('admin/testesidiomas')?>', '_top')" />
	</div>
</form>
<h2>Questões</h2>
<div id="lst_quest"></div>
<script type="text/javascript">
$(function() {
	function carregaQuestoes(){
		$.post('<? echo URL::site("admin/cadastroforms/carregaquestoesidiomas") ?>',
			{ teste_id: <?=$teste->id?>},
			function(data) {
				$("#lst_quest").html(data);
			}
		);
	}
	carregaQuestoes();
});
</script>