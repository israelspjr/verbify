<div class="content" style="margin-top: 30px;">

	<div class="dv_quadrado_invisivel vermelho"></div>

	<!-- <h2 class="h2_title txt-vermelho">escola <label class="titulo"><a href="<?=URL::site("contratante/login");?>" class="colorbox professor">já é cadastrado?</a></label></h2> -->

	<h2 class="h2_title txt-vermelho">escola</h2>

	<div id="dv_login">

		<label class="titulo">já é cadastrado?</label>

		<form method="post" action="<?=URL::site("contratante/login")?>" id="frm-login">

			<label>Email: </label><input type="text" name="email" />

			<label>Senha: </label><input type="password" name="senha" />

			<input type="submit" class="btn_entrar" name="entrar" value="entrar" />

		</form>

		<div class="clear"></div>

	</div>

	<!--

	<div class="lnklogin"><a href="<?=URL::site("contratante/login")?>">já é cadastrado?</a></div>

	-->

	<div class="clear"></div>

	<div class="dv_img" style="margin-top: 10px; width: 950px; height: 527px; overflow: hidden;"><img src="<?=URL::site("assets/img/home/escolas_login_BX.jpg")?>" /></div>

	<div style="margin: 15px 0;">

		<p>

			Empresas, escolas, alunos que desejam fazer a melhor contratação de professores de idioma, vocês estão a alguns cliques de um processo de recrutamento e seleção adequado à sua necessidade.

			É só filtrar o professor no perfil que precisa, analisar os resultados dos testes, selecionar os melhores e entrar em contato apenas com os escolhidos. Simples, prático e econômico.

			Menos tempo na seleção e mais eficácia na contratação. Não era o que estava precisando? 

			<!--Você está a alguns cliques de um processo de recrutamento e seleção adequado à sua necessidade.

			É só filtrar o professor no perfil que precisa, analisar os resultados dos testes, selecionar os melhores e entrar em contato apenas com os escolhidos.

			Simples, prático e econômico. Menos tempo na seleção e mais eficácia na contratação. Não era o que estava precisando? -->

		</p>

	</div>

    

<form id="preCadastro" method="post" style="padding-bottom: 5px;display:none;" action="<?=URL::site("candidato/login")?>" target="iframe_pre">

<input id="emailp" type="text" name="emailp" class="ipt <? echo (Arr::get($errors, 'email')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email'); ?>"  maxlength="100" />

<button type="submit" id="buttonPre" name="buttonPre">Enviar</button>

</form>



