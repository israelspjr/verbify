<div class="content">
	<h2 class="h2_subtitle">Busca Avançada</h2>
	<form id="frm_busca" method="post">
		<fieldset>
			<legend>Filtros</legend>
			<div id="dv_local" class="newline">
				<div class="inline">
					<label>Estado</label>
					<select name="estado" class="ipt">
						<option value="">Indiferente</option>
						<?
						foreach($estados as $estado) {
							echo '<option value="'.$estado->vc_uf.'" '.(Arr::get($values, "estado") == $estado->vc_uf ? 'selected' : '').'>'.$estado->vc_estado.'</option>';
						}
						?>
					</select>
				</div>
				<div class="inline">
					<label>Cidade</label>
					<div id="dv_cidade" class="ipt"></div>
				</div>
				<div class="inline hide" id="regiao">
					<label>Região</label>
					<div id="dv_regiao" class="ipt"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div id="dv_idiomas" class="newline">
				<div class="inline">
					<label>Idiomas</label>
					<select name="idioma" class="ipt">
						<option value="">Indiferente</option>
						<?
						foreach($idiomas as $idioma) {
							echo '<option value="'.$idioma->id.'" '.(Arr::get($values, "idioma") == $idioma->id ? 'selected' : '').'>'.$idioma->descricao.'</option>';
						}
						?>
					</select>
				</div>
				<div class="inline">
					<label>Dia da Semana</label>
					<select name="semana" class="ipt">
						<option value="">Indiferente</option>
						<?
						foreach($semana as $key => $dia) {
							echo '<option value="'.$key.'" '.(Arr::get($values, "semana") == $key ? 'selected' : '').'>'.$dia.'</option>';
						}
						?>
					</select>
				</div>
				<div class="inline">
					<label>Intervalo</label>
					<select class="hora" name="horade">
						<option></option>
						<?
						for($i=6;$i<=21;$i++)
							echo '<option value="'.$i.'" '.(Arr::get($values, "horade") == $i ? 'selected' : '').'>'.$i.'h</option>';
						?>
					</select>
					às 
					<select class="hora" name="horaate">
						<option></option>
						<?
						for($i=7;$i<=22;$i++)
							echo '<option value="'.$i.'" '.(Arr::get($values, "horaate") == $i ? 'selected' : '').'>'.$i.'h</option>';
						?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="dv-btn newline">
				<input type="submit" name="buscar" value="buscar" />
			</div>
		</fieldset>
	</form>
	<div style="margin: 10px 0;">
		<?
		if(isset($count)){
			echo '<h3>'.($count ==1 ? '1 professor encontrado.' : "$count professores encontrados.").'</h3>';
		}?>
	</div>
</div>
<script>
	$(function(){
		$("select[name='estado']").change(function(){
			carregaCidade();
		});
		$("#frm_busca").delegate("select[name='cidade']", "change", function() {
			carregaRegiao($(this));
		});
		$("#frm_busca").delegate("select[name='cidade']", "load", function() {
			carregaRegiao($(this));
		});
		carregaCidade();
	});
	
	function carregaCidade(){
		$.post('<? echo URL::site("contratante/ajaxforms/cidadesbusca") ?>',
			{ 
				estado: $("select[name=estado]").val(),
				cidade: '<?=Arr::get($values, "cidade") ?>'
			},
			function(data) {
				$("#dv_cidade").html(data);
				carregaRegiao($("select[name=cidade]"));
			}
		);
		
	}
	
	function carregaRegiao(el) {
		if(el.val()=='7374'){
			$.post('<? echo URL::site("contratante/ajaxforms/regioesbusca") ?>',
				{  regiao: '<?=Arr::get($values, "regioes") ?>' },
				function(data) {
					$("#dv_regiao").html(data);
				}
			);
			$("#regiao").show();
		} else {
			$("#regiao").hide();
		}
	}
</script>
