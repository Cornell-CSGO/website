$(function(){
	
	function chevron_toggle(){
		$('#once-fold').find("svg,i").toggleClass('fa-chevron-left').toggleClass('fa-chevron-down');
	}
	
	$('#once-fold').click(chevron_toggle);
	$('#genqh2').click(function() {
		$('#ops-collapse').collapse('toggle');
		$('#qualified-slider').slider('refresh');
		chevron_toggle();
	})
	
	
	let sir = $('#saved_irel').text();
	$('select[name=irelation] option[value='+sir+']').attr('selected','selected');
	

 
// 	/* $("#ex13").slider({
// 	    ticks: [0, 100, 200, 300, 400],
// 	     ticks_labels: ['$0', '$100', '$200', '$300', '$400'],
// 	     ticks_snap_bounds: 30
// 	}); */
});
