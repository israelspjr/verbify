<h2>Escolas</h2>
<form>
	<input name="nome" value="<? echo Arr::get($_REQUEST, "nome") ?>" />
	<input type="submit" value="buscar" /> &nbsp;<input type="button" name="Excel" value="Exportar para o Excel" onclick="generateexcel('dv_table_contratantes');"/>
</form>
<?
if($pagination->total_rows == 0){
	echo '<p class="p_warning">Nenhum registro encontrado</p>';
} else {
	echo '<p>'.$pagination->total_rows.' escola(s) encontrada(s)</p>
	<div id="dv_table_contratantes">'.$table.'</div>
	<div class="dv_paginacao">'.$pagination->renderFullNav().'</div>';
}
?>
<script>

    function generateexcel(tableid) {
  	var table= document.getElementById(tableid);
  	var html = table.outerHTML;
	window.open('data:application/vnd.ms-excel,' + escape(html));
}
</script>