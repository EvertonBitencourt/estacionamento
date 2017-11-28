<?php
require 'db/DB.class.php';
//inicia a conexão
$db = new DB( 'everton_bitencourt', //usuario
              '1234',//senha
              'ebs_composto', //banco
              'webacademico.canoas.ifrs.edu.br'//servidor
            );

$db->begin();

$nome_tipo_autor = array("Primario", "Secundario","Terciario");
foreach($nome_tipo_autor as $linha) {
 $result = $db->query("INSERT INTO tipo_autor (nome_tipo_autor) VALUES ('$linha');");
 if(!$result)
  $db->rollback();
} 
$db->commit();
?>