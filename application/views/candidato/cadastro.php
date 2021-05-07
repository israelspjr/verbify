<?php



$values["paises"] = ORM::factory("pais")->find_all();

error_reporting(E_ALL);


	?>
<!--<script src="https://code.jquery.com/jquery-2.2.4.js"></script>-->

<script src="http://www.vagasdeprofessores.com.br/profteste/assets/js/jquery.form.js" type="text/javascript"></script>

<!--<script src="http://www.vagasdeprofessores.com.br/profteste/assets/js/jquery.fileupload.js" type="text/javascript"></script>       -->

        <form id="formularioPf" method="post" enctype="multipart/form-data" action="" style="display:none;" >

      <input type="hidden" id="acao" name="acao" value="foto" />

      <input type="hidden" id="destino" name="destino" value="#visualizar" />

      <input type="file" id="add_foto" name="file" onchange="postFileForm('formularioPf')" />

    </form>

<div class="content" style="margin-top: 30px;">   

	<div class="dv_quadrado_invisivel verde"></div>

	<h2 class="h2_title txt-verde"><?=__('professor')?></h2>

	<div id="dv_login" style="width: 600px;">

		<form method="post" action="<?=URL::site("candidato/login")?>" id="frm-login" style="float: right;">

			<label><?=__('email')?>: </label><input type="text" name="email" />

			<label><?=__('senha')?>: </label><input type="password" name="senha" />

			<input type="submit" class="btn_entrar" name="entrar" value="<?=__('entrar')?>" />

		</form>

		<label class="titulo" style="margin: 0 15px 0 0; float: right;"><?=__('ja é cadastrado?')?></label>

		<div class="clear"></div>

	</div>

	<div class="clear"></div>

	<div>

		<div class="dv_img" style="margin-top: 10px; width: 950px; height: 527px; overflow: hidden;"><img src="<?=URL::site("assets/img/home/prof_login_BX.jpg")?>" /></div>

		<div style="margin: 15px 0;">

			<p>

			<!--	<?php /*=__('Professor')*/?>, <br />-->

       <div>





</div>     

			<!--	<?php /*=//__('cadastrop1')*/?>-->

			</p>

		</div>

        <!--

 <script src="<?=URL::site("assets/js/jquery.fileupload.js")?>" type="text/javascript"></script>       

        <form id="formularioPf" method="post" enctype="multipart/form-data" action="" style="display:none;" >

      <input type="hidden" id="acao" name="acao" value="foto" />

      <input type="hidden" id="destino" name="destino" value="#visualizar" />

      <input type="file" id="add_foto" name="foto" onchange="postFileForm('formularioPf')" />

    </form>

    

<form id="preCadastro" method="post" style="padding-bottom: 5px;display:none;" action="<?=URL::site("candidato/login")?>" target="iframe_pre">

<input id="emailp" type="text" name="emailp" class="ipt <? echo (Arr::get($errors, 'email')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email'); ?>"  maxlength="100" />

<button type="submit" id="buttonPre" name="buttonPre">Enviar</button>

</form>



<iframe name="iframe_pre" id="iframe_pre" style="display:none;"></iframe>

