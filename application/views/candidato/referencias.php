<h2 class="h2_curtitle"><? echo __('Referências'); ?></h2>
<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>
<form id="frm-cadastro-talento" method="post">
	<fieldset id="fds_referencias">
		<legend><? echo __('Solicitar Referências'); ?></legend>
		<div class="row">
			<label><? echo __('nome'); ?></label>
			<input type="text" name="nome" maxlength="200" value="<?=$ref->nome?>" />
			<p class="error"><?=(Arr::get($errors, "nome") ? Arr::get($errors, "nome") : '')?></p>
			<div class="clear"></div>
		</div>
		<div class="row">
			<label><? echo __('email'); ?> </label>
			<input type="text" name="email" maxlength="200" value="<?=$ref->email?>" />
			<p class="error"><?=(Arr::get($errors, "email") ? Arr::get($errors, "email") : '')?></p>
			<div class="clear"></div>
		</div>
		<div class="dv_btn">
			<input type="submit" name="enviar" value="<? echo __('enviar'); ?>" />
		</div>
	</fieldset>
</form>
<?
foreach($referencias as $row){
	echo '
	<div>
		<div class="dv_referencia '.($row->aprovado == 0 ? 'pendente' : 'aprovado').'">
			<blockquote>"'.$row->mensagem.'"</blockquote>
			<p>
				'.$row->nome.', '.$row->relacionamento->descricao.'<br />
				'.$row->email.'<br />
				'.Helper::format_timestamp($row->ts_mensagem).'
			</p>
		</div>
		<div class="dv_acao">
			'.($row->aprovado == 0 ? '<a href="'.URL::site("candidato/referencias/publicar/".$row->id).'">'.__('Publicar').'</a> |' : '').
			'<a href="'.URL::site("candidato/referencias/excluir/".$row->id).'">'.__('Excluir').'</a>
		</div>
	</div>';
}
?>
