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

if(isset($nome_empresa) && isset($cnpj) && isset($vagas) && is_numeric($numero)){  
	if($acao != 'atualizarFim') {
		$dados[0] = $nome_empresa;
		$dados[1] = $cnpj;
		$dados[2] = $endereco;
		$dados[3] = $numero;
		$dados[4] = $bairro;
		$dados[5] = $vagas;
		$dados[6] = $id_municipio;
		$db->execute("INSERT INTO empresa (nome_empresa, cnpj, endereco, numero, bairro, vagas, id_municipio) VALUES (?,?,?,?,?,?,?)", $dados);	
	}
  
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM empresa WHERE id_empresa=?",$dados2);
}
$dadosTemp['id'] = '';
$dadosTemp['nome_empresa'] = '';
$dadosTemp['id_municipio'] = '';
$dadosTemp['nome_municipio'] = '';
$dadosTemp['cnpj'] = '';
$dadosTemp['endereco'] = '';
$dadosTemp['numero'] = '';
$dadosTemp['bairro'] = '';
$dadosTemp['vagas'] = '';
$dadosTemp['nome_estado'] = '';
$dadosTemp['nome_pais'] = '';

if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $nome_empresa;
  $dados[1] = $cnpj;
  $dados[2] = $endereco;
  $dados[3] = $numero;
  $dados[4] = $bairro;
  $dados[5] = $vagas;
  $dados[6] = (int)$id_municipio;  
  $dados[7] = $id;
  
  $db->execute("UPDATE empresa SET nome_empresa=?, cnpj=?, endereco=?, numero=?, bairro=?, vagas=?, id_municipio=? WHERE id_empresa=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT * FROM empresa e
						INNER JOIN municipio m ON e.id_municipio=m.id_municipio
						INNER JOIN estado est ON est.id_estado=m.id_estado
						INNER JOIN pais p ON p.id_pais=est.id_pais
						WHERE id_empresa = $id
						GROUP BY e.id_empresa, e.nome_empresa, e.cnpj, e.endereco, e.numero, 
						e.bairro, e.vagas, e.id_municipio, m.id_municipio, m.nome_municipio, m.id_estado,
						est.id_estado, est.nome_estado, est.id_pais,p.id_pais, p.nome_pais
						ORDER BY e.nome_empresa, e.id_municipio");
					
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
							<form role="form" action="empresa.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="empresa.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="nome_empresa">Empresa: </label>
								</div>
					  
								<div class="col col-xs-4">
									<input type="text" name="nome_empresa" class="form-control" id="nome_empresa" value="<?=$dadosTemp['nome_empresa']?>">
								</div>
								<div class="col col-xs-1">
									<label class="control-label" for="cnpj">CNPJ: </label>
								</div>								
					  
								<div class="col col-xs-2">
									<input type="text" name="cnpj" class="form-control" id="cnpj"  
									maxlength="18" value="<?=$dadosTemp['cnpj']?>">
								</div>									
								
								
								
								<div class="col col-xs-1">
									<label class="control-label" for="vagas">Vagas: </label>
								</div>
								
								<div class="col col-xs-1">
									<input type="text" name="vagas" class="form-control" id="vagas" value="<?=$dadosTemp['vagas']?>">
								</div>						
								<div class="col col-xs-2 text-right">
									<button type="submit" class="btn btn-sm btn-primary btn-create">Novo / Atualizar</button>
								</div>
							
						</div>
						<div class="label">
						
						</div>
						
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="endereco">Endereço: </label>
								</div>
					  
								<div class="col col-xs-5">
									<input type="text" name="endereco" class="form-control" id="endereco" value="<?=$dadosTemp['endereco']?>">
								</div>			

								<div class="col col-xs-1">
									<label class="control-label" for="numero">Número: </label>
								</div>								
					  
								<div class="col col-xs-1">
									<input type="text" name="numero" class="form-control" id="numero" value="<?=$dadosTemp['numero']?>">
								</div>									

								<div class="col col-xs-1">
									<label class="control-label" for="bairro">Bairro: </label>
								</div>								
					  
								<div class="col col-xs-3">
									<input type="text" name="bairro" class="form-control" id="bairro" value="<?=$dadosTemp['bairro']?>">
								</div>									
					  
					  					  
								
						</div>
						
						<div class="label">
						
						</div>
						
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="nome_pais">País: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" id="id_pais" name="id_pais"  onblur="myFunction()">
										<option value="<?= $linha['id_pais']?>"><?=$dadosTemp['nome_pais']?> </option>
										<?php
										$consulta = $db->query("SELECT * FROM pais ORDER BY nome_pais DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_pais']?>" ><?= $linha['nome_pais']?></option>									  
										<?php
										}
										?>
									</select>
								</div>	
								
								
								<div class="col col-xs-1">
									<label class="control-label" for="nome_estado">Estado: </label>
								</div>								
					  
					  
								<div class="col col-xs-3">
									<select class="form-control" name="id_estado">
										<option value="<?= $linha['id_estado']?>"><?=$dadosTemp['nome_estado']?> </option>
										<?php
										$busca = "SELECT * FROM estado ORDER BY nome_estado DESC";
										$consulta = $db->query($busca);
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_estado']?>" ><?= $linha['nome_estado']?></option>									  
										<?php
										}
										?>
									</select>
								</div>				

								<div class="col col-xs-1">
									<label class="control-label" for="nome_municipio">Município: </label>
								</div>									
					  
					  
								<div class="col col-xs-3">
									<select class="form-control" name="id_municipio">
										<option value="<?=$dadosTemp['id_municipio']?> "><?=$dadosTemp['nome_municipio']?> </option>
										<?php
										$consulta = $db->query("SELECT * FROM municipio ORDER BY nome_municipio DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_municipio']?>" ><?= $linha['nome_municipio']?></option>									  
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
									<th>Empresa</th>
									<th>CNPJ</th>
									<th>Endereço</th>
									<th>Nº</th>
									<th>Bairro</th>
									<th>Vagas</th>
									<th>Município</th>
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT * FROM empresa e
															INNER JOIN municipio m ON e.id_municipio=m.id_municipio
															GROUP BY e.id_empresa, e.nome_empresa, e.cnpj, e.endereco, e.numero, 
															e.bairro, e.vagas, e.id_municipio, m.id_municipio, m.nome_municipio, m.id_estado	
															ORDER BY e.nome_empresa, m.id_municipio");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <a class="btn btn-default" href="?id=<?= $linha['id_empresa']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										  <a class="btn btn-danger" href="?id=<?= $linha['id_empresa']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?= $linha['id_empresa']?></td>
										<td><?= $linha['nome_empresa']?></td>
										<td><?= $linha['cnpj']?></td>
										<td><?= $linha['endereco']?></td>
										<td><?= $linha['numero']?></td>
										<td><?= $linha['bairro']?></td>
										<td><?= $linha['vagas']?></td>
										<td><?= $linha['nome_municipio']?></td>
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