-->

		<form id="frm-cadastro-talento" method="post" style="padding-bottom: 5px;" enctype="multipart/form-data">

			<fieldset>

				<legend><? echo __('Dados de Acesso'); ?></legend>

				<ul>

					<li>

						<label for="email" class="lbl-left"><? echo __('email'); ?> <span class="obl">*</span></label>

						<input id="email" type="text" name="email" required class="ipt <? echo (Arr::get($errors, 'email')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email'); ?>"  maxlength="100" />

						<label for="email" class="error"><?= Arr::get($errors, 'email'); ?></label>

					</li>

					<li>

						<label for="senha" class="lbl-left"><?=__('senha')?> <span class="obl">*</span></label>

						<input id="senha" type="password" required name="senha" class="ipt <? echo (Arr::get($errors, 'senha')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'senha'); ?>" maxlength="12" />

						<label for="senha" class="error"><?= Arr::get($errors, 'senha'); ?></label>

					</li>

					<li>

						<label for="csenha" class="lbl-left"><?=__('Repetir senha')?> <span class="obl">*</span></label>

						<input id="csenha" type="password" required name="_external[csenha]" class="ipt <? echo (Arr::path($errors, '_external.csenha')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::path($values, '_external.csenha'); ?>" maxlength="12" />

						<label for="csenha" class="error"><?= Arr::path($errors, '_external.csenha'); ?></label>

					</li>

		<!--		<li><button type="button" value="Continuar" onclick="continuar();" >Continuar Cadastro </button>-->

                </li>

                </ul>

                

				<div class="clear"></div>

			</fieldset>

            

      <!--      <div id="fullcadastro" style="display:none;">-->

			<fieldset>

				<legend><? echo __('Fale sobre você'); ?></legend>

				<ul>

					<li>

						<label for="nome" class="lbl-left"><? echo __('Nome Completo'); ?> <span class="obl">*</span></label>

						<input id="nome" type="text" name="nome" required class="ipt <? echo (Arr::get($errors, 'nome')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'nome'); ?>" maxlength="120" />

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

						<label for="rg" class="lbl-left"><span id="lblrg"><? echo __('RG'); ?></span><span class="obl">*</span></label>

						<input id="rg" type="text" name="rg" class="ipt rg" required maxlength="19" value="<?= Arr::get($values, 'rg'); ?>" />

					</li>

					<li>

						<label for="sexo" class="lbl-left"><? echo __('Sexo'); ?> <span class="obl">*</span></label>

						<label class="lbl-radio">

							<input value="M" name="sexo" type="radio" groupname="radioSexo" required class="rdo" <?=(Arr::get($values, 'sexo') == 'M' ? 'checked' : ''); ?> />

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

						<label for="dtnasc" required class="lbl-left"><? echo __('Dt nascimento'); ?> <span class="obl">*</span></label>

						<input id="dtnasc" type="text" name="dtnasc" class="ipt data <? echo (Arr::get($errors, 'dtnasc')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'dtnasc'); ?>" maxlength="10" />

						<label for="dtnasc" class="error"><?= Arr::get($errors, 'dtnasc'); ?></label>

					</li>

					<li>

						<label for="nacionalidade" class="lbl-left"><? echo __('Nacionalidade'); ?> <span class="obl">*</span></label>

					<!--	<input id="nacionalidade" type="text" name="nacionalidade" class="ipt <? echo (Arr::get($errors, 'nacionalidade')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'nacionalidade'); ?>" maxlength="120" />

						<label for="nacionalidade" class="error"><?= Arr::get($errors, 'nacionalidade'); ?></label>-->

                         <select name="nacionalidade" class="ipt">

    

			<?php



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

                    <label for="foto_perfil" class="lbl-left"><? echo __('Inserir Foto do Perfil: '); ?> <span class="obl">*</span></label>

                    <div id="resultadoFoto"></div>
                    
           <img src="http://www.vagasdeprofessores.com.br/bup/assets/img/upload_foto.png" onclick="$('#add_foto').click();" title="Adicionar" />

        <div id="visualizar">

          <?php if($foto != ''){?>

          <img src="<?php echo CAMINHO_UP?>imagem/foto/clientePf/miniatura-<?php echo $fotoThumb;?>" />

          <?php }?>

        <!--  <input type="hidden" name="foto_oculta" value="<?php echo $foto;?>" />-->

          </div>


      <!--     <iframe src="http://www.vagasdeprofessores.com.br/profteste.php" style="border: 0; height: 36px;"></iframe>
