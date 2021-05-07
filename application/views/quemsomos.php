<div class="content2" style="margin-top: 30px;">
	<div class="dv_quadrado_invisivel amarelo"></div>
	<h2 class="h2_title txt-amarelo"><?=I18n::get('quem somos')?></h2>
	<div class="clear"></div>
	<div>
		<div class="dv_img" style="width: 950px; height: 527px; overflow: hidden;"><img src="<?=URL::site("assets/img/home/quem_somos_BX.jpg")?>" /></div>
		<div id="dv_quemsomos">
			<div id="dv_texto">
				<p><?=I18n::get('quemsomosp1')?></p>
				<div style="margin: 15px 0;">
					<p><?=I18n::get('quemsomosp2')?></p>
					<p><?=I18n::get('quemsomosp3')?></p>
					<p><?=I18n::get('quemsomosp4')?></p>
					<p><?=I18n::get('quemsomosp5')?></p>
				</div>
				<p><?=I18n::get('quemsomosp6')?></p>
			</div>
			<a href="<?=URL::site("home/maisinfo")?>"><h2><?=I18n::get('comofunciona')?></h2></a>
			<a href="<?=URL::site("home/maisinfo?page=2")?>"><h2><?=I18n::get('principaisvantagens')?></h2></a>
			<a href="<?=URL::site("home/maisinfo?page=3")?>"><h2><?=I18n::get('faq')?></h2></a>
		</div>
	</div>
</div>