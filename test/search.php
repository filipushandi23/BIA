<?php
	include '../connection.php';
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container my-4">

			<div class="box">
				<input type="text" autocomplete="off" placeholder="Search" id="search-box" class="form-control"/><br>
				<input type="text" name="nama" id="tag-nama" class="form-control"><br>
				<input type="text" name="no_rek" id="tag-rekening" class="form-control"><br>
				<div class="result"></div>
			</div>
			
		</div>
		
    
	<script type="text/javascript">
	
	$(document).ready(function(){
		$('#search-box').on("keyup input", function(){
			/* Get input value on change */
			var inputVal = $(this).val();
			var resultDropdown = $(this).siblings(".result");
			if(inputVal.length){
				$.get("backend-search.php", {term: inputVal}).done(function(data){
					// Display the returned data in browser
					resultDropdown.html(data);
					
				});
			} else{
				resultDropdown.empty();
			}
		});
		
		
		// Set search input value on click of result item
		$(document).on("click", ".result p", function(){
			var myObject = JSON.parse($(".result p").text());
			$(this).parents(".box").find('#tag-nama').val(myObject.nama);
			$(this).parents(".box").find('#tag-rekening').val(myObject.no_rek);
			$(this).parent(".result").empty();
		});
	});

	</script>
	</body>
</html>