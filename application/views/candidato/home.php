<div id="dv_candidato_home">
	<div id="dv_welcome">
		<? echo 'Olá, '.$candidato->nome.'!'; ?>
	</div>
	<?=(isset($aviso) ? '<p class="p_warning">'.$aviso.'</p>' : '');?>
	<?=(isset($convites) ? $convites : '');?>
	<div class="dv_intro">
    	<!--<h3>Complete o seu currículo agora mesmo! <a href="<?=URL::site("candidato/meusdados")?>">Clique aqui</a>.-->
		<h3>AQUI COMEÇA A SUA OPORTUNIDADE DE MOSTRAR SEU TALENTO E EXPERIÊNCIA. VOCÊ VAI PERCORRER AS SEGUINTES FASES:</h3>
		<p><strong>a) CURRÍCULO - </strong>na verdade, você não vai fazer upload de um CV, mas sim contar para o Banco Único de Professores sobre seus Dados Pessoais, Interesses, Experiência/Formação. 
			Entre em <a href="<?=URL::site("candidato/meusdados")?>">CURRÍCULO</a>.</p>
		<p><strong>b) TESTES - </strong>nesta seção, você realizará o teste escrito (no idioma que você se cadastrou*). Tem dúvidas? Leia a seção <a href="<?=URL::site("home/maisinfo?page=3")?>">Dúvidas mais Frequentes</a> ou entre em contato conosco. <a href="mailto:atendimento@companhiadeidiomas.com.br">atendimento@companhiadeidiomas.com.br</a></p>
	</div>
</div>