-->
                        <li>

						<label for="idioma" class="lbl-left"><? echo __('Idiomas que leciona'); ?> <span class="obl">*</span></label>

						<div class="dv_campo" id="idioma">

							<?

							foreach($idiomas as $idioma){

								$idiomas_post = (isset($values["idioma"]) ? $values["idioma"] : array());

								echo '

								<label class="lbl-check">

									<input type="checkbox" name="idioma['.$idioma->id.']" value="1" groupname="checkIdiomas" '.(Arr::get($idiomas_post, $idioma->id) ? "checked" : "").' '.($idioma->is_outro ==1 ? 'id="chk-outro-idioma"' : '').' />

									<span>'.__($idioma->descricao).'</span>

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

                  <label for="provisionamento" class="lbl-left"><? echo __('Como conheceu o Banco único de professores?'); ?> <span class="obl">*</span></label>

                        <div class="dv_campo">

     <input type="radio" name="provisionamento" class="prov" value="adwords" required <?=((Arr::get($values, 'comoconheceu')=="adwords") ? "checked" : "");?>>

	<span>Adwords</span></label>

                  <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="facebook" <?=((Arr::get($values, 'comoconheceu')=="facebook") ? "checked" : "");?>>

	<span>Facebook</span></label>

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

                 <?php $comoconheceu = Arr::get($values, 'comoconheceu'); ?>

                 <label class="lbl-check">

	<input type="radio" name="provisionamento" class="prov" value="outros" id="radio-outro-provisionamento" <?php 

		

		if (($comoconheceu !="") && ($comoconheceu !="facebook") && ($comoconheceu !="adwords") &&  ($comoconheceu !="busca internet"))  {

			echo "checked";	

			$usarOutros = 1;	}?> >

	<span>Outros</span>

       <?php   if ($usarOutros == 1) {

			 echo "<span>&nbsp;($comoconheceu)</span>";

			 }?>

	</label></div>

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
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="35">35</option>
                        <option value="40">40</option>
                        <option value="45">45</option>
                        <option value="50">50</option>
                        <option value="55">55</option>
                        <option value="60">60</option>
                        <option value="65">65</option>
                        <option value="70">70</option>
                        <option value="75">75</option>
                        <option value="80">80</option>
                        <option value="85">85</option>
                        <option value="90">90</option>
                        <option value="95">95</option>
                        <option value="100">100</option>           
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

			<!--		<li>

						<label for="tel2" class="lbl-left"><?=__('Telefone')?>(2) </label>

						<div class="dv_rdotel">

							<label><input type="radio" name="pais2" class="rdopais" value="B" <?=(Arr::get($values, 'pais2')<>"E" ? "checked" : "")?> /><?=__('TelBrasil')?></label>

							<label><input type="radio" name="pais2" class="rdopais" value="E" <?=(Arr::get($values, 'pais2')=="E" ? "checked" : "")?> /><?=__('TelExterior')?></label>

						</div>

						<input id="tel2" type="text" name="tel2" class="ipt tel <? echo (Arr::get($errors, 'tel2')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'tel2'); ?>" maxlength="14" />

						<label for="tel2" class="error"><?= Arr::get($errors, 'tel2'); ?></label>

					</li>-->

					<li>

						<label for="email2" class="lbl-left"><? echo __('Email alternativo'); ?> </label>

						<input id="email2" type="text" name="email2" class="ipt <? echo (Arr::get($errors, 'email2')<>"" ? 'ipt-error' : ''); ?>" value="<?= Arr::get($values, 'email2'); ?>"  maxlength="120" />

						<label for="email2" class="error"><?= Arr::get($errors, 'email2'); ?></label>

					</li>

					<li>

						<label for="skype" class="lbl-left">Skype <span class="obl">*</span></label>

						<input id="skype" required type="text" name="skype" class="ipt" value="<?= Arr::get($values, 'skype'); ?>"  maxlength="100" />

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

			<!--		<li>

						<label for="outrosim" class="lbl-left"><? echo __('Outro IM'); ?> </label>

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

						<input type="text" required name="cep" id="cep" class="ipt" value="<?= Arr::get($values, 'cep'); ?>" maxlength="10" />

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

						<input type="text" name="compl" id="compl" class="ipt" value="<?= Arr::get($values, 'compl'); ?>" maxlength="100" />

					</li>

					<li>

						<label for="bairro" class="lbl-left"><? echo __('Bairro'); ?><span class="obl">*</span></label>

						<input type="text" required name="bairro" id="bairro" class="ipt" value="<?= Arr::get($values, 'bairro'); ?>" maxlength="100" />

					</li>

					

					<li>

						<label for="cidade" class="lbl-left"><? echo __('Cidade'); ?><span class="obl">*</span></label>

						<input type="text" required name="cidade" id="cidade" class="ipt" value="<?= Arr::get($values, 'cidade'); ?>" maxlength="150" required="required"/>

					</li>

					<li>

						<label for="estado" class="lbl-left"><? echo __('Estado'); ?><span class="obl">*</span></label>

						<input type="text" required name="estado" id="estado" class="ipt" value="<?= Arr::get($values, 'estado'); ?>" maxlength="100" required="required"/>

					</li>

					<li>

						<label for="pais" class="lbl-left"><? echo __('País'); ?></label>

						<input type="text" name="pais" class="ipt" value="<?= Arr::get($values, 'pais'); ?>" maxlength="200" />

					</li>

				</ul>

			</fieldset>

            

			<div class="dv_btn" style="margin: 30px 10px;">

				<input type="submit" onclick="valida()" name="cadastrar" value="<? echo __('cadastrar'); ?>"/>

			</div>

		</form>

        </div>

        <div>

<!--

<span class="btn btn-success fileinput-button">

   <i class="glyphicon glyphicon-plus"></i>

      <span>Foto de perfil</span>

      <input id="fileupload" type="file" name="files[]" multiple>

</span><br><br>





<script type="text/javascript">

$(function () {

    'use strict';

    // Change this to the location of your server-side upload handler:

 //   var url = window.location.hostname === 'blueimp.github.io' ?

  //              '//jquery-file-upload.appspot.com/' : 'http://www.vagasdeprofessores.com.br/profteste/uploads/foto.php';

  var url = 'http://www.vagasdeprofessores.com.br/profteste/uploads/foto.php';

    $('#fileupload').fileupload({

        url: url,

        dataType: 'json',

        done: function (e, data) {

            $.each(data.result.files, function (index, file) {

                $('<p/>').text(file.name).appendTo('#files');

				$('#foto').val('profteste/uploads/fotos/'+file.name);

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



</form>-->

</div>

        		<br class="clear" />

	<!--	<div class="dv_obs"><!--<? //echo __('aviso'); ?>--><!--Para o idioma japonês, ainda não há teste escrito no portal, mas o candidato poderá preencher seu cadastro, e entraremos em contato.</div>-->

	</div>

<!--</div>-->

<script>


/* #imagem é o id do input, ao alterar o conteudo do input execurará a função baixo */

$('#add_file').on('change', function(){

	$('#visualizarFile').html('Enviando...');

	/* Efetua o Upload sem dar refresh na pagina */ 

	$('#form_uploadFile').ajaxForm({

		target:'#visualizarFile' // o callback será no elemento com o id #visualizar

	}).submit();

});



function postFileForm(idForm) {



	var form = $('#' + idForm);

//	showLoad();



	form.ajaxForm({

		url : '../../../foto.php',

		type : 'POST',

		success : function(e) {

			

			$('#resultadoFoto').html(e);

			

//			acaoJson(e);

		},

		error : function(data) {

			alert('Erro durante o processamento');

		},

		complete : function(data) {

//			fecharNivel_load();

		}

	}).submit();



}

$(function() {

	$(".data").mask("99/99/9999");

	$(".anos").mask("?99");



	maskDocumento($("input[name=doctype]:checked"));

	maskTelefone($("input[name=pais1]:checked"));

	maskTelefone($("input[name=pais2]:checked"));



	showQual( $("#chk-outro-idioma"), $('#dv_outroidioma') );

	showQual( $("#chk-outra-locomocao"), $('#dv_outralocomocao') );

    showQual( $("#radio-outro-provisionamento"), $('#dv_outroprovisionamento') );



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



        self.submit();



    });

	

//	document



    

    //$('input[type="submit"][name="cadastrar"]').



	$(".rdodoc").click(function(){

		maskDocumento($(this));

	});



	$(".rdopais").click(function(){

		maskTelefone($(this));

	});



});



function continuar(){

	$("#fullcadastro").show();

	$("#emailp").val($("#email").val());

	$("#buttonPre").click();

	

}



$(document).ready(function() {

	

	if ($("#email").val() != '') {

		continuar();

	}

	

    //Tooltips

    $(".tip_trigger").hover(function(){

        tip = $(this).find('.tip');

        tip.show(); //Show tooltip

    }, function() {

        tip.hide(); //Hide tooltip

    });

	

	

});



function valida() {

	

	

	if ($('#email').val() == '') {

	alert("Por favor preencha o email");	

		

	}

	

  	

}



function maskDocumento(el){

	if(el.val() == "B"){

		$("#lblcpf").html('CPF');

		$(".cpf").mask("999.999.999-99");

	} else {

		$("#lblcpf").html('ID');

		$(".cpf").unmask();

	}

}

function maskTelefone(el){

	if(el.val() == "B"){

		el.parents("li").find(".tel").mask("(+55)(99)9999-9999?9");

	} else {

		el.parents("li").find(".tel").unmask();

	}

}

function showQual(chk, div) {

	if( chk.is(':checked') ) {

		div.appendTo(chk.parent().parent());

		div.show();

	} else {

		div.hide();

	}

}


    $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#endereco").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");
                $("#compl").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#endereco").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#estado").val("...");
                        $("#compl").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#endereco").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#estado").val(dados.uf);
                                $("#compl").val(dados.complemento);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });



</script>







