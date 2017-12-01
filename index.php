<?php
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('lzrymjxrdqcmhe', //usuario
              'a0a6acc595e5c2591749b76679342e03b140dc8b81c1a6e757b5feba58b3e665',//senha
              'd8ji7jlpf7b7rq', //banco
              'ec2-50-16-204-127.compute-1.amazonaws.com'//servidor
);


extract($_POST); //transformando os dados em variáveis
$contador=0;
$flag = false;
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $temp = $db->query("SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'");
    foreach ($temp as $linha) {
        $contador++;
    }
    if (($contador)<=0){
         echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='index.php';</script>";
    }
    else{
        $flag = true;
        echo"<script language='javascript' type='text/javascript'>alert('Login realizado!');window.location.href='index.php';</script>";
    }
}
?>

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
			<?php include_once "menu.php"; ?>	
			<div>
				<form role="form" method="post">
				  <div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email"  name="email">
				  </div>
				  <div class="form-group">
					<label for="pwd">Senha:</label>
					<input type="password" class="form-control" id="pwd" name="senha">
				  </div>
				  <div class="checkbox">
					<label><input type="checkbox"> Lembre-me</label>
				  </div>
				  <button type="submit"  name="submit" class="btn btn-default">Enviar</button>
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>

