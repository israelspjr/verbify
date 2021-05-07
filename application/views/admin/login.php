<div class="clear"></div>
<h2 class="h2_subtitle">Área do Administrador</h3>
<div id="dv_login">
	<?php echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : ''); ?>
	<form id="frm_login" method="post" action="">
		<div>
			<label>Usuário</label>
			<input type="text" name="user" maxlength="100" value="<?=(isset($user)?$user:'')?>"/>
		</div>
		<div>
			<label>Senha</label>
			<input type="password" name="senha" maxlength="20" />		
		</div>
		<div class="dv_btn">
			<input type="submit" name="entrar" value="Entrar" />
		</div>
	</form>
</div>