<h2 class="h2_subtitle">Teste Oral</h2>
<div class="dv_questao">
	<h3><?=$teste->nome?></h3>
	<form method="post" action="<?php echo URL::site('candidato/testeoral/upload/'.$teste->id) ?>" id="frm_upload">
		<div style="margin: 10px 0;" id="dv_preview">
			<input type="hidden" name="filename" value="<?=$filename?>" />
			<div class="dv_myresult" id="player" style="width:450px;height:340px;text-align:center;line-height:290px;border:1px solid #c0c0c0;background:#fff;float:left;">
				<img class="button" src="<?=URL::site('assets/img/showme.png')?>" />
			</div>
			<div style="float: left; margin: 10px 20px; background: #fff; width:350px; padding: 10px;">
				Ao obter o resultado desejado, clique no botão "GRAVAR" abaixo do vídeo para concluir o teste.<br />
			</div>
			<div class="clear"></div>
			<input type="submit" name="gravar" class="uploadify-button" value="GRAVAR" style="width: 150px; height: 30px;" />
			<input type="button" name="cancelar" class="uploadify-button" value="CANCELAR" onClick="window.open('<?=URL::site("candidato/testeoral/descartar/".$video->id)?>', '_top')" style="width: 150px; height: 30px;"/>
			<script>
			$(function(){
				flowplayer("player", "http://releases.flowplayer.org/swf/flowplayer-3.2.12.swf", {
					// this will enable pseudostreaming support
					plugins: {
						pseudo: {
							url: "http://releases.flowplayer.org/swf/flowplayer.pseudostreaming-3.2.9.swf"
						}
					},

					// clip properties
					clip: {
						// our clip uses pseudostreaming
						provider: 'pseudo',
						url: 'http://profcerto.com.br<?=$targetFile?>'
					}
				});
			});
			</script>		
		</div>
	</form>
	<div class="clear"></div>
	<br />
</div>
<br />
<script>
$(function() {
	$('#video').uploadify({
		'buttonText' : 'SELECIONAR VÍDEO',
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