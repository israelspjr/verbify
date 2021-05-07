<?
echo '
<div class="dvsao_certificacoes">
	<h2 class="h2_title">'.__('Certificação').' n° '.$i.'</h2>
	<input type="hidden" name="cordem['.$i.']" value="'.$i.'">
	<ul>
		<li>
			<label for="cert" class="lbl-left">'.__('Certificação').' <span class="obl">*</span></label>
			<input type="text" name="cert_descricao['.$i.']" class="ipt" />
		</li>
		<li>
			<label for="cert" class="lbl-left">'.__('Ano').' <span class="obl">*</span></label>
			<input type="text" name="cert_ano['.$i.']" class="ipt ano" />
		</li>
		<li>
			<label for="cert" class="lbl-left">'.__('Tipo').' <span class="obl">*</span></label>
			<label class="lbl-radio">
				<input type="radio" name="cert_tipo['.$i.']" value="N" class="rdo" checked>
				<span>'.__('Nacional').'</span>
			</label>
			<label class="lbl-radio">
				<input type="radio" name="cert_tipo['.$i.']" value="I" class="rdo">
				<span>'.__('Internacional').'</span>
			</label>
		</li>
		<li>
			<label for="cert" class="lbl-left">'.__('Idioma').' <span class="obl">*</span></label>
			<select name="cert_idioma['.$i.']" class="ipt">
				<option></option>';
				foreach($idiomas as $row){
					echo '<option value="'.$row->id.'">'.__($row->descricao).'</option>';
				}
			echo '
			</select>
		</li>
	</ul>
	<br class="clear" />
</div>';
?>