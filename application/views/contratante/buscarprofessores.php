<h2 class="h2_subtitle">Buscar Professores - Portal</h2>
<form id="frm_busca_red" method="get">
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
			
			<div id="dv_idiomas" class="inline">
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
				<div class="clear"></div>
			</div>
			<div class="inline">
				<label>Tipo Cadastro</label>
				<select name="conveniado" class="ipt">
					<option value="" <?=(Arr::get($values, "conveniado") == '' ? 'selected' : '')?>>Indiferente</option>
					<option value="0" <?=(Arr::get($values, "conveniado") == '0' ? 'selected' : '')?>>Portal</option>
					<option value="1" <?=(Arr::get($values, "conveniado") == '1' ? 'selected' : '')?>>Trabalhe Conosco</option>
				</select>
			</div>			
			<div class="clear"></div>
		</div>
		<div class="dv-btn newline">
			<input type="submit" name="buscar" value="buscar" />
		</div>
	</fieldset>
	<div class="clear" style="height: 3px;"></div>
</form>
<div style="margin: 10px 0;">
	<?
	if(isset($pagination)){
		echo '<h3>'.($pagination->total_rows ==1 ? '1 professor encontrado.' : "$pagination->total_rows professores encontrados.").'</h3>';
		if($pagination->total_rows > 0){
			$trs = array();
			foreach($cands as $row){
				$cand = ORM::factory('candidato', $row->id);
				$idiomas = ucwords(implode("<br /> ", $cand->getArrayIdiomas()));
				$trs[] = '
				<tr onClick="window.open(\''.URL::site('contratante/curriculo/geral/'.$row->id).'\', \'_top\')" class="tr_lista_prof">
					<td>'.($cand->conveniado_id == $user->id ? $cand->nome : $row->codigo).'</td>
					<td>'.$idiomas.'</td>
					<td>'.$row->testes.'</td>
					<td>'.$cand->getLocalidade().'</td>
					<td class="center">'.($cand->conveniado_id == $user->id ? 'Trabalhe conosco' : 'Portal').'</td>
				</tr>';
			}
			echo '<table id="tb_candidatos">
				<tr>
					<th>Professor</th>
					<th>Idiomas</th>
					<th>Testes Realizados</th>
					<th>Região</th>
					<th class="th_link">Tipo Cadastro</th>
				</tr>
				'.implode('', $trs).'
			</table>';
		}
	}
	echo '<div class="dv_paginacao">'.(isset($pagination) ? $pagination->renderFullNav() : '').'</div>';
	?>
</div>
<script>
	$(function(){
		$("select[name='estado']").change(function(){
			carregaCidade();
		});
		$("#frm_busca_red").delegate("select[name='cidade']", "change", function() {
			carregaRegiao($(this));
		});
		$("#frm_busca_red").delegate("select[name='cidade']", "load", function() {
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