<h2>Cadastrar Teste</h2>
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
	<div class="dv_btn" style="margin-top: 20px;">
		<input type="submit" name="salvar" value="salvar" />
		<input type="button" name="cancelar" value="voltar" onClick="window.open('<?=URL::site('admin/testesidiomas')?>', '_top')" />
	</div>
</form>
<!-- <label>Vigência</label><input type="text" name="vigencia" /> -->
