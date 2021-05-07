<h2><?=$teste->nome?></h2>
<p class="p_descricao"><?=$teste->descricao?></p>
<div id="dv_frm">
	<form method="post" id="frm_addquestion">
		<fieldset id="fs_addquestion">
			<legend>Adicionar questão</legend>
			<div>
				<label>Tipo</label><br />
				<select name="tipo" id="tipo">
					<option value="1">certo/errado</option>
					<option value="2">perfil</option>
					<option value="3">escolhas</option>
					<option value="4">grade</option>
					<option value="5">dissertativa</option>
					<option value="6">concordo/discordo</option>
				</select>
			</div>
			<div>
				<label>Enunciado</label><br />
				<textarea class="questao" name="questao"></textarea>
			</div>
			<div id="dv_form_respostas">
			</div>
			<div>
				<input type="button" name="adicionar" value="adicionar resposta" onClick="addFormRespostaButton();">
			</div>
		</fieldset>
		<div class="dv_btn">
			<input type="submit" name="salvar" value="salvar">
			<input type="button" name="voltar" value="voltar" onClick="window.open('<?=URL::site('admin/testes/editar/'.$teste->id)?>', '_top')">
		</div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	i = $("#dv_form_respostas").children().size();
	if(i == 0){
		addFormRespostaButton();
	}
});

$("#tipo").change(function(){
	$("#dv_form_respostas").empty();
	addFormRespostaButton();
});

function addFormRespostaButton(){
	i = $("#dv_form_respostas").children().size()+1;
	$.post('<? echo URL::site("admin/cadastroforms/respostas") ?>',
		{ posicao: i, tipo: $("#tipo").val() },
		function(data) {
			$("#dv_form_respostas").append(data);
		}
	);
}
</script>
<?
/*	
function editar(id){
	$.post('<? echo URL::site("admin/cadastroforms/editquestao") ?>',
		{ id: id },
		function(data) {
			$("#dv_frm").html(data);
		}
	);
}

function excluir(id){
	$.post('<? echo URL::site("admin/cadastroforms/deletequestao") ?>',
		{ id: id },
		function(data) {
			carregaQuestoes();
		}
	);
}
*/?>
