<div id="candidatomenu" class="menurestrito">

	<ul class="menu">

		<li><a href="#" class="parent"><span><? echo __('vagas')?></span></a>

			<div>

				<ul>

					<li><a href="<?= URL::site("candidato/vagas")?>"><span><? echo __('buscar vagas')?></span></a></li>

					<li><a href="<?= URL::site("candidato/candidaturas")?>"><span><? echo __('candidaturas')?></span></a></li>

				</ul>

			</div>

		</li>

	<!--	<li><a href="<?= URL::site("candidato/meuscreditos")?>" class="parent"><span><? echo __('meus créditos')?></span></a></li>-->

		<li><a href="<?= URL::site("candidato/meusdados")?>" class="parent"><span><? echo __('currículo')?></span></a></li>

		<li><a href="#" class="parent"><span><? echo __('testes'); ?></span></a>

			<div>

				<ul>

					<li><a href="<?= URL::site("candidato/testes")?>"><span><? echo __('realizar teste'); ?></span></a></li>

					<li><a href="<?= URL::site("candidato/testes/resultados")?>"><span><? echo __('resultados'); ?></span></a></li>

				</ul>

			</div>
            
            <li><a href="<?= URL::site("candidato/referencias")?>" class="parent"><span><? echo __('referências')?></span></a></li>

		</li>

		<li><a href="<?= URL::site("candidato/alterarsenha")?>" class="parent"><span><? echo __('alterar senha'); ?></span></a></li>

		<li><a href="<?= URL::site("candidato/login/logout")?>" class="parent"><span><? echo __('sair'); ?></span></a></li>

	</ul>

</div>

