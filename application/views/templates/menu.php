<div class="content">

	<ul id="menu">

		<li ><a href="<?=URL::site();?>"><span class="azul"></span>home</a></li>

		<li ><a href="<?= URL::site("quemsomos");?>" class="quemsomos <?=($active=="quemsomos" ? "active" : "")?>"><span class="amarelo"></span><?=I18n::get('quem somos')?></a></li>

		<li ><a href="<?=URL::site("candidato/cadastro")?>" class="professor <?=($active=="professor" ? "active" : "")?>"><span class="verde"></span><?=I18n::get('professor')?></a></li>

		<li ><a href="<?=URL::site("contratante/cadastro")?>" class="escola <?=($active=="escola" ? "active" : "")?>"><span class="vermelho"></span><?=I18n::get('escola')?></a></li>

		<li ><a href="<?= URL::site("contato");?>" class="contato <?=($active=="contato" ? "active" : "")?>"><span class="marrom"></span><?=I18n::get('contato')?></a></li>

	</ul>

	<div class="clear"></div>

</div>