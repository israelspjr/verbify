<p class="p_success">Parabéns, o teste foi concluído com sucesso.</p>
<div>
	<h3><?=$teste->teste->nome?></h3>
	<?=$html?>
	<div class="dv_btn">
		<form method="post" action="<?=URL::site("candidato/testes/resultados")?>">
			<input type="hidden" name="testeex_id" value="<?=$teste->id?>" />
			<!-- <input class="btn_start" name="publicar" type="submit" value="Publicar" /> -->
			<input name="publicar" type="submit" value="Publicar" />
		</form>
	</div>
</div>