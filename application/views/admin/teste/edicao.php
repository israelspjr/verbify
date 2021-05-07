<h2>Alterar Teste</h2>
<form method="post" id="frm_teste">
	<div>
		<div class="tabs" style="margin-top: 10px;">
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
		<input type="button" name="adicionar" value="adicionar questão" onClick="window.open('<?=URL::site("admin/questoes/cadastrar/".$teste->id)?>', '_top')" />
		<input type="submit" name="salvar" value="salvar" />
		<?
		if($teste->publicado == 0)
			echo '<input type="submit" name="publicar" value="publicar" />';
		else
			echo '<input type="submit" name="despublicar" value="despublicar" />';
		?>
		<input type="submit" name="excluir" value="excluir" onClick="if(!confirm('Tem certeza que deseja excluir este teste?')){ return false; }" />
		<input type="button" name="resultados" value="cadastrar resultados" onClick="window.open('<?=URL::site("admin/testes/resultados/".$teste->id)?>', '_top');" />
		<input type="button" name="cancelar" value="voltar" onClick="window.open('<?=URL::site('admin/testes')?>', '_top')" />
	</div>
</form>
<h2>Questões</h2>
<div id="lst_quest">
	<?
	if(count($questoes) > 0){
		foreach($questoes as $que){
			echo '
			<div class="quest">
				<div class="acoes">
					<a href="'.URL::site('admin/questoes/editar/'.$que->id).'">Editar</a> |
					<a href="'.URL::site('admin/questoes/excluir/'.$que->id).'" onClick="if(!confirm(\'Você tem certeza que deseja excluir esta questão?\')){ return false; }">Excluir</a>
				</div>
				<div class="tabs" style="margin-top: 20px;">
					<ul>
						<li><a href="#tabs-1">Português</a></li>
						<li><a href="#tabs-2">Inglês</a></li>
					</ul>
					<div id="tabs-1">
						'.FormTestes::getHtmlAdminShowQuestion($que).'
					</div>
					<div id="tabs-2">
						'.FormTestesEn::getHtmlAdminShowQuestion($que).'
					</div>
				</div>
			</div>
			<script type="text/javascript">
			$(function(){
				$( "#tabs" ).tabs();
			});
			</script>	';
		}
	} else {
		echo '<p class="p_warning">Nenhuma questão cadastrada</p>';
	}
	?>
</div>
<script type="text/javascript">
$(function(){
	$( ".tabs" ).tabs();
});
</script>