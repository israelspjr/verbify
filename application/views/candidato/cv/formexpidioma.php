<?
echo '
<div class="dvsao_experiencias">
	<h2 class="h2_title">'.__('Experiência Profissional').' n° '.$i.'</h2>
	<input type="hidden" name="epordem_idioma['.$i.']" value="'.$i.'">
	<ul>
		<li>
			<label class="lbl-left">'.__('Função').' <span class="obl">*</span></label>
			<input type="text" name="funcao_idioma['.$i.']" class="ipt" />
		</li>
		<li>
			<label class="lbl-left">'.__('Data ínicio').' <span class="obl">*</span></label>
			<input type="text" name="exp_dtinicio_idioma['.$i.']" class="ipt mes" />
		</li>
		<li>
			<label class="lbl-left">'.__('Data saída').' <span class="obl">*</span></label>
			<input type="text" name="exp_dtfim_idioma['.$i.']" class="ipt mes dtfim" />
			<label><input type="checkbox" class="atual" name="atual_idioma[1]" checked value="1">'.__('Atualidade').'</label>
		</li>
	</ul>
	<br class="clear" />
</div>';
?>