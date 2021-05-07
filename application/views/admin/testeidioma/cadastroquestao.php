<h2><?=$teste->nome?></h2>
<p class="p_descricao"><?=$teste->descricao?></p>
<div id="dv_frm">
	<form method="post" id="frm_addquestion">
		<fieldset id="fs_addquestion">
			<legend>Adicionar questão</legend>
			<div style="display: inline-block;">
				<label>Tipo</label><br />
				<select name="tipo" id="tipo">
					<?
					$arrtipo = FormTestes::getArrayTipoQuestao();
					foreach($arrtipo as $key => $value)
						echo '<option value="'.$key.'">'.$value.'</option>';
					?>
				</select>
			</div>
			<div style="display: inline-block;">
				<label>Tempo (s)</label><br />
				<input type="text" name="max_tempo" value="30" />
			</div>
			<div class="max_check" style="display: none;">
				<span>Nº de respostas: </span><br />
				<input type="text" class="max_check" name="max_check" style="width: 25px; text-align: right;" />
			</div>
			<div>
				<label>Tópico</label><br />
				<input name="topico" maxlength="300" class="iptresposta" value="" />
				<span class="error"><?=Arr::get($errors, "topico")?></span>
			</div>
			<div>
				<label>Enunciado</label><br />
				<textarea class="questao" name="questao"></textarea>
				<span class="error"><?=Arr::get($errors, "enunciado")?></span>
			</div>
			<div id="dv_form_respostas">
			</div>
			<div class="clear"></div>
			<div>
				<input type="button" name="adicionar" id="add_resposta" value="adicionar resposta" onClick="addFormRespostaButton();">
			</div>
		</fieldset>
		<div class="dv_btn">
			<input type="submit" name="salvar" value="salvar">
			<input type="button" name="voltar" value="voltar" onClick="window.open('<?=URL::site('admin/testesidiomas/editar/'.$teste->id)?>', '_top')">
		</div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	i = $("#dv_form_respostas").children().size();
	if(i == 0){
		addFormRespostaButton();
	}
  if($('#tipo').val() == 4) {
    $('#add_resposta').hide();
  } else {
    $('#add_resposta').show();
    if($("#tipo").val() == 3) {
      $('.max_check').show();
    } else {
      $('.max_check').hide();
    }
  }
});

$("#tipo").change(function(){
  if($(this).val() == 3) {
	$('.max_check span').html('Nº máximo de respostas: ');
    $('#add_resposta, .max_check').show();
  } else if($(this).val() == 4) {
    $('#add_resposta, .max_check').hide();
  } else if($(this).val() == 5) {
	$('.max_check span').html('Nº de respostas: ');
    $('.max_check').show();
    $('#add_resposta').hide();
  } else if($(this).val() == 6) {
    $('#add_resposta, .max_check').hide();
  } else {
    $('#add_resposta').show();
    $('.max_check').hide();
  }
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