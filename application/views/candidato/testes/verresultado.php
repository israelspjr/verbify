<?
if($testeex->teste->tipo==2){
	echo '<h2 class="h2_subtitle">Vídeo: '.$teste->nome.'</h2>';
} else {
	echo '<h2 class="h2_subtitle">'.__('Resultado').': '.$teste->getNome($lang).'</h2>';
}
/*Número de questões: <?=$teste->questoes->count_all()?><br />
Situação: <?=$testeex->getSituacao()?><br />
*/
?>
<div id="dv_testes" style="border: 1px solid silver; background: #F0F0F0; padding: 10px; margin: 10px 0;">
	<?
	echo ($testeex->teste->tipo==2 ? Controller_Candidato_TesteOral::htmlResultados($testeex): Controller_Candidato_Testes::htmlResultados($testeex, $lang));
	?>
</div>
<div class="dv_btn">
	<form method="post" action="<?=URL::site("candidato/testes/resultados")?>">
		<input type="hidden" name="testeex_id" value="<?=$testeex->id?>" />
	<!--	//($testeex->divulgar == 0 ? '<input name="publicar" type="submit" value="'.__('Publicar').'" />' : '<input name="despublicar" type="submit" value="'.__('Despublicar').'" />')?>-->
		<input type="button" value="<? echo __('Voltar'); ?>" onClick="window.open('<?=URL::site("candidato/testes/resultados")?>', '_top');" />
	</form>
</div>
