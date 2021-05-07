<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title><?php echo (isset($title) ? $title . ' - ' : '') ?>Companhia de Idiomas</title>
		<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
		<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
	</head>
	<body>
		<div id="dv_all">
			<?php echo $content ?>
		</div>
	</body>
</html>