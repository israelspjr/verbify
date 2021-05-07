<h2 class="h2_subtitle"><? echo __('Teste Oral'); ?></h2>
<div class="dv_questao">
	<h3><?=$teste->getNome($lang)?></h3>
	<p class="p_pergunta">
		<? echo nl2br($teste->getEnunciado($lang)) ?>
	</p>
	<div style="margin: 10px 0;">
		<p><? echo __('Você poderá enviar um vídeo em um dos seguintes formatos:'); ?><br />
		MOV, MP4, FLV, AVI, 3GP, PSP, MPEG, MPEGTS, DVD, SVCD, VCD, VOB, ASF, RM, MJPEG, MPEG2VIDEO, 3G2, MP3, OGG<br />
		<a href="<?=URL::site("assets/img/tutorial_gravacao.pdf")?>" target="_blank" style="text-decoration: underline;"><? echo __('Clique aqui'); ?></a> <? echo __('e veja como gravar um vídeo usando sua webcam.'); ?>
		</p>

	</div>
	<form method="post" action="<?php echo URL::site('candidato/testeoral/upload/'.$teste->id) ?>" id="frm_upload">
		<input type="file" name="video" id="video" />
		<div style="margin: 10px 0; display: none;" id="dv_preview"></div>
	</form>
	<div class="clear"></div>
	<br />
</div>
<br />
<script>
$(function() {
	$('#video').uploadify({
		'buttonText' : '<? echo __('SELECIONAR VÍDEO')?>',
		'width'    : 150,
		'method'   : 'post',
		'multi'    : false,
		'formData' : { 'urlsite' : '<?=URL::site()?>' },
		'swf'      : '<?=URL::site("assets/uploadify/uploadify.swf")?>',
		'uploader' : '<?=URL::site("assets/uploadify/uploadify.php")?>',
		'onUploadSuccess' : function(file, data, response) {
			$("#dv_preview").html(data);
			$("#dv_preview").show();
		}
	});
});
</script>