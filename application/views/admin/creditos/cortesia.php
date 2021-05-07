<form method="post">
	<?=(isset($error) ? '<p class="p_error">'.$error.'</p>' : '')?>
	<fieldset style="padding: 10px;">
		<div style="float:left; margin-right: 20px;">
			Contratante:
			<select name="contratante">
				<?=implode('', $opt_contratantes)?>
			</select>
		</div>
		<div style="float:left; margin-right: 20px;">
			Quantidade de créditos:
			<input type="text" name="qtde" />
		</div>
		<div style="float:left;">
			<input type="submit" name="cortesia" value="liberar" />
		</div>
		<div style="clear: both"></div>
	</fieldset>
</form>
