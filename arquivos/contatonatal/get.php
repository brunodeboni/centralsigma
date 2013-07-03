<?php
$conexao = mysql_connect('mysql.centralsigma.com.br', 'centralsigma02', 'S4k813042012') or die ('Não pode se conectar porque ' . mysql_error());
mysql_select_db('centralsigma02', $conexao);

$sql = "SELECT contato_pessoa.*, presentes_unicos.* FROM contato_pessoa INNER JOIN presentes_unicos ON contato_pessoa.contpess_id = presentes_unicos.contpess_id";
$query = mysql_query($sql) or die(mysql_error());
$resultado = mysql_fetch_array($query);



$nome = $resultado[1];
$empresa =  $resultado[2];
$endereco = $resultado[31];
$bairro = $resultado[4];
$cidade = $resultado[5];
$cep = $resultado[6];
$uf = $resultado[7];
$regiao = $resultado[8];
$telefone1 = $resultado[9];
$telefone2 = $resultado[10];
$setor = $resultado[11];
$email = $resultado[12];
$tamanho = $resultado[13];
$msgnatal = $resultado[14];
$status = $resultado[18];

echo "<strong>Nome: </strong> ".$nome;
echo  "<br>  <strong>Empresa: </strong> ".$empresa;
echo  "<br>  <strong>Endere&ccedil;o: </strong> ".$endereco;
echo  "<br>  <strong>Bairro: </strong> ".$bairro;
echo  "<br>  <strong>Cidade: </strong> ".$cidade;
echo  "<br>  <strong>Estado: </strong> ".$uf;
echo  "<br>  <strong>CEP: </strong> ".$cep;
echo "<br>  <strong>Tel/Ramal: </strong> ".$telefone1;
echo  "<br>  <strong>Tel Celular: </strong> ".$telefone2;
echo  "<br>  <strong>Setor: </strong> ".$setor;
echo  "<br>  <strong>Email: </strong> ".$email;
echo  "<br>  <strong>Tamanho Camisa: </strong> ".$tamanho;
echo  "<br>  <strong>Mensagem de Natal: </strong> ".$msgnatal;
if ($status == 0) {
    echo  "<br>  <strong>Status do presente: </strong> Dispon&iacute;vel";
} if ($status == 1) {
    echo  "<br>  <strong>Status do presente: </strong> Em an&aacute;lise";
    } if ($status == 2) {
           echo  "<br>  <strong>Status do presente: </strong> J&aacute; encontrado"; 
    }

$sql2 = "SELECT presentes.*, presentes_unicos.* FROM presentes INNER JOIN presentes_unicos ON presentes.id_presente = presentes_unicos.id_presente";
$query2 = mysql_query($sql2) or die(mysql_error());
$resultado2 = mysql_fetch_array($query2);

$presente = $resultado2[1];

echo "<br>  <strong>Presente: </strong> ".$presente;
?>
