<h2>Language Tests</h2>

<?php

if(count($results) > 0) {

	$trs = array();

	$i = 0;

	foreach($results as $row){

		$i++;

		$trs[] = '

		<tr class="'.($i%2 == 0 ? "tr_even" : "tr_odd").'">

			<td><a href="'.URL::site("admin/testesidiomas/editar/".$row->id).'">'.$row->nome.'</a></td>

			<td>'.$row->getPublicado().'</td>

		</tr>';

	}

	echo '<p>'.count($results).' testes cadastrados</p>

	<table class="tb_lista">

		<tr>

			<th>Nome</th>

			<th>Publicado</th>

		</tr>

		'.implode("", $trs).'

	</table>';

} else {

	echo '<p class="p_warning">Nenhum teste cadastrado</p>';

}

?>

<input type="button" name="cadastrar" value="registering new test" onClick="window.open('<?=URL::site('admin/testesidiomas/cadastro')?>', '_top');" />

