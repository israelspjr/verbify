<h2 class="h2_subtitle">Trabalhe Conosco</h2>
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