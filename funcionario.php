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

if(isset($nome_funcionario) && isset($cpf)){  
	if($acao != 'atualizarFim') {
		$dados[0] = $nome_funcionario;
		$dados[1] = $id_empresa;
		$dados[2] = $id_cargo;
		$dados[3] = $cpf;
		$db->execute("INSERT INTO funcionario (nome_funcionario, id_empresa, id_cargo, cpf) VALUES (?,?,?,?)", $dados);	
	}
  
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM funcionario WHERE id_funcionario=?",$dados2);
}
$dadosTemp['id_funcionario'] = '';
$dadosTemp['nome_funcionario'] = '';
$dadosTemp['id_empresa'] = '';
$dadosTemp['nome_empresa'] = '';
$dadosTemp['id_cargo'] = '';
$dadosTemp['cpf'] = '';
$dadosTemp['nome_cargo'] = '';


if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $nome_funcionario;
  $dados[1] = $cpf;
  $dados[2] = $id_cargo;
  $dados[3] = $id_empresa;
  $dados[4] = $id;
  
  $db->execute("UPDATE funcionario SET nome_funcionario=?, cpf=?, id_cargo=?, id_empresa=?  WHERE id_funcionario=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT f.id_funcionario,f.nome_funcionario, f.id_empresa, f.id_cargo, f.cpf, e.nome_empresa, c.nome_cargo FROM funcionario f
							INNER JOIN empresa e ON e.id_empresa=f.id_empresa
							INNER JOIN cargo c ON c.id_cargo=f.id_cargo
							WHERE id_funcionario = $id
							GROUP BY f.id_funcionario,f.nome_funcionario, f.id_empresa, f.id_cargo, f.cpf, e.nome_empresa, c.nome_cargo
						");
					
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
							<form role="form" action="funcionario.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="funcionario.php" method="post">
						
							<? } ?>
					
						<div class="row">
							
								<div class="col col-xs-1">
									<label class="control-label" for="nome_funcionario">Funcionário: </label>
								</div>
					  
								<div class="col col-xs-4">
									<input type="text" name="nome_funcionario" class="form-control" id="nome_funcionario" value="<?=$dadosTemp['nome_funcionario']?>">
								</div>
								
								<div class="col col-xs-1">
									<label class="control-label" for="cnpj">CPF: </label>
								</div>								
					  
								<div class="col col-xs-4">
									<input type="text" name="cpf" class="form-control" id="cpf"  
									maxlength="18" value="<?=$dadosTemp['cpf']?>">
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
									<label class="control-label" for="nome_estado">Cargo: </label>
								</div>								
					  
					  
								<div class="col col-xs-4">
									<select class="form-control" name="id_cargo">
										<option value="<?= $linha['id_cargo']?>"><?=$dadosTemp['nome_cargo']?> </option>
										<?php
										$busca = "SELECT * FROM cargo ORDER BY nome_cargo DESC";
										$consulta = $db->query($busca);
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_cargo']?>" ><?= $linha['nome_cargo']?></option>									  
										<?php
										}
										?>
									</select>
								</div>												
								
								
								<div class="col col-xs-1">
									<label class="control-label" for="nome_pais">Empresa: </label>
								</div>
								
								<div class="col col-xs-4">
									<select class="form-control" name="id_empresa">
										<option value="<?= $linha['id_empresa']?>"><?=$dadosTemp['nome_empresa']?></option>
										<?php
										$consulta = $db->query("SELECT * FROM empresa ORDER BY nome_empresa DESC");
										foreach ($consulta as $linha) {
										?>
										<option value="<?= $linha['id_empresa']?>"> <?= $linha['nome_empresa']?> </option>									  
										<?php
										}
										?>
									</select>
								</div>	
								
								<div class="col col-xs-2">
									
								</div>	
					  	
						</div>
							
						<div class="label">
						</div>
						
				
						
						</form>
						
						
					</div>
					
					<div class="panel-body">
							<table class="table table-striped table-bordered table-list">
							  <thead>
								<tr>
									<th><em class="fa fa-cog"></em></th>
									<th class="hidden-xs">ID</th>
									<th>Funcionario</th>
									<th>CPF</th>
									<th>Empresa</th>
									<th>Cargo</th>
								</tr> 
							  </thead>
								<tbody>
								   <?php
									$consulta = $db->query("SELECT f.id_funcionario,f.nome_funcionario, f.id_empresa, f.id_cargo, f.cpf, e.nome_empresa, c.nome_cargo FROM funcionario f
							INNER JOIN empresa e ON e.id_empresa=f.id_empresa
							INNER JOIN cargo c ON c.id_cargo=f.id_cargo
							GROUP BY f.id_funcionario,f.nome_funcionario, f.id_empresa, f.id_cargo, f.cpf, e.nome_empresa, c.nome_cargo");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										  <a class="btn btn-default" href="?id=<?= $linha['id_funcionario']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										  <a class="btn btn-danger" href="?id=<?= $linha['id_funcionario']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?= $linha['id_funcionario']?></td>
										<td><?= $linha['nome_funcionario']?></td>
										<td><?= $linha['cpf']?></td>
										<td><?= $linha['nome_empresa']?></td>
										<td><?= $linha['nome_cargo']?></td>
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