<iframe name="iframe_pre" id="iframe_pre" style="display:none;"></iframe>

    

    

	<form id="frm-cadastro-contratante" method="post" style="padding-bottom: 5px;" enctype="multipart/form-data">

		<fieldset>

			<legend>Dados de Acesso</legend>

			<ul>

				<li>

					<label for="email" class="lbl-left">Email <span class="obl">*</span></label>

					<input id="email" type="text" name="email" class="ipt <? echo (Arr::get($errors, 'email')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email'); ?>"  maxlength="100" />

					<label for="email" class="error"><?= Arr::get($errors, 'email'); ?></label>

				</li>

				<li>

					<label for="senha" class="lbl-left">Senha <span class="obl">*</span></label>

					<input id="senha" type="password" name="senha" class="ipt <? echo (Arr::get($errors, 'senha')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'senha'); ?>" maxlength="12" />

					<label for="senha" class="error"><?= Arr::get($errors, 'senha'); ?></label>

				</li>

				<li>

					<label for="csenha" class="lbl-left">Repetir Senha <span class="obl">*</span></label>

					<input id="csenha" type="password" name="_external[csenha]" class="ipt <? echo (Arr::path($errors, '_external.csenha')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::path($values, '_external.csenha'); ?>" maxlength="12" />

					<label for="csenha" class="error"><?= Arr::path($errors, '_external.csenha'); ?></label>

				</li>

                <li><button type="button" value="Continuar" onclick="continuar();" >Continuar Cadastro </button>

                </li>

			</ul>

			<div class="clear"></div>

		</fieldset>

        <div id="fullcadastro" style="display:none;">

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

                    <label for="foto_perfil" class="lbl-left"><? echo __('Inserir Logomarca: '); ?></label>

                    	<span class="btn btn-success fileinput-button">

        				<i class="glyphicon glyphicon-plus"></i>

        				<span>Selecionar Foto...</span>

       					<input id="fileupload" type="file" name="files[]" multiple>

      					</span>

      					<div id="files" class="files"></div>

                        </li>

                        <input id="foto" type='hidden' name="foto" value="" /> 

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

						<label for="contato" class="lbl-left">Nome do Contato <span class="obl">*</span></label>

						<input id="contato" type="text" name="contato" class="ipt <? echo (Arr::get($errors, 'c_nome')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'contato'); ?>" maxlength="200" />

						<label for="contato" class="error"><?= Arr::get($errors, 'c_nome'); ?></label>

					</li>

					<li>

						<label for="c_tel" class="lbl-left">Telefone <span class="obl">*</span></label>

						<input id="c_tel" type="text" name="c_tel" class="ipt tel <? echo (Arr::get($errors, 'c_tel')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'c_tel'); ?>" maxlength="19" />

						<label for="c_tel" class="error"><?= Arr::get($errors, 'c_tel'); ?></label>

					</li>

					<li>

						<label for="cargo" class="lbl-left">Cargo do Contato <span class="obl">*</span></label>

						<input id="cargo" type="text" name="cargo" class="ipt <? echo (Arr::get($errors, 'c_cargo')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'cargo'); ?>" maxlength="200" />

						<label for="cargo" class="error"><?= Arr::get($errors, 'c_cargo'); ?></label>

					</li>

                    <li>

                        <label for="provisionamento" class="lbl-left"><? echo __('Como conheceu o ProfCerto?'); ?></label>

                        <div class="dv_campo" style="background: #fff;">

                            <label class="">

								<input type="radio" name="provisionamento" class="prov" value="adwords">

								<span>adwords</span>

							</label>

                            <label class="lbl-check">

								<input type="radio" name="provisionamento" class="prov" value="facebook">

								<span>facebook</span>

							</label>

                            <label class="lbl-check">

								<input type="radio" name="provisionamento" class="prov" value="busca internet">

								<span>busca internet</span>

							</label>

                      <!--      <label class="lbl-check">

								<input type="radio" name="provisionamento" class="prov" value="DISAL" <?=((Arr::get($values, 'comoconheceu')=="DISAL" || (Arr::get($values, 'comoconheceu')=="DISAL_BANNER")) ? "checked" : "");?>>

								<span>DISAL</span>

							</label>-->

                            <label class="lbl-check">

								<input type="radio" name="provisionamento" class="prov" value="outros" id="radio-outro-provisionamento">

								<span>outros</span>

							</label>

                        </div>

                        <div id="dv_outroprovisionamento" class="hide clear">

                            <label for="outroprovisionamento"><? echo __('Qual')?>? </label>

							<input type="text" name="outroprovisionamento" class="ipt-outro" value="" maxlength="100" />

						</div>

                        <label for="outroprovisionamento" class="error"><?= Arr::get($errors, 'comoconheceu'); ?></label>

                        <input type="hidden" name="comoconheceu" id="comoconheceu" value ="<?=((Arr::get($values, 'comoconheceu')=="DISAL" || (Arr::get($values, 'comoconheceu')=="DISAL_BANNER")) ? "DISAL_BANNER" : "");?>">

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

					<label for="endereco" class="lbl-left">Endereço <span class="obl">*</span></label>

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

		<fieldset>

			<legend>Conveniado</legend>

			<div style="margin: 0 20px;">Seja nosso conveniado e coloque o Profcerto no link do trabalhe conosco do seu site.<br />

				<label><input type="checkbox" name="conveniado" value="1" <?=(Arr::get($values, 'conveniado') == 1 ? "checked" : ""); ?> /> Desejo mais informações</label>

			</div>

		</fieldset>

		<div class="dv_btn" style="margin: 30px 10px;">

			<input type="submit" name="cadastrar" value="cadastrar"/>

		</div>

	</form>

    </div>

    

	<br class="clear" />

</div>

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



  //  showQual( $("#radio-outro-provisionamento"), $('#dv_outroprovisionamento') );



    $(".prov").change(function () {

        showQual( $("#radio-outro-provisionamento"), $('#dv_outroprovisionamento'));

        $('#comoconheceu').val($(this).val());

    });



    jQuery("#frm-cadastro-talento").submit(function(e) {

        var self = this;

        e.preventDefault();

        if($('#comoconheceu').val() == 'outros')

        {

            $('#comoconheceu').val($('input[name="outroprovisionamento"]').val());   

        }

        self.submit();

    });



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

			name: "cidade_id"

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

function continuar(){

	$("#fullcadastro").show();

	$("#emailp").val($("#email").val());

	$("#buttonPre").click();

	

}



/*jslint unparam: true */

/*global window, $ */

$(function () {

    'use strict';

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?

                '//jquery-file-upload.appspot.com/' : 'http://www.profcerto.com.br/uploads/fotos/';

    $('#fileupload').fileupload({

        url: url,

        dataType: 'json',

        done: function (e, data) {

            $.each(data.result.files, function (index, file) {

                $('<p/>').text(file.name).appendTo('#files');

				$('#foto').val('uploads/fotos/files/'+file.name);

		//		alert(file.name);

            });

        },

        progressall: function (e, data) {

            var progress = parseInt(data.loaded / data.total * 100, 10);

            $('#progress .progress-bar').css(

                'width',

                progress + '%'

            );

        }

    }).prop('disabled', !$.support.fileInput)

        .parent().addClass($.support.fileInput ? undefined : 'disabled');

});

</script>



