<div id="menucontratante" class="menurestrito">
	<ul class="menu">
		<li><a href="" class="parent"><span>seleção</span></a>
			<div>
				<ul>
					<? if ($user->conveniado == 1){ ?>
						<li><a href="<?= URL::site("contratante/buscarcadastrados")?>"><span>trabalhe conosco</span></a></li>
					<? } ?>
					<li><a href="<?= URL::site("contratante/buscarprofessores")?>"><span>buscar professores - portal</span></a></li>
					<li><a href="<?= URL::site("contratante/acompanhamento")?>"><span>acompanhamento</span></a></li>
				</ul>
			</div>
		</li>
		<li><a href="<?= URL::site("contratante/minhasvagas")?>" class="parent"><span>minhas vagas</span></a></li>
		<li><a href="<?= URL::site("contratante/meuscreditos")?>" class="parent"><span>meus créditos</span></a></li>
		<li><a href="<?= URL::site("contratante/meusdados")?>" class="parent"><span>meus dados</span></a></li>
		<li><a href="<?= URL::site("contratante/alterarsenha")?>" class="parent"><span>alterar senha</span></a></li>
		<li><a href="<?= URL::site("contratante/login/logout")?>" class="parent"><span>sair</span></a></li>
	</ul>
</div>