<?php
require 'db/DB.class.php';
//inicia a conexão
$db = new DB( 'lzrymjxrdqcmhe', //usuario
              'a0a6acc595e5c2591749b76679342e03b140dc8b81c1a6e757b5feba58b3e665',//senha
              'd8ji7jlpf7b7rq', //banco
              'ec2-50-16-204-127.compute-1.amazonaws.com'//servidor
            );

extract($_REQUEST);//transformando os dados enviados em variaveis


$acao = (isset($_REQUEST['acao'] )) ? $_REQUEST['acao']  : '';

//$nome_pais = (isset($_REQUEST['nome_pais'] )) ? $_REQUEST['nome_pais']  : '';

if(isset($id_registro) && isset($horario_pagamento) && isset($total_pagamento) && isset($id_forma_pagamento)){  
	if($acao != 'atualizarFim') {
		$horario_pagamento = date('Y-m-d H:i:s', time());
		
		$dados[0] = $id_registro;
		$dados[1] = $horario_pagamento;
		$dados[2] = $total_pagamento;
		$dados[3] = $id_forma_pagamento;
		$db->execute("INSERT INTO cobranca_avulsa (id_registro,horario_pagamento,total_pagamento,id_forma_pagamento) VALUES (?,?,?,?)", $dados);	
	}
  
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM cobranca_avulsa WHERE id_cobranca=?",$dados2);
}
$dadosTemp['id_cobranca'] = '';
$dadosTemp['id_registro'] = '';
$dadosTemp['horario_pagamento'] = '';
$dadosTemp['total_pagamento'] = '';
$dadosTemp['id_forma_pagamento'] = '';
$dadosTemp['nome_forma_pagamento'] ='';

if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $id_registro;
  $dados[1] = $horario_pagamento;
  $dados[2] = $total_pagamento;
  $dados[3] = $id_forma_pagamento;
  $dados[4] = $id;
  
  
  $db->execute("UPDATE contrato SET id_registro=?, horario_pagamento=?, total_pagamento=?, id_forma_pagamento=? WHERE id_cobranca=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT ca.id_registro, ca.horario_pagamento, ca.total_pagamento, ca.id_forma_pagamento, ca.id_cobranca FROM cobranca_avulsa ca
																INNER JOIN acesso a ON a.id_registro=ca.id_registro
																INNER JOIN forma_pagamento fp ON fp.id_forma_pagamento=ca.id_forma_pagamento
																	WHERE id_cobranca = $id
																	GROUP BY ca.id_registro, ca.horario_pagamento, ca.total_pagamento, ca.id_forma_pagamento, ca.id_cobranca, fp.nome_forma_pagamento
																	ORDER BY ca.id_cobranca");
					
  foreach ($consulta as $linha) {
    $dadosTemp = $linha;
  }
  $acao = 'atualizarFim';
}

