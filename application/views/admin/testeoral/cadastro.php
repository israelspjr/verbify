<form method="post" id="frm_testeoral">
	<input type="hidden" name="id" value="<?=$teste->id?>" />
	<label>Nome</label>
	<input type="text" name="nome" value="<?=$teste->nome?>"/>
	<label>Enunciado</label>
	<textarea name="enunciado"><?=$teste->enunciado?></textarea>

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