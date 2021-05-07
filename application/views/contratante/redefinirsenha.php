<? echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : ''); ?>
<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
<form method="post" id="frm_redefinir">
	<input type="hidden" name="forgotkey" value="" />
	<label>Nova Senha</label>
	<input type="password" name="novasenha" />
	<label>Repita a nova senha</label>
	<input type="password" name="cnovasenha" />
	<div class="dv_btn" style="margin: 10px 0;">
		<input type="submit" name="salvar" value="redefinir" />
	</div>
</form>