<h2 class="h2_subtitle">Alterar Senha</h2>
<? echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : ''); ?>
<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
<form method="post" id="frm_redefinir">
	<label>Senha Atual</label>
	<input type="password" name="senha" value="<?=Arr::get($values, "senha") ?>" />
	<label>Nova Senha</label>
	<input type="password" name="novasenha" value="<?=Arr::get($values, "novasenha") ?>" />
	<label>Repita a nova senha</label>
	<input type="password" name="cnovasenha" value="<?=Arr::get($values, "cnovasenha") ?>" />
	<div class="dv_btn" style="margin: 10px 0;">
		<input type="submit" name="salvar" value="alterar" />
	</div>
</form>