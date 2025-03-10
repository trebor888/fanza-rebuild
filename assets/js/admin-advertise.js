jQuery(document).ready(function($){
	$('.hlp_advertise_setting input[type="radio"]').change(function(){
		var event_top = $(this).val();
		if(event_top == "No") {
			$(this).next('.advertis').slideUp();
		}else {
			$(this).parent('td').find('.advertis').slideDown();
		}
	});
});