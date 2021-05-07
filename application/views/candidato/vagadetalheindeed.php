<?php foreach($vagas as $vaga) { ?>
	<div style="margin: 10px 20px;">
		
		<div style="margin-top:20px;">
			<? echo $vaga->getIntro(); ?>
		</div>
		<div class="dv_btn" style="margin-top:20px;">
			<hr style="width: 60px;">
		</div>
	</div>
<?php } ?>