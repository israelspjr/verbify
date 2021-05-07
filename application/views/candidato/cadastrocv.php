<h2 class="h2_curtitle"><? echo __('Interesses'); ?></h2>

<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); 
error_reporting(E_ALL);?>

<? echo (isset($errors) ? '<p class="p_error">'.__('Verifique os erros de preenchimento.').'</p>' : '');

$user = Session::instance()->get("talen_user", NULL); 

$query = DB::select()->from('candidato_experiencia')
		             ->where('candidato_id', '=', $user->id)
					 ->where('experiencia_id', 'IN', array('51','52'));
			//		 ->execute();
$result2 = $query->execute()->as_array();	
//print_r($result2);				 

for ($x=0 ;$x<count($result2);$x++) { //as $valorE) {
//	echo $x;
	if ($result2[$x]['experiencia_id'] == 51) {
		$varA1 = str_split($result2[$x]['valor']);
		$perguntaQual1 = $result2[$x]['qual'];
	
	}
	
	if ($result2[$x]['experiencia_id'] == 52) {
		$varA2 = str_split($result2[$x]['valor']);
		$perguntaQual2 = $result2[$x]['qual'];
	}
}

//		var_dump($varA1);
//		var_dump($varA2);
?>

<form id="frm-cadastro-talento" method="post">

	<fieldset>

		<legend><? echo __('Interesse e Experiência com Ensino, Coordenação e Outras Carreiras'); ?></legend>
        
        <ul>
        
        <li>
		<label for="experiencia" class="lbl-bigleft">Em quais plataformas para aulas ao vivo você tem experiência? </label>  
        <div class="dv_campo">   
        <label class="lbl-radio-long">

	    <input type="checkbox" name="experienciaE[]" value="1" <?php if (in_array(1, $varA1)) { echo "checked=\"checked\""; } ?> groupname="experienciaE51" class="exp" /> Zoom</label>
        <input type="checkbox" name="experienciaE[]" value="2" <?php if (in_array(2, $varA1)) { echo "checked=\"checked\""; } ?> groupname="experienciaE51" class="exp" /> Meets</label><br>
        <input type="checkbox" name="experienciaE[]" value="3" <?php if (in_array(3, $varA1)) { echo "checked=\"checked\""; } ?> groupname="experienciaE51" class="exp" /> Skype</label><br>
        <input type="checkbox" name="experienciaE[]" value="4" <?php if (in_array(4, $varA1)) { echo "checked=\"checked\""; } ?> groupname="experienciaE51" class="exp" /> Jitsi</label><br>
        Outro: <input type="text" name="experiencia_qualE" value="<?php echo $perguntaQual1; ?>" groupname="experiencia_qualE[51]" class="exp" /></label>
        <input type="hidden" name="experiencia_anosE" value="0" groupname="experiencia_anosE[51]" class="exp" /></label>
  		</label>
        <label for="experiencia" class="error"></label>
</div>
        </li>

  <li>
		<label for="experiencia" class="lbl-bigleft">Qual(is) plataformas para aulas ao vivo você prefere? </label>  
        <div class="dv_campo">   
        <label class="lbl-radio-long">

	    <input type="checkbox" name="experienciaP[]" value="1" <?php if (in_array(1, $varA2)) { echo "checked=\"checked\""; } ?>groupname="experienciaP52" class="exp" /> Zoom</label>
        <input type="checkbox" name="experienciaP[]" value="2" <?php if (in_array(2, $varA2)) { echo "checked=\"checked\""; } ?> groupname="experienciaP52" class="exp" /> Meets</label><br>
        <input type="checkbox" name="experienciaP[]" value="3" <?php if (in_array(3, $varA2)) { echo "checked=\"checked\""; } ?> groupname="experienciaP52" class="exp" /> Skype</label><br>
        <input type="checkbox" name="experienciaP[]" value="4" <?php if (in_array(4, $varA2)) { echo "checked=\"checked\""; } ?> groupname="experienciaP52" class="exp" /> Jitsi</label><br>
        Outro: <input type="text" name="experiencia_qualP" value="<?php echo $perguntaQual2; ?>" groupname="experiencia_qualP[52]" class="exp" /></label>
        <input type="hidden" name="experiencia_anosP" value="0" groupname="experiencia_anosP[52]" class="exp" /></label>
 		</label>
        <label for="experiencia" class="error"></label>
