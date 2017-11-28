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

if(isset($placa) && isset($ano_fabricacao)){  
	if($acao != 'atualizarFim') {
		$dados[0] = $placa;
		$dados[1] = $ano_fabricacao;
		$dados[2] = $id_cor;
		$dados[3] = $id_marca;
		$db->execute("INSERT INTO veiculo (placa, ano_fabricacao, id_cor, id_marca) VALUES (?,?,?,?)", $dados);	
	}
  
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM veiculo WHERE id_veiculo=?",$dados2);
}
$dadosTemp['id_veiculo'] = '';
$dadosTemp['placa'] = '';
$dadosTemp['ano_fabricacao'] = '';
$dadosTemp['id_cor'] = '';
$dadosTemp['id_marca'] = '';
$dadosTemp['nome_cor'] = '';
$dadosTemp['nome_marca'] = '';
if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $placa;
  $dados[1] = $ano_fabricacao;
  $dados[2] = $id_cor;
  $dados[3] = $id_marca;
  $dados[4] = $id;
  
  $db->execute("UPDATE veiculo SET placa=?, ano_fabricacao=?, id_cor=?, id_marca=? WHERE id_veiculo=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT * FROM veiculo v
								INNER JOIN cor c ON c.id_cor=v.id_cor
								INNER JOIN marca m ON m.id_marca=v.id_marca
								WHERE v.id_veiculo = $id
								GROUP BY v.id_veiculo, c.id_cor, v.id_cor, m.id_marca, v.id_marca,
								c.nome_cor, m.nome_marca,
								v.placa, v.ano_fabricacao ORDER BY v.id_veiculo");
					
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
							<form role="form" action="veiculo.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="veiculo.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="id_veiculo">ID Veículo: </label>
								</div>
					  
								<div class="col col-xs-4">
									<input type="text" name="id_veiculo" class="form-control" id="id_veiculo" value="<?=$dadosTemp['id_veiculo']?>">
								</div>
								<div class="col col-xs-1">
									<label class="control-label" for="placa">Placa: </label>
								</div>								
					  
								<div class="col col-xs-3">
									<input type="text" name="placa" class="form-control" id="placa"  
									maxlength="18" value="<?=$dadosTemp['placa']?>">
								</div>									
								
								<div class="col col-xs-1">
									<label class="control-label" for="ano_fabricacao">Ano de Fabricação: </label>
								</div>								
					  
								<div class="col col-xs-3">
									<input type="text" name="ano_fabricacao" class="form-control" id="ano_fabricacao"  
									maxlength="18" value="<?=$dadosTemp['ano_fabricacao']?>">
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
									<label class="control-label" for="nome_cor">Cor: </label>
								</div>
								
								<div class="col col-xs-3">
									<select class="form-control" id="id_cor" name="id_cor"  onblur="myFunction()">
										<option value="<?=$dadosTemp['id_cor']?> "><?=$dadosTemp['nome_cor']?></option>
										<?php
										$consulta = $db->query("SELECT * FROM cor ORDER BY nome_cor DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_cor']?>" ><?= $linha['nome_cor']?></option>									  
										<?php
										}
										?>
									</select>
								</div>	
								
								
								<div class="col col-xs-1">
									<label class="control-label" for="nome_marca">Marca: </label>
								</div>								
					  
					  
								<div class="col col-xs-3">
									<select class="form-control" name="id_marca">
										<option value="<?=$dadosTemp['id_marca']?> "><?=$dadosTemp['nome_marca']?></option>
										<?php
										$busca = "SELECT * FROM marca ORDER BY nome_marca DESC";
										$consulta = $db->query($busca);
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_marca']?>" ><?= $linha['nome_marca']?></option>									  
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
									<th>Placa</th>
									<th>Ano Fabricação</th>
									<th>Cor</th>
									<th>Marca</th>
									
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT * FROM veiculo v
																INNER JOIN cor c ON c.id_cor=v.id_cor
																INNER JOIN marca m ON m.id_marca=v.id_marca
																	GROUP BY v.id_veiculo,c.id_cor,m.id_marca, v.id_cor, v.id_marca, c.nome_cor, m.nome_marca,
																				 v.placa, v.ano_fabricacao ORDER BY v.id_veiculo, c.nome_cor, m.nome_marca");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <a class="btn btn-default" href="?id=<?= $linha['id_veiculo']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										  <a class="btn btn-danger" href="?id=<?= $linha['id_veiculo']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?= $linha['id_veiculo']?></td>
										<td><?= $linha['placa']?></td>
										<td><?= $linha['ano_fabricacao']?></td>
										<td><?= $linha['nome_cor']?></td>
										<td><?= $linha['nome_marca']?></td>
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




