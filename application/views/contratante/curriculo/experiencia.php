<div class="curriculo">
<? 
// viagens
if(count($viagens) > 0){ ?>
	<div>
		<h2>Viagens internacionais</h2>
		<?
			foreach($viagens as $row){
				echo '
				<div class="viagem">
					Destino: '.$row->pais->name.'<br />
					Período: '.Helper::format_date($row->dtde).' - '.Helper::format_date($row->dtate).'<br />
					Atividade no país: '.($row->atividade <> 'outra' ? ucfirst($row->atividade) .'<br />'.$row->descricao : $row->descricao).'
				</div>';
			}
		?>
	</div>
<? } ?>

<? 
// certificações
if(count($certificacoes) > 0){ ?>
	<div>
		<h2>Certificações</h2>
		<?
			foreach($certificacoes as $row){
				echo '
				<div class="certificacao">
					<h4>'.$row->idioma->descricao.'</h4>
					'.$row->ano.' : '.$row->descricao.' ('.($row->tipo =='I' ? 'Internacional' : 'Nacional').')<br />
				</div>';
			}
		?>
	</div>
<? } ?>

<?
// graduações
if(count($graduacoes) > 0){ ?>
	<div>
		<h2>Graduação</h2>
		<?
			foreach($graduacoes as $row){
				echo '
				<div class="graduacao">
					'.$row->grau->descricao.' ('.$row->getSituacao().')<br />
					Curso: '.$row->curso->descricao.'<br />
					Período: '.Helper::format_date_to_mes($row->dt_inicio).' - '.($row->situacao<>3 ? 'atualidade' : Helper::format_date_to_mes($row->dt_conclusao)).'<br />
					Instituição: '.$row->instituicao.'								
				</div>';
			}
		?>
	</div>
<? } ?>

<? 
// experiências profissionais
if(count($experiencias) > 0){ ?>
	<div>
		<h2>Experiência Profissional</h2>
		<?
			foreach($experiencias as $row){
				echo '
				<div class="experiencia">
					'.Helper::format_date_to_mes($row->dt_inicio).' - '.($row->atualidade ==1 ? 'atualidade' : Helper::format_date_to_mes($row->dt_fim)).'<br />
					'.$row->funcao.'
				</div>';
			}
		?>
	</div>
<? } ?>

<? 
// cursos livres
if(count($cursoslivres) > 0){ ?>
	<div>
		<h2>Cursos Livres</h2>
		<?
			foreach($cursoslivres as $row){
				echo '
				<div class="cursoslivres">
					'.$row->ano.': '.$row->curso.' ('.$row->instituicao.')
				</div>';
			}
		?>
	</div>
<? } ?>
</div>
