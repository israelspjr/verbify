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

				<label for="rg" class="lbl-left"><span id="lblrg"><? echo __('RG'); ?></span> <span class="obl">*</span></label>

				<input id="rg" type="text" name="rg" class="ipt rg" maxlength="19" required value="<?= Arr::get($values, 'rg'); ?>" />

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
                
                <label class="lbl-radio">

					<input value="O" name="sexo" type="radio" groupname="radioSexo" class="rdo" <?=(Arr::get($values, 'sexo') == 'O' ? 'checked' : ''); ?> />

					<span><? echo __('Outros'); ?></span>

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

			<!--	<input id="nacionalidade" type="text" name="nacionalidade" class="ipt <? echo (Arr::get($errors, 'nacionalidade')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'nacionalidade'); ?>" maxlength="120" />-->

          <select name="nacionalidade" class="ipt">

    

			<?php

//var_dump($values);	
//var_dump(Arr::get($values, 'valorHora'));
						$nacionalidade = Arr::get($values, 'nacionalidade');

						if ($nacionalidade == '') {

						$nacionalidade = $values['nacionalidade'];

						

						}

					

//						echo $nacionalidade;

						foreach($values['paises'] as $valor) {

//							var_dump($valor);

//							echo $valor->id;



							echo '<option value="'.$valor->id.'" ';

							if ($valor->id == $nacionalidade) {

								echo 'selected="selected"';

							}

							echo '>';

							

							echo $valor->name.'</option>';

//						}

						}

						?></select>

				<label for="nacionalidade" class="error"><?= Arr::get($errors, 'nacionalidade'); ?></label>

				

                

			</li>

            <li>

                    <label for="foto_perfil" class="lbl-left"><? echo __('Inserir Foto do Perfil: '); ?> <span class="obl">*</span></label>

                    	

                         <div id="resultadoFoto" style="    float: left;"><img src="http://www.vagasdeprofessores.com.br/bup/uploads/<?= Arr::get($values, 'foto'); ?>" width="100px" height="100px"/></div>

           <iframe src="http://www.vagasdeprofessores.com.br/profteste.php" style="border: 0; height: 36px;"></iframe>

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

				<li>

                        <label for="provisionamento" class="lbl-left"><? echo __('Como conheceu o Banco único de professores?'); ?> <span class="obl">*</span></label>

                        <div class="dv_campo">

                            <label class="">



								<input type="radio" name="provisionamento" class="prov" value="adwords" required <?=((Arr::get($values, 'comoconheceu')=="adwords") ? "checked" : "");?>>



								<span>Adwords</span>



							</label>

                            <label class="lbl-check">



								<input type="radio" name="provisionamento" class="prov" value="facebook" <?=((Arr::get($values, 'comoconheceu')=="facebook") ? "checked" : "");?>>



								<span>Facebook</span>



							</label>

                               <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="linkedin" <?=((Arr::get($values, 'comoconheceu')=="linkedin") ? "checked" : "");?>>

	<span>Linkedin</span></label>

                  <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="google" <?=((Arr::get($values, 'comoconheceu')=="google") ? "checked" : "");?>>

	<span>Google</span></label>
    
    			 <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="instagram" <?=((Arr::get($values, 'comoconheceu')=="instagram") ? "checked" : "");?>>

	<span>Instagram</span></label>

                 <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="outros buscadores" <?=((Arr::get($values, 'comoconheceu')=="outros buscadores" || (Arr::get($values, 'comoconheceu')=="outros_buscadores")) ? "checked" : "");?>>

	<span>Outros buscadores</span></label>

                 <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="vagas" <?=((Arr::get($values, 'comoconheceu')=="vagas" || (Arr::get($values, 'comoconheceu')=="vagas")) ? "checked" : "");?>>

    <span>Site de vagas</span></label>

                 <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="indicacao" <?=((Arr::get($values, 'comoconheceu')=="indicacao" || (Arr::get($values, 'comoconheceu')=="indicacao")) ? "checked" : "");?>>

	<span>Indicação colega</span></label>

                  <!--          <label class="lbl-check">



								<input type="radio" name="provisionamento" class="prov" value="DISAL" <?=((Arr::get($values, 'comoconheceu')=="DISAL" || (Arr::get($values, 'comoconheceu')=="DISAL_BANNER")) ? "checked" : "");?>>



								<span>DISAL</span>



							</label>-->

                            

                            <?php $comoconheceu = Arr::get($values, 'comoconheceu'); ?>

                            <label class="lbl-check">



								<input type="radio" name="provisionamento" class="prov" value="outros" id="radio-outro-provisionamento" <?php 

								

		if (($comoconheceu !="") && ($comoconheceu !="facebook") && ($comoconheceu !="adwords") &&  ($comoconheceu !="busca internet"))  {

			echo "checked";	

			$usarOutros = 1;	}?> >



								<span>outros</span>

                                

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

                        <input type="hidden" name="comoconheceu" id="comoconheceu" value ="<?=((Arr::get($values, 'comoconheceu')=="DISAL" || (Arr::get($values, 'comoconheceu')=="DISAL_BANNER")) ? "DISAL_BANNER" : ""); ?>">

					</li>
                     <li>
                     <label for="provisionamento" class="lbl-left"><? echo __('Valor/hora mínimo:'); ?> <span class="obl">*</span></label>

                        <div class="dv_campo">
                        <select name="valorHora" class="ipt" required>
                        <option value="">Selecione</option>
                        <option value="20" <?php if (Arr::get($values, 'valorHora') == 20) { echo "selected"; }?> >20</option>
                        <option value="30" <?php if (Arr::get($values, 'valorHora') == 30) { echo "selected"; }?>>30</option>
                        <option value="35" <?php if (Arr::get($values, 'valorHora') == 35) { echo "selected"; }?>>35</option>
                        <option value="40" <?php if (Arr::get($values, 'valorHora') == 40) { echo "selected"; }?>>40</option>
                        <option value="45" <?php if (Arr::get($values, 'valorHora') == 45) { echo "selected"; }?>>45</option>
                        <option value="50" <?php if (Arr::get($values, 'valorHora') == 50) { echo "selected"; }?>>50</option>
                        <option value="55" <?php if (Arr::get($values, 'valorHora') == 55) { echo "selected"; }?>>55</option>
                        <option value="60" <?php if (Arr::get($values, 'valorHora') == 60) { echo "selected"; }?>>60</option>
                        <option value="65" <?php if (Arr::get($values, 'valorHora') == 65) { echo "selected"; }?>>65</option>
                        <option value="70" <?php if (Arr::get($values, 'valorHora') == 70) { echo "selected"; }?>>70</option>
                        <option value="75" <?php if (Arr::get($values, 'valorHora') == 75) { echo "selected"; }?>>75</option>
                        <option value="80" <?php if (Arr::get($values, 'valorHora') == 80) { echo "selected"; }?>>80</option>
                        <option value="85" <?php if (Arr::get($values, 'valorHora') == 85) { echo "selected"; }?>>85</option>
                        <option value="90" <?php if (Arr::get($values, 'valorHora') == 90) { echo "selected"; }?>>90</option>
                        <option value="95" <?php if (Arr::get($values, 'valorHora') == 95) { echo "selected"; }?>>95</option>
                        <option value="100" <?php if (Arr::get($values, 'valorHora') == 100) { echo "selected"; }?>>100</option>           
                        </select>
                        <label for="valorHora" class="error"><?= Arr::get($errors, 'valorHora'); ?></label>
                    </div>
