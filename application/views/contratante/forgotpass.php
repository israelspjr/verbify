<div class="content" style="margin-top: 30px;">
	<div class="dv_quadrado_invisivel vermelho"></div>
	<h2 class="h2_title txt-vermelho" style="margin-top: 83px; margin-bottom: 15px;">contratante</h2>
	<div class="clear"></div>
	<h2 class="h2_subtitle">esqueci minha senha</h2>
	<div id="dv_esqueci_intro">
		<p>Digite o e-mail com o qual se cadastrou. Enviaremos sua senha para este e-mail.</p>
	</div>
	<? echo (isset($erro) ? $erro : '') ?>
	<form id="frm_esqueci" method="POST" style="margin: 20px; text-align: center;">
		<div>
			<label>E-mail</label>
			<input type="text" name="email" maxlength="100" value="<?=(isset($email)?$email:'')?>" style="width: 300px;"/>
		</div>
		<div class="dv_btn" style="margin: 20px;">
			<input type="submit" name="enviar" value="enviar" />
			<input type="button" value="cancelar" onClick="window.open('<? echo URL::site("contratante"); ?>','_top')"/>
		</div>
	</form>
</div>