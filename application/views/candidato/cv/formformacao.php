<div class="dvsao_expprof">
	<h2 class="h2_title">Formação n° <? echo $i ?></h2>
	<input type="hidden" name="ordem[<? echo $i ?>]" value="<? echo $i ?>">
	<div class="dv_box">
		<label class="lbl_block">Escolaridade <span class="obl">*</span></label>
		<select name="grau[<? echo $i ?>]" class="ipt_field">
		<?
		foreach($graus as $grau)
			echo '<option value="'.$grau->id.'">'.$grau->descricao.'</option>'
		?>
		</select>
	</div>
	<div class="dv_box">
		<label class="lbl_block">Curso <span class="obl">*</span></label>
		<input type="text" name="curso[<? echo $i ?>]" class="ipt_field" maxlength="150">
	</div>
	<div class="dv_box">
		<label class="lbl_block">Situação <span class="obl">*</span></label>
		<div class="ipt_field">
			<input type="radio" name="situacao[<? echo $i ?>]" id="situacao<? echo $i ?>_1" value="3" class="situacao"><label for="situacao<? echo $i ?>_1">Concluído</label>
			<input type="radio" name="situacao[<? echo $i ?>]" id="situacao<? echo $i ?>_2" value="1" class="situacao" style="margin-left: 10px;"><label for="situacao<? echo $i ?>_2">Cursando</label>
			<input type="radio" name="situacao[<? echo $i ?>]" id="situacao<? echo $i ?>_3" value="2" class="situacao" style="margin-left: 10px;"><label for="situacao<? echo $i ?>_3">Trancado</label>
		</div>
	</div>
	<div class="dv_box">
		<label class="lbl_block">Data ínicio <span class="obl">*</span></label>
		<div class="ipt_field"><input type="text" name="dtini[<? echo $i ?>]" class="mes"></div>
	</div>
	<div class="dv_box">
		<label class="lbl_block">Data conclusão <span class="obl">*</span></label>
		<div class="ipt_field">
			<input type="text" name="dtfim[<? echo $i ?>]" class="mes fim">
		</div>
	</div>
	<div class="dv_box">
		<label class="lbl_block">Nome da instituição <span class="obl">*</span></label>
		<input type="text" name="instituicao[<? echo $i ?>]" class="ipt_field" maxlength="150">
	</div>
	<br class="clear" />
</div>