<?php
$emailp = $_POST['emailp'];

if ($emailp <> "") {

$query = DB::insert('candidato_pre', array('email'))->values(array($emailp))->execute();

//echo $emailp;

}

?>
<!--

<div class="content" style="margin-top: 30px;">
	<div class="dv_quadrado_invisivel verde"></div>
	<h2 class="h2_title txt-verde" style="margin-top: 83px;"><? echo __('professor') ?></h2>
	<div class="clear"></div>
	<div class="pg_login">
		<div id="dv_boxlogin">
			<form method="post" action="<?=URL::site("candidato/login")?>" id="frm-login">
				<input type="text" name="email" required placeholder="email" />
				<input type="password" name="senha" required placeholder="<? echo strtolower(__('senha')); ?>" />
				<input type="submit" class="btn_entrar" name="entrar" value="<? echo __('entrar2')?>" />
				<span class="forgotpass"><a href="<? echo URL::site('candidato/forgotpass')?>" id="a-forgotpass"><? echo __('esqueceu a senha?') ?></a></span>
				<div class="clear"></div>
			</form>
			<br />
			<?php echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : '<div class="erro_box"></div>'); ?>
		</div>
	</div>
</div>-->