</li>
<li>

						<label for="mei" class="lbl-left"><? echo __('Registro MEI:'); ?> </label>

						<input id="mei" type="text" name="mei" class="ipt <? echo (Arr::get($errors, 'mei')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'mei'); ?>" maxlength="120" />
					</li>
				</ul>

	</fieldset>
    <fieldset>

		<legend><? echo __('Escreva sobre você'); ?></legend>

		<textarea name="sobreMim" maxlength="1000" class="sobreMim" style="margin: 0px; width: 891px; height: 70px;"><?= Arr::get($values, 'sobreMim');?></textarea>

	</fieldset>


	<fieldset>

		<legend><? echo __('Contatos'); ?></legend>

		<ul>

			<li>

				<label for="tel1" class="lbl-left"><? echo __('WhatsApp:'); ?> <span class="obl">*</span></label>

				<div class="dv_rdotel">

					<label><input type="radio" name="pais1" class="rdopais" value="B" <?=(Arr::get($values, 'pais1')<>"E" ? "checked" : "")?> /><? echo __('TelBrasil'); ?></label>

					<label><input type="radio" name="pais1" class="rdopais" value="E" <?=(Arr::get($values, 'pais1')=="E" ? "checked" : "")?> /><? echo __('TelExterior'); ?></label>

				</div>

				<input id="tel1" type="text" name="tel1" class="ipt tel <? echo (Arr::get($errors, 'tel1')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'tel1'); ?>" />

				<label for="tel1" class="error"><?= Arr::get($errors, 'tel1'); ?></label>

				<a href="#" class="tip_trigger"><img src="<?=URL::site("assets/img/info.png")?>"/><span class="tip"><? echo __('TelefoneInfo'); ?></span></a>

			</li>

		<!--	<li>

				<label for="tel2" class="lbl-left"><?=__('Telefone')?>(2) </label>

				<div class="dv_rdotel">

					<label><input type="radio" name="pais2" class="rdopais" value="B" <?=(Arr::get($values, 'pais2')<>"E" ? "checked" : "")?> /><? echo __('TelBrasil'); ?></label>

					<label><input type="radio" name="pais2" class="rdopais" value="E" <?=(Arr::get($values, 'pais2')=="E" ? "checked" : "")?> /><? echo __('TelExterior'); ?></label>

				</div>

				<input id="tel2" type="text" name="tel2" class="ipt tel <? echo (Arr::get($errors, 'tel2')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'tel2'); ?>" maxlength="14" />

				<label for="tel2" class="error"><?= Arr::get($errors, 'tel2'); ?></label>

			</li>-->

			<li>

				<label for="email2" class="lbl-left"><? echo __('Email alternativo'); ?></label>

				<input id="email2" type="text" name="email2" class="ipt <? echo (Arr::get($errors, 'email2')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email2'); ?>"  maxlength="120" />

				<label for="email2" class="error"><?= Arr::get($errors, 'email2'); ?></label>

			</li>

			<li>

				<label for="skype" class="lbl-left">Skype <span class="obl">*</span></label>

				<input id="skype" required type="text" name="skype" class="ipt skype <? echo (Arr::get($errors, 'skype')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'skype'); ?>"  maxlength="100" />

                <label for="skype" class="error"><?= Arr::get($errors, 'skype'); ?></label>

			</li>
             <li>

						<label for="instagram" class="lbl-left">Instagram </label>

						<input id="instagram" type="text" name="instagram" class="ipt" value="<?= Arr::get($values, 'instagram'); ?>"  maxlength="100" />

					</li>
                    
                     <li>

						<label for="youtube" class="lbl-left">Youtube</label>

						<input id="youtube" type="text" name="youtube" class="ipt" value="<?= Arr::get($values, 'youtube'); ?>"  maxlength="100" />

					</li>
                    
                    <li>

						<label for="linkedin" class="lbl-left">Linkedin</label>

						<input id="linkedin" type="text" name="linkedin" class="ipt" value="<?= Arr::get($values, 'linkedin'); ?>"  maxlength="100" />

					</li>

