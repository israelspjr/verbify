<div id="dv_header">

	<div style="position: absolute; right: 20px; top: 5px;">

		<a href="<?=URL::siteChangeLng("pt")?>"><?=HTML::image('assets/img/flags/br.png');?></a>

		<a href="<?=URL::siteChangeLng("en")?>"><?=HTML::image('assets/img/flags/gb.png');?></a>

	</div>

	<div>

		<a class="logo" href="<?=URL::site()?>"><img src='<?=URL::site('assets/img/logotipo_principal.png')?>' style="width:200px" />

        </a>

        <!--<span style="    font-size: 52px;

    color: green;

    font-weight: bolder;

    font-family: serif;-->

  <!--  <span class="h2_title" style=" padding-left: 25px;padding-top:13px;color:#7F8E34;margin:0;    font-weight: bold;    width: 257px;"> Banco único de professores</span></div></a>
-->
        

	<!--	<a id='logo-disal' href="http://www.disal.com.br/"></a>-->
    
   

		<div id="dv_hello" style="margin: 20px 0 0 0;">

        

			<div style="float: left; font-size: 16pt;">

			<!--	<div style="float: left; width: 30px; overflow: hidden; margin-right: 5px;"><img src="<?=URL::site("assets/img/profcerto_atdon.jpg")?>" border="0" alt="Atendimento on line - Seguro"></div>

				<a href="#" onclick="alochat = window.open('https://clouds.aloweb.com.br/website/?cl=41299200' , 'alo41299200' , 'scrollbars=no ,width=522, height=533 , top=50 , left=50');">

					<span style="font-size: 16px; font-weight: bold; line-height: 30px; vertical-align: middle;"><? echo __('Atendimento Online'); ?></span>

				</a>

			</div>-->

			<div style="float: right; margin: 0 10px 0 20px;">

				<?=(isset($hello) ? $hello : '')?>

			</div>

			<div style="clear:both;"></div>

		</div>

		<div id="dv_search">

			<form method="post" action="<?=URL::site("buscasimples")?>">

				<input type="text" id="ipt_search" name="search" value="" />

				<div id="dv_entrar"><a href="#" id="a-entrar"><?=I18n::get('entrar')?></a></div>

				<div class="dv-buscaavancada">

				<!--	<a href="<?=URL::site("buscaavancada")?>"><?=I18n::get('busca avançada')?></a>-->

				</div>

			</form>

			<div id="dv_boxlogin">

				<form method="post" action="<?=URL::site("candidato/login")?>" id="frm-login">

					<!-- provisorio

					<input type="hidden" name="tpuser" value="P" />

					<div class="dv_opt" style="height: 5px;"></div> -->

					<div class="dv_opt">

						<label><input type="radio" name="tpuser" value="P" checked>professor</label>

						<label><input type="radio" name="tpuser" value="E">escola</label>

					</div>

					<input type="text" name="email" placeholder="email" />

					<input type="password" name="senha" placeholder="<? echo strtolower(__('senha')); ?>" />

					<input type="submit" class="btn_entrar" name="entrar" value="<? echo __("entrar2") ?>" />

					<span class="forgotpass"><a href="<? echo URL::site('candidato/forgotpass')?>" id="a-forgotpass"><? echo __('esqueceu a senha?') ?></a></span>

				</form>

			</div>

		</div>

	</div>

	<div id="dv_menu">

		<? echo View::factory("templates/menu")->bind("active", $active); ?>

	</div>

	<!--<div style="position: absolute; right: 20px; bottom: 20px;">

		<a href="<?=URL::site("candidato/cadastro")?>" style="color: red; font-size: 24px; font-weight: bold;">Cadastre-se</a>

	</div>-->

</div>

<script>

$(function(){

	$("#a-entrar").click(function(){

		if($("#dv_boxlogin").is(":visible")){

			$("#dv_boxlogin").hide();

		} else {

			$("#dv_boxlogin").show();

		}

	});

	$("input[name=tpuser]").click(function(){

		if($("input[name=tpuser]:checked").val() == 'E'){

			$("#frm-login").attr('action', '<?=URL::site("contratante/login")?>');

			$("#a-forgotpass").attr('href', '<?=URL::site("contratante/forgotpass")?>');

		} else {

			$("#frm-login").attr('action', '<?=URL::site("candidato/login")?>');

			$("#a-forgotpass").attr('href', '<?=URL::site("candidato/forgotpass")?>');

		}

	});

});

</script>

<a target="_blank" title="Entre em contato" class="whatsapp-plug-icon" style="position: fixed; z-index: 1000; bottom: 20px; left: 20px; width: 50px; height: 50px; -webkit-border-radius: 50%; cursor: pointer; background-color: #0ba360; transition: .3s; background-position: center; background-repeat: no-repeat; background-image: url('<?=URL::site("assets/img/zap23.png")?>'); background-size: 50% auto;" href="https://api.whatsapp.com/send?phone=5511969352074&amp;text=Portal do profteste: " rel="noopener noreferrer"></a>