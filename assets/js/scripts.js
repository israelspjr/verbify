$(function() {
  $("textarea[maxlength]").keypress(function(event){
      var key = event.which;

      //todas as teclas incluindo enter
      if(key >= 33 || key == 13) {
          var maxLength = $(this).attr("maxlength");
          var length = this.value.length;
          if(length >= maxLength) {
              event.preventDefault();
          }
      }
  });
});

function mostra_item(item_id){
	jQuery('.hide2').hide();
	jQuery('#'+item_id).show();
	$.colorbox.resize();
}