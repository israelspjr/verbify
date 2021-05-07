<div id="dv_maisinfo">
	<ul id="mycarousel" class="jcarousel-skin-tango">
		<li>
			<div class="dv_pagina">
				<div class="dv_img"><img src="<?=URL::site("assets/img/home/como_funciona_BX.jpg")?>" /></div>
				<div class="dv_texto" id="comofunciona">
					<h4 >IF YOU ARE A TEACHER...</h4>
					<p>Whether you are a language teacher – Brazilian or not – in Brazil or abroad, you can fill out your registration form and take the following tests, all free of charges!</p>
					<p>
						<ul>
							<li>Written Test (in the language you teach)</li>
							<li>Educational and Behavioral Tests</li>
							<li>Business and Current Affairs (important for teachers who want to work with executives and / or in-company classes)</li>
							<li>Oral Assessment- by uploading a video recorded by yourself in the language you teach (see how to do it in the tutorial)</li>
						</ul>
					</p>
					<p>You can even invite people who know your work to recommend it: former students, colleagues, current students, coordinators and owners of schools.</p>
					<p>Then all you have to do is to wait for offers from schools or private students interested in your services.
						Contractors may later on schedule other tests or interview with you, so that the parts can become better acquainted before you are hired.
					</p>
				</div>
			</div>
		</li>
		<li>
			<div class="dv_pagina">
				<div class="dv_img"><img src="<?=URL::site("assets/img/home/princ_vantagens_BX.jpg")?>" /></div>
				<div class="dv_texto">
					<p>Among the advantages of Profcerto, we can highlight:</p>
					<ul>
						<li>Exclusive Bank of Resumes with teachers of several languages;</li>
						<li>Customized Search tool for better identification of the professional profile that best suits your job or meets your expectation;</li>
						<li>Easy access to the results of the written, behavioral, and educational tests, video and references of the candidate;</li>
						<li>Diversity of candidates to meet any expectation, wide range of languages and experiences, such as teaching English to children, French to executives, and so on. Our goal is to attract language teachers who are a perfect match to your needs;</li>
						<li>Reduction not only of recruitment and selection costs, but also the need for long initial training, since the chosen professional may have exactly the experience you need;</li>
						<li>Speed, simplicity, practicality, and effectiveness.</li>
					</ul>
				</div>
			</div>
		</li>
		<li>
			<div class="dv_pagina">
				<div class="dv_img"><img src="<?=URL::site("assets/img/home/duvidas_freq_BX.jpg")?>" /></div>
				<div class="dv_texto" id="duvidas">
					<h4>I am a teacher</h4>
					<div class="faq">
						<p class="perg">1) Do I have to pay anything to sign in and take the tests?</p>
						<p class="resp">No. The portal is totally free of charges for language teachers.</p>
					</div>
					<div class="faq">
						<p class="perg">2) I have no experience as a teacher. Can I register and take the tests anyway?</p>
						<p class="resp">
							Yes, you can. However, it is crucial that you tell nothing but the truth on the portal.
							Some schools even prefer teachers with no experience because they believe that in that case the method can be more easily incorporated.
							So, tell nothing but the truth. We also advise you to take all the tests, showing that you have linguistic and educational competence, even though you have no experience.
						</p>
					</div>
					<div class="faq">
						<p class="perg">3) Can I just take some of the tests?</p>
						<p class="resp">
							Yes, but we advise you to take all of them, because you are competing for job openings for schools or private students who do not have much time to select.
							Thus, if there are other candidates who have taken all the tests, it is likely that they will be prioritized in the selection process, as it is easier to evaluate them.
							It is free of charges, so spare some appropriate time for this action, as it will leverage your career.
						</p>
					</div>
					<div class="faq">
						<p class="perg">4) I do not know how to post a video on the internet.</p>
						<p class="resp">
							The team of ProfCerto developed a clear tutorial, so that you can upload your video easily. Should you have any questions, there are great tutorials on YouTube as well.
							You can also contact us by Skype: atendimentoprofcerto.
						</p>
					</div>
					<div class="faq">
						<p class="perg">5) I have taken a test, but I did not like the result and I do not want to post the diagnosis for schools / students to have access. What should I do?</p>
						<p class="resp">
							When taking the test, you will automatically receive the result. If you are not satisfied with it, click "do not show".
							Schools or private students will see a message stating that you prefer to be assessed in that modality by the contractors themselves, i.e., the portal will not expose a result you do not want to.
						</p>
					</div>
					<br />
				</div>
			</div>
		</li>
		<li>
			<div class="dv_pagina">
				<div class="dv_img"><img src="<?=URL::site("assets/img/home/fale_conosco_BX.jpg")?>" /></div>
				<div class="dv_texto">
					<div style="margin: 15px 0;">
						<p><?=I18n::get('faleconoscop1')?></p>
					</div>
					<div id="dv_contato">
						<form id="frm_contato" method="post">
							<? echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : ''); ?>
							<div class="row">
								<label><?=I18n::get('nome')?></label>
								<input type="text" name="nome" maxlength="200" />
							</div>
							<div class="<?=I18n::get('email')?>">
								<label>Email</label>
								<input type="text" name="email" maxlength="200" />
							</div>
							<div class="row">
								<label><?=I18n::get('message')?></label>
								<textarea name="message"></textarea>
							</div>
							<div class="dv-btn">
								<input type="hidden" name="enviar" value="Enviar" />
								<input type="button" id="btn_enviar" name="btn_enviar" value="<?=I18n::get('enviar')?>" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>