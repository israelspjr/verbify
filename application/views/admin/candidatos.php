<script>

function veri(ids)

{

	var ids;

	if (ids == '')

	   {

  	    onload

		sit_teste.style.display = 'none';

		return(true);

	   }

	else

       {

  	    onload

		sit_teste.style.display = 'inline';

		return(true);



       }

	

}

</script>

<?php $sexo = Arr::get($values, "sexo");
//echo "<pre>";

$var = $_SESSION['adm_user'];
//var_dump($var);
$admin = $var->user;
$_SESSION['nomeAdmin'] = $admin;
//var_dump($_SESSION);
//echo "</pre>";
 ?>

<h2>Candidatos</h2>
<?php 

if ($admin != 'admin2') { ?>
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

				/*		if ($estado->vc_uf == "SP") {

						echo '<option selected="selected" value="'.$estado->vc_uf.'" '.(Arr::get($values, "estado") == $estado->vc_uf ? 'selected' : '').'>'.$estado->vc_estado.'</option>';

					

						} else {*/

						echo '<option value="'.$estado->vc_uf.'" '.(Arr::get($values, "estado") == $estado->vc_uf ? 'selected' : '').'>'.$estado->vc_estado.'</option>';

						//}

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

		</div>

		<div id="dv_nome" class="newline">

			<div class="inline" style="margin-top: 10px;">

				<label>Nome</label>

				<input type="text" name="nome" value="<?=Arr::get($values, "nome")?>" class="ipt"/>

			</div>



		<!--	<div class="inline" style="margin-top: 10px;">

				<label>Tipo Cadastro</label>

				<select name="conveniado" class="ipt">

					<option value="" <?=(Arr::get($values, "conveniado") == '' ? 'selected' : '')?>>Indiferente</option>

					<option value="0" <?=(Arr::get($values, "conveniado") == '0' ? 'selected' : '')?>>Portal</option>

					<option value="1" <?=(Arr::get($values, "conveniado") == '1' ? 'selected' : '')?>>Trabalhe Conosco</option>

				</select>

			</div>-->



			<div id="dv_idiomas" class="inline" style="margin-top: 10px;" >

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

			<div class="clear"></div>

		</div>



		<div class="newline">

        <div class="inline" style="margin-top: 10px;">

				<label>E-mail</label>

				<input type="text" name="email" value="<?=Arr::get($values, "email")?>" class="ipt"/>

			</div>

			<div style="margin-top: 10px;" class="inline">

				<label>Situação dos Testes</label>

				<select name="testesrealizados" class="ipt">

					<option value="2" <?=(Arr::get($values, "testesrealizados") == '2' ? 'selected' : '')?>>Indiferente</option>

					<option value="0" <?=(Arr::get($values, "testesrealizados") == '0' ? 'selected' : '')?>>Pendentes</option>

					<option value="1" <?=(Arr::get($values, "testesrealizados") == '1' ? 'selected' : '')?>>Realizados</option>

				</select>

                

			</div>

            <div class="inline" style="margin-top: 10px;">

                <label>Nacionalidade</label>

                <select name="nacionalidade" class="ipt">

						<option value="">Indiferente</option>

                        <?

						foreach($pais as $valor) {

//							if ($nacionalidade == $pais

							echo '<option value="'.$valor->id.'" '.(Arr::get($values, "nacionalidade") == $valor->id ? 'selected' : '').'>'.$valor->name.'</option>';

						}

						?>

					</select>

                </div>

		</div>



	    <div class="clear" style="height: 3px;"></div>



		<div class="newline">

			<div class="inline" style="margin-top: 10px;">

				<label>Situação</label>

				<div style="margin: 5px 0 20px;" >

					<label style="display: inline; padding-right: 20px;"><input type="radio" name="active" value="1" <? echo ($active<>0 ? "checked" : "")?>> Ativos</label>

					<label style="display: inline;"><input type="radio" name="active" value="0" <? echo ($active==0 ? "checked" : "")?>> Inativos</label>

				</div>

               

			</div>

             <div class="inline" style="margin-top: 10px;">

                Sexo

                <div style="margin: 5px 0 20px;" >

					<label style="display: inline; padding-right: 10px;"><input type="radio" name="sexo" value="F" <? echo ($sexo=="F" ? "checked" : "")?>> Feminino</label>

					<label style="display: inline; padding-right: 10px;"><input type="radio" name="sexo" value="M" <? echo ($sexo=="M" ? "checked" : "")?>> Masculino</label>

                    <label style="display: inline;"><input type="radio" name="sexo" value="" <? echo ($sexo=='' ? "checked" : "")?>> Ambos</label>

				</div>

                </div>

		</div>



		<div class="dv-btn newline">

			<input type="submit" name="buscar" value="buscar" /> <input type="button" name="Excel" value="Baixar no formato Excel" onclick="generateexcel('dv_table_candidatos');"/>

		</div>



	</fieldset>

	<div class="clear" style="height: 3px;"></div>

</form>

<br />

<?

}

if($pagination->total_rows == 0){

	echo '<p class="p_warning">Nenhum registro encontrado</p>';

} else {

	echo '<p>'.$pagination->total_rows.' candidatos encontrados</p>

	<div id="dv_table_candidatos">'.$table.'</div>

	<div class="dv_paginacao">'.$pagination->renderFullNav().'</div>';

}

?>

<script>

window.onload = function () {
    if (! localStorage.justOnce) {
        localStorage.setItem("justOnce", "true");
        window.location.reload();
    }
}



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

		var C = $("select[name=estado]").val();

		if (C == '') {

			C = "SP";

		} 

		

		$.post('<? echo URL::site("contratante/ajaxforms/cidadesbusca") ?>',

			{

				estado: C,

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



    function generateexcel(tableid) {

  	var table= document.getElementById(tableid);

  	var html = table.outerHTML;

	window.open('data:application/vnd.ms-excel,' + escape(html));

}



</script>

