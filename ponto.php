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

if(isset($hora_ponto)){  
	if($acao != 'atualizarFim') {
		$dados[0] = $id_ponto;
		$dados[1] = $hora_ponto;
		$dados[2] = $id_funcionario;
		$dados[3] = $id_tipo_acesso;
		$db->execute("INSERT INTO ponto (hora_ponto,id_funcionario,id_tipo_acesso) VALUES (?,?,?)", $dados);	
	}
  
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM ponto WHERE id_ponto=?",$dados2);
}
$dadosTemp['id_ponto'] = '';
$dadosTemp['hora_ponto'] = '';
$dadosTemp['id_funcionario'] = '';
$dadosTemp['id_tipo_acesso'] = '';
$dadosTemp['nome_funcionario'] = '';
$dadosTemp['nome_tipo_acesso'] = '';
if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $hora_ponto;
  $dados[1] = $id_funcionario;
  $dados[2] = $id_tipo_acesso;
  $dados[3] = $id;
  
  $db->execute("UPDATE ponto SET hora_ponto=?, id_funcionario=?, id_tipo_acesso=? WHERE id_ponto=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT * FROM ponto p
								INNER JOIN funcionario f ON f.id_funcionario=p.id_funcionario
								INNER JOIN tipo_acesso tp ON tp.id_tipo_acesso=p.id_funcionario
								WHERE p.id_ponto = $id
								GROUP BY p.id_ponto, p.id_funcionario, f.id_funcionario, f.nome_funcionario,
								p.id_tipo_acesso, tp.id_tipo_acesso, tp.nome_tipo_acesso, p.hora_ponto
								ORDER BY p.id_ponto");
					
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
							<form role="form" action="ponto.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="ponto.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="id_ponto">ID Ponto: </label>
								</div>
					  
								<div class="col col-xs-4">
									<input type="text" name="id_ponto" class="form-control" id="id_ponto" value="<?=$dadosTemp['id_ponto']?>">
								</div>
								<div class="col col-xs-1">
									<label class="control-label" for="hora_ponto">Hora Ponto: </label>
								</div>								
					  
								<div class="col col-xs-3">
									<input type="text" name="hora_ponto" class="form-control" id="hora_ponto"  
									maxlength="18" value="<?=$dadosTemp['hora_ponto']?>">
								</div>									
							
								<div class="col col-xs-2 text-right">
									<button type="submit" class="btn btn-sm btn-primary btn-create">Novo / Atualizar</button>
								</div>
							
						</div>
						<div class="label">
						
						</div>
						
					
						<div class="label">
						
						</div>
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="nome_funcionario">Funcionário: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" id="id_funcionario" name="id_funcionario"  onblur="myFunction()">
										<option value="<?=$dadosTemp['id_funcionario']?> "><?=$dadosTemp['nome_funcionario']?></option>
										<?php
										$consulta = $db->query("SELECT * FROM funcionario ORDER BY nome_funcionario DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_funcionario']?>" ><?= $linha['nome_funcionario']?></option>									  
										<?php
										}
										?>
									</select>
								</div>	
								
								
								<div class="col col-xs-1">
									<label class="control-label" for="nome_tipo_acesso">Nome Tipo Ponto: </label>
								</div>								
					  
					  
								<div class="col col-xs-3">
									<select class="form-control" name="id_tipo_acesso">
										<option value="<?=$dadosTemp['id_tipo_acesso']?> "><?=$dadosTemp['nome_tipo_acesso']?></option>
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
						
						
						</form>
						
						
					</div>
					
					<div class="panel-body">
							<table class="table table-striped table-bordered table-list">
							  <thead>
								<tr>
									<th><em class="fa fa-cog"></em></th>
									<th class="hidden-xs">ID</th>
									<th>Id Ponto</th>
									<th>Hora Ponto</th>
									<th>Funcionário</th>
									<th>Tipo Acesso</th>
									
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT * FROM ponto p
															INNER JOIN funcionario f ON f.id_funcionario=p.id_funcionario
															INNER JOIN tipo_acesso tp ON tp.id_tipo_acesso=p.id_funcionario
																	GROUP BY p.id_ponto, p.id_funcionario, f.id_funcionario, f.nome_funcionario,
																	p.id_tipo_acesso, tp.id_tipo_acesso, tp.nome_tipo_acesso, p.hora_ponto
																	ORDER BY p.id_ponto");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <a class="btn btn-default" href="?id=<?= $linha['id_ponto']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										  <a class="btn btn-danger" href="?id=<?= $linha['id_ponto']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?= $linha['id_ponto']?></td>
										<td><?= $linha['hora_ponto']?></td>
										<td><?= $linha['id_funcionario']?></td>
										<td><?= $linha['id_tipo_acesso']?></td>
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




