<?
if(isset($errors)){
	echo '<p class="erro">'.$errors.'</p>';
} else {
	?>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Mini Currículo</a></li>
			<li><a href="#tabs-2">Interesses</a></li>
			<li><a href="#tabs-3">Experiências / Formação</a></li>
			<li><a href="#tabs-4">Testes</a></li>
		</ul>
		<div id="tabs-1">
			<? include_once("curriculo/mini.php") ?>
		</div>
		<div id="tabs-2">
			<? include_once("curriculo/interesse.php") ?>
		</div>
		<div id="tabs-3">
			<? include_once("curriculo/experiencia.php") ?>
		</div>
		<div id="tabs-4">
			<? include_once("curriculo/testes.php") ?>
		</div>
	</div>
	<?
}
?>
<a href="<?=URL::site("contratante/curriculo/contato/".$candidato->id)?>">ver dados de contato >></a>
<script>
$(function() {
	$( "#tabs" ).tabs({ selected: 1 });
});
</script>