</div>
   
        
        
        </li>

			<?

			foreach($experiencias as $exp) {

				$experiencia_post = (isset($values["experiencia"][$exp->id]) ? $values["experiencia"][$exp->id] : '0');

				if($exp->experiencia == 1) {

					$experiencia_anos = Arr::get($values, "experiencia_anos");

					$experiencia_escolas = Arr::get($values, "experiencia_escolas");

					echo '<li>

						<label for="experiencia" class="lbl-bigleft">'.__($exp->descricao).'</label>

						<div class="dv_campo '.(Arr::get($errors, 'exp'.$exp->id)<>""? "ipt-error": "").'">

							<label class="lbl-radio-long">

								<input type="radio" name="experiencia['.$exp->id.']" value="0" groupname="experiencia'.$exp->id.'" '.($experiencia_post == "0" ? 'checked': '').' class="exp" />

								<span>'.__('Não tenho interesse.').'</span>

							</label>

							<label class="lbl-radio-long">

								<input type="radio" name="experiencia['.$exp->id.']" value="1" groupname="experiencia'.$exp->id.'" '.($experiencia_post == "1" ? 'checked': '').' class="exp" />

								<span>'.__('Tenho interesse, mas não tenho experiência.').'</span>

							</label>

							<div class="lbl-radio-long">

								<input type="radio" id="tenho'.$exp->id.'" name="experiencia['.$exp->id.']" value="2" groupname="experiencia'.$exp->id.'" '.($experiencia_post == "2" ? 'checked': '').' class="exp" />

								<label for="tenho'.$exp->id.'">'.__('Tenho interesse e tenho experiência de').' </label><input type="text" name="experiencia_anos['.$exp->id.']" class="anos" value="'.($experiencia_post == "2" ? (Arr::get($experiencia_anos, $exp->id)) : '').'"/> '.__('anos.').'

								<br>'.($exp->escolas ? __('Escolas ou Experiência pessoal (opinião):').' <input type="text" name="experiencia_escolas['.$exp->id.']" value="'.($experiencia_post == "2" ? (Arr::get($experiencia_escolas, $exp->id)) : '').'" class="escolas" />' : '').'

							</div>

							<label for="experiencia" class="error">'.Arr::get($errors, 'exp'.$exp->id).'</label>

						</div>

					</li>';

				} elseif($exp->yesorno == 1) {

					$experiencia_qual = Arr::get($values, "experiencia_qual");

					echo '<li>

						<label for="tel1" class="lbl-bigleft">'.__($exp->descricao).'</label>

						<div class="dv_campo '.(Arr::get($errors, 'exp'.$exp->id)<>""? "ipt-error": "").'">

							<label class="lbl-radio-long">

								<input type="radio" name="experiencia['.$exp->id.']" value="0" groupname="experiencia'.$exp->id.'" '.($experiencia_post == "0" ? 'checked': '').' />

								<span>'.__('Não').'</span>

							</label>

							<label class="lbl-radio-long">

								<input type="radio" name="experiencia['.$exp->id.']" value="1" groupname="experiencia'.$exp->id.'" '.($experiencia_post == "1" ? 'checked': '').' />

								<span>'.__('Sim').'. '.__('Qual').'? <input type="text" name="experiencia_qual['.$exp->id.']" value="'.(Arr::get($experiencia_qual, $exp->id)).'"/></span>

							</label>

							<label for="experiencia" class="error">'.Arr::get($errors, 'exp'.$exp->id).'</label>

						</div>

					</li>';

				}

			}

			?>

		</ul>

	</fieldset>

	<div>

		<input type="submit" value="<? echo __('salvar'); ?>" />

	</div>

</form>