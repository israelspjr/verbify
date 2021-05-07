<h2 class="h2_curtitle"><? echo __('Disponibilidade'); ?></h2>

<? echo (isset($success) ? '<p class="p_success">'.$success.'</p>' : ''); ?>

<? echo (isset($errors) ? '<p class="p_error">Verifique os erros de preenchimento.</p>' : ''); ?>

<form id="frm-cadastro-talento" method="post">

	<fieldset>

		<legend><? echo __('Você gostaria de lecionar nas seguintes Modalidades: '); ?></legend>

		<ul>

			<li>

				<label class="lbl-check">

					<input type="checkbox" name="tipo" value="ambos" <?=(($localidade->tipo_disponibilidade == "ambos" || $localidade->tipo_disponibilidade == "") ? "checked" : "") ?> /><span><? echo __('Aulas Online Ao Vivo (ex: Zoom)'); ?></span>

				</label><br>

				<label class="lbl-check" style="    float: none;
    width: 500px;">

					<input type="checkbox" name="tipo" value="ead" <?=($localidade->tipo_disponibilidade == "ead" ? "checked" : "") ?>/><span><? echo __('Aulas Presenciais na escola, empresas, condomínios, residências etc'); ?>*</span><br>

				</label>

			<label class="lbl-check" style="    float: none;
    width: 500px;">

					<input type="checkbox" name="tipo" value="presencial" <?=($localidade->tipo_disponibilidade == "presencial" ? "checked" : "") ?>/><span><? echo __('Tutorias assíncronas em Ambientes Virtuais de Aprendizagem'); ?></span><br>

				</label>

			</li>

			<li>
<legend><? echo __('Com relação a Aulas Presenciais, você gostaria de lecionar: '); ?></legend>
				<label class="lbl-check">

					<input type="radio" name="pais" checked value="brasil" <?=(($localidade->pais == "brasil" || $localidade->pais == "") ? "checked" : "") ?> /><span><? echo __('Brasil'); ?></span>

				</label>

				<label>

					<input type="radio" name="pais" value="outro" <?=((($localidade->pais <>"" && $localidade->pais <> "brasil") or Arr::get($values, 'pais') == "outro") ? "checked" : "") ?> /><span><? echo __('Outro país'); ?>. <? echo __('Qual'); ?>?</span>

				</label>

				<input type="text" name="outropais" value="<?=(($localidade->pais =="" && $localidade->pais <> "brasil") ? $localidade->pais : "") ?>"/>

				<label class="error"><?=Arr::get($errors, 'pais')?></label>

			</li>

		</ul>

		<div id="dv_brasil">

			<ul>

				<li>

					<label for="nome" class="lbl-left"><? echo __('Estado'); ?> <span class="obl">*</span></label>

					<select name="estado" class="ipt">

						<option value="0"></option>

						<?

						foreach($estados as $estado) {

							echo '<option value="'.$estado->vc_uf.'" '.($localidade->estado_id == $estado->vc_uf ? 'selected' : '').'>'.$estado->vc_estado.'</option>';

						}

						?>

					</select>

					<label class="error"><?=Arr::get($errors, 'estado_id')?></label>

				</li>

				<li>

					<label for="nome" class="lbl-left"><? echo __('Cidade'); ?> <span class="obl">*</span></label>

					<div id="dv_cidade" class="ipt"></div>

					<label class="error"><?=Arr::get($errors, 'cidade_id')?></label>

				</li>

				<li id="li_regiao">

					<label for="nome" class="lbl-left"><? echo __('Região'); ?> <span class="obl">*</span></label>

					<div id="dv_regiao"></div>

					<label class="error"><?=Arr::get($errors, 'regiao_id')?></label>

				</li>

			</ul>

		</div>

	</fieldset>

<!--	<fieldset>

		<legend><? echo __('Escreva sobre você'); ?></legend>

		<textarea name="sobremim" maxlength="1000" class="sobremim"><?=$localidade->sobremim?></textarea>

	</fieldset>-->

	<div>

		<input type="submit" name="salvar" value="<? echo __('salvar'); ?>" />

	</div>

</form>



<script>

	$(function(){

		$("#tb_disponibilidade .item").click(function(){

			var status = $(this).children(".status").val();

			if(status == 0) {

				$(this).children(".status").val(1);

				$(this).removeClass('livre').addClass('ocupado');

				$(this).children(".span_cidade").html('');

				$("#edit-td").val($(this).attr("id"));

				$.fancybox({

					'href': '#form_marcar'

				});

			} else {

				$(this).children(".status").val(0);

				$(this).children(".span_cidade").html('LIVRE');

				$(this).removeClass('ocupado').addClass('livre');

			}

		});

		$("input[name='m_cidade']").click(function(){

			changeLabel();

		});



		$("input[name='marcar']").click(function(){

			var local = $("input[name='m_local']").val().trim();

			var tdid = $("#edit-td").val();

			$("#"+tdid+" .span_cidade").html(local);

			$("#"+tdid+ " .local").val(local);

			$.fancybox.close();

		});



		$("input[name='pais']").click(function(){

			showBrasil();

		});



		$("select[name='estado']").change(function(){

			carregaCidade();

		});



		$("#dv_brasil").delegate("select[name='cidade']", "change", function() {

			carregaRegiao($(this));

		});



		$("#dv_brasil").delegate("select[name='cidade']", "load", function() {

			carregaRegiao($(this));

		});



		changeLabel();

		showBrasil();

		carregaCidade();

	});



	function changeLabel(){

		var val = $("input[name='m_cidade']:checked").val();

		if(val == "sp"){

			$("label[for='local']").html('Bairro');

		} else {

			$("label[for='local']").html('Qual');

		}

		$("input[name='m_local']").val('');

	}



	function showBrasil(){

		var val = $("input[name='pais']:checked").val();

		if(val == "brasil"){

			$("#dv_brasil").show();

		} else {

			$("#dv_brasil").hide();

		}

	}



	function carregaCidade(){

		$.post('<? echo URL::site("candidato/cadastroforms/cidades") ?>',

			{

				estado: $("select[name=estado]").val(),

				cidade: '<?=$localidade->cidade_id?>'

			},

			function(data) {

				$("#dv_cidade").html(data);

				carregaRegiao($("select[name=cidade]"));

			}

		);



	}



	function carregaRegiao(el) {

		if(el.val()=='7374'){

			$.post('<? echo URL::site("candidato/cadastroforms/regioes") ?>',

				{  'regioes[]': ["<?=implode('","', $regioes)?>"] },

				function(data) {

					$("#dv_regiao").html(data);

				}

			);

			$("#li_regiao").show();

		} else {

			$("#li_regiao").hide();

		}

	}

</script>