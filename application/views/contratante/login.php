<div class="content" style="margin-top: 30px;">
	<div class="dv_quadrado_invisivel vermelho"></div>
	<h2 class="h2_title txt-vermelho" style="margin-top: 83px;">contratante</h2>
	<div class="clear"></div>
	<div class="pg_login">
		<div id="dv_boxlogin" style="margin-left: 135px;">
			<form method="post" action="<?=URL::site("contratante/login")?>" id="frm-login">
				<input type="text" name="email" />
				<input type="password" name="senha" />
				<input type="submit" class="btn_entrar" name="entrar" value="<? echo __('entrar2')?>" />
				<span class="forgotpass"><a href="<? echo URL::site('contratante/forgotpass')?>" id="a-forgotpass">esqueceu a senha?</a></span>
				<div class="clear"></div>
			</form>
			<br />
			<?php echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : '<div class="erro_box"></div>'); ?>
		</div>
	</div>
</div>