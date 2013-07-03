<?php 
$urgencia = $_POST['urgencia'];
$assunto = $_POST['assunto'];
$questao = $_POST['questao'];
$nome = $_POST['nome'];
$empresa = $_POST['empresa'];
$telefone = decode_telefone($_POST['telefone']);
$celular = decode_telefone($_POST['celular']);
$email = $_POST['email'];

$assunto_email = "Urgência: ".$urgencia." - ".$assunto;
$mensagem = "Urgência: ".$urgencia."<br><br><pre>".$questao."</pre><br><br>".$nome.
				"<br>".$empresa."<br>".$telefone."<br>".celular."<br>".$email;
$destinatario = "qualidade@redeindustrial.com.br";


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Additional headers
$headers .= 'From: qualidade@redeindustrial.com.br '. "\r\n";
$headers .= 'Cc: '.$email. "\r\n";

$enviar = mail($destinatario, $assunto_email, $mensagem, $headers);

//Cadastrar no banco de dados
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');


$sql = "insert into setor_qualidade (urgencia, assunto, questao, nome, empresa, telefone, celular, email) 
	values (:urgencia, :assunto, :questao, :nome, :empresa, :telefone, :celular, :email)";
$query = $db->prepare($sql);
$query->execute(array(
	':urgencia' => $urgencia,
	':assunto' => $assunto, 
	':questao' => $questao, 
	':nome' => $nome, 
	':empresa' => $empresa, 
	':telefone' => $telefone, 
	':celular' => $celular, 
	':email' => $email
));

function decode_telefone($telefone){
		$telefone = trim($telefone);
		if($telefone=="") return "";
		$nums = "0123456789";
	
		$numsarr = str_split($nums);
		$telsarr = str_split($telefone);
	
		$novo_telefone = "";
	
		foreach($telsarr as $tel){
			$ex = false;
			foreach($numsarr as $num){
				if($tel == $num){
					$ex = true;
					break;
				}
			}
			 
			if($ex) $novo_telefone .= $tel;
		}
	
		return $novo_telefone;
}

header("Location: http://www.centralsigma.com.br/index.php?option=com_content&view=article&id=854");



?>