<!--			<li>

				<label for="outrosim" class="lbl-left"><? echo __('Outro IM'); ?></label>

				<input id="outrosim" type="text" name="outrosim" class="ipt" value="<?= Arr::get($values, 'outrosim'); ?>"  maxlength="120" />

			</li>-->

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

				<label for="cep" class="lbl-left"><? echo __('CEP'); ?></label>

				<input type="text" name="cep" class="ipt" value="<?= Arr::get($values, 'cep'); ?>" maxlength="10" />

			</li>

			<li>

				<label for="endereco" class="lbl-left"><? echo __('Endereço Residencial'); ?> <span class="obl">*</span></label>

				<input type="text" id="endereco" name="endereco" class="ipt" required value="<?= Arr::get($values, 'endereco'); ?>" />

			</li>

			<li>

				<label for="numero" class="lbl-left">N° <span class="obl">*</span></label>

				<input type="text" name="numero" class="ipt" required value="<?= Arr::get($values, 'numero'); ?>" maxlength="100" />

			</li>

			<li>

				<label for="compl" class="lbl-left"><? echo __('Compl.'); ?></label>

				<input type="text" name="compl" class="ipt" value="<?= Arr::get($values, 'compl'); ?>" maxlength="100" />

			</li>

			<li>

				<label for="bairro"  class="lbl-left"><? echo __('Bairro'); ?><span class="obl">*</span></label>

				<input type="text" required name="bairro" class="ipt" value="<?= Arr::get($values, 'bairro'); ?>" maxlength="100" />

			</li>

			

			<li>

				<label for="cidade"  class="lbl-left"><? echo __('Cidade'); ?><span class="obl">*</span></label>

				<input type="text" required name="cidade" class="ipt" value="<?= Arr::get($values, 'cidade'); ?>" maxlength="150" />

			</li>

			<li>

				<label for="estado"  class="lbl-left"><? echo __('Estado'); ?><span class="obl">*</span></label>

				<input type="text" required name="estado" class="ipt" value="<?= Arr::get($values, 'estado'); ?>" maxlength="100" />

			</li>

			<li>

				<label for="pais" class="lbl-left"><? echo __('País'); ?></label>

				<input type="text" name="pais" class="ipt" value="<?= Arr::get($values, 'pais'); ?>" maxlength="200" />

			</li>

		</ul>

	</fieldset>



	<div>

		<input type="submit" value="<? echo __('salvar'); ?>" />

	</div>

