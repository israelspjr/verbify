<form method="post" id="frm_addquestion">
	<input type="hidden" name="questao_id" value="<?=$questao->id?>" />
	<div>
		<label>Questão</label><br />
		<textarea class="questao" name="questao"><?=$questao->enunciado?></textarea>
	</div>
	<div id="dv_form_respostas">
		<?=$respostas?>
	</div>
	<div>
		<input type="button" name="adicionar" value="adicionar respostas" onClick="addFormRespostaButton();">
	</div>
	<div>
		<input type="submit" name="salvar" value="salvar questão">
		<input type="submit" name="voltar" value="cancelar" onClick="window.open('<?=URL::site('admin/testes/editar/'.$questao->teste->id)?>', '_top')">
	</div>
</form>