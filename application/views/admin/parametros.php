<h2>Parâmetros</h2>
<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
<? echo (isset($erro) ? '<p class="p_erro">'.print_r($erro).'</p>' : ''); ?>
<form method="post" id="frm_params">
	<fieldset>
		<legend>Preço do crédito</legend>
		<ul>
			<li>
				<label class="lblconsumo">1 crédito = </label>
				<input type="text" name="reais" value="<?=Helper::number_format($conversao->real)?>" class="money" />
				<label for="consumo" class="error"><?=(Arr::get($errors, 'reais'))?></label>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<legend>Consumo de Créditos</legend>
		<table class="tb_consumo">
			<tr>
				<th class="td_descricao">Ação</th>
				<th class="ipt">Contratante</th>
				<th class="ipt">Contratante Conv.</th>
			</tr>
		<?
		foreach($consumos as $consumo){
			$erro = Arr::get($errors, $consumo->id);
			echo '
			<tr>
				<td>'.$consumo->descricao.'</td>
				<td><input type="text" name="consumo['.$consumo->id.']" maxlegth="3" value="'.$consumo->consumo.'" class="numeric" /></td>
				<td><input type="text" name="consumo_conveniado['.$consumo->id.']" maxlegth="3" value="'.$consumo->consumo_conveniado.'" class="numeric" /></td>
			</tr>';
		}
		?>
		</table>
		<div id="dv_descontos">
			<a href="<?=URL::site("admin/parametros/descontos")?>">tabela de desconto do contato</a>
		</div>
		<hr style="margin: 10px 0;" />
		<table class="tb_consumo">
			<tr>
				<th class="td_descricao">Teste</th>
				<th class="ipt">Escola</th>
				<th class="ipt">Escola Conv.</th>
				<th class="ipt">Professor</th>
				<th class="ipt">Professor Conv.</th>
			</tr>
			<?
			foreach($testes as $teste){
				echo '
				<tr>
					<td>'.$teste->nome.'</td>
					<td><input type="text" name="consumoteste['.$teste->id.']" maxlegth="3" value="'.$teste->consumo.'" class="numeric" /></td>
					<td><input type="text" name="consumo_teste_conveniado['.$teste->id.']" maxlegth="3" value="'.$teste->consumo_conveniado.'" class="numeric" /></td>
					<td><input type="text" name="consumotesteprof['.$teste->id.']" maxlegth="3" value="'.$teste->consumo_professor.'" class="numeric" /></td>
					<td><input type="text" name="consumo_teste_profconveniado['.$teste->id.']" maxlegth="3" value="'.$teste->consumo_professor_conveniado.'" class="numeric" /></td>
				</tr>';
				//<label for="consumo" class="error">'.(Arr::get($erro, 'consumo')).'</label>
			}
			?>
		</table>
	</fieldset>
	<div class="dv-btn">
		<input type="submit" name="salvar" value="salvar" />
	</div>
</form>
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