<?
echo '
<div class="dvsao_graduacoes">
	<h2 class="h2_title">'.__('Graduação').' n° '.$i.'</h2>
	<input type="hidden" name="gordem['.$i.']" value="'.$i.'">
	<ul>
		<li>
			<label class="lbl-left">'.__('Escolaridade').' <span class="obl">*</span></label>
			<select name="escolaridade['.$i.']" class="ipt escolaridade">';
				foreach($grauescolar as $row){
					echo '<option value="'.$row->id.'">'.__($row->descricao).'</option>';
				}
				echo '
			</select>
		</li>
		<li class="li_curso hide">
			<label class="lbl-left">'.__('Curso').' <span class="obl">*</span></label>
			<select name="curso['.$i.']" class="ipt" id="selcurso'.$i.'">
				<option value="0"></option>';
				foreach($cursos as $row) {
					echo '<option value="'.$row->id.'">'.$row->descricao.'</option>';
				}
				echo '
			</select>
			<a class="outro" href="#dv-outro" rel="'.$i.'">'.__('Outro').'</a>
		</li>
		<li>
			<label class="lbl-left">'.__('Situação').' <span class="obl">*</span></label>
			<div class="ipt">
			<label >
				<input type="radio" name="situacao['.$i.']" value="3" groupname="situacao'.$i.'" class="situacao" checked />
				<span>'.__('Concluído').'</span>
			</label>
			<label >
				<input type="radio" name="situacao['.$i.']" value="1" groupname="situacao'.$i.'" class="situacao" />
				<span>'.__('Cursando').'</span>
			</label>
			<label >
				<input type="radio" name="situacao['.$i.']" value="2" groupname="situacao'.$i.'" class="situacao" />
				<span>'.__('Trancado').'</span>
			</label>
			<br>
			<label >
				<input type="radio" name="situacao['.$i.']" value="4" groupname="situacao'.$i.'" class="situacao" />
				<span>'.__('Não lembro as datas').'</span>
			</label>
			</div>
		</li>
		<li>
			<label for="dtini" class="lbl-left">'.__('Data ínicio').' </label>
			<input type="text" name="grad_dtini['.$i.']" class="mes ipt ini" />
		</li>
		<li>
			<label for="dtfim" class="lbl-left">'.__('Data conclusão').' </label>
			<input type="text" name="grad_dtfim['.$i.']" class="mes ipt fim" /> 
		</li>
		<li>
			<label for="cert" class="lbl-left">'.__('Instituição').' </label>
			<input type="text" name="instituicao['.$i.']" class="ipt" />
		</li>
	</ul>
	<br class="clear" />
</div>';
?>