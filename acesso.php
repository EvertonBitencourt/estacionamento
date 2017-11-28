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

if(isset($hora_entrada) && isset($id_empresa) && isset($id_tipo_acesso) && isset($id_equipamento) && isset($id_cliente)){  
	if($acao != 'atualizarFim') {
		$dados[0] = $hora_entrada;
		$dados[1] = $hora_saida;
		$dados[2] = $id_empresa;
		$dados[3] = $id_tipo_acesso;
		$dados[4] = $id_equipamento;
		$dados[5] = $id_cliente;
		$db->execute("INSERT INTO acesso (hora_entrada, hora_saida, id_empresa, id_tipo_acesso, id_equipamento, id_cliente) VALUES (?,?,?,?,?,?)", $dados);	
	}
  
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM acesso WHERE id_registro=?",$dados2);
}
$dadosTemp['id_registro'] = '';
$dadosTemp['hora_entrada'] = '';
$dadosTemp['hora_saida'] = '';
$dadosTemp['id_empresa'] = '';
$dadosTemp['id_tipo_acesso'] = '';
$dadosTemp['id_equipamento'] = '';
$dadosTemp['id_cliente'] = '';
$dadosTemp['nome_equipamento'] = '';
$dadosTemp['nome_empresa'] = '';
$dadosTemp['nome_cliente'] = '';
$dadosTemp['nome_tipo_acesso'] = '';

