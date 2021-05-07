<div style="margin: 10px 20px;">
	<h2 class="h2_subtitle">Detalhe da Vaga</h2>
	<div style="margin-top:20px;">
		<? echo $vaga->getIntro(); ?>
	</div>
	<div class="dv_btn" style="margin-top:20px;">
		<input type="button" name="btn-cadastro" value="candidatar-se" onclick="window.open('<?=URL::site('candidato/cadastro')?>', '_top');" style="padding: 2px 10px;" />
	</div>
</div>