<div class="container navbar navbar-default">
	<p class="text-center" style="margin-top:10px">copy &copy; by fakhrul945@gmail.com</p>
</div>
<script>
	jQuery(document).ready(function(){
		$( "#birth_date" ).datepicker({
			dateFormat : "yy/mm/dd",
			changeMonth: true,
			changeYear: true
		});
	});

	$('#birth_date').change(function(){
	    $(this).attr('value', $('#birth_date').val());
	});



</script>
<script>
	function submit(){
		var data = jQuery('#registration_form').serialize();
		jQuery.ajax({
			data : data,
			method : 'POST',
			url : 'parser/registration_parser.php',
			success: function(data){
				if(data != 'passed'){
					jQuery('#registraion_error').html(data);
				}else{
					location.reload();
				}
				
			},
			error : function(){alert('Something went to wrong.')}
		});
	}
</script>
</body>
</html>