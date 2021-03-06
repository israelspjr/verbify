<div class="content" style="margin-top: 30px;">
	<div class="dv_quadrado_invisivel marrom"></div>
	<h2 class="h2_title txt-marrom"><? echo __('contato'); ?></h2>
	<div class="clear"></div>
	<div>
		<div class="dv_img" style="width: 950px; height: 527px; overflow: hidden;"><img src="<?=URL::site("assets/img/home/contato_BX.jpg")?>" /></div>
		<div style="margin: 15px 0;">
			<p>A Equipe da Companhia de Idiomas está à disposição para esclarecer suas dúvidas e facilitar ainda mais todo o processo de recrutamento e seleção do professor mais indicado. <!--<?=I18n::get('faleconoscop1')?>--></p>
		</div>
		<div id="dv_contato">
			<form id="frm_contato" method="post">
				<? echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : ''); ?>
				<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
				<div class="row">
					<label><?=I18n::get('nome')?></label>
					<input type="text" name="nome" maxlength="200" value="<?=(Arr::get($values, 'nome'))?>" />
				</div>
				<div class="row">
					<label><?=I18n::get('email')?></label>
					<input type="text" name="email" maxlength="200" value="<?=(Arr::get($values, 'email'))?>" />
				</div>
				<div class="row">
					<label><?=I18n::get('mensagem')?></label>
					<textarea name="message"><?=(Arr::get($values, 'message'))?></textarea>
				</div>
				<div class="dv-btn">
					<input type="hidden" name="enviar" value="Enviar" />
					<input type="submit" id="btn_enviar" name="btn_enviar" value="<?=I18n::get('enviar')?>" />
				</div>
			</form>
			<br />
		</div>
	</div>
</div>
<script>
</script>