<div class="curriculo mini">
	<h2><?=$candidato->nome?></h2>
	<div>
		<label class="lbldados">Email:</label>
		<?=($candidato->email)?>
	</div>
	<? if($candidato->email2 <> ""){ ?>
		<div>
			<label class="lbldados">Email alternativo:</label>
			<?=($candidato->email2)?>
		</div>
	<? } ?>
	<? if($candidato->tel1 <> ""){ ?>
		<div>
			<label class="lbldados">Telefone(1):</label>
			<?=$candidato->tel1?>
		</div>
	<? } ?>
	<? if($candidato->tel2 <> ""){ ?>
		<div>
			<label class="lbldados">Telefone(2):</label>
			<?=$candidato->tel2?>
		</div>
	<? } ?>
	<? if($candidato->skype <> ""){ ?>
		<div>
			<label class="lbldados">Skype:</label>
			<?=($candidato->skype)?>
		</div>
	<? } ?>
	<? if($candidato->outrosim <> ""){ ?>
		<div>
			<label class="lbldados">Outros IM:</label>
			<?=($candidato->outrosim)?>
		</div>
	<? } ?>
	<? if($candidato->blog <> ""){ ?>
		<div>
			<label class="lbldados">Blog:</label>
			<?=($candidato->blog)?>
		</div>
	<? } ?>
	<? if($candidato->facebook <> ""){ ?>
		<div>
			<label class="lbldados">Facebook:</label>
			<?=($candidato->facebook)?>
		</div>
	<? } ?>
	<? if($candidato->outrars <> ""){ ?>
		<div>
			<label class="lbldados">Outra Rede Social:</label>
			<?=($candidato->outrars)?>
		</div>
	<? } ?>
	<?
	$endereco = $candidato->getEndereco();
	if($endereco <> ""){ ?>
		<div>
			<label class="lbldados">Endereço Residencial:</label>
			<div style="float: left;"><?=($endereco)?></div>
			<div class="clear"></div>
		</div>
	<? } ?>
</div>
