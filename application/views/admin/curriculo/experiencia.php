<h2 class="h2_curtitle"><? echo __('Experiência / Formação'); ?></h2>
<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
<? echo (isset($errors) ? '<p class="p_error">'.__('Verifique os erros de preenchimento.').'</p>' : ''); ?>
<form id="frm-cadastro-talento" method="post">
	<fieldset>
		<legend><? echo __('Viagens Internacionais'); ?></legend>
		<div id="dv_form_viagens">
			<?
			$i = 1;
			foreach($viagens as $row) {
				$erro = (isset($errors["viagem"][$i]) ? $errors["viagem"][$i] : array());
				?>
				<div class="dvsao_viagens">
					<h2 class="h2_title"><? echo __('Viagem'); ?> n° <? echo $i ?></h2>
					<input type="hidden" name="vordem[<? echo $i ?>]" value="<? echo $i ?>">
					<ul>
						<li>
							<label for="pais" class="lbl-left"><? echo __('País'); ?> <span class="obl">*</span></label>
							<select name="pais[<?=$i?>]" class="ipt <? echo (Arr::get($erro, 'pais_id')<>'' ? 'ipt-error' : ''); ?>">
								<option value=""></option>
								<?
								foreach($paises as $pais)
									echo '<option value="'.$pais->id.'" '.($row->pais==$pais->id ? 'selected' : '').'>'.$pais->name.'</option>';
								?>
							</select>
							<label for="pais" class="error"><?= Arr::get($erro, 'pais_id'); ?></label>
						</li>
						<li>
							<label for="dt_partida<?=$i?>" class="lbl-left"><? echo __('Data da Partida'); ?> <span class="obl">*</span></label>
							<input name="dt_partida[<?=$i?>]" class="ipt data <? echo (Arr::get($erro, 'dtde')<>'' ? 'ipt-error' : ''); ?>" id="dt_partida<?=$i?>" value="<?=Helper::format_date($row->dtde) ?>" />
							<label for="dt_partida" class="error"><?= Arr::get($erro, 'dtde'); ?></label>
						</li>
						<li>
							<label for="dt_volta<?=$i?>" class="lbl-left"><? echo __('Data da Volta'); ?> <span class="obl">*</span></label>
							<input name="dt_volta[<?=$i?>]" class="ipt data <? echo (Arr::get($erro, 'dtate')<>'' ? 'ipt-error' : ''); ?>" id="dt_volta<?=$i?>" value="<?=Helper::format_date($row->dtate) ?>" />
							<label for="dt_volta" class="error"><?= Arr::get($erro, 'dtate'); ?></label>
						</li>
						<li>
							<label for="atividade" class="lbl-left"><? echo __('Atividade no país'); ?> <span class="obl">*</span></label>
							<input type="radio" name="atividade[<?=$i?>]" value="turismo" id="at_tur[<?=$i?>]" class="rdo" <?=($row->atividade=="turismo" ? "checked" : "")?>><label for="at_tur[<?=$i?>]"><? echo __('turismo'); ?></label>
							<input type="radio" name="atividade[<?=$i?>]" value="trabalho" id="at_tra[<?=$i?>]" class="rdo" <?=($row->atividade=="trabalho" ? "checked" : "")?>><label for="at_tra[<?=$i?>]"><? echo __('trabalho'); ?></label>
							<input type="radio" name="atividade[<?=$i?>]" value="estudo" id="at_est[<?=$i?>]" class="rdo" <?=($row->atividade=="estudo" ? "checked" : "")?>><label for="at_est[<?=$i?>]"><? echo __('estudo'); ?></label>
							<input type="radio" name="atividade[<?=$i?>]" value="outra" id="at_out[<?=$i?>]" class="rdo" <?=($row->atividade=="outra" ? "checked" : "")?>><label for="at_out[<?=$i?>]"><? echo __('outra atividade'); ?></label>
							<label for="dt_volta" class="error colcampo clear"><?= Arr::get($erro, 'atividade'); ?></label>
						</li>
						<li>
							<label for="txt_desc[<?=$i?>]" class="lbl-left"><? echo __('Descreva'); ?></label>
							<textarea name="txt_desc[<?=$i?>]" class="txt"><?=$row->descricao?></textarea>
						</li>
					</ul>
					<br class="clear" />
				</div>
				<?
				$i++;
			}
			?>
		</div>
		<div class="dv_btn">
			<input type="button" name="adicionar" value="<? echo __('adicionar'); ?>" onClick="addFormViagensButton()" id="btn_adicionar" />
			<input type="button" name="remover" value="<? echo __('remover'); ?>" onClick="removeFormViagens()" id="btn_excluir" />
		</div>
	</fieldset>


	<fieldset>
		<legend><? echo __('Certificações'); ?></legend>
		<div id="dv_form_certificacoes">
		<?
		$i = 1;
		if(isset($certificacoes)){
			foreach($certificacoes as $row){
				$erro = (isset($errors["certi"][$i]) ? $errors["certi"][$i] : array());
				echo '
				<div class="dvsao_certificacoes">
					<h2 class="h2_title">'.__('Certificação').' n° '.$i.'</h2>
					<input type="hidden" name="cordem['.$i.']" value="'.$i.'">
					<ul>
						<li>
							<label for="cert" class="lbl-left">'.__('Certificação').' <span class="obl">*</span></label>
							<input type="text" name="cert_descricao['.$i.']" class="ipt '.(Arr::get($erro, 'descricao')<>'' ? 'ipt-error' : '').'" value="'.$row->descricao.'"/>
							<label for="cert" class="error">'.Arr::get($erro, 'descricao').'</label>
						</li>
						<li>
							<label for="cert" class="lbl-left">'.__('Ano').' <span class="obl">*</span></label>
							<input type="text" name="cert_ano['.$i.']" class="ipt ano '.(Arr::get($erro, 'ano')<>'' ? 'ipt-error' : '').'" value="'.$row->ano.'" />
							<label for="cert" class="error">'.Arr::get($erro, 'ano').'</label>
						</li>
						<li>
							<label for="cert" class="lbl-left">'.__('Tipo').' <span class="obl">*</span></label>
							<label class="lbl-radio">
								<input type="radio" name="cert_tipo['.$i.']" value="N" class="rdo" '.($row->tipo == 'N' ? 'checked' : '').' />
								<span>'.__('Nacional').'</span>
							</label>
							<label class="lbl-radio">
								<input type="radio" name="cert_tipo['.$i.']" value="I" class="rdo" '.($row->tipo == 'I' ? 'checked' : '').' />
								<span>'.__('Internacional').'</span>
							</label>
							<label for="cert" class="error">'.Arr::get($erro, 'tipo').'</label>
						</li>
						<li>
							<label for="cert" class="lbl-left">'.__('Idioma').' <span class="obl">*</span></label>
							<select name="cert_idioma['.$i.']" class="ipt '.(Arr::get($erro, 'idioma_id')<>'' ? 'ipt-error' : '').'">
								<option></option>';
								foreach($idiomas as $idioma){
									echo '<option value="'.$idioma->id.'" '.($row->idioma_id == $idioma->id ? 'selected' : '').'>'.__($idioma->descricao).'</option>';
								}
							echo '
							</select>
							<label for="cert" class="error">'.Arr::get($erro, 'idioma_id').'</label>
						</li>
					</ul>
					<br class="clear" />
				</div>';
				$i++;
			}
		}
		?>
		</div>
		<div class="dv_btn">
			<input type="button" name="adicionar" value="<? echo __('adicionar'); ?>" onClick="addFormCertsButton()" id="btn_adicionar" />
			<input type="button" name="remover" value="<? echo __('remover'); ?>" onClick="removeFormCerts()" id="btn_excluir" />
		</div>
	</fieldset>


	<fieldset>
		<legend><? echo __('Graduação'); ?></legend>
		<div id="dv_form_graduacoes">
		<?
		$i = 1;
		if(count($graduacoes) > 0){
			foreach($graduacoes as $grad){
				$erro = (isset($errors["gradu"][$i]) ? $errors["gradu"][$i] : array());
				echo '
				<div class="dvsao_graduacoes">
					<h2 class="h2_title">'.__('Graduação').' n° '.$i.'</h2>
					<input type="hidden" name="gordem['.$i.']" value="'.$i.'">
					<ul>
						<li>
							<label class="lbl-left">'.__('Escolaridade').' <span class="obl">*</span></label>
							<select name="escolaridade['.$i.']" class="ipt escolaridade">';
								foreach($grauescolar as $row) {
									echo '<option value="'.$row->id.'" '.($row->id == $grad->grauescolar_id ? 'selected' : '').'>'.__($row->descricao).'</option>';
								}
								echo '
							</select>
							<label for="cert" class="error">'.Arr::get($erro, 'grauescolar_id').'</label>
						</li>
						<li class="li_curso">
							<label class="lbl-left">'.__('Curso').' <span class="obl">*</span></label>
							<select name="curso['.$i.']" class="ipt curso" id="selcurso'.$i.'">
								<option value="0"></option>';
								foreach($cursos as $row) {
									echo '<option value="'.$row->id.'" '.($row->id == $grad->curso_id ? 'selected' : '').'>'.$row->descricao.'</option>';
								}
								echo '
							</select>
							<a class="outro" href="#dv-outro" rel="'.$i.'">'.__('Outro').'</a>
							<label for="curso" class="error colcampo clear">'.Arr::get($erro, 'curso_id').'</label>
						</li>
						<li>
							<label class="lbl-left">'.__('Situação').' <span class="obl">*</span></label>
							<div class="ipt">
								<label >
									<input type="radio" name="situacao['.$i.']" value="3" groupname="situacao'.$i.'" class="situacao" '.($grad->situacao==3 ? 'checked': '').' />
									<span>'.__('Concluído').'</span>
								</label>
								<label >
									<input type="radio" name="situacao['.$i.']" value="1" groupname="situacao'.$i.'" class="situacao" '.($grad->situacao==1 ? 'checked': '').' />
									<span>'.__('Cursando').'</span>
								</label>
								<label >
									<input type="radio" name="situacao['.$i.']" value="2" groupname="situacao'.$i.'" class="situacao" '.($grad->situacao==2 ? 'checked': '').' />
									<span>'.__('Trancado').'</span>
								</label>
							</div>
							<label class="error">'.Arr::get($erro, 'situacao').'</label>
						</li>
						<li>
							<label for="dtini" class="lbl-left">'.__('Data ínicio').' <span class="obl">*</span></label>
							<input type="text" name="grad_dtini['.$i.']" class="mes ipt" value="'.Helper::format_date_to_mes($grad->dt_inicio).'" />
							<label class="error">'.Arr::get($erro, 'dt_inicio').'</label>
						</li>
						<li>
							<label for="dtfim" class="lbl-left">'.__('Data conclusão').' <span class="obl">*</span></label>
							<input type="text" name="grad_dtfim['.$i.']" class="mes ipt fim" value="'.Helper::format_date_to_mes($grad->dt_conclusao).'"/>
							<label class="error">'.Arr::get($erro, 'dt_conclusao').'</label>
						</li>
						<li>
							<label for="cert" class="lbl-left">'.__('Instituição').' <span class="obl">*</span></label>
							<input type="text" name="instituicao['.$i.']" class="ipt" value="'.$grad->instituicao.'"/>
							<label class="error">'.Arr::get($erro, 'instituicao').'</label>
						</li>
					</ul>
					<br class="clear" />
				</div>';
				$i++;
			}
		} else {
			$erro = (isset($errors["gradu"][$i]) ? $errors["gradu"][$i] : array());
			echo '
			<div class="dvsao_graduacoes">
				<h2 class="h2_title">'.__('Graduação').' n° '.$i.'</h2>
				<input type="hidden" name="gordem['.$i.']" value="'.$i.'">
				<ul>
					<li>
						<label class="lbl-left">'.__('Escolaridade').' <span class="obl">*</span></label>
						<select name="escolaridade['.$i.']" class="ipt escolaridade">';
							foreach($grauescolar as $row) {
								echo '<option value="'.$row->id.'">'.__($row->descricao).'</option>';
							}
							echo '
						</select>
					</li>
					<li class="li_curso">
						<label class="lbl-left">'.__('Curso').' <span class="obl">*</span></label>
						<select name="curso['.$i.']" class="ipt curso" id="selcurso'.$i.'">
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
								<input type="radio" name="situacao['.$i.']" value="3" groupname="situacao'.$i.'" class="situacao" />
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
						</div>
					</li>
					<li>
						<label for="dtini" class="lbl-left">'.__('Data ínicio').' <span class="obl">*</span></label>
						<input type="text" name="grad_dtini['.$i.']" class="mes ipt" value="" />
					</li>
					<li>
						<label for="dtfim" class="lbl-left">'.__('Data conclusão').' <span class="obl">*</span></label>
						<input type="text" name="grad_dtfim['.$i.']" class="mes ipt fim" value=""/>
					</li>
					<li>
						<label for="cert" class="lbl-left">'.__('Instituição').' <span class="obl">*</span></label>
						<input type="text" name="instituicao['.$i.']" class="ipt" value=""/>
					</li>
				</ul>
				<br class="clear" />
			</div>';
		}
		?>
		</div>
		<div class="dv_btn">
			<input type="button" name="adicionar" value="<? echo __('adicionar'); ?>" onClick="addFormGraduacaoButton()" id="btn_adicionar" />
			<input type="button" name="remover" value="<? echo __('remover'); ?>" onClick="removeFormGraduacao()" id="btn_excluir" />
		</div>
	</fieldset>

	<fieldset>
		<legend><? echo __('Experiências Profissionais no Ensino de Idiomas'); ?></legend>
		<label><input type="checkbox" name="semexperiencia" id="chkidiomas" value="1" <?=(count($experiencias_idiomas)==0 ? 'checked' : '')?>/>&nbsp;<? echo __('Não tenho experiência'); ?></label>
		<div id="dv_form_expprofissionais_idiomas">
		<?
		$i = 1;
		if(count($experiencias_idiomas) > 0){
			foreach($experiencias_idiomas as $exp){
				$erro = (isset($errors["eprof_idioma"][$i]) ? $errors["eprof_idioma"][$i] : array());
				echo '
				<div class="dvsao_experiencias">
					<h2 class="h2_title">'.__('Experiência Profissional').' n° '.$i.'</h2>
					<input type="hidden" name="epordem_idioma['.$i.']" value="'.$i.'">
					<ul>
						<li>
							<label class="lbl-left">'.__('Função').' <span class="obl">*</span></label>
							<input type="text" name="funcao_idioma['.$i.']" class="ipt" value="'.$exp->funcao.'"/>
							<label for="cert" class="error">'.Arr::get($erro, 'funcao').'</label>
						</li>
						<li>
							<label class="lbl-left">'.__('Data ínicio').' <span class="obl">*</span></label>
							<input type="text" name="exp_dtinicio_idioma['.$i.']" class="ipt mes" value="'.Helper::format_date_to_mes($exp->dt_inicio).'" />
							<label for="cert" class="error">'.Arr::get($erro, 'dt_inicio').'</label>
						</li>
						<li>
							<label class="lbl-left">'.__('Data saída').' <span class="obl">*</span></label>
							<input type="text" name="exp_dtfim_idioma['.$i.']" class="ipt mes dtfim" value="'.Helper::format_date_to_mes($exp->dt_fim).'" />
							<label ><input type="checkbox" class="atual" name="atual_idioma['.$i.']" value="1" '.($exp->atualidade==1 ? 'checked' : '').'>'.__('Atualidade').'</label>
							<label for="exp_dtfim_idioma" class="error colcampo clear">'.Arr::get($erro, 'dt_fim').'</label>
						</li>
					</ul>
					<br class="clear" />
				</div>';
				$i++;
			}
		}
		?>
		</div>
		<div class="dv_btn">
			<input type="button" name="adicionar" value="<? echo __('adicionar'); ?>" onClick="addFormExpProfIdiomaButton()" id="btn_adicionar" />
			<input type="button" name="remover" value="<? echo __('remover'); ?>" onClick="removeFormExpIdiomaProf()" id="btn_excluir" />
		</div>
	</fieldset>

	<fieldset>
		<legend><? echo __('Experiências Profissionais além do Ensino de Idiomas'); ?></legend>
		<div id="dv_form_expprofissionais">
		<?
		$i = 1;
		if(isset($experiencias)){
			foreach($experiencias as $exp){
				$erro = (isset($errors["eprof"][$i]) ? $errors["eprof"][$i] : array());
				echo '
				<div class="dvsao_experiencias">
					<h2 class="h2_title">'.__('Experiência Profissional').' n° '.$i.'</h2>
					<input type="hidden" name="epordem['.$i.']" value="'.$i.'">
					<ul>
						<li>
							<label class="lbl-left">'.__('Função').' <span class="obl">*</span></label>
							<input type="text" name="funcao['.$i.']" class="ipt" value="'.$exp->funcao.'"/>
							<label for="cert" class="error">'.Arr::get($erro, 'funcao').'</label>
						</li>
						<li>
							<label class="lbl-left">'.__('Data ínicio').' <span class="obl">*</span></label>
							<input type="text" name="exp_dtinicio['.$i.']" class="ipt mes" value="'.Helper::format_date_to_mes($exp->dt_inicio).'" />
							<label for="cert" class="error">'.Arr::get($erro, 'dt_inicio').'</label>
						</li>
						<li>
							<label class="lbl-left">'.__('Data saída').' <span class="obl">*</span></label>
							<input type="text" name="exp_dtfim['.$i.']" class="ipt mes dtfim" value="'.Helper::format_date_to_mes($exp->dt_fim).'" />
							<label ><input type="checkbox" class="atual" name="atual['.$i.']" value="1" '.($exp->atualidade==1 ? 'checked' : '').'>'.__('Atualidade').'</label>
							<label for="exp_dtfim" class="error colcampo clear">'.Arr::get($erro, 'dt_fim').'</label>
						</li>
					</ul>
					<br class="clear" />
				</div>';
				$i++;
			}
		}
		?>
		</div>
		<div class="dv_btn">
			<input type="button" name="adicionar" value="<? echo __('adicionar'); ?>" onClick="addFormExpProfButton()" id="btn_adicionar" />
			<input type="button" name="remover" value="<? echo __('remover'); ?>" onClick="removeFormExpProf()" id="btn_excluir" />
		</div>
	</fieldset>

	<fieldset>
		<legend><? echo __('Cursos Livres'); ?></legend>
		<div id="dv_form_cursos">
		<?
		$i = 1;
		if(isset($cursoslivres)){
			foreach($cursoslivres as $cursolivre){
				$erro = (isset($errors["curso"][$i]) ? $errors["curso"][$i] : array());
				echo '
				<div class="dvsao_cursos">
					<h2 class="h2_title">'.__('Curso').' n° '.$i.'</h2>
					<input type="hidden" name="cursoordem['.$i .']" value="'.$i .'">
					<ul>
						<li>
							<label for="curso" class="lbl-left">'.__('Curso').' <span class="obl">*</span></label>
							<input name="cursolivre['.$i.']" class="ipt" maxlegth="200" value="'.$cursolivre->curso.'" />
							<label for="cert" class="error">'.Arr::get($erro, 'curso').'</label>
						</li>
						<li>
							<label for="cl_instituicao" class="lbl-left">'.__('Instituição').' <span class="obl">*</span></label>
							<input name="cl_instituicao['.$i .']" class="ipt" maxlegth="200" value="'.$cursolivre->instituicao.'" />
							<label for="cert" class="error">'.Arr::get($erro, 'instituicao').'</label>
						</li>
						<li>
							<label for="cl_ano" class="lbl-left">'.__('Ano').' <span class="obl">*</span></label>
							<input name="cl_ano['.$i .']" class="ipt" value="'.$cursolivre->ano.'" />
							<label for="cert" class="error">'.Arr::get($erro, 'ano').'</label>
						</li>
					</ul>
					<br class="clear" />
				</div>';
				$i++;
			}
		}
		?>
		</div>
		<div class="dv_btn">
			<input type="button" name="adicionar" value="<? echo __('adicionar'); ?>" onClick="addFormCursoButton()" id="btn_adicionar" />
			<input type="button" name="remover" value="<? echo __('remover'); ?>" onClick="removeFormCurso()" id="btn_excluir" />
		</div>
	</fieldset>

	<div>
		<input type="submit" name="salvar" value="<? echo __('salvar'); ?>" />
	</div>
