// contador(30); segundos
function contador(segundos){
	contador1 = setTimeout('postar()', segundos*1000);
	atualiza(segundos);
}
function atualiza(segundos){
	if(segundos>0){
		$("#ipt-tempo").val(segundos);
		formatar(segundos);
		segundos = segundos-1;
		contador2 = setTimeout('atualiza(\''+segundos+'\')', 1000);
	}
}
function postar(){
	$("#tempoesgotado").val("1");
	alert("Tempo esgotado!");
	$("#btn_gravar").click();
}

function formatar(s) {
	var Seconds = s;
        
	var Days = Math.floor(Seconds / 86400);
	Seconds -= Days * 86400;

	var Hours = Math.floor(Seconds / 3600);
	Seconds -= Hours * (3600);

	var Minutes = Math.floor(Seconds / 60);
	Seconds -= Minutes * (60);

	var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds)
    $("#tempo").html(TimeStr);
}
function LeadingZero(Time) {
	return (Time < 10) ? "0" + Time : + Time;
}