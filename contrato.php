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

if(isset($id_contrato) && isset($valor) && isset($desconto) && isset($data_inicio) && isset($data_fim)){  
	if($acao != 'atualizarFim') {
		$dados[0] = $id_contrato;
		$dados[1] = $valor;
		$dados[2] = $desconto;
		$dados[3] = $data_inicio;
		$dados[4] = $data_fim;
		$dados[5] = $id_tipo_contrato;
		$db->execute("INSERT INTO contrato (id_contrato,valor,desconto,data_inicio,data_fim,id_tipo_contrato) VALUES (?,?,?,?,?,?)", $dados);	
	}
  
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM contrato WHERE id_contrato=?",$dados2);
}
$dadosTemp['id_contrato'] = '';
$dadosTemp['valor'] = '';
$dadosTemp['desconto'] = '';
$dadosTemp['data_inicio'] = '';
$dadosTemp['data_fim'] = '';
$dadosTemp['id_tipo_contrato'] = '';
$dadosTemp['nome_tipo_contrato'] = '';
if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $valor;
  $dados[1] = $desconto;
  $dados[2] = $data_inicio;
  $dados[3] = $data_fim;
  $dados[4] = $id_tipo_contrato;
  $dados[5] = $id;
  
  
  $db->execute("UPDATE contrato SET valor=?, desconto=?, data_inicio=?, data_fim=?, id_tipo_contrato=? WHERE id_contrato=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT c.id_contrato, c.valor, c.data_inicio, c.data_fim, c.id_tipo_contrato, c.desconto, t.nome_tipo_contrato FROM contrato c
								INNER JOIN tipo_contrato t ON t.id_tipo_contrato=c.id_tipo_contrato
								WHERE id_contrato = $id
								GROUP BY c.id_contrato, c.valor, c.data_inicio, c.data_fim, c.id_tipo_contrato, c.desconto, t.nome_tipo_contrato															
															ORDER BY c.id_contrato, c.id_tipo_contrato,t.nome_tipo_contrato");
					
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
							<form role="form" action="contrato.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="contrato.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="id_contrato">Contrato: </label>
								</div>
					  
								<div class="col col-xs-4">
									<input type="text" name="id_contrato" class="form-control" id="id_contrato" value="<?=$dadosTemp['id_contrato']?>">
								</div>
								<div class="col col-xs-1">
									<label class="control-label" for="valor">Valor: </label>
								</div>								
					  
								<div class="col col-xs-2">
									<input type="text" name="valor" class="form-control" id="valor"  
									maxlength="18" value="<?=$dadosTemp['valor']?>">
								</div>									
								
								
								
								<div class="col col-xs-1">
									<label class="control-label" for="desconto">Desconto: </label>
								</div>
								
								<div class="col col-xs-1">
									<input type="text" name="desconto" class="form-control" id="desconto" value="<?=$dadosTemp['desconto']?>">
								</div>						
								<div class="col col-xs-2 text-right">
									<button type="submit" class="btn btn-sm btn-primary btn-create">Novo / Atualizar</button>
								</div>
							
						</div>
						<div class="label">
						
						</div>
						
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="data_inicio">Data de Inicio: </label>
								</div>
					  
								<div class="col col-xs-5">
									<input type="text" name="data_inicio" class="form-control" id="data_inicio" value="<?=$dadosTemp['data_inicio']?>">
								</div>			

								<div class="col col-xs-1">
									<label class="control-label" for="data_fim">Data de Fim: </label>
								</div>								
					  
								<div class="col col-xs-1">
									<input type="text" name="data_fim" class="form-control" id="data_fim" value="<?=$dadosTemp['data_fim']?>">
								</div>									

						</div>
						
						<div class="label">
						
						</div>
						
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="nome_tipo_contrato">Tipo Contrato: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" id="id_tipo_contrato" name="id_tipo_contrato"  onblur="myFunction()">
										<option value="<?= $linha['id_tipo_contrato']?>"><?=$dadosTemp['nome_tipo_contrato']?> </option>
										<?php
										$consulta = $db->query("SELECT * FROM tipo_contrato ORDER BY nome_tipo_contrato DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_tipo_contrato']?>" ><?= $linha['nome_tipo_contrato']?></option>									  
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
									<th>Contrato</th>
									<th>Valor</th>
									<th>Desconto</th>
									<th>Data de Inicio</th>
									<th>Data de Fim</th>
									<th>Tipo do Contrato</th>
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT c.id_contrato, c.valor, c.data_inicio, c.data_fim, c.desconto, c.id_tipo_contrato, t.nome_tipo_contrato FROM contrato c
															INNER JOIN tipo_contrato t ON t.id_tipo_contrato=c.id_tipo_contrato
															GROUP BY c.id_contrato, c.valor, c.data_inicio, c.data_fim, c.id_tipo_contrato, c.desconto, t.nome_tipo_contrato															
															ORDER BY c.id_contrato, c.id_tipo_contrato,t.nome_tipo_contrato");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <a class="btn btn-default" href="?id=<?= $linha['id_contrato']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										  <a class="btn btn-danger" href="?id=<?= $linha['id_contrato']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?= $linha['id_contrato']?></td>
										<td><?= $linha['valor']?></td>
										<td><?= $linha['desconto']?></td>
										<td><?= $linha['data_inicio']?></td>
										<td><?= $linha['data_fim']?></td>
										<td><?= $linha['nome_tipo_contrato']?></td>
										
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




