<h2>Tabela de desconto do contato</h2>
<p>Custo padrão: <?=$padrao->consumo?> créditos</p>
<form action="" method="post" id="frm_desconto">
	<input type="hidden" name="id" value="" />
	<fieldset>
		<p>
			Se contratante já pagou <input type="text" name="minimo" class="numeric" value="" /> créditos, <br />
			Custo do contato será de <input type="text" name="consumo" class="numeric" value="" /> créditos
		</p>
		<input type="submit" name="salvar" value="gravar" />
		<input type="button" onclick="window.location.reload()" value="cancelar" />
	</fieldset>
</form>
<?
if(count($descontos) > 0){
	$rows = array();
	foreach($descontos as $row){
		$rows[] = '<tr><td><span class="minimo">'.$row->minimo.'</span> créditos</td><td><span class="consumo">'.$row->consumo.'</span> créditos</td><td><a href="#" class="lnk_editar" id="'.$row->id.'">Editar</a> | <a href="'.URL::site("admin/parametros/excluirdescontos/".$row->id).'">Excluir</a></td></tr>';
	}
	$table = '<table class="tb_lista">
		<tr>
			<th>Pagou</th>
			<th>Custo Contato</th>
			<th>Ação</th>
		</tr>
		'.implode("", $rows).'</table>';
	echo $table;
}
?>
<script>
	$(".lnk_editar").click(function(){
		var id = $(this).attr("id");
		var minimo = $(this).parents("tr").find(".minimo").html();
		var consumo = $(this).parents("tr").find(".consumo").html();
		$("input[name=minimo]").val(minimo);
		$("input[name=consumo]").val(consumo);
		$("input[name=id]").val(id);
		return false;
	});
</script>