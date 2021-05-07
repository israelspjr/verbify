<?

if(isset($errors)){

	echo '<p class="erro">'.$errors.'</p>';

} else {

	?>

	<div id="tabs">

		<ul>

			<li><a href="<?=URL::site("contratante/")?>">Mini Currículo</a></li>

			<li><a href="#tabs-2">Interesses</a></li>

			<li><a href="#tabs-3">Experiências / Formação</a></li>
            
            <li><a href="#tabs-3">Competências</a></li>

			<li><a href="#tabs-4">Testes</a></li>

		</ul>

	</div>

	<?

}

?>

<script>

$(function() {

	$( "#tabs" ).tabs({ selected: 1 });

});

</script>

