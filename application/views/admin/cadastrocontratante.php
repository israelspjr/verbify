<h2 class="curnome"><? echo $contratante->getNome() ?></h2>
<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
<? echo (!empty($errors) ? '<p class="p_error">Verifique os erros de preenchimento.</p>' : ''); ?>
<form id="frm-cadastro-contratante" method="post">
	<fieldset>
		<legend>Dados de Acesso</legend>
		<ul>
			<li>
				<label for="email" class="lbl-left">Email <span class="obl">*</span></label>
				<input id="email" type="text" name="email" class="ipt <? echo (Arr::get($errors, 'email')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email'); ?>"  maxlength="100" />
				<label for="email" class="error"><?= Arr::get($errors, 'email'); ?></label>
			</li>
		</ul>
		<div class="clear"></div>
	</fieldset>
	<fieldset>
		<legend>Tipo de Pessoa</legend>
		<ul>
			<li>
				<label for="tipopessoa" class="lbl-left">Tipo de Pessoa <span class="obl">*</span></label>
				<label class="lbl-radio">
					<input value="PJ" name="tipopessoa" type="radio" groupname="radioPessoa" class="rdo" <?=(Arr::get($values, 'tipopessoa') <> 'PF' ? 'checked' : ''); ?> />
					<span>Pessoa Jurídica</span>
				</label>
				<label class="lbl-radio">
					<input value="PF" name="tipopessoa" type="radio" groupname="radioPessoa" class="rdo" <?=(Arr::get($values, 'tipopessoa') == 'PF' ? 'checked' : ''); ?> />
					<span>Pessoa Física</span>
				</label>
				<label for="tipopessoa" class="error"><?= Arr::get($errors, 'tipopessoa'); ?></label>
			</li>
		</ul>
	</fieldset>
	<div id="dv_pf">
		<fieldset>
			<legend>Dados Pessoais</legend>
			<ul>
				<li>
					<label for="nome" class="lbl-left">Nome Completo <span class="obl">*</span></label>
					<input id="nome" type="text" name="nome" class="ipt <? echo (Arr::get($errors, 'nome')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'nome'); ?>" maxlength="200" />
					<label for="nome" class="error"><?= Arr::get($errors, 'nome'); ?></label>
				</li>
				<li>
					<label for="cpf" class="lbl-left">CPF <span class="obl">*</span></label>
					<input id="cpf" type="text" name="cpf" class="ipt cpf <? echo (Arr::get($errors, 'cpf')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'cpf'); ?>" maxlength="19" />
					<label for="cpf" class="error"><?= Arr::get($errors, 'cpf'); ?></label>
				</li>
				<li>
					<label for="tel" class="lbl-left">Telefone <span class="obl">*</span></label>
					<input id="tel" type="text" name="tel" class="ipt tel <? echo (Arr::get($errors, 'tel')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'tel'); ?>" maxlength="19" />
					<label for="tel" class="error"><?= Arr::get($errors, 'tel'); ?></label>
				</li>
			</ul>
		</fieldset>
	</div>
	<div id="dv_pj">
		<fieldset>
			<legend>Dados da Empresa</legend>
			<ul>
				<li>
					<label for="razao" class="lbl-left">Razão Social <span class="obl">*</span></label>
					<input id="razao" type="text" name="razao" class="ipt <? echo (Arr::get($errors, 'razao')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'razao'); ?>" maxlength="200" />
					<label for="razao" class="error"><?= Arr::get($errors, 'razao'); ?></label>
				</li>
				<li>
					<label for="nomefantasia" class="lbl-left">Nome Fantasia </label>
					<input id="nomefantasia" type="text" name="nomefantasia" class="ipt <? echo (Arr::get($errors, 'nomefantasia')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'nomefantasia'); ?>" maxlength="200" />
					<label for="nomefantasia" class="error"><?= Arr::get($errors, 'nomefantasia'); ?></label>
				</li>
				<li>
					<label for="franquia" class="lbl-left">É Franquia? <span class="obl">*</span></label>
					<label class="lbl-radio">
						<input value="0" name="franquia" type="radio" groupname="radioFranquia" class="rdo" <?=(Arr::get($values, 'franquia') <> '1' ? 'checked' : ''); ?> />
						<span>Não</span>
					</label>
					<label class="lbl-radio">
						<input value="1" name="franquia" type="radio" groupname="radioFranquia" class="rdo" <?=(Arr::get($values, 'franquia') == '1' ? 'checked' : ''); ?> />
						<span>Sim</span>
					</label>
				</li>
				<li id="li_qualfranquia">
					<label for="franquia_descr" class="lbl-left">Qual? <span class="obl">*</span></label>
					<input id="franquia_descr" type="text" name="franquia_descr" class="ipt <? echo (Arr::get($errors, 'franquia')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'franquia_descr'); ?>" maxlength="200" />
					<label for="franquia" class="error"><?= Arr::get($errors, 'franquia'); ?></label>
				</li>
				<li>
					<label for="cnpj" class="lbl-left">CNPJ <span class="obl">*</span></label>
					<input id="cnpj" type="text" name="cnpj" class="ipt cnpj <? echo (Arr::get($errors, 'cnpj')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'cnpj'); ?>" />
					<label for="cnpj" class="error"><?= Arr::get($errors, 'cnpj'); ?></label>
				</li>
				<li>
					<label for="c_nome" class="lbl-left">Nome do Contato <span class="obl">*</span></label>
					<input id="c_nome" type="text" name="c_nome" class="ipt <? echo (Arr::get($errors, 'c_nome')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'c_nome'); ?>" maxlength="200" />
					<label for="c_nome" class="error"><?= Arr::get($errors, 'c_nome'); ?></label>
				</li>
				<li>
					<label for="c_tel" class="lbl-left">Telefone <span class="obl">*</span></label>
					<input id="c_tel" type="text" name="c_tel" class="ipt tel <? echo (Arr::get($errors, 'c_tel')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'c_tel'); ?>" maxlength="19" />
					<label for="c_tel" class="error"><?= Arr::get($errors, 'c_tel'); ?></label>
				</li>
				<li>
					<label for="c_cargo" class="lbl-left">Cargo do Contato <span class="obl">*</span></label>
					<input id="c_cargo" type="text" name="c_cargo" class="ipt <? echo (Arr::get($errors, 'c_cargo')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'c_cargo'); ?>" maxlength="200" />
					<label for="c_cargo" class="error"><?= Arr::get($errors, 'c_cargo'); ?></label>
				</li>
			</ul>
		</fieldset>
	</div>
	<fieldset>
		<legend>Endereço</legend>
		<ul>
			<li>
				<label for="estado" class="lbl-left">Estado <span class="obl">*</span></label>
				<select name="estado_id" class="ipt">
					<option value=""></option>
					<?
					foreach($estados as $estado) {
						echo '<option value="'.$estado->vc_uf.'" '.(Arr::get($values, 'estado_id') == $estado->vc_uf ? 'selected' : '').'>'.$estado->vc_estado.'</option>';
					}
					?>
				</select>
				<label class="error"><?=Arr::get($errors, 'estado_id')?></label>
			</li>
			<li>
				<label for="cidade" class="lbl-left">Cidade <span class="obl">*</span></label>
				<div id="dv_cidade" class="ipt"></div>
				<label for="cidade" class="error"><?= Arr::get($errors, 'cidade_id'); ?></label>
			</li>
			<li>
				<label for="endereco" class="lbl-left">Logradouro <span class="obl">*</span></label>
				<input id="endereco" type="text" name="endereco" class="ipt <? echo (Arr::get($errors, 'endereco')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'endereco'); ?>" maxlength="200" />
				<label for="endereco" class="error"><?= Arr::get($errors, 'endereco'); ?></label>
			</li>
			<li>
				<label for="numero" class="lbl-left">Número <span class="obl">*</span></label>
				<input id="numero" type="text" name="numero" class="ipt <? echo (Arr::get($errors, 'numero')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'numero'); ?>" maxlength="45" />
				<label for="numero" class="error"><?= Arr::get($errors, 'numero'); ?></label>
			</li>
			<li>
				<label for="compl" class="lbl-left">Complemento</label>
				<input id="compl" type="text" name="compl" class="ipt <? echo (Arr::get($errors, 'compl')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'compl'); ?>" maxlength="45" />
				<label for="compl" class="error"><?= Arr::get($errors, 'compl'); ?></label>
			</li>
			<li>
				<label for="bairro" class="lbl-left">Bairro <span class="obl">*</span></label>
				<input id="bairro" type="text" name="bairro" class="ipt <? echo (Arr::get($errors, 'bairro')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'bairro'); ?>" maxlength="100" />
				<label for="bairro" class="error"><?= Arr::get($errors, 'bairro'); ?></label>
			</li>
			<li>
				<label for="cep" class="lbl-left">CEP <span class="obl">*</span></label>
				<input id="cep" type="text" name="cep" class="ipt cep <? echo (Arr::get($errors, 'cep')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'cep'); ?>" maxlength="9" />
				<label for="cep" class="error"><?= Arr::get($errors, 'cep'); ?></label>
			</li>
		</ul>
	</fieldset>
	<div>
		<input type="submit" name="salvar" value="salvar" />
		<input type="button" name="voltar" value="voltar" onClick="window.open('<? echo URL::site('admin/contratantes/dados/'.$contratante->id) ?>', 'top');" />
	</div>