</form>

<br class="clear" />

<!--<div class="dv_obs"><span class="obs">*</span> <? echo __('aviso'); ?></div>-->

<script>

$(function() {

	$(".cpf").mask("999.999.999-99");

	$(".data").mask("99/99/9999");

	$(".anos").mask("?99");



//	maskDocumento($("input[name=doctype]:checked"));

//	maskTelefone($("input[name=pais1]:checked"));

//	maskTelefone($("input[name=pais2]:checked"));



	showQual( $("#chk-outro-idioma"), $('#dv_outroidioma') );

	showQual( $("#chk-outra-locomocao"), $('#dv_outralocomocao') );



	$("#chk-outro-idioma").click(function(){

		showQual( $(this), $('#dv_outroidioma') );

	});



	$("#chk-outra-locomocao").click(function(){

		showQual( $(this), $('#dv_outralocomocao') );

	});

	

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

		

		if ($("#foto").val() == '') {

			alert("Precisamos de uma foto sua!");

			$("#fileupload").focus();

		} else {



        self.submit();

		

		}



    });



	

	



	$(".rdodoc").click(function(){

		maskDocumento($(this));

	});

	$(".rdopais").click(function(){

		maskTelefone($(this));

	});

});



$(document).ready(function() {

    //Tooltips

    $(".tip_trigger").hover(function(){

        tip = $(this).find('.tip');

        tip.show(); //Show tooltip

    }, function() {

        tip.hide(); //Hide tooltip

    });

});



function showQual(chk, div) {

	if( chk.is(':checked') ) {

		div.appendTo(chk.parent().parent());

		div.show();

	} else {

		div.hide();

	}

}



/*jslint unparam: true */

/*global window, $ */

$(function () {

    'use strict';

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?

                '//jquery-file-upload.appspot.com/' : 'http://www.vagasdeprofessores.com.br/uploads/fotos/files/'

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