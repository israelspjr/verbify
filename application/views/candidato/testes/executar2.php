<h2 class="h2_subtitle"><?=$teste->getNome()?></h2>
<?=(isset($error) ? $error : '')?>
<? if($question->loaded()){ ?>
	<form method="post" id="frm_questao">
		<input type="hidden" name="tempoesgotado" id="tempoesgotado" value="0" />
		<input type="hidden" name="dtempo" id="ipt-tempo" value="<?=$tempo?>" />
		<input type="hidden" name="questao_id" value="<?=$question->id?>" />
		<div class="dv_questao">
			<div style="float: right; margin: 10px;"><span id="tempo"></span></div>
			<h3><? echo __('Pergunta'); ?><?=$question->ordem?> / <?=$questions?> <?=($question->topico<>"" ? ": ".$question->topico : "")?></h3>
			<?=FormTestes::getHtmlCandidatoShowNextQuestion($question, $question->ordem, (isset($error) ? Arr::get($_POST,"resposta") : ''))?>
		</div>
		<input type="submit" name="gravar" id="btn_gravar" value="<? echo __('gravar'); ?>"/>
	</form>
<script type="text/javascript">
$(function(){
	<? if($question->max_tempo > 0)
	{
		echo 'contador('.$tempo.');';
	}
	?>
});
</script>
<? } else { ?>
	<p class="p_success"><? echo __('Parabéns, você concluiu o teste.').' <a href="'.URL::site("candidato/testes/resultados/".$teste->id).'">'.__('Clique aqui').'</a> '.__('para ver o resultado').'.'; ?></p>
<?
}
?>