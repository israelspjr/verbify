<h2 class="h2_subtitle"><? echo __('buscar vagas')?></h2>
<form id="frm_busca" method="post" style="padding: 2px 0;">
	<fieldset>
		<legend>Filtros</legend>
		<div id="dv_local" class="newline">
			<div class="inline">
				<label>Estado</label>
				<select name="estado" class="ipt">
					<option value=""></option>
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

			<div id="dv_idiomas" class="inline">
				<div class="inline">
					<label>Idiomas</label>
					<select name="idioma" class="ipt">
						<option value=""></option>
						<?
						foreach($idiomas as $idioma) {
							echo '<option value="'.$idioma->id.'" '.(Arr::get($values, "idioma") == $idioma->id ? 'selected' : '').'>'.$idioma->descricao.'</option>';
						}
						?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<div class="dv_btn" style="margin: 10px 0;">
				<input type="submit" name="buscar" value="buscar" />
			</div>
		</fieldset>
	</form>

	<div style="margin: 10px 0;">
		<?
		if(isset($count)){
			echo '<h3>'.($count ==1 ? '1 vaga encontrada.' : "$count vagas encontradas.").'</h3>';
			if($count > 0){
				foreach($vagas as $row){
					echo '
					<div class="dv_vaga">
						<div class="dv_vaga_info">
							'.$row->getIntro().'
						</div>
						<div class="dv_btn">
							<input type="button" class="candidatar" value="tenho interesse" href="'.URL::site('candidato/ajaxcontent/candidatarse/'.$row->id).'" />
						</div>
					</div>';
					//Contratante: '.($row->exibir == 1 ? $row->contratante->getNome() : 'Confidencial').'<br />
				}
			}
		}
		?>
	</div>
</div>
<div class="clear"></div>
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

		$(".candidatar").fancybox({
			'width'				: '400px',
			'height'			: '0',
			'type'				: 'iframe',
			'titlePosition'	: 'inside'
		});
	});

	function carregaCidade(){
		$.post('<? echo URL::site("candidato/cadastroforms/cidades") ?>',
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
			$.post('<? echo URL::site("candidato/cadastroforms/regioesbusca") ?>',
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