<?=$maisinfolang?>
<div id="dv_home">
	<div class="content" style=" font-family: MyriadProLightRegular; line-height: 14px;">
		<div class="cols" id="col-first">
			<a href="<?=URL::site('home/maisinfo')?>" class="1"><img src="<?=URL::site('assets/img/home/oquee.jpg')?>" /></a>
			<div class="title azul"><?=I18n::get('comofunciona')?></div>
			<p><?=I18n::get('comofuncionachamada')?></p>
		</div>
		<div class="cols">
			<a href="<?=URL::site('home/maisinfo?page=2')?>" class="2"><img src="<?=URL::site('assets/img/home/vantagens.jpg')?>" /></a>
			<div class="title amarelo"><?=I18n::get('principaisvantagens')?></div>
			<p><?=I18n::get('principaisvantagenschamada')?></p>
		</div>
		<div class="cols">
			<a href="<?=URL::site('home/maisinfo?page=3')?>" class="3"><img src="<?=URL::site('assets/img/home/faq.jpg')?>" /></a>
			<div class="title vermelho"><?=I18n::get('faq')?></div>
			<p><?=I18n::get('faqchamada')?></p>
		</div>
		<div class="cols" id="col-last">
			<a href="<?=URL::site('home/maisinfo?page=4')?>"><img src="<?=URL::site('assets/img/home/contato.jpg')?>" /></a>
			<div class="title cinza"><?=I18n::get('faleconosco')?></div>
			<p><?=I18n::get('faleconoscochamada')?></p>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div style=" padding-top: 40px; background: #fff url(<?=URL::site("assets/img/ponta-right2.jpg")?>) no-repeat right top;">
	<div id="dv_footer" style="background-color: #ffffff; margin-top: -6px;">
		<? echo View::factory("templates/footer") ?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#mycarousel').jcarousel({
		visible: 1,
		scroll: 1,
		start: <?=$start?>
	});
});

$(function(){
	$("#dv_contato").delegate("#btn_enviar", "click", function(){
		$.post(
			"<?=URL::site("contato")?>",
			$("#frm_contato").serialize(),
			function(data) {
				var contato = $(data).find("#dv_contato").html();
				$("#dv_contato").html(contato);
			}
		);
	});
});
</script>