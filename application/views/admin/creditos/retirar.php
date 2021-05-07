<form method="post">
	<div>
		<label><input type="radio" name="tpconta" value="C" <? echo ($tipo=="C" ? "checked" : "")?>/> Contratante</label>
		<label><input type="radio" name="tpconta" value="P" <? echo ($tipo=="P" ? "checked" : "")?>/> Professor</label>
	</div>
	<div style="margin: 10px 0;">
		<input type="text" name="nome" placeholder="nome" style="width: 500px;"/>
		<input type="submit" value="buscar" />
	</div>
</form>
<?
if($pagination->total_rows == 0){
	echo '<p class="p_warning">Nenhum registro encontrado</p>';
} else {
	echo '<p>'.$pagination->total_rows.' candidatos encontrados</p>
	<div id="dv_table_contratantes">'.$table.'</div>
	<div class="dv_paginacao">'.$pagination->renderFullNav().'</div>';
}
?>