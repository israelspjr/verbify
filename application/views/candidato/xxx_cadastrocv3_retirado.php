	<fieldset>
		<legend>Disponibilidade</legend>
		<? echo (isset($errors['disponibilidade']) ? '<label class="error">'.$errors['disponibilidade'].'</label>' : '') ?>
		<table id="tb_disponibilidade">
			<tr>
				<td style="border: none; width: 160px;"></td>
				<?
				foreach($semana as $i)
					echo "<th style='width: 120px;'>$i</th>";
				?>
			</tr>
			<?
			for($i = 6; $i<=21;$i++){
				echo '<tr>
				<th>'.$i.':00 às '.($i+1).':00</th>';
				foreach($semana as $key => $value){
					if(isset($disponibilidades[$key][$i]) AND $disponibilidades[$key][$i]["value"] == 1) {
						echo '
						<td class="item ocupado" id="td-'.$key.'-'.$i.'">
							<input type="hidden" name="status['.$key.']['.$i.']" value="'.$disponibilidades[$key][$i]["value"].'" class="status" />
							<input type="hidden" name="local['.$key.']['.$i.']" value="'.$disponibilidades[$key][$i]["local"].'" class="local" />
							<span class="span_cidade">'.$disponibilidades[$key][$i]["local"].'</span>
						</td>';
					} else {
						echo '
						<td class="item livre" id="td-'.$key.'-'.$i.'">
							<input type="hidden" name="status['.$key.']['.$i.']" value="0" class="status" />
							<input type="hidden" name="local['.$key.']['.$i.']" value="" class="local" />
							<span class="span_cidade">LIVRE</span>
						</td>';
					}
				}
				echo '</tr>';
			} ?>
		</table>
		<div class="hide" id="form_marcar">
			<input type="hidden" id="edit-td" />
			<ul >
				<li style="margin: 10px 0;">
					<label>Cidade</label><br />
					<label class="lbl-radio"><input type="radio" name="m_cidade" value="sp" checked><span>São Paulo</span></label>
					<label class="lbl-radio"><input type="radio" name="m_cidade" value="outra"><span>Outra</span></label>
				</li>
				<li style="margin: 10px 0;">
					<label for="local">Qual?</label><br />
					<input type="text" name="m_local" id="m_local" maxlegth="200" />
				</li>
			</ul>
			<div>
				<input type="button" name="marcar" value="marcar" />
			</div>
		</div>
	</fieldset>
