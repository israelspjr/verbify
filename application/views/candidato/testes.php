<h2 class="h2_subtitle"><? echo __('testes'); ?></h2>
<div id="dv_testes">
<? if(count($testes) > 0){ ?>
	<ul class="ul_testes">
	<?
	foreach($testes as $teste){
		echo '<li>'.Controller_Candidato_Testes::getChamada($teste, $convites, $lang).'</li>';
	} ?>
	</ul>
<? } else { ?>
	<p class="p_warning">Nenhum teste disponível</p>
<? } ?>