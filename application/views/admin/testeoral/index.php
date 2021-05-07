<h2>Teste Oral</h2>
<form method="post" id="frm_testeoral">
	<input type="hidden" name="id" value="<?=$teste->id?>" />
	<label>Nome</label>
	<input type="text" name="nome" value="<?=$teste->nome?>"/>
	<?=(Arr::get($errors, "nome") ? '<label class="error">'.Arr::get($errors, "nome").'</label>' : '');?>
	<div id="tabs" style="margin: 10px 0;">
		<ul>
			<li><a href="#tabs-1">Português</a></li>
			<li><a href="#tabs-2">Inglês</a></li>
		</ul>
		<div id="tabs-1">
			<label>Enunciado</label>
			<textarea name="enunciado"><?=$teste->enunciado?></textarea>
		</div>
		<div id="tabs-2">
			<label>Enunciado</label>
			<textarea name="enunciado_en"><?=$teste->enunciado_en?></textarea>
		</div>
	</div>
	<label class="lbl_left">Idioma</label>
	<div class="dv_campo" id="idioma">
		<?
		echo '
		<label class="lbl-check">
			<input type="radio" name="idioma" value="0" groupname="checkIdiomas" '.($teste->idioma_id == 0 ? "checked" : "").' />
			<span>Indiferente</span>
		</label>';
		foreach($idiomas as $idioma){
			echo '
			<label class="lbl-check">
				<input type="radio" name="idioma" value="'.$idioma->id.'" groupname="checkIdiomas" '.($teste->idioma_id == $idioma->id ? "checked" : "").' />
				<span>'.$idioma->descricao.'</span>
			</label>';
		}
		?>
	</div>
	<div class="clear"></div>

	<div class="dv_btn" style="margin: 10px 0;">
		<input type="submit" name="salvar" value="salvar" />
	</div>
</form>
<? if(count($testes) > 0){ ?>
	<table class="tb_lista">
		<tr><th>Nome</th><th>Enunciado</th><th>Ação</th></tr>
		<? foreach($testes as $teste){ ?>
			<tr>
				<td><?=$teste->nome?></td>
				<td><?=nl2br($teste->enunciado)?></td>
				<td>
					<?=($teste->publicado
						? '<a href="'.URL::site("admin/testeoral/despublicar/".$teste->id).'">Despublicar</a>'
						: '<a href="'.URL::site("admin/testeoral/publicar/".$teste->id).'">Publicar</a>')?>|
					<a href="<?=URL::site("admin/testeoral/editar/".$teste->id)?>">Editar</a> |
					<a href="<?=URL::site("admin/testeoral/excluir/".$teste->id)?>">Excluir</a>
				</td>
			</tr>
		<? } ?>
	</table>
<? } ?>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
</script>