</form>

<div id="dv-outro" class="hide">
	<form method="post" id="frmoutrocurso">
		<input type="hidden" name="posicao" value="" id="oc_posicao" />
		<label><? echo __('Curso'); ?></label><br />
		<input type="text" name="outrocurso" style="width: 300px;" maxlength="200" id="oc_descricao" />
		<div class="dv_btn" style="margin: 10px; text-align: center;">
			<input type="button" value="<? echo __('cadastrar'); ?>" id="cadastraoutro" />
		</div>
	</form>
</div>

<script type="text/javascript">
	$(function(){
		$(".situacao:checked").each(function(){ setSituacao(this); });
		$(".escolaridade").each(function(){ setCurso(this); });
		$(".atual").each(function(){ setAtualidade(this); });

		$("#dv_form_viagens").delegate(".data", "focus", function() {
			$(this).mask("99/99/9999");
		});

		$("#dv_form_certificacoes").delegate(".ano", "focus", function() {
			$(this).mask("9999");
		});

		$("#dv_form_graduacoes").delegate(".situacao", "click", function() {
			setSituacao(this);
		});

		$("#dv_form_graduacoes").delegate(".mes", "focus", function() {
			$(this).mask("99/9999");
		});

		$("#dv_form_graduacoes").delegate(".escolaridade", "click", function() {
			setCurso(this);
		});

		$("#dv_form_graduacoes").delegate(".outro", "click", function() {
			$("#oc_posicao").val($(this).attr('rel'));
			$("#oc_descricao").val('');
			$(".outro").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'	: 'none',
				'height'				: '80px'
			});
		});

		$("#dv_form_expprofissionais").delegate(".mes", "focus", function() {
			$(this).mask("99/9999");
		});

		$("#dv_form_expprofissionais").delegate(".atual", "change", function() {
			setAtualidade(this);
		});

		$("#dv_form_expprofissionais_idiomas").delegate(".mes", "focus", function() {
			$(this).mask("99/9999");
		});

		$("#dv_form_expprofissionais_idiomas").delegate(".atual", "change", function() {
			setAtualidade(this);
		});

		$("#cadastraoutro").click(function(){
			$.post('<? echo URL::site("candidato/cadastroforms/outrocurso") ?>',
				$("#frmoutrocurso").serialize(),
				function(data) {
					var pos = $("#oc_posicao").val();
					$("#selcurso"+pos).append(data);
					parent.$.fancybox.close();
				}
			);
		});
	});

	$("#chkidiomas").click(function(){
		if($(this).is(':checked')){
			$("#dv_form_expprofissionais_idiomas>div").remove();
		} else {
			addFormExpProfIdiomaButton();
		}
	});

	function addFormViagensButton(){
		i = $("#dv_form_viagens").children().size()+1;
		$.post('<? echo URL::site("candidato/cadastroforms/viagens") ?>',
			{ posicao: i},
			function(data) {
				$("#dv_form_viagens").append(data);
			}
		);
	}

	function removeFormViagens(){
		$("#dv_form_viagens>div:last-child").remove();
	}

	function addFormCertsButton(){
		i = $("#dv_form_certificacoes").children().size()+1;
		$.post('<? echo URL::site("candidato/cadastroforms/certificacoes") ?>',
			{ posicao: i},
			function(data) {
				$("#dv_form_certificacoes").append(data);
			}
		);
	}

	function removeFormCerts(){
		$("#dv_form_certificacoes>div:last-child").remove();
	}

	function addFormGraduacaoButton(){
		i = $("#dv_form_graduacoes").children().size()+1;
		$.post('<? echo URL::site("candidato/cadastroforms/graduacoes") ?>',
			{ posicao: i},
			function(data) {
				$("#dv_form_graduacoes").append(data);
			}
		);
	}

	function removeFormGraduacao(){
		if($("#dv_form_graduacoes").children().size() == 1){
			alert('Você deve preencher ao menos uma formação');
		} else {
			$("#dv_form_graduacoes>div:last-child").remove();
		}
	}

	function addFormExpProfButton(){
		i = $("#dv_form_expprofissionais").children().size()+1;
		$.post('<? echo URL::site("candidato/cadastroforms/expprofissional") ?>',
			{ posicao: i },
			function(data) {
				$("#dv_form_expprofissionais").append(data);
			}
		);
	}

	function removeFormExpProf(){
		$("#dv_form_expprofissionais>div:last-child").remove();
	}

	function addFormExpProfIdiomaButton(){
		i = $("#dv_form_expprofissionais_idiomas").children().size()+1;
		$.post('<? echo URL::site("candidato/cadastroforms/expidioma") ?>',
			{ posicao: i },
			function(data) {
				$("#dv_form_expprofissionais_idiomas").append(data);
			}
		);
		$("#chkidiomas").removeAttr("checked");
	}

	function removeFormExpIdiomaProf(){
		$("#dv_form_expprofissionais_idiomas>div:last-child").remove();
		if($("#dv_form_expprofissionais_idiomas").children().size() == 0){
			$("#chkidiomas").attr("checked", "checked");
		}
	}

	function addFormCursoButton(){
		i = $("#dv_form_cursos").children().size()+1;
		$.post('<? echo URL::site("candidato/cadastroforms/cursos") ?>',
			{ posicao: i },
			function(data) {
				$("#dv_form_cursos").append(data);
			}
		);
	}

	function removeFormCurso(){
		$("#dv_form_cursos>div:last-child").remove();
	}

	function setSituacao(el){
		var name = el.name;
		var value = $('input[name="'+el.name+'"]:checked').val();
		if(value == 3){
			$(el).parents('.dvsao_graduacoes').find('.fim').removeAttr('disabled');
		} else {
			$(el).parents('.dvsao_graduacoes').find('.fim').val('').attr('disabled', 'disabled');
		}
	}

	function setCurso(el){
		if(el.value==1 || el.value==2){
			$(el).parents('.dvsao_graduacoes').find('.li_curso').hide();
		} else {
			$(el).parents('.dvsao_graduacoes').find('.li_curso').show();
		}
	}

	function setAtualidade(el){
		if($(el).is(':checked')){
			$(el).parents('.dvsao_experiencias').find('.dtfim').val('').attr('disabled', 'disabled');
		} else {
			$(el).parents('.dvsao_experiencias').find('.dtfim').removeAttr('disabled');
		}
	}
</script>