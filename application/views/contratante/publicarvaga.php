<h2 class="h2_subtitle">Publicar Vaga</h2>
<form method="post" id="frm_vaga">
	<div>
		<label class="frm_lbl">Idioma <span class="obl">*</span></label>
		<select name="idioma" class="ipt">
			<option value=""></option>
			<?
			foreach($idiomas as $idioma) {
				echo '<option value="'.$idioma->id.'" '.(Arr::get($values, "idioma")==$idioma->id ? 'selected' : '').'>'.$idioma->descricao.'</option>';
			}
			?>
		</select>
		<label class="error"><?=Arr::get($errors, "idioma_id")?></label>
	</div>
	
	<div>
		<label class="frm_lbl">Estado <span class="obl">*</span></label>
		<select name="estado" class="ipt">
			<option value=""></option>
			<?
			foreach($estados as $estado) {
				echo '<option value="'.$estado->vc_uf.'" '.(Arr::get($values, "estado") == $estado->vc_uf ? 'selected' : '').'>'.$estado->vc_estado.'</option>';
			}
			?>
		</select>
		<label class="error"><?=Arr::get($errors, "estado_id")?></label>
	</div>
	<div>
		<label class="frm_lbl">Cidade <span class="obl">*</span></label>
		<div id="dv_cidade"></div>
		<label class="error"><?=Arr::get($errors, "cidade_id")?></label>
	</div>
	<div id="dv_regiao_all">
		<label class="frm_lbl">Região <span class="obl">*</span></label>
		<div id="dv_regiao"></div>
		<label class="error"><?=Arr::get($errors, "regiao_id")?></label>
	</div>

	<div>
		<label class="frm_lbl">Bairro</label>
		<input type="text" name="bairro" value="<?=Arr::get($values, "bairro")?>" maxlength="200" />
	</div>
	<div>
		<label class="frm_lbl">Selecione <span class="obl">*</span></label>
		<div class="dv_campo">
			<label><input type="checkbox" name="local[]" value="e" <?=(Arr::get($values, "locale") == 1 ? 'checked' : '') ?> />aulas na escola</label><br />
			<label><input type="checkbox" name="local[]" value= "c" <?=(Arr::get($values, "localc") == 1 ? 'checked' : '') ?> />aulas in company</label>
		</div>
		<label class="error"><?=Arr::path($errors, "_external.local")?></label>
	</div>
	<div>
		<label class="frm_lbl">Selecione <span class="obl">*</span></label>
		<div class="dv_campo">
			<label><input type="checkbox" name="tipo[]" value="c" <?=(Arr::get($values, "tipoc") == 1 ? 'checked' : '') ?> />cursos para crianças</label><br />
			<label><input type="checkbox" name="tipo[]" value="t" <?=(Arr::get($values, "tipot") == 1 ? 'checked' : '') ?> />cursos para adolescentes</label><br />
			<label><input type="checkbox" name="tipo[]" value="a" <?=(Arr::get($values, "tipoa") == 1 ? 'checked' : '') ?> />cursos para adultos</label>
		</div>
		<label class="error"><?=Arr::path($errors, "_external.tipo")?></label>
	</div>
	<div>
		<label class="frm_lbl">Número de vagas <span class="obl">*</span></label>
		<input type="text" name="nvagas" value="<?=Arr::get($values, "nvagas")?>" maxlength="200" />
		<label class="error"><?=Arr::get($errors, "nvagas")?></label>
	</div> 
	<?/*
	<div>
		<label class="frm_lbl">Título da Vaga <span class="obl">*</span></label>
		<input type="text" name="titulo" value="<?=Arr::get($values, "titulo")?>" maxlength="200" />
		<label class="error"><?=Arr::get($errors, "titulo")?></label>
	</div>
	<div>
		<label class="frm_lbl">Descrição da Vaga <span class="obl">*</span></label>
		<textarea name="descricao"><?=Arr::get($values, "descricao")?></textarea>
		<label class="error"><?=Arr::get($errors, "descricao")?></label>
	</div>
	<div>
		<label class="frm_lbl">Horário</label>
		<input type="text" name="horario" value="<?=Arr::get($values, "horario")?>" />
	</div>
	<div>
		<label class="frm_lbl">Salário</label>
		<input type="text" name="salario" value="<?=Arr::get($values, "salario")?>" />
	</div>
	<div>
		<label class="frm_lbl">Contratante</label>
		<div class="dv_campo"><?=$nome?></div>
		<input type="hidden" name="exibir_nome" value="1" id="exibir_nome" <?=(Arr::get($values, "exibir_nome")=="1" ? "checked" : "")?> />
		<label for="exibir_nome">Exibir</label>
	</div>
	*/?>
	<div class="dv_btn">
		<input type="submit" name="publicar" value="publicar" />
		<input type="button" name="cancelar" value="cancelar" onClick="window.open('<?=URL::site("contratante/minhasvagas")?>', '_self')" />
	</div>

</form>
<script>
	$(function(){
		$("select[name='estado']").change(function(){
			carregaCidade();
		});
		
		carregaCidade();
	});

	$("#frm_vaga").delegate("select[name='cidade']", "change", function() {
		carregaRegiao($(this));
	});

	$("#frm_vaga").delegate("select[name='cidade']", "load", function() {
		carregaRegiao($(this));
	});	
	
	function carregaCidade(){
		$.post('<? echo URL::site("contratante/ajaxforms/cidades") ?>',
			{ 
				estado: $("select[name=estado]").val(),
				cidade: '<?=Arr::get($values, "cidade")?>'
			},
			function(data) {
				$("#dv_cidade").html(data);
				carregaRegiao($("select[name=cidade]"));
			}
		);
	}
	
	function carregaRegiao(el) {
		if(el.val()=='7374'){
			$.post('<? echo URL::site("contratante/ajaxforms/regioes") ?>',
				{  'regiao': '<?=Arr::get($values, "regioes")?>' },
				function(data) {
					$("#dv_regiao").html(data);
				}
			);
			$("#dv_regiao_all").show();
		} else {
			$("#dv_regiao_all").hide();
		}
	}
</script>