<?php 

//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".URL::site("candidato/login")."'>";

?>

<div id="dv_home">

	<div id="dv_video">

  <!--  <ul id="slider">

      <?php

   //   if(isset($banners) && count($banners) > 0) {

   //     foreach($banners as $banner) { ?>

			<li>

				<a href="<?=$banner->link?>">

					<img src="<?=URL::site('uploads/banners/'.$banner->banner);?>" alt="" />

				</a>

			</li>

			<?php

			// <?=URL::site("candidato/cadastro")

			//$banner->link;

     //   }

 //   } ?>

    </ul>

    <script type="text/javascript">

      $(function(){

        $('#slider').rhinoslider({

			autoPlay: 'true',

			effect: 'fade',

			showTime: '8000'

        });

      });

    </script>

	</div>-->

	<div id="dv_texto">

		<div class="content">

			<div id="dv_home_meio">

				<h1><?=I18n::get('homeh1')?></h1>

				<p><?=I18n::get('homep1')?></p>

				<p><?=I18n::get('homep2')?></p>

				<p><?=I18n::get('homep3')?></p>

			</div>

		</div>

	</div>

	<div class="content" style=" font-family: MyriadProLightRegular; line-height: 14px;">

		<div class="cols" id="col-first">

			<a href="<?=URL::site('home/maisinfo')?>"><img src="<?=URL::site('assets/img/home/oquee.jpg')?>" /></a>

			<div class="title azul"><?=I18n::get('comofunciona')?></div>

			<p><?=I18n::get('comofuncionachamada')?></p>

		</div>

		<div class="cols">

			<a href="<?=URL::site('home/maisinfo?page=2')?>"><img src="<?=URL::site('assets/img/home/vantagens.jpg')?>" /></a>

			<div class="title amarelo"><?=I18n::get('principaisvantagens')?></div>

			<p><?=I18n::get('principaisvantagenschamada')?></p>

		</div>

		<div class="cols">

			<a href="<?=URL::site('home/maisinfo?page=3')?>"><img src="<?=URL::site('assets/img/home/faq.jpg')?>" /></a>

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