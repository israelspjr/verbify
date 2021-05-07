<div style="width: 900px; margin-right: 20px;">
	<h2 class="h2_teste"><?=$teste->getNome()?></h2>
	<div>
		Número de questões: <?=$teste->questoes->count_all()?><br />
		Data: <?=Helper::format_timestamp($testeex->dt_execucao) ?><br />
		<div class="dv_resultado">
			<div id="dv_testes" style="border: 1px solid silver; background: #F0F0F0; padding: 10px; margin: 10px 0;">
				<? 
				echo ($testeex->teste->tipo==2 ? Controller_Candidato_TesteOral::htmlResultados($testeex): Controller_Candidato_Testes::htmlResultados($testeex));
				?>
			</div>
		</div>
	</div>
</div>