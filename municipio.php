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

if(isset($nome_municipio) ){   
	if($acao  != 'atualizarFim') {
		$dados[0] = $nome_municipio;
		$dados[1] = $id_estado;
		$db->execute("INSERT INTO municipio (nome_municipio,id_estado) VALUES (?,?)", $dados);
	}
}
//deletar
if(isset($id) && $acao == 'deletar'){
  $dados2[0] = $id;
  $db->execute("DELETE FROM municipio WHERE id_municipio=?",$dados2);
}
$dadosTemp['id'] = '';
$dadosTemp['nome_municipio'] = '';
$dadosTemp['id_estado'] = '';
$dadosTemp['nome_estado'] = '';

if(isset($acao) && $acao == 'atualizarFim'){
  $dados[0] = $nome_municipio;
  $dados[1] = $id_estado;
  $dados[2] = $id;
  
  $db->execute("UPDATE municipio SET nome_municipio=?, id_estado=? WHERE id_municipio=?", $dados);
}

if(isset($acao) && $acao == 'atualizar'){
  $consulta = $db->query("SELECT * FROM municipio m
						INNER JOIN estado e ON e.id_estado=m.id_estado WHERE id_municipio = $id
					GROUP BY m.id_municipio, m.nome_municipio, m.id_estado,e.id_estado, e.nome_estado, e.id_pais "); //m.id_estado
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
							<form role="form" action="municipio.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
							<? } else { ?>
							<form role="form" action="municipio.php" method="post">															
							<? } ?>
								<div class="col col-xs-2">
									<label class="control-label" for="nome_municipio">Município: </label>
								</div>
								<div class="col col-xs-5">
									<input type="text" name="nome_municipio" class="form-control" id="nome_municipio" value="<?=$dadosTemp['nome_municipio']?>">
								</div>									  
								<div class="col col-xs-3">
									<select class="form-control" name="id_estado">
										<option value="<?= $linha['id_estado']?>"><?=$dadosTemp['nome_estado']?> </option>
											<?php
											$consulta = $db->query("SELECT * FROM estado ORDER BY nome_estado DESC");
											foreach ($consulta as $linha) {
											?>
										<option value="<?= $linha['id_estado']?>" ><?= $linha['nome_estado']?></option>									  
										<?php
										}
										?>
									</select>
								</div>
								<div class="col col-xs-2 text-right">
									<button type="submit" class="btn btn-sm btn-primary btn-create">Criar Novo</button>
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
									<th>Município</th>
									<th>Estado</th>	
								</tr> 
							</thead>
							<tbody>
							<?php
							$consulta = $db->query("SELECT * FROM municipio m
														INNER JOIN estado e ON e.id_estado=m.id_estado 
														GROUP BY m.id_municipio, m.nome_municipio, m.id_estado,e.id_estado, e.nome_estado,e.id_pais
														ORDER BY e.nome_estado,m.nome_municipio");
								foreach ($consulta as $linha) {
								?>
								<tr>
									<td align="center"> 
										<a class="btn btn-default" href="?id=<?= $linha['id_municipio']?>&acao=atualizar"><em class="fa fa-pencil"></em></a>
										 <a class="btn btn-danger" href="?id=<?= $linha['id_municipio']?>&acao=deletar"><em class="fa fa-trash"></em></a>
									</td>
									<td class="hidden-xs"><?= $linha['id_municipio']?></td>
									<td><?= $linha['nome_municipio']?></td>
									<td><?= $linha['nome_estado']?></td>
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




