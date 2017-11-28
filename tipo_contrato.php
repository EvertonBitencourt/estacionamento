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
//$nome_tipo_contrato = (isset($_POST['nome_tipo_contrato'])) ? $_POST['nome_tipo_contrato'] : '';
//$senha = (isset($_POST['CAMPO_SENHA'])) ? $_POST['CAMPO_SENHA'] : '';


if(isset($id_tipo_contrato) && isset($acao) && isset($nome_tipo_contrato)){   
	if($acao  != 'atualizarFim') {
		$dados[0] = $id_tipo_contrato;
		$dados[1] = $nome_tipo_contrato;
		$db->execute("INSERT INTO tipo_contrato (id_tipo_contrato,nome_tipo_contrato) VALUES (?,?)", $dados);
	}
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM tipo_contrato WHERE id_tipo_contrato=?",$dados2);
}
$dadosTemp['id_tipo_contrato'] = '';
$dadosTemp['nome_tipo_contrato'] = '';



if(isset($acao) && $acao == 'atualizarFim'){

  $dados[0] = $nome_tipo_contrato;
  $dados[1] = $id;
  
  $db->execute("UPDATE tipo_contrato SET nome_tipo_contrato=? WHERE id_tipo_contrato=?", $dados);
  
  $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT * FROM tipo_contrato WHERE id_tipo_contrato = $id");
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
						<div class="row">
							<? if(isset($id) && isset($acao)) { ?>
							<form role="form" action="tipo_contrato.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="tipo_contrato.php" method="post">									
							<? } ?>
								<div class="col col-xs-1">
									<label class="control-label" for="id_equipamento">Tipo de Contrato: </label>
								</div>
								<div class="col col-xs-1">
									<input type="text" name="id_tipo_contrato" class="form-control" id="id_tipo_contrato" value="<?=$dadosTemp['id_tipo_contrato']?>">
								</div>
								<div class="col col-xs-2">
									<label class="control-label" for="nome_tipo_contrato">Nome do Tipo do Contrato: </label>
								</div>		  
								<div class="col col-xs-5">
									<input type="text" name="nome_tipo_contrato" class="form-control" id="nome_tipo_contrato" value="<?=$dadosTemp['nome_tipo_contrato']?>">
								</div>
								<div class="col col-xs-3">
									<button type="submit" class="btn btn-sm btn-primary btn-create">Novo / Atualizar</button>
								</div>
							</form>
						</div>
					</div>
					
					<div class="panel-body">
						<table class="table table-striped table-bordered table-list">
							<thead>
							<tr>
								<th><em class="fa fa-cog"></em></th>
								<th class="hidden-xs">ID</th>
								<th>Nome</th>											
								</tr> 
							</thead>
							<tbody>
									<?php
									$consulta = $db->query("SELECT * FROM tipo_contrato ORDER BY id_tipo_contrato");
									foreach ($consulta as $linha) {
									?>
									<tr>
										<td align="center"> 
										<a class="btn btn-default" href="?id=<?= $linha['id_tipo_contrato']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										<a class="btn btn-danger" href="?id=<?= $linha['id_tipo_contrato']?>&acao=deletar"><em class="fa fa-trash"></em></a>
										</td>
										<td class="hidden-xs"><?= $linha['id_tipo_contrato']?></td>
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
	<script>window.jQuery || document.write('<script src="includes/js/jquery-1.8.2.min.js"><\/script>')</script>
	
	<!-- Bootstrap JS -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Custom JS -->
	<script src="includes/js/script.js"></script>
	
	</body>
</html>






