<h2 class="curnome">
	<? echo $contrat->getNome() ?>
	<div style="float: right; margin-top: -5px;">
		<input type="button" value="Editar" onClick="window.open('<? echo URL::site("admin/cadastrocontratante/index/".$contrat->id)?>', '_top')" />
	</div>
</h2>
<table id="contrat_dados">
	<tr>
		<th>Email:</th>
		<td><?=$contrat->email?></td>
	</tr>
	<tr>
		<th>Senha:</th>
		<td><?=$contrat->senhatxt?></td>
	</tr>
	<tr>
		<th>Tipo de Pessoa:</th>
		<td><?=$contrat->tppessoa?></td>
	</tr>
	<?
	if($contrat->tppessoa == "PF")
	{
		echo '
		<tr>
			<th>Nome Completo: </th>
			<td>'.$contrat->contratantepf->nome.'</td>
		</tr>
		<tr>
			<th>CPF:</th>
			<td>'.Helper::format_cpf($contrat->contratantepf->cpf).'</td>
		</tr>
		<tr>
			<th>Telefone:</th>
			<td>'.$contrat->contratantepf->tel.'</td>
		</tr>
		';
	} else {
		echo '
		<tr>
			<th>Razão Social:</th>
			<td>'.$contrat->contratantepj->razao.'</td>
		</tr>
		<tr>
			<th>Nome Fantasia:</th>
			<td>'.$contrat->contratantepj->nomefantasia.'</td>
		</tr>
		<tr>
			<th>É Franquia:</th>
			<td>'.($contrat->contratantepj->franquia == 0 ? 'Não' : $contrat->contratantepj->franquia_descr).'</td>
		</tr>
		<tr>
			<th>CNPJ:</th>
			<td>'.Helper::format_cnpj($contrat->contratantepj->cnpj).'</td>
		</tr>
		<tr>
			<th>Nome do Contato:</th>
			<td>'.$contrat->contratantepj->c_nome.'</td>
		</tr>
		<tr>
			<th>Telefone:</th>
			<td>'.$contrat->contratantepj->c_tel.'</td>
		</tr>
		<tr>
			<th>Cargo do Contato:</th>
			<td>'.$contrat->contratantepj->c_cargo.'</td>
		</tr>
		';
	}
	?>
	<tr>
		<th>Endereço:</th>
		<td>
			<?=$contrat->endereco.', '.$contrat->numero.' '.$contrat->compl.'<br />'.
			$contrat->bairro.'<br />'.$contrat->cidade->vc_cidade.' - '.$contrat->estado->vc_uf.'<br />'.
			$contrat->cep ?>
		</td>
	</tr>
	<? if($contrat->conveniado) { ?>
		<tr>
			<th>Link:</th>
			<td><?=$contrat->getLinkConveniado()?></td>
		</tr>
	<? } ?>
</table>
<div class="dv_btn" style="margin: 20px 0 0;">
	<?
	if(!$contrat->conveniado)
		echo '<input type="button" onClick="window.open(\''.URL::site("admin/contratantes/conveniar/".$contrat->id).'\', \'_top\');" value="marcar como conveniado" />';
	else
		echo '<input type="button" onClick="window.open(\''.URL::site("admin/contratantes/desconveniar/".$contrat->id).'\', \'_top\');" value="marcar como não conveniado" />';
	?>
	<input type="button" onClick="window.open('<?=URL::site("admin/contratantes")?>', '_top');" value="voltar" />
</div>