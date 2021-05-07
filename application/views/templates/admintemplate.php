<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title><?php echo (isset($title) ? $title . ' - ' : '') ?>ProfTeste</title>
		<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
		<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
		<link rel="SHORTCUT ICON" href="<?=URL::site("assets/img/favicon.gif")?>" type="image/x-icon" />
	</head>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-38716664-1']);
		_gaq.push(['_trackPageview']);
	
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-43681041-1']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	<body>
		<div id="dv_all">
			<div id="dv_header">
				<div class="faixa"></div>
				<div class="content">
					<div class="logo"></div>
					<?=View::factory("templates/menuadmin")?>
				</div>
			</div>
			<div id="dv_page">
				<div class="content">
					<? echo $content ?>
				</div>
			</div>
			<div id="dv_footer">
				<!--Desenvolvido por <a href="http://www.vgt.com.br" target="_blank">VGT Tecnologia</a> divisão <a href="http://www.vgsites.com.br" target="_blank">VGSites</a>.-->
				@ Todos os direitos reservados. - <?php echo date("Y") ?>.
			</div>
		</div>
	</body>
</html>
