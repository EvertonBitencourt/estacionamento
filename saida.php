<?php

// Year+((Month < 10) ? "-0" : "-") + Month + ((Day < 10) ? "-0" : "-") +Day+ " " +

require 'db/DB.class.php';
//inicia a conexão
$db = new DB( 'lzrymjxrdqcmhe', //usuario
              'a0a6acc595e5c2591749b76679342e03b140dc8b81c1a6e757b5feba58b3e665',//senha
              'd8ji7jlpf7b7rq', //banco
              'ec2-50-16-204-127.compute-1.amazonaws.com'//servidor
            );

extract($_REQUEST);//transformando os dados enviados em variaveis


$acao = (isset($_REQUEST['acao'] )) ? $_REQUEST['acao']  : '';


if((isset($id_registro) || isset($id_cliente))){  

	$hora_saida = date('Y-m-d H:i:s', time());
	
	$dados[0] = $hora_saida;
	$dados[1] = 2;
	
	
	if(!(empty($id_cliente) || empty($id_registro))) {
		//die("CHEIO");
		$dados[2] = $id_registro;
		$dados[3] = $id_cliente;
		$db->execute("UPDATE acesso SET hora_saida=?, id_tipo_acesso=? WHERE id_registro=? AND id_cliente=? AND hora_saida IS NULL", $dados);	
	}
		
	else{
		if(!(empty($id_registro))){
			//die("REGISTRO");
			$dados[2] = $id_registro;
			$db->execute("UPDATE acesso SET hora_saida=?, id_tipo_acesso=? WHERE id_registro=? AND hora_saida IS NULL", $dados);	
		}
		else {
			if(!(empty($id_cliente))){
				//die("CLIENTE");
				$dados[2] = $id_cliente;
				$db->execute("UPDATE acesso SET hora_saida=?, id_tipo_acesso=? WHERE id_registro=? AND hora_saida IS NULL", $dados);	
			}
			
		}
	}  
}
$dadosTemp['id'] = '';
$dadosTemp['id_registro'] = '';
$dadosTemp['hora_entrada'] = '';
$dadosTemp['hora_saida'] = '';
$dadosTemp['id_empresa'] = '';
$dadosTemp['id_tipo_acesso'] = '';
$dadosTemp['id_equipamento'] = '';
$dadosTemp['id_cliente'] = '';
$dadosTemp['nome_equipamento'] = '';
$dadosTemp['nome_empresa'] = '';
$dadosTemp['nome'] = '';
$dadosTemp['nome_tipo_acesso'] = '';

if(isset($acao) && $acao == 'atualizar'){
  //$consulta = $db->query("SELECT id_registro FROM acesso WHERE id_registro = $id");
  //foreach ($consulta as $linha) {
   // $dadosTemp = $linha;

  
	$hora_saida = date('Y-m-d H:i:s', time());
	$dados[0] = $hora_saida;
	$dados[1] = 2;
	$dados[2] = $id;
	$db->execute("UPDATE acesso SET hora_saida=?, id_tipo_acesso=? WHERE id_registro=?", $dados);

	$acao = '';
	//}
  
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
	<body onload="showtime()">

		<div class="container" id="main">
			
			<? require_once "menu.php" ?>
								
			<div>
			
				<div class="panel panel-default panel-table">
				    <div class="panel-heading">

					
					<? if(isset($id) && isset($acao)) { ?>
							<form role="form" name="clock" action="saida.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" name="clock" action="saida.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1" align="right">
									<label class="control-label" for="hora_saida"><em class="fa fa-clock-o fa-2x"></em></label>
								
								</div>							
								<div class="col col-xs-1">
									<input class="form-control" name="face" type="text"  size="12" value="" readonly>
								</div>							
								
								<div class="col col-xs-1">
									<label class="control-label" for="registro">Registro: </label>
								</div> 				
					 			<div class="col col-xs-3">
									<input type="text" name="id_registro" class="form-control" id="id_registro" value=""/>
								</div> 				
								
								
								<div class="col col-xs-1">
									<label class="control-label" for="cliente">Cliente: </label>
									
								</div>  					  							  								
								
								<div class="col col-xs-3">
									
									<input type="text" name="id_cliente" class="form-control" id="id_cliente" value=""/>
									
								</div>  					  							  								
								
								<div class="col col-xs-2">
									<button type="submit" class="btn btn-sm btn-primary btn-create"><em class="fa fa-sign-out"> </em>  Registrar Saída</button>
								</div>
							
						</div>
						
						</form>
						
						
					</div>
					
					<div class="panel-body">
							<table class="table table-striped table-bordered table-list">
							  <thead>
								<tr>
									<th><em class="fa fa-taxi"></em></th>
									<th>Registro</th>
									<th>Entrada</th>
									<th>Saída</th>
									<th>Empresa</th>
									<th>Tipo de Acesso</th>
									<th>Equipamento</th>
									<th>Cliente</th>
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT a.id_registro, a.hora_entrada,a.id_tipo_acesso, a.hora_saida, e.nome_empresa, ta.nome_tipo_acesso, eq.nome_equipamento, a.id_cliente FROM acesso a
																INNER JOIN empresa e ON e.id_empresa=a.id_empresa
																INNER JOIN tipo_acesso ta ON ta.id_tipo_acesso=a.id_tipo_acesso
																INNER JOIN equipamento eq ON eq.id_equipamento=a.id_equipamento
																GROUP BY a.id_registro, a.hora_entrada, a.hora_saida, a.id_tipo_acesso,a.id_empresa,ta.nome_tipo_acesso, eq.nome_equipamento, a.id_cliente, e.nome_empresa
																ORDER BY a.id_registro DESC");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <?php if($linha['id_tipo_acesso']==1) { ?>
										   <a class="btn btn btn-danger" href="?id=<?= $linha['id_registro']?>&acao=atualizar"><em class="fa fa-sign-out"></em></a>
										  <?php } else { ?>
										  <a class="btn btn-success disabled" href="?id=<?= $linha['id_registro']?>&acao=atualizar"><em class="fa fa-check"></em></a>
										  
										  <?php } ?>
										</td>
										<td><?= $linha['id_registro']?></td>
										<td><?= date('d/m/Y H:i', strtotime($linha['hora_entrada']));?></td>
										<?php if($linha['id_tipo_acesso']==2) { ?>
										<td><?= date('d/m/Y H:i', strtotime($linha['hora_saida']));?></td>
										<?php } else { ?>
										<td> </td>
										<?php } ?>
										<td><?= $linha['nome_empresa']?></td>
										<td><?= $linha['nome_tipo_acesso']?></td>
										<td><?= $linha['nome_equipamento']?></td>
										<td><?= $linha['id_cliente']?></td>
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




