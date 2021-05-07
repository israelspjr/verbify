<?
$dvs = array();
foreach($respostas as $row)
{
	$error = (isset($errors[$row->valor]) ? $errors[$row->valor] : array());
	$dvs[] = '<label>'.$row->valor.'</label>
	<div>
		<textarea name="texto['.$row->id.']">'.Arr::get($resultado, $row->valor).'</textarea>
		'.(Arr::get($error, "texto") ? '<label class="error">'.Arr::get($error, "texto").'</label>' : '').'
	</div>';
}
?>
<h2>Cadastrar Resultados</h2>
<?=(isset($success) ? $success : '')?>
<form method="post" id="frm_resultados">
	<div>
		<? echo implode("", $dvs); ?>
	</div>
	<div class="dv_btn">
		<input type="submit" name="salvar" value="salvar" />
		<input type="button" name="cancelar" value="voltar" onClick="window.open('<?=URL::site('admin/testes/editar/'.$teste->id)?>', '_top')" />
	</div>
</form>