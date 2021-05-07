<h2 class="h2_curtitle"><? echo __('Interesses'); ?></h2>
<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
<? echo (isset($errors) ? '<p class="p_error">'.__('Verifique os erros de preenchimento.').'</p>' : ''); ?>
<form id="frm-cadastro-talento" method="post">
	<fieldset>
		<legend><? echo __('Interesse e Experiência com Ensino, Coordenação e Outras Carreiras'); ?></legend>
		<ul>
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
								'.($exp->escolas ? __('Escolas').' <input type="text" name="experiencia_escolas['.$exp->id.']" value="'.($experiencia_post == "2" ? (Arr::get($experiencia_escolas, $exp->id)) : '').'" class="escolas" />' : '').'
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