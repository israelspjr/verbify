<h2 class="h2_subtitle">Teste Oral</h2>
<div class="dv_questao">
	<h3><?=$teste->nome?></h3>
	<p class="p_pergunta">
		<?php if ($uploaded_file): ?>
			<h2 class="h2_subtitle">Upload efetuado com sucesso</h2>
		<?php else: ?>
			<p><?php echo $error_message ?></p>
				<div>
					<a href="<?=URL::site("candidato/testeoral/index/".$teste->id)?>">Voltar</a>
				</div>
		<?php endif ?>
	</p>
</div>