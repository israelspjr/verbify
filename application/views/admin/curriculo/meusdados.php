<h2 class="h2_curtitle"><? echo __('Dados Pessoais'); ?></h2>

<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>

<? echo (isset($errors) ? '<p class="p_error">'.__('Verifique os erros de preenchimento.').'</p>' : ''); ?>

<form id="frm-cadastro-talento" method="post">

	<fieldset>

		<legend><? echo __('Dados de Acesso'); ?></legend>

		<ul>

			<li>

				<label for="email" class="lbl-left"><? echo __('email'); ?> <span class="obl">*</span></label>

				<input id="email" type="text" name="email" class="ipt <? echo (Arr::get($errors, 'email')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email'); ?>"  maxlength="100" />

				<label for="email" class="error"><?= Arr::get($errors, 'email'); ?></label>

			</li>

			<li>

				<label for="senha" class="lbl-left"><? echo __('senha'); ?> <span class="obl">*</span></label>

				<input id="senhatxt" type="text" name="senhatxt" class="ipt <? echo (Arr::get($errors, 'senhatxt')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'senhatxt'); ?>"  maxlength="100" />
                
   			</li>

		</ul>

		<div class="clear"></div>

	</fieldset>

	<fieldset>

		<legend><? echo __('Fale sobre você'); ?></legend>

		<ul>

			<li>

				<label for="nome" class="lbl-left"><? echo __('Nome Completo'); ?> <span class="obl">*</span></label>

				<input id="nome" type="text" name="nome" class="ipt <? echo (Arr::get($errors, 'nome')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'nome'); ?>" maxlength="120" />

				<label for="nome" class="error"><?= Arr::get($errors, 'nome'); ?></label>

			</li>

			<li>

				<label for="cpf" class="lbl-left"><span id="lblcpf"><? echo __('CPF'); ?></span> <span class="obl">*</span></label>

				<div class="dv_rdotel">

					<label><input type="radio" name="doctype" class="rdodoc" value="B" <?=(Arr::get($values, 'doctype')<>"E" ? "checked" : "")?> /><? echo __('Brasileiro'); ?></label>

					<label><input type="radio" name="doctype" class="rdodoc" value="E" <?=(Arr::get($values, 'doctype')=="E" ? "checked" : "")?> /><? echo __('Estrangeiro'); ?></label>

				</div>

				<input id="cpf" type="text" name="cpf" class="ipt cpf <? echo (Arr::get($errors, 'cpf')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'cpf'); ?>" maxlength="19" />

				<label for="cpf" class="error"><?= Arr::get($errors, 'cpf'); ?></label>

			</li>

			<li>

				<label for="rg" class="lbl-left"><span id="lblrg"><? echo __('RG'); ?></span></label>

				<input id="rg" type="text" name="rg" class="ipt rg" maxlength="19" value="<?= Arr::get($values, 'rg'); ?>" />

			</li>

			<li>

				<label for="sexo" class="lbl-left"><? echo __('Sexo'); ?> <span class="obl">*</span></label>

				<label class="lbl-radio">

					<input value="M" name="sexo" type="radio" groupname="radioSexo" class="rdo" <?=(Arr::get($values, 'sexo') == 'M' ? 'checked' : ''); ?> />

					<span><? echo __('Masculino'); ?></span>

				</label>

				<label class="lbl-radio">

					<input value="F" name="sexo" type="radio" groupname="radioSexo" class="rdo" <?=(Arr::get($values, 'sexo') == 'F' ? 'checked' : ''); ?> />

					<span><? echo __('Feminino'); ?></span>

				</label>

				<label for="sexo" class="error"><?= Arr::get($errors, 'sexo'); ?></label>

			</li>

			<li>

				<label for="dtnasc" class="lbl-left"><? echo __('Dt nascimento'); ?> <span class="obl">*</span></label>

				<input id="dtnasc" type="text" name="dtnasc" class="ipt data <? echo (Arr::get($errors, 'dtnasc')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'dtnasc'); ?>" maxlength="10" />

				<label for="dtnasc" class="error"><?= Arr::get($errors, 'dtnasc'); ?></label>

			</li>

			<li>

				<label for="nacionalidade" class="lbl-left"><? echo __('Nacionalidade'); ?> <span class="obl">*</span></label>

		<!--		<input id="nacionalidade" type="text" name="nacionalidade" class="ipt <? echo (Arr::get($errors, 'nacionalidade')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'nacionalidade'); ?>" maxlength="120" />
