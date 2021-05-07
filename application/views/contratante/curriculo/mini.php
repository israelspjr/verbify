<div class="curriculo mini">
	<h2>Dados Pessoais</h2>
	<div>
		<label class="lbldados">Sexo:</label>
		<?=$candidato->sexo?>
	</div>
	<div>
		<label class="lbldados">Dt Nascimento:</label>
		<?=Helper::format_date($candidato->dtnasc)?>
	</div>
	<div>
		<label class="lbldados">Nacionalidade:</label>
		<?=$candidato->nacionalidade?>
	</div>
	<div>
		<label class="lbldados">Idiomas que leciona:</label>
		<?=implode(", ", $idiomas)?>
	</div>
	<div>
		<label class="lbldados">Locomove-se na cidade:</label>
		<?=implode(", ", $locomos)?>
	</div>

	<h2>Sobre mim</h2>
	<div>
		<?=$loca->sobremim?>
	</div>

	<h2>Disponibilidade</h2>
	<div>
		<label class="lbldados">EAD / Presencial:</label>
		<?=$ead;?>
	</div>
	<div>
		<label class="lbldados">País:</label>
		<?=ucfirst($loca->pais) ?>
	</div>
	<? 
	if($loca->pais =='brasil'){
		echo '<div>
			<label class="lbldados">Estado:</label>
			'.$loca->estado->vc_estado.'
		</div>';
		echo '<div>
			<label class="lbldados">Cidade:</label>
			'.ucfirst($loca->cidade->vc_cidade).'
		</div>';
		if($loca->cidade_id=="7374"){
			$regioes = Helper::orm_to_array($candidato->regiao->find_all(), "descricao");
			echo '<div>
				<label class="lbldados">Região:</label>
				<div style="float: left;">
					'.implode("<br />", $regioes).'
				</div>
				<div class="clear"></div>
			</div>';
		}
	}
	?>
</div>
