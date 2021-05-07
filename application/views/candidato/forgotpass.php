<div class="content" style="margin-top: 30px;">
	<div class="dv_quadrado_invisivel verde"></div>
	<h2 class="h2_title txt-verde" style="margin-top: 83px; margin-bottom: 15px;"><? echo __('professor') ?></h2>
	<div class="clear"></div>
	<div>
		<h2 class="h2_subtitle"><? echo __('Esqueci minha senha') ?></h2>
		<div id="dv_esqueci_intro">
			<p align="center"><? echo __('Esqueci minha senha label1') ?></p>
		</div>
		<? echo (isset($erro) ? $erro : '') ?>
		<form id="frm_esqueci" method="POST" style="margin: 20px; text-align: center;">
			<div>
				<label>E-mail</label>
				<input type="text" name="email" maxlength="100" value="<?=(isset($email)?$email:'')?>" style="width: 300px;"/>
			</div>
			<div class="dv_btn" style="margin: 20px;">
				<input type="submit" name="enviar" value="<? echo strtolower(__('enviar')) ?>" />
				<input type="button" value="<? echo __('cancelar') ?>" onClick="window.open('<? echo URL::site("candidato"); ?>','_top')"/>
			</div>
		</form>
	</div>
</div>