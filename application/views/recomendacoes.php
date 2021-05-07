<div class="content">
	<h2 class="h2_curtitle">Referência de <?=$ref->candidato->nome?></h2>
	<form method="post" action="" id="frm_recomendacoes">
		<div>
			<label>Nome: </label>
			<input type="text" name="nome" value="<?=$ref->nome?>" disabled />
		</div>
		<div>
			<label>Relacionamento: </label>
			<select name="relacionamento">
				<option></option>
				<?
				foreach($relacionamentos as $row)
					echo '<option value="'.$row->id.'" '.($ref->relacionamento_id == $row->id ? 'selected' : '').'>'.$row->descricao.'</option>';
				?>
			</select>
			<label for="relacionamento" class="error"><?= Arr::get($errors, 'relacionamento_id'); ?></label>
		</div>
		<div>
			<label>Mensagem: </label>
			<textarea name="mensagem"><?=$ref->mensagem?></textarea>
			<label for="mensagem" class="error"><?= Arr::get($errors, 'mensagem'); ?></label>
		</div>
		<div class="dv_btn">
			<input type="submit" name="enviar" value="enviar" />
		</div>
	</form>
</div>