if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $hora_entrada;
  $dados[1] = $hora_saida;
  $dados[2] = $id_empresa;
  $dados[3] = $id_tipo_acesso;
  $dados[4] = $id_equipamento;
  $dados[5] = $id_cliente;  
  $dados[6] = $id;
  
  $db->execute("UPDATE acesso SET hora_entrada=?, hora_saida=?, id_empresa=?, id_tipo_acesso=?, id_equipamento=?, id_cliente=?, WHERE id_registro=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT a.id_registro, a.hora_entrada, a.hora_saida, a.id_empresa, a.id_tipo_acesso, a.id_equipamento, a.id_cliente FROM acesso a
							INNER JOIN empresa e ON e.id_empresa=a.id_empresa
							INNER JOIN tipo_acesso ta ON ta.id_tipo_acesso=a.id_tipo_acesso
							INNER JOIN equipamento eq ON eq.id_equipamento=a.id_equipamento
							INNER JOIN cliente c ON c.id_cliente=a.id_cliente
							WHERE id_registro = $id
							GROUP BY a.id_registro, a.hora_entrada, a.hora_saida, a.id_empresa, a.id_tipo_acesso, a.id_equipamento, a.id_cliente"
							);
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
		
	</head>
	<body>

		<div class="container" id="main">
			
			<? require_once "menu.php" ?>
								
			<div>
			
				<div class="panel panel-default panel-table">
				    <div class="panel-heading">

					
					<? if(isset($id) && isset($acao)) { ?>
							<form role="form" action="acesso.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="acesso.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="id_registro">Acesso: </label>
								</div>
					  
								<div class="col col-xs-2">
									<input type="text" name="id_registro" class="form-control" id="id_registro" value="<?=$dadosTemp['id_registro']?>">
								</div>
								
								<div class="col col-xs-1">
									<label class="control-label" for="hora_entrada">Hora de Entrada: </label>
								</div>								
					  
								<div class="col col-xs-3">
									<input type="text" name="hora_entrada" class="form-control" id="hora_entrada"  
									maxlength="18" value="<?=$dadosTemp['hora_entrada']?>">
								</div>									
								
								<div class="col col-xs-3 text-right">
									<button type="submit" class="btn btn-sm btn-primary btn-create">Novo / Atualizar</button>
								</div>
							
						</div>
						<div class="row">
								<div class="col col-xs-1">
									<label class="control-label" for="hora_saida">Hora de Saída: </label>
								</div>
								
								<div class="col col-xs-3">
									<input type="text" name="hora_saida" class="form-control" id="hora_saida" value="<?=$dadosTemp['hora_saida']?>">
								</div>
								
								<div class="col col-xs-1">
									<label class="control-label" for="Empresa">Empresa: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" name="id_empresa">
										<option value="<?= $linha['id_empresa']?>"><?=$dadosTemp['nome_empresa']?> </option>
										<?php
										$busca = "SELECT * FROM empresa ORDER BY nome_empresa DESC";
										$consulta = $db->query($busca);
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_empresa']?>" ><?= $linha['nome_empresa']?></option>									  
										<?php
										}
										?>
									</select>
								</div>
								
								<div class="col col-xs-1">
									<label class="control-label" for="id_tipo_acesso">Tipo de Acesso: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" name="id_tipo_acesso">
										<option value="<?= $linha['id_tipo_acesso']?>"><?=$dadosTemp['nome_tipo_acesso']?> </option>
										<?php
										$busca = "SELECT * FROM tipo_acesso ORDER BY nome_tipo_acesso DESC";
										$consulta = $db->query($busca);
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_tipo_acesso']?>" ><?= $linha['nome_tipo_acesso']?></option>									  
										<?php
										}
										?>
									</select>
								</div>
							</div>	
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="id_equipamento">Equipamento: </label>
								</div>
					  
								<div class="col col-xs-3">
									<select class="form-control" name="id_equipamento">
										<option value="<?= $linha['id_equipamento']?>"><?=$dadosTemp['nome_equipamento']?> </option>
										<?php
										$busca = "SELECT * FROM equipamento ORDER BY nome_equipamento DESC";
										$consulta = $db->query($busca);
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_equipamento']?>" ><?= $linha['nome_equipamento']?></option>									  
										<?php
										}
										?>
									</select>
								</div>			

								<div class="col col-xs-1">
									<label class="control-label" for="id_cliente">Cliente: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" name="id_cliente">
										<option value="<?= $linha['id_cliente']?>"><?=$dadosTemp['nome_cliente']?> </option>
										<?php
										$busca = "SELECT * FROM cliente ORDER BY nome_cliente DESC";
										$consulta = $db->query($busca);
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_cliente']?>" ><?= $linha['nome_cliente']?></option>									  
										<?php
										}
										?>
									</select>
								</div>  					  							  
								
						</div>
						
						
						</form>
						
						
					</div>
					
					<div class="panel-body">
							<table class="table table-striped table-bordered table-list">
							  <thead>
								<tr>
									<th><em class="fa fa-cog"></em></th>
									<th class="hidden-xs">Registro</th>
									<th>Hora de Entrada</th>
									<th>Hora de Saída</th>
									<th>Empresa</th>
									<th>Tipo de Acesso</th>
									<th>Equipamento</th>
									<th>Cliente</th>
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT a.id_registro, a.hora_entrada, a.hora_saida, a.id_empresa, a.id_tipo_acesso, a.id_equipamento, a.id_cliente FROM acesso a
																INNER JOIN empresa e ON e.id_empresa=a.id_empresa
																INNER JOIN tipo_acesso ta ON ta.id_tipo_acesso=a.id_tipo_acesso
																INNER JOIN equipamento eq ON eq.id_equipamento=a.id_equipamento
																INNER JOIN cliente c ON c.id_cliente=a.id_cliente
																GROUP BY a.id_registro, a.hora_entrada, a.hora_saida, a.id_empresa, a.id_tipo_acesso, a.id_equipamento, a.id_cliente");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <a class="btn btn-default" href="?id=<?= $linha['id_registro']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										  <a class="btn btn-danger" href="?id=<?= $linha['id_registro']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?= $linha['id_registro']?></td>
										<td><?= $linha['hora_entrada']?></td>
										<td><?= $linha['hora_saida']?></td>
										<td><?= $linha['nome_empresa']?></td>
										<td><?= $linha['nome_tipo_acesso']?></td>
										<td><?= $linha['nome_equipamento']?></td>
										<td><?= $linha['nome_cliente']?></td>
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




