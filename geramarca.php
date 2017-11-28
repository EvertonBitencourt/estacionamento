<?php
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('lzrymjxrdqcmhe', //usuario
              'a0a6acc595e5c2591749b76679342e03b140dc8b81c1a6e757b5feba58b3e665',//senha
              'd8ji7jlpf7b7rq', //banco
              'ec2-50-16-204-127.compute-1.amazonaws.com'//servidor
);
$nome_cor = ['Chevrolet','Fiat','Ford','Toyota','Yamaha','Kawasaki','Citroen','JAC','Honda','Volkswagen', 'Renault'];


extract($_REQUEST); //transformando os dados em variáveis
//delete
if (isset($id) && $acao == 'deletar') {
    $dados[0] = $id;
    $db->execute("DELETE FROM cor WHERE id_cor=?", $dados);
}

//update
$dadosTemp['nome_cor'] = '';

if (isset($acao) && $acao == 'atualizarFim') {
    $dados[0] = $nome_cor;
    $dados[1] = $id;
    $db->execute("UPDATE cor SET nome_cor=? WHERE id_cor=?", $dados);
}

if (isset($acao) && $acao == 'atualizar') {
    $consulta = $db->query("SELECT * FROM cor WHERE id_cor=$id");
    foreach ($consulta as $linha) {
        $dadosTemp = $linha;
    }
    $acao = 'atualizarFim';
}
$insert = 0;
set_time_limit (0);
while ($insert < 500){
    $dados[0] = $nome_cor[rand(0,9)];
    $db->execute("INSERT INTO cliente (id_cor, nome_cor) VALUES (?,?)", $dados);
    $insert++;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Teste gerador de dados</title>
    </head>
    <body>
        <div class="container">
            <table class="table table-striped table-bordered" style="width:400px">
                <thead>
                    <tr>
                        <th id="cen">ID Cor</th>
                        <th id="cen">Nome Cor</th>
                        <th id="cen">Opção</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $consulta = $db->query("SELECT * FROM cor ORDER BY id_cor DESC");
                    foreach ($consulta as $linha) {
                        ?>
                        <tr>
                            <td id="cen"> <?= $linha['id_cor'] ?></td>
                            <td id="cen"> <?= $linha['nome_cor'] ?></td>
                            <td id="cen"><a href="?id=<?= $linha['id_cor'] ?>&acao=deletar">Deletar</a>
                                <a href="?id=<?= $linha['id_cor'] ?>&acao=atualizar">Atualizar</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </body>
</html>
