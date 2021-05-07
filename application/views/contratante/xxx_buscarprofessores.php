			<div class="inline">
				<label>Dia da Semana</label>
				<select name="semana" class="ipt">
					<option value="">Indiferente</option>
					<?
					foreach($semana as $key => $dia) {
						echo '<option value="'.$key.'" '.(Arr::get($values, "semana") == $key ? 'selected' : '').'>'.$dia.'</option>';
					}
					?>
				</select>
			</div>
			<div class="inline">
				<label>Intervalo</label>
				<select class="hora" name="horade">
					<option></option>
					<?
					for($i=6;$i<=21;$i++)
						echo '<option value="'.$i.'" '.(Arr::get($values, "horade") == $i ? 'selected' : '').'>'.$i.'h</option>';
					?>
				</select>
				às 
				<select class="hora" name="horaate">
					<option></option>
					<?
					for($i=7;$i<=22;$i++)
						echo '<option value="'.$i.'" '.(Arr::get($values, "horaate") == $i ? 'selected' : '').'>'.$i.'h</option>';
					?>
				</select>
			</div>
