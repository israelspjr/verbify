<div class="dvsao_cursos">
	<h2 class="h2_title"><? echo __('Curso'); ?> n° <? echo $i ?></h2>
	<input type="hidden" name="cursoordem[<? echo $i ?>]" value="<? echo $i ?>">
	<ul>
		<li>
			<label for="cursolivre" class="lbl-left"><? echo __('Curso'); ?> <span class="obl">*</span></label>
			<input name="cursolivre[<?=$i?>]" class="ipt" maxlegth="200" />
		</li>
		<li>
			<label for="instituicao" class="lbl-left"><? echo __('Instituição'); ?> <span class="obl">*</span></label>
			<input name="cl_instituicao[<?=$i?>]" class="ipt" maxlegth="200" />
		</li>
		<li>
			<label for="ano" class="lbl-left"><? echo __('Ano'); ?> <span class="obl">*</span></label>
			<input name="cl_ano[<?=$i?>]" class="ipt" />
		</li>
	</ul>
	<br class="clear" />
</div>