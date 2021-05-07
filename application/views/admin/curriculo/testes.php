<div class="curriculo">
	<h2>Testes Realizados</h2>
    <table class="tb_geral">
<?php 

if ($_REQUEST['deletar'] == 1) {
	
	$teste_id2 = $_REQUEST['teste_id2'];
	
	$teste2 = DB::delete("teste_executado")
			->where('candidato_id' , '=', $candidato->id)
			->where('teste_id', '=', $teste_id2)
			->execute();
			
	$teste2 = DB::delete("candidato_resposta")
			->where('candidato_id' , '=', $candidato->id)
			->where('teste_id', '=', $teste_id2)
			->execute();
			
	echo "teste deletado com sucesso";		

}
		$teste = DB::select('teste_id', 'candidato_id', 'dt_execucao', 'divulgar')
			->from("teste_executado")
			->where('candidato_id' , '=', $candidato->id)
			->execute();
			
			
			
			foreach($teste as $row) {
				
			$nomeIdioma = DB::select('id', 'nome')
			->from('testes')
			->where('id' , '=', $row['teste_id'])
			->execute();
			
				echo '
				<tr>
					<td><a href="'.URL::site('admin/testesexecutados/resultado?teste_id='.$row['teste_id'].'&candidato_id='.$candidato->id).'" class="a_ver" style="  text-decoration: underline;">'.$nomeIdioma[0]['nome'].'</a> &nbsp;&nbsp;<a href="'.URL::site('admin/curriculo/testes/'.$candidato->id).'?deletar=1&teste_id2='.$row['teste_id'].'"><img src="'.URL::site('../assets/img/excluir.png').'"></a></td>
				</tr>';
			}
			

    ?></table>
    <h2>Testes Publicados</h2>
	<? if(count($testespublicados) > 0){ ?>
		<table class="tb_geral">
			<?
			foreach($testespublicados as $row){
				echo '
				<tr>
					<td><a href="'.URL::site('admin/testesexecutados/resultado?teste_id='.$row->id.'&candidato_id='.$candidato->id).'" class="a_ver">'.$row->nome.'</a></td>
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
		<table class="tb_geral" >
			<?
			foreach($testesoutros as $row){
				echo '
				<tr>
					<td>'.$row->nome.'</td>
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
	  'type' : 'ajax',
	  'padding' : 20,
	  'autoResize' : true
	});
	
});
</script>
