<div id="dv_regiao_checks">
	<label><input type="checkbox" name="_discart" value="" id="all" /> Todas </label>
	<?=implode("", $chks)?>
</div>
<script type="text/javascript">
$(function() {
	$("#all").click(function() {
		$("input[name='regioes[]']").attr("checked", this.checked);
	});

	$("input[name='regioes[]']").click(function() {
		checkTodos();
	});
	checkTodos();
});

function checkTodos(){
	var total_checkbox     = $("input[name='regioes[]']").length;
	var total_selecionados = $("input[name='regioes[]']:checked").length;
	$("#all").attr("checked", total_checkbox == total_selecionados ? true : false);
}
</script>
