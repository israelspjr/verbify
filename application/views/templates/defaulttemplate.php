<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">

	<head>

		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />

		<title><?php echo (isset($title) ? $title . ' - ' : '') ?>BUP</title>

		<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>

		<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>

		<link rel="SHORTCUT ICON" href="<?=URL::site("assets/img/favicon.gif")?>" type="image/x-icon" />

		<!-- Slider Kit compatibility -->

		<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?=URL::site("assets/sliderkit/css/sliderkit-demos-ie6.css")?>" /><![endif]-->

		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?=URL::site("assets/sliderkit/css/sliderkit-demos-ie7.css")?>" /><![endif]-->

		<!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?=URL::site("assets/sliderkit/css/sliderkit-demos-ie8.css")?>" /><![endif]-->

	</head>

	<script>

		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');



		ga('create', 'UA-41705155-1', 'profcerto.com.br');

		ga('send', 'pageview');



	</script>



	<script>

		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');



		ga('create', 'UA-43681041-1', 'profcerto.com.br');

		ga('send', 'pageview');



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

		<? echo $header ?>

		<div id="dv_all">

			<div id="dv_page">

				<? echo $content ?>

			</div>

			<?php if(Request::current()->action() != 'maisinfo') { ?>

			<div id="dv_footer">

				<? echo View::factory("templates/footer") ?>

			</div>

			<?php } ?>

		</div>

	</body>

</html>