-->
        <select name="nacionalidade" class="ipt">
    
			<?php
var_dump($values);	
						$nacionalidade = Arr::get($values, 'nacionalidade');
						if ($nacionalidade == '') {
						$nacionalidade = $values['nacionalidade'];
						
						}
					
						echo $nacionalidade;
						foreach($values['paises'] as $valor) {
//							var_dump($valor);
							echo $valor->id;
			/*				if ($valor->id == 30) {
							echo '<option selected="selected" value="'.$valor->id.'" '.(Arr::get($values, "nacionalidade") == $valor->id ? 'selected' : '').'>'.$valor->name.'</option>';
						
							} else {*/
							echo '<option value="'.$valor->id.'" ';
							if ($valor->id == $nacionalidade) {
								echo 'selected="selected"';
							}
							echo '>';
							
							echo $valor->name.'</option>';
//							}
						}
             ?>           
             </select>
				<label for="nacionalidade" class="error"><?= Arr::get($errors, 'nacionalidade'); ?></label>

			</li>

			<li>

				<label for="idioma" class="lbl-left"><? echo __('Idiomas que leciona'); ?> <span class="obl">*</span></label>

				<div class="dv_campo" id="idioma">

					<?
					
					foreach($idiomas as $idioma){

						$idiomas_post = (isset($values["idioma"]) ? $values["idioma"] : array());

						echo '

						<label class="lbl-check">

							<input type="checkbox" name="idioma['.$idioma->id.']" value="1" groupname="checkIdiomas" '.(Arr::get($idiomas_post, $idioma->id) ? "checked" : "").' '.($idioma->is_outro ==1 ? 'id="chk-outro-idioma"' : '').' />

							<span>'.__($idioma->descricao).' '.(in_array($idioma->id, $idiomas_obs) ? '<span class="obs">*</span>' : '').'</span>
							
						

						</label>';

					}

					?>

				</div>

				<div id="dv_outroidioma" class="hide clear">

					<label for="outroidioma"><? echo __('Qual'); ?>? </label>

					<input type="text" name="outroidioma" value="<?= Arr::get($values, 'outroidioma'); ?>" maxlength="100" class="ipt-outro" />

				</div>

				<label for="idioma" class="error colcampo clear"><?= Arr::path($errors, '_external.idioma'); ?></label>
                

			</li>
            <li>
            <label for="idioma" class="lbl-left"><? echo __('Sotaque dos idiomas:'); ?> </label>
            <input type="text" name="sotaque" value="<?= Arr::get($values, 'sotaque'); ?>" maxlength="100" class="ipt" />
            </li>

			<li>

				<label for="locomocao" class="lbl-left"><? echo __('Locomove-se na cidade'); ?> <span class="obl">*</span></label>

				<div class="dv_campo">

					<?

					foreach($locomocao as $loc){

						$locomocao_post = (isset($values["locomocao"]) ? $values["locomocao"] : array());

						echo '

						<label class="lbl-check">

							<input type="checkbox" name="locomocao['.$loc->id.']" value="1" groupname="checkIdiomas" '.(Arr::get($locomocao_post, $loc->id) ? "checked" : "").' '.($loc->is_outro ==1 ? 'id="chk-outra-locomocao"' : '').' />

							<span>'.__($loc->descricao).'</span>

						</label>';

					}

					?>

				</div>

				<div id="dv_outralocomocao" class="hide clear">

					<label for="outralocomocao"><? echo __('Qual')?>? </label>

					<input type="text" name="outralocomocao" value="<?= Arr::get($values, 'outralocomocao'); ?>" maxlength="100" class="ipt-outro"/>

				</div>

				<label for="locomocao" class="error colcampo clear"><?= Arr::path($errors, '_external.locomocao'); ?></label>

			</li>
            
            <li>
                        <label for="provisionamento" class="lbl-left"><? echo __('Como conheceu a Companhia de Idiomas?'); ?> <span class="obl">*</span></label>
                        <div class="dv_campo">
                           			<input type="radio" name="comoconheceu" class="prov" value="adwords" required <?=((Arr::get($values, 'comoconheceu')=="adwords") ? "checked" : "");?>>

								<span>Adwords</span>

							</label>
                            <label class="lbl-check">

								<input type="radio" name="comoconheceu" class="prov" value="facebook" <?=((Arr::get($values, 'comoconheceu')=="facebook") ? "checked" : "");?>>

								<span>Facebook</span>

							</label>
                             <label class="lbl-check">

								<input type="radio" name="comoconheceu" class="prov" value="linkedin" <?=((Arr::get($values, 'comoconheceu')=="linkedin") ? "checked" : "");?>>

								<span>Linkedin</span>

							</label>
                            <label class="lbl-check">

								<input type="radio" name="comoconheceu" class="prov" value="google" <?=((Arr::get($values, 'comoconheceu')=="google") ? "checked" : "");?>>

								<span>Google</span>

							</label>
                            <label class="lbl-check">

								<input type="radio" name="comoconheceu" class="prov" value="outros buscadores" <?=((Arr::get($values, 'comoconheceu')=="outros buscadores" || (Arr::get($values, 'comoconheceu')=="outros_buscadores")) ? "checked" : "");?>>

								<span>Outros buscadores</span>

							</label>
                            
                             <label class="lbl-check">

								<input type="radio" name="comoconheceu" class="prov" value="vagas" <?=((Arr::get($values, 'comoconheceu')=="vagas" || (Arr::get($values, 'comoconheceu')=="vagas")) ? "checked" : "");?>>

								<span>Site vagas</span>

							</label>
                            
                            <label class="lbl-check">

								<input type="radio" name="comoconheceu" class="prov" value="indicacao" <?=((Arr::get($values, 'comoconheceu')=="indicacao" || (Arr::get($values, 'comoconheceu')=="indicacao")) ? "checked" : "");?>>

								<span>Indicação colega</span>

							</label>
                            
                            <?php $comoconheceu = Arr::get($values, 'comoconheceu'); ?>
                            <label class="lbl-check">

								<input type="radio" name="comoconheceu" class="prov" value="outros" id="radio-outro-provisionamento" <?php 
								
		if (($comoconheceu !="") && ($comoconheceu !="facebook") && ($comoconheceu !="adwords") &&  ($comoconheceu !="busca internet"))  {
			echo "checked";	
			$usarOutros = 1;	}?> >

								<span>Outros</span>
                                
                             <?php   if ($usarOutros == 1) {
								 echo "<span>&nbsp;($comoconheceu)</span>";
							 }?>

							</label>
                        </div>
                        <div id="dv_outroprovisionamento" class="hide clear">
                            <label for="outroprovisionamento"><? echo __('Qual')?>? </label>
							<input type="text" name="outroprovisionamento" class="ipt-outro" value="" maxlength="100" />
						</div>
                        <label for="outroprovisionamento" class="error"><?= Arr::get($errors, 'comoconheceu'); ?></label>
                 <!--       <input type="hidden" name="comoconheceu" id="comoconheceu" value ="<?=((Arr::get($values, 'comoconheceu')=="DISAL" || (Arr::get($values, 'comoconheceu')=="DISAL_BANNER")) ? "DISAL_BANNER" : ""); ?>">-->
					</li>

		<!--	<li>

				<label for="comoconheceu" class="lbl-left"><? echo __('Como conheceu o ProfTeste?'); ?></label>

				<input id="comoconheceu" type="text" name="comoconheceu" class="ipt <? echo (Arr::get($errors, 'comoconheceu')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'comoconheceu'); ?>" maxlength="100" />

				<label for="comoconheceu" class="error"><?= Arr::get($errors, 'comoconheceu'); ?></label>

			</li><br />-->
            <li>
             <label for="aprovadoCI" class="lbl-left"><? echo __('AprovadoCI'); ?></label>
              <input value="1" id="aprovadoCI" type="radio" name="aprovadoCI" groupname="aprovadoCI" class="rdo" <?=(Arr::get($values, 'aprovadoCI') == '1' ? 'checked' : ''); ?> /> sim
              <input value="2" id="aprovadoCI" type="radio" name="aprovadoCI" groupname="aprovadoCI" class="rdo" <?=(Arr::get($values, 'aprovadoCI') == '2' ? 'checked' : ''); ?> /> não
              <input value="0" id="aprovadoCI" type="radio" name="aprovadoCI" groupname="aprovadoCI" class="rdo" <?=(Arr::get($values, 'aprovadoCI') == '0' ? 'checked' : ''); ?> /> não avaliado
             </li>
             <li>
             <label for="obs" class="lbl-left"><? echo __('Observações'); ?></label>
         <!--    <input type="text" name="obs" value="<?= Arr::get($values, 'obs'); ?>" maxlength="100" class="ipt" />
         	-->
            <textarea rows=10 cols=90 name="obs"><?= Arr::get($values, 'obs'); ?></textarea>
         
         
             </li>

		</ul>

	</fieldset>

	<fieldset>

		<legend><? echo __('Contatos'); ?></legend>

		<ul>

			<li>

				<label for="tel1" class="lbl-left"><? echo __('Telefone'); ?>(1) <span class="obl">*</span></label>

				<div class="dv_rdotel">

					<label><input type="radio" name="pais1" class="rdopais" value="B" <?=(Arr::get($values, 'pais1')<>"E" ? "checked" : "")?> /><? echo __('TelBrasil'); ?></label>

					<label><input type="radio" name="pais1" class="rdopais" value="E" <?=(Arr::get($values, 'pais1')=="E" ? "checked" : "")?> /><? echo __('TelExterior'); ?></label>

				</div>

				<input id="tel1" type="text" name="tel1" class="ipt tel <? echo (Arr::get($errors, 'tel1')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'tel1'); ?>" maxlength="14" />

				<label for="tel1" class="error"><?= Arr::get($errors, 'tel1'); ?></label>

				<a href="#" class="tip_trigger"><img src="<?=URL::site("assets/img/info.png")?>"/><span class="tip"><? echo __('TelefoneInfo'); ?></span></a>

			</li>

			<li>

				<label for="tel2" class="lbl-left"><?=__('Telefone')?>(2) </label>

				<div class="dv_rdotel">

					<label><input type="radio" name="pais2" class="rdopais" value="B" <?=(Arr::get($values, 'pais2')<>"E" ? "checked" : "")?> /><? echo __('TelBrasil'); ?></label>

					<label><input type="radio" name="pais2" class="rdopais" value="E" <?=(Arr::get($values, 'pais2')=="E" ? "checked" : "")?> /><? echo __('TelExterior'); ?></label>

				</div>

				<input id="tel2" type="text" name="tel2" class="ipt tel <? echo (Arr::get($errors, 'tel2')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'tel2'); ?>" maxlength="14" />

				<label for="tel2" class="error"><?= Arr::get($errors, 'tel2'); ?></label>

			</li>

			<li>

				<label for="email2" class="lbl-left"><? echo __('Email alternativo'); ?></label>

				<input id="email2" type="text" name="email2" class="ipt <? echo (Arr::get($errors, 'email2')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email2'); ?>"  maxlength="120" />

				<label for="email2" class="error"><?= Arr::get($errors, 'email2'); ?></label>

			</li>

			<li>

				<label for="skype" class="lbl-left">Skype <span class="obs">**</span></label>

				<input id="skype" type="text" name="skype" class="ipt" value="<?= Arr::get($values, 'skype'); ?>"  maxlength="100" />

			</li>

			<li>

				<label for="outrosim" class="lbl-left"><? echo __('Outro IM'); ?></label>

				<input id="outrosim" type="text" name="outrosim" class="ipt" value="<?= Arr::get($values, 'outrosim'); ?>"  maxlength="120" />

			</li>

			<li>

				<label for="blog" class="lbl-left">Blog</label>

				<input id="blog" type="text" name="blog" class="ipt <? echo (Arr::get($errors, 'blog')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'blog'); ?>"  maxlength="250" />

				<label for="blog" class="error"><?= Arr::get($errors, 'blog'); ?></label>

			</li>

			<li>

				<label for="facebook" class="lbl-left">Facebook </label>

				<input id="facebook" type="text" name="facebook" class="ipt <? echo (Arr::get($errors, 'facebook')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'facebook'); ?>" maxlength="250" />

				<label for="facebook" class="error"><?= Arr::get($errors, 'facebook'); ?></label>

			</li>

			<li>

				<label for="outrars" class="lbl-left"><? echo __('Outra Rede Social'); ?> </label>

				<input id="outrars" type="text" name="outrars" class="ipt <? echo (Arr::get($errors, 'outrars')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'outrars'); ?>" maxlength="250" />

				<label for="outrars" class="error"><?= Arr::get($errors, 'outrars'); ?></label>

			</li>

		</ul>

	</fieldset>



	<fieldset>

		<legend><? echo __('Endereço Residencial'); ?></legend>

		<ul>

			<li>

				<label for="endereco" class="lbl-left"><? echo __('Endereço Residencial'); ?> </label>

				<input type="text" id="endereco" name="endereco" class="ipt" value="<?= Arr::get($values, 'endereco'); ?>" />

			</li>

			<li>

				<label for="numero" class="lbl-left">N° </label>

				<input type="text" name="numero" class="ipt" value="<?= Arr::get($values, 'numero'); ?>" maxlength="100" />

			</li>

			<li>

				<label for="compl" class="lbl-left"><? echo __('Compl.'); ?></label>

				<input type="text" name="compl" class="ipt" value="<?= Arr::get($values, 'compl'); ?>" maxlength="100" />

			</li>

			<li>

				<label for="bairro" class="lbl-left"><? echo __('Bairro'); ?></label>

				<input type="text" name="bairro" class="ipt" value="<?= Arr::get($values, 'bairro'); ?>" maxlength="100" />

			</li>

			<li>

				<label for="cep" class="lbl-left"><? echo __('CEP'); ?></label>

				<input type="text" name="cep" class="ipt" value="<?= Arr::get($values, 'cep'); ?>" maxlength="10" />

			</li>

			<li>

				<label for="cidade" class="lbl-left"><? echo __('Cidade'); ?></label>

				<input type="text" name="cidade" class="ipt" value="<?= Arr::get($values, 'cidade'); ?>" maxlength="150" />

			</li>

			<li>

				<label for="estado" class="lbl-left"><? echo __('Estado'); ?></label>

				<input type="text" name="estado" class="ipt" value="<?= Arr::get($values, 'estado'); ?>" maxlength="100" />

			</li>

			<li>

				<label for="pais" class="lbl-left"><? echo __('País'); ?></label>

				<input type="text" name="pais" class="ipt" value="<?= Arr::get($values, 'pais'); ?>" maxlength="200" />

			</li>

		</ul>

	</fieldset>



	<div>

		<input type="submit" value="<? echo __('salvar'); ?>" />

		<input type="button" value="<? echo __('voltar'); ?>" onClick="window.open('<? echo URL::site("admin/curriculo/geral/".$id)?>', '_top')" />

	</div>

</form>

<br class="clear" />

<script type="text/javascript">

$(function() {

	$(".cpf").mask("999.999.999-99");

	$(".data").mask("99/99/9999");

	$(".anos").mask("?99");

	maskDocumento($("input[name=doctype]:checked"));

	maskTelefone($("input[name=pais1]:checked"));

	maskTelefone($("input[name=pais2]:checked"));



	showQual( $("#chk-outro-idioma"), $('#dv_outroidioma') );

	showQual( $("#chk-outra-locomocao"), $('#dv_outralocomocao') );



	$("#chk-outro-idioma").click(function(){

		showQual( $(this), $('#dv_outroidioma') );

	});



	$("#chk-outra-locomocao").click(function(){

		showQual( $(this), $('#dv_outralocomocao') );

	});



	$(".rdodoc").click(function() {

		maskDocumento($(this));

	});

	$(".rdopais").click(function() {

		maskTelefone($(this));

	});



    //Tooltips

    $(".tip_trigger").hover(function(){

        tip = $(this).find('.tip');

        tip.show(); //Show tooltip

    }, function() {

        tip.hide(); //Hide tooltip

    });



});

</script>