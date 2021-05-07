<table class="tb_lista">
	<tr>
		<th>Pacote (Créditos)</th>
		<th>Investimento (R$)</th>
		<th>Ação</th>
	</tr>
	<tr>
		<form method="post">
		<td>
			<input type="text" name="credito" class="numeric" value="<?=(isset($errors) ? Arr::get($_POST, "credito") : '')?>" />
			<span class="error"><?=(isset($errors["creditos"]) ? $errors["creditos"] : '') ?></span>
		</td>
		<td>
			<input type="text" name="preco" class="money" value="<?=(isset($errors) ? Arr::get($_POST, "preco") : '')?>" />
			<span class="error"><?=(isset($errors["reais"]) ? $errors["reais"] : '') ?></span>
		</td>
		<td><input type="submit" name="cadastrar" value="cadastrar" /></td>
		</form>
	</tr>
	<?
	foreach($pacotes as $pack){
		echo '
		<tr>
			<td>'.$pack->creditos.'</td>
			<td>'.Helper::number_format($pack->reais).'</td>
			<td>
				<form method="post">
					<input type="hidden" name="pack_id" value="'.$pack->id.'" />
					<input type="submit" name="excluir" value="excluir" />
				</form>
			</td>
		</tr>';		
	}
	?>
</table>
<script>
$(function() {
	$(".money").maskMoney({ thousands:'.', decimal:','});
});

// Numeric only control handler
jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 8 ||
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};
$(".numeric").ForceNumericOnly();
</script>