<div class="curriculo">
	<h2>Competências</h2>
	<? 
	var_dump($comp);
	if(count($comp) == 0){
		echo '
		<div class="interesse">
			<p>Não há competências cadastradas</p>
		</div>';
	} /*else {
		foreach($exps as $row){
			if($row->experiencia->experiencia == 1){
				echo '
				<div class="interesse">'.$row->experiencia->descricao.'
					<div class="interesse_resposta">'.
						($row->valor==1
							? 'Tenho interesse, mas não tenho experiência.'
							: 'Tenho interesse e tenho experiência de '.($row->anos == 1 ? '1 ano' : $row->anos. ' anos').'.<br />'.
							($row->escolas 
								? 'Escolas: '.$row->escolas
								: ''
							)
						). '</div>
				</div>';
			} elseif($row->experiencia->yesorno == 1) {
				echo '
				<div class="interesse">'.$row->experiencia->descricao.'
					<div class="interesse_resposta">'.($row->valor==1 ? 'Sim. '.$row->qual : 'Não').'</div>
				</div>';
			}
		}
	}*/
	?>
</div>
