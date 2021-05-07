<div id="dv_candidato_home">
	<div id="dv_welcome">
		<? echo 'Hello, '.$candidato->nome.'!'; ?>
	</div>
	<?=(isset($aviso) ? '<p class="p_warning">'.$aviso.'</p>' : '');?>
	<?=(isset($convites) ? $convites : '');?>
	<div class="dv_intro">
		<h3>Here is the beginning of your opportunity to show your talent and experience. You will go through the following phases:</h3>
		<p><strong>a) RESUME - </strong>actually you will not upload a resume, but you will tell your future employers (schools, companies or private students) about your Personal Information, Interests, Experience / Background and Availability of time for teaching.
			Through the portal you will also take the opportunity to ask students, former students, fellow language teachers or language school coordinators for references about your work. They will receive a request by email. Shall we go on?
			Please click on <a href="<?=URL::site("candidato/meusdados")?>">RESUME</a>.</p>
		<p><strong>b) TESTS - </strong>in this section you will take the tests: Written (in the language you registered *), Educational (in Portuguese), and Behavioral (in Portuguese).
			You will also upload a video where you answer some questions (see the tutorial). Should you have any trouble uploading the video, there is a technical tutorial for you to follow.
			And if you still have questions, just talk to the team of ProfCerto – by email, Skype or chat (please access Contact on the Home Page).
		</p>
		<p>If by chance you do not have time to finish all the tests, no problem. Try to finish one of them and come back as soon as possible to finish the others!
			Remember: schools, companies and private students are screening professionals just like you - but they will want to see your tests before inviting you to new opportunities.</p>
		<p>If by any chance you take a test and do not like the result (yes, you will have access to your own results!), you may choose not to disclose it.</p>
		<p>Got questions? Read the <a href="<?=URL::site("home/maisinfo?page=3")?>">Frequently Asked Questions</a> section or contact us.</p>
	</div>
</div>