?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<!-- Website Title & Description for Search Engine purposes -->
		<title>Cassiano Doneda</title>
		<meta name="description" content="">
		
		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="includes/css/bootstrap-glyphicons.css" rel="stylesheet">
		
		<!-- Custom CSS -->
		<link href="includes/css/styles.css" rel="stylesheet">
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
		
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="includes/js/modernizr-2.6.2.min.js"></script>
		<script language="javascript" type="text/javascript">

		

		function showtime(){	
			setTimeout("showtime();",1000);
			callerdate.setTime(callerdate.getTime()+1000);

			var Year = String(callerdate.getFullYear());
			var Month = String(callerdate.getMonth());
			var Day  = String(callerdate.getDay());
			var hh  = String(callerdate.getHours());
			var mm  = String(callerdate.getMinutes());
			
			

			document.clock.face.value =   ((hh < 10) ? " " : "") + hh + ((mm < 10) ? ":0" : ":") + mm;
			
			
		}

		callerdate=new Date( <?php echo date("Y,m,d,H,i,s");?>);

		

		</script>
		
	</head>
	<body onload="showtime();">

		<div class="container" id="main">
			
			<? require_once "menu.php" ?>
								
			<div>
			
				<div class="panel panel-default panel-table">
				    <div class="panel-heading">

					
					<? if(isset($id) && isset($acao)) { ?>
							<form role="form" name="clock" action="cobranca_avulsa.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" name="clock" action="cobranca_avulsa.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="id_cobranca">Cobrança: </label>
								</div>
					  
								<div class="col col-xs-3">
									<input type="text" name="id_cobranca" class="form-control" id="id_cobranca" value="<?=$dadosTemp['id_cobranca']?>">
								</div>
								<div class="col col-xs-1">
									<label class="control-label" for="id_registro">Registro: </label>
								</div>								
					
								<div class="col col-xs-2">
									<select class="form-control" id="id_registro" name="id_registro"  onblur="myFunction()">
										<option value="<?= $linha['id_registro']?>"><?=$dadosTemp['id_registro']?> </option>
										<?php
										$consulta = $db->query("SELECT * FROM acesso ORDER BY id_registro DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_registro']?>" ><?= $linha['id_registro']?></option>									  
										<?php
										}
										?>
									</select>
								</div>														
								
								<div class="col col-xs-1" align="right">
									<label class="control-label" for="horario_pagamento"><em class="fa fa-clock-o fa-2x"></em></label>
								
								</div>	
								
								<div class="col col-xs-1">
									<input class="form-control" name="face" type="text"  size="12" value="" readonly>
								</div>
								
								<div class="col col-xs-2 text-right">
									<button type="submit" class="btn btn-sm btn-primary btn-create">Novo / Atualizar</button>
								</div>
							
						</div>
						<div class="label">
						
						</div>
						
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="total_pagamento">Total a Pagar: </label>
								</div>
					  
								<div class="col col-xs-4">
									<input type="text" name="total_pagamento" class="form-control" id="total_pagamento" value="<?=$dadosTemp['total_pagamento']?>">
								</div>			

								<div class="col col-xs-1">
									<label class="control-label" for="nome_forma_pagamento">Forma de Pagamento: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" id="id_" name="id_forma_pagamento"  onblur="myFunction()">
										<option value="" </option>
										<?php
										$consulta = $db->query("SELECT * FROM forma_pagamento ORDER BY nome_forma_pagamento DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_forma_pagamento']?>" ><?= $linha['nome_forma_pagamento']?></option>									  
										<?php
										}
										?>
									</select>
								</div>
						</div				
										  
						</div>
						
						
						</form>
						
						
					</div>
					
					<div class="panel-body">
							<table class="table table-striped table-bordered table-list">
							  <thead>
								<tr>
									<th><em class="fa fa-cog"></em></th>
									<th>Cobrança</th>
									<th>Registro</th>
									<th>Horário Pagamento</th>
									<th>Total a Pagar</th>
									<th>Forma de Pagamento</th>
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT ca.id_registro, ca.horario_pagamento, ca.total_pagamento, ca.id_forma_pagamento, ca.id_cobranca FROM cobranca_avulsa ca
																INNER JOIN acesso a ON a.id_registro=ca.id_registro
																INNER JOIN forma_pagamento fp ON fp.id_forma_pagamento=ca.id_forma_pagamento
																	GROUP BY ca.id_registro, ca.horario_pagamento, ca.total_pagamento, ca.id_forma_pagamento, ca.id_cobranca, fp.nome_forma_pagamento
																	ORDER BY ca.id_cobranca");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <a class="btn btn-default" href="?id=<?= $linha['id_cobranca']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										  <a class="btn btn-danger" href="?id=<?= $linha['id_registro']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td><?= $linha['Horário Pagamento']?></td>
										<td><?= $linha['Total a Pagar']?></td>
										<td><?= $linha['nome_forma_pagamento']?></td>
										
									<?php
									}
									?>
									
									</tr>
								</tbody>
							</table>
					</div>
					
					<div class="panel-footer">
						<div class="row">
							<div class="col col-xs-4">Page 1 of 5
							</div>
							<div class="col col-xs-8">
								<ul class="pagination hidden-xs pull-right">
								  <li><a href="#">1</a></li>
								  <li><a href="#">2</a></li>
								  <li><a href="#">3</a></li>
								  <li><a href="#">4</a></li>
								  <li><a href="#">5</a></li>
								</ul>
								<ul class="pagination visible-xs pull-right">
								  <li><a href="#">«</a></li>
							      <li><a href="#">»</a></li>
								</ul>
							</div>
						</div>
					</div>
					
				</div>		

				
			</div>
			
			
			
		</div> <!-- end container -->
	

	

	<!-- All Javascript at the bottom of the page for faster page loading -->
		
	<!-- First try for the online version of jQuery-->
	<script src="http://code.jquery.com/jquery.js"></script>
	
	<!-- If no online access, fallback to our hardcoded version of jQuery -->
	<script>window.jQuery || document.write('<script src="include/js/jquery-1.8.2.min.js"><\/script>')</script>
	
	<!-- Bootstrap JS -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Custom JS -->
	<!-- <script src="include/js/script.js"></script> -->
	<!-- <script src="include/js/formatacampo.js"></script> -->
	
	</body>
</html>




