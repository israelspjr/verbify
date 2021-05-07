<div class="curriculo">
	<h2 class="h2_curtitle">Referências</h2>
	<?
	foreach($referencias as $row){
		echo '
		<div>
			<div class="dv_referencia">
				<blockquote>"'.$row->mensagem.'"</blockquote>
				<p>
					'.$row->nome.', '.$row->relacionamento->descricao.'<br />
					'.$row->email.'<br />
					'.Helper::format_timestamp($row->ts_mensagem).'
				</p>
			</div>
		</div>';
	}
	?>
</div>
