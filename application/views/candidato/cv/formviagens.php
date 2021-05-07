<div class="dvsao_viagens">
	<h2 class="h2_title"><? echo __('Viagem'); ?> n° <? echo $i ?></h2>
	<input type="hidden" name="vordem[<? echo $i ?>]" value="<? echo $i ?>">
	<ul>
		<li>
			<label for="pais" class="lbl-left"><? echo __('País'); ?> <span class="obl">*</span></label>
			<select name="pais[<?=$i?>]" class="ipt">
				<option value=""></option>
				<?
				foreach($paises as $pais)
					echo '<option value="'.$pais->id.'">'.$pais->name.'</option>';
				?>
			</select>
		</li>
		<li>
			<label for="dt_partida<?=$i?>" class="lbl-left"><? echo __('Data da Partida'); ?> <span class="obl">*</span></label>
			<input name="dt_partida[<?=$i?>]" class="ipt data" id="dt_partida<?=$i?>" />
		</li>
		<li>
			<label for="dt_volta<?=$i?>" class="lbl-left"><? echo __('Data da Volta'); ?> <span class="obl">*</span></label>
			<input name="dt_volta[<?=$i?>]" class="ipt data" id="dt_volta<?=$i?>" />
		</li>
		<li>
			<label for="atividade" class="lbl-left"><? echo __('Atividade no país'); ?> <span class="obl">*</span></label>
			<input type="radio" name="atividade[<?=$i?>]" value="turismo" id="at_tur[<?=$i?>]" class="rdo" ><label for="at_tur[<?=$i?>]"><? echo __('turismo'); ?></label>
			<input type="radio" name="atividade[<?=$i?>]" value="trabalho" id="at_tra[<?=$i?>]" class="rdo" ><label for="at_tra[<?=$i?>]"><? echo __('trabalho'); ?></label>
			<input type="radio" name="atividade[<?=$i?>]" value="estudo" id="at_est[<?=$i?>]" class="rdo" ><label for="at_est[<?=$i?>]"><? echo __('estudo'); ?></label>
			<input type="radio" name="atividade[<?=$i?>]" value="outra" id="at_out[<?=$i?>]" class="rdo" ><label for="at_out[<?=$i?>]"><? echo __('outra atividade'); ?></label>
		</li>
		<li>
			<label for="txt_desc[<?=$i?>]" class="lbl-left"><? echo __('Descreva'); ?></label>
			<textarea name="txt_desc[<?=$i?>]" class="txt"></textarea>
		</li>
	</ul>
	<br class="clear" />
</div>