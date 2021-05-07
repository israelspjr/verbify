<div class="content" style="margin-top: 30px;">
<!--	<div class="dv_quadrado_invisivel" style="background: #EE4237"></div>
	<h2 class="h2_title txt-vermelho">cadastro</h2>
	<div class="clear"></div>
	-->
	<form id="frm-cadastro-contratante" method="post" style="padding-bottom: 5px;">
		<? echo (isset($erro) ? '<p class="p_error">'.$erro.'</p>' : ''); ?>
		<fieldset>
			<legend>Dados de Contato</legend>
			<ul>
				<li>
					<label for="empresa" class="lbl-left">Empresa <span class="obl">*</span></label>
					<input id="empresa" type="text" name="empresa" class="ipt " value="<?=Arr::get($values, "empresa")?>" maxlength="100">
					<label for="empresa" class="error"><?=(Arr::get($error,"empresa"))?></label>
				</li>
				<li>
					<label for="nome" class="lbl-left">Nome <span class="obl">*</span></label>
					<input id="nome" type="text" name="nome" class="ipt " value="<?=Arr::get($values, "nome")?>" maxlength="100">
					<label for="nome" class="error"><?=(Arr::get($error,"nome"))?></label>
				</li>
				<li>
					<label for="telefone" class="lbl-left">Telefone <span class="obl">*</span></label>
					<input id="telefone" type="text" name="telefone" class="ipt" id="telefone" value="<?=Arr::get($values, "telefone")?>" maxlength="100">
					<label for="telefone" class="error"><?=(Arr::get($error,"telefone"))?></label>
				</li>
				<li>
					<label for="email" class="lbl-left">Email <span class="obl">*</span></label>
					<input id="email" type="text" name="email" class="ipt " value="<?=Arr::get($values, "email")?>" maxlength="100">
					<label for="email" class="error"><?=(Arr::get($error,"email"))?></label>
				</li>
			</ul>
		</fieldset>
		<div class="dv_btn" style="margin: 20px 10px 10px;">
			<input type="submit" name="cadastrar" value="cadastrar"/>
			<input type="button" name="voltar" value="voltar" onClick="window.open('<?=URL::site()?>', '_top')" />
		</div>
	</form>
</div>
<script>
$('#telefone')
    .mask("(99) 9999-9999?9")  
        .live('focusout', function (event) {  
            var target, phone, element;  
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
            phone = target.value.replace(/\D/g, '');  
            element = $(target);  
            element.unmask();  
            if(phone.length > 10) {  
                element.mask("(99) 99999-999?9");  
            } else {  
                element.mask("(99) 9999-9999?9");  
            }  
        });
</script>