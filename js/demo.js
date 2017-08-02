$(document).ready(function() {
	$('#menulink').load('includes/menu.html');	
	//** Start code for collapse and expand answers **//
	$(document).on('click', 'span.results--see-more', function () {		
		var id = this.id;	 
		if($('div.results--more-info_'+id).css('display') == 'block'){
			$('div.results--more-info_'+id).css("display", "none");	
		}
		else{	
			$('div.results--more-info_'+id).css("display", "block");	
		}	
	});
	//** End code for collapse and expand answers **//
	
	//** Start ajax code for post question and getting answers **//
	
		$( "#questionform" ).submit(function( event ) {

				event.preventDefault();			
	 var question = $("#question").val();
		if(question != ''){		
			$.ajax({
				type: 'POST',
				url: 'includes/getanswers.php',
				data: { question:question },
				dataType: "html",  
				beforeSend:function(){
					$('#loading').show();				
				},
				success:function(data){
					$('.output').css("display", "block");		
				// successful request; do something with the data
					if (data != '')	{
						$('.service--results').load('includes/service.txt');
						//$('.standard--results').load('includes/standard.txt');						
					}
					else {
						alert("No data to display");
						$('.output').css("display", "none");		
					}
				},
				complete: function(){
					$('#loading').hide();
				},
				error : errorHandler
			});		
		}
		else {
			alert("Enter your question." );
			return false;
		}
	});
	function errorHandler(jqXHR, exception) {
    if (jqXHR.status === 0) {
        alert('Not connect.\n Verify Network.');
    } else if (jqXHR.status == 404) {
        alert('Requested page not found. [404]');
    } else if (jqXHR.status == 500) {
        alert('Internal Server Error [500].');
    } else if (exception === 'parsererror') {
        alert('Requested JSON parse failed.');
    } else if (exception === 'timeout') {
        alert('Time out error.');
    } else if (exception === 'abort') {
        alert('Ajax request aborted.');
    } else {
        alert('Uncaught Error.\n' + jqXHR.responseText);
    }
}
		//** End ajax code for post question and getting answers **//
		
		//** Start code to get random question **//
		
		$("#getrandom").click(function() {		
			$.ajax({
				type: 'GET',
				url: 'includes/getanswers.php',
				data: { action:'random' },
				
				success:function(data){				
				// successful request; do something with the data
					if (data != '')	{
						$('#question').val(data);
					}
					else {
						alert("No data");
					}
				},				
				error:function(){		
			}
			});		
		
	});
	//** End code for getting randon question **//
		
});
 function ESCclose(evt) {
  if (evt.keyCode == 27) 
		document.getElementById('light').style.display='none';
		document.getElementById('fade').style.display='none';
		document.getElementById('lightone').style.display='none';
		document.getElementById('fadeone').style.display='none';
		document.getElementById('lighttwo').style.display='none';
		document.getElementById('fadetwo').style.display='none';
 }