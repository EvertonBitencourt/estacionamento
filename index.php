<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<!-- Website Title & Description for Search Engine purposes -->
		<title>Everton Bitencourt</title>
		<meta name="description" content="">
		
		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="include/css/bootstrap-glyphicons.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap-datetimepicker.min.css">
		
		<!-- Custom CSS -->
		<link href="include/css/styles.css" rel="stylesheet">
		
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="include/js/modernizr-2.6.2.min.js"></script>
		
		
		
		
	</head>
	<body>

		<div class="container" id="main">
			<? require_once "menu.php" ?>	
			<div>
				<form role="form">
				  <div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email">
				  </div>
				  <div class="form-group">
					<label for="pwd">Senha:</label>
					<input type="password" class="form-control" id="pwd">
				  </div>
				  <div class="checkbox">
					<label><input type="checkbox"> Lembre-me</label>
				  </div>
				  <button type="submit" class="btn btn-default">Enviar</button>
				</form>
			</div>
		</div> <!-- end container -->
	
	<!-- All Javascript at the bottom of the page for faster page loading -->
		
	<!-- First try for the online version of jQuery-->
	<script src="http://code.jquery.com/jquery.js"></script>
	
	<!-- If no online access, fallback to our hardcoded version of jQuery -->
	<script>window.jQuery || document.write('<script src="includes/js/jquery-1.8.2.min.js"><\/script>')</script>
	
	<!-- Bootstrap JS -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Custom JS -->
	<script src="includes/js/script.js"></script>
	
	<script type="text/javascript"  src="bootstrap/js/bootstrap-datepicker.js">   </script>
    <script type="text/javascript"  src="bootstrap/js/bootstrap-datetimepicker.pt-BR.js"> </script
	<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
      $('#datetimepicker').datepicker({
        format: 'dd/MM/yyyy',
        language: 'pt-BR'
      });
    </script>
	
	<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#example1').datepicker({
                    format: "dd/mm/yyyy",
					language: 'pt-BR'
                });  
            
            });
        </script>
	
	</body>
</html>

