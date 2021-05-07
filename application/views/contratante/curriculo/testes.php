<div class="curriculo">
	<h2>Testes Publicados</h2>
	<? if(count($testespublicados) > 0){ ?>
		<table class="tb_geral">
			<tr>
				<th>Teste</th>
				<th class="th_link">Ação</th>
			</tr>
			<?
			foreach($testespublicados as $row){
				$link = '<a href="'.URL::site('contratante/testes/resultado?teste_id='.$row->id.'&candidato_id='.$candidato->id).'" class="a_ver">Ver</a>';
				echo '
				<tr>
					<td>'.$row->getNome().'</td>
					<td>'.$link.'</td>
				</tr>';
			}
			?>
		</table>
	<? } else {
		echo '<p>Nenhum teste disponível</p>';
	} 
	?>

	<h2>Testes Disponíveis</h2>
	<? if(count($testesoutros) > 0){ ?>
		<table class="tb_geral">
			<tr>
				<th>Teste</th>
				<th class="th_link">Ação</th>
			</tr>
			<?
			foreach($testesoutros as $row){
				$link = '<a href="'.URL::site('contratante/testes/convidar?teste_id='.$row->id.'&candidato_id='.$candidato->id).'" class="a_convidar">Convidar</a>';
				echo '
				<tr>
					<td>'.$row->getNome().'</td>
					<td>'.$link.'</td>
				</tr>';
			}
			?>
		</table>
	<? } else {
		echo '<p>Nenhum teste disponível</p>';
	} 
	?>
	
</div>
<script>
$(function(){
	$(".a_ver").fancybox({
		'hideOnContentClick' : true,
		'padding' : 10,
		'width' : 940,
		'autoResize' : true,
		'type' : 'iframe'
	});
	
	$(".a_convidar").fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
		'width'			: '400px',
        'autoScale'     : true,
		'type'			: 'iframe'
	});
});
</script>