</form>
<script>
$(function() {
	$(".cpf").mask("999.999.999-99");
	$(".cnpj").mask("99.999.999/9999-99");
	$(".tel").mask("(99)9999-9999?9");
	$(".cep").mask("99999-999");
	$('input[name=tipopessoa]').click(function(){
		showFieldset();
	});
	showFieldset();

	$("select[name='estado_id']").change(function(){
		carregaCidade();
	});
	carregaCidade();

	$("input[name='franquia']").click(function(){
		showFranquia();
	});
	showFranquia();
});

function showFieldset(){
	$('#dv_pj').hide();
	$('#dv_pf').hide();
	if($('input[name=tipopessoa]:checked').val() == 'PF'){
		$('#dv_pf').show();
	} else {
	$('#dv_pj').show();
	}
}

function carregaCidade(){
	$.post('<? echo URL::site("contratante/ajaxforms/cidades") ?>',
		{
			estado: $("select[name=estado_id]").val(),
			cidade: '<?= Arr::get($values, 'cidade_id'); ?>',
			name: 'cidade_id'
		},
		function(data) {
			$("#dv_cidade").html(data);
		}
	);
}

function showFranquia(){
	if($('input[name=franquia]:checked').val() == '1'){
		$('#li_qualfranquia').show();
	} else {
		$('input[name=franquia_descr]').val('');
		$('#li_qualfranquia').hide();
	}
}
</script>