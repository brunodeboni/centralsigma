<!DOCTYPE html>
<html>
<head>
<title>Download SIGMA ANDROID</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../default.css">
    <link rel="stylesheet" type="text/css" href="cadastro.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="../plugins/jquery.maskedinput.js"></script>
</head>
<body>
    <div id="container">
		<!-- Conteúdo -->
		<!-- Formulário -->
		<div id="formulario">
			<form id="cadastro_empresa" action="" method="post">
				<h1>Download SIGMA ANDROID</h1>
				
				<p>Se preferir, você pode acessar esta página diretamente do seu smartphone ou tablet através do QR Code abaixo, para realizar o download no próprio aparelho.</p>
				<img src="1375809838.png" id="qrcode">
				<br>
				
				<span>Empresa:</span>
				<input type="text" id="empresa" name="empresa" class="block" required><br>
					
				<span>CNPJ:</span>
				<input type="text" id="cnpj" name="cnpj" class="block" required><br>
					
				<span>Rua:</span>
				<input type="text" id="logradouro" name="logradouro" class="block" placeholder="Ex: Avenida São João" required><br>
					
				<span>Número:</span>
				<input type="text" id="nro" name="nro" required>
					
				<span style="margin-left: 10px;">Complemento:</span>
				<input type="text" id="complemento" name="complemento" size="30" required><br><br>
					
				<span>Cidade:</span>
				<input type="text" id="cidade" name="cidade" class="block" required><br>
					
				<span>Estado:</span>
				<select id="uf" name="uf" class="block" required>
					<option value="">Selecione...</option>
					<option value="AC">Acre</option>
			        <option value="AL">Alagoas</option>
			        <option value="AP">Amapá</option>
			        <option value="AM">Amazonas</option>
			        <option value="BA">Bahia</option>
			        <option value="CE">Ceará</option>
			        <option value="DF">Distrito Federal</option>
			        <option value="ES">Espírito Santo</option>
			        <option value="GO">Goiás</option>
			        <option value="MA">Maranhão</option>
			        <option value="MT">Mato Grosso</option>
			        <option value="MS">Mato Grosso do Sul</option>
			        <option value="MG">Minas Gerais</option>
			        <option value="PA">Pará</option>
			        <option value="PB">Paraíba</option>
			        <option value="PR">Paraná</option>
			        <option value="PE">Pernambuco</option>
			        <option value="PI">Piauí</option>
			        <option value="RJ">Rio de Janeiro</option>
			        <option value="RN">Rio Grande do Norte</option>
			        <option value="RS">Rio Grande do Sul</option>
			        <option value="RO">Rondônia</option>
			        <option value="RR">Roraima</option>
			        <option value="SC">Santa Catarina</option>
			        <option value="SP">São Paulo</option>
			        <option value="SE">Sergipe</option>
			        <option value="TO">Tocantins</option>
				</select><br>
					
				<span>Telefone Comercial:</span>
				<input type="text" id="telefone" name="telefone" class="block" required><br>
				
				<span>Celular:</span>
				<input type="text" id="celular" name="celular" class="block" required><br>
				
				<span>E-mail:</span>
				<input type="text" id="email" name="email" class="block" required><br>
					
				<br>
				<div id="div_erro"></div>
					
				<button id="btn">Enviar</button>
					
			</form>
				
<script>

$(document).ready(function() {
	$('#cnpj').mask('99.999.999/9999-99');
	$('#telefone').mask('(99) 9999-9999?9');
	$('#celular').mask('(99) 9999-9999?9');
	$('#nro').mask('?99999999');
});

//Subsitui caracteres especiais
var r={'special':/[\W]/g};
function valid(o,w){
	o = o.replace(r[w],'');
	return o;
}

$('#btn').click(function() {
	
	if ($('#empresa').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o nome da Empresa.'); return false;}
	if ($('#cnpj').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o CNPJ da Empresa.'); return false;}
	if (!validarCNPJ($('#cnpj').val())) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe um CNPJ válido.'); return false;}
	if ($('#logradouro').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o endereço da Empresa.'); return false;}
	if ($('#nro').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o endereço da Empresa.'); return false;}
	if ($('#cidade').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a cidade da Empresa.'); return false;}
	if ($('#uf').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o estado da Empresa.'); return false;}
	if ($('#telefone').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o telefone da Empresa.'); return false;}
	if ($('#celular').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe um número de celular.'); return false;}
	if ($('#email').val() == "" || !checarEmail($('#email').val())) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe um endereço de e-mail para contato.'); return false;}
	
	$('#cadastro_empresa').submit();
});

function checarEmail(mail){
	if(mail.length==0) return true;
	
	if ((mail.length > 7) && !((mail.indexOf("@") < 1) || (mail.indexOf('.') < 2)))
		{return true;}
	else
		{return false;}
}

function validarCNPJ(cnpj) {
	 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs inválidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2;
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}

</script>

<?php 

if (isset ($_POST['empresa'])) {
	
	$endereco = $_POST['logradouro'].", ".$_POST['nro'];
	
	require '../../conexoes.inc.php';
	$db = Database::instance('mobile_provider');
	
    $sql = "insert into cadastro 
    	(empresa, cnpj, endereco, complemento, cidade, uf, telefone, celular, email, status) 
    	values (:empresa, :cnpj, :endereco, :complemento, :cidade, :uf, :telefone, :celular, :email, 0)";
    $query = $db->prepare($sql);
    $success = $query->execute(array(
    	':empresa' => $_POST['empresa'],
    	':cnpj' => $_POST['cnpj'],
    	':endereco' => $endereco,
    	':complemento' => $_POST['complemento'],
    	':cidade' => $_POST['cidade'],
    	':uf' => $_POST['uf'],
    	':telefone' => $_POST['telefone'],
    	':celular' => $_POST['celular'],
   		':email' => $_POST['email']
    ));
    
    if ($success) {
    	//header('skymobile.apk');
    	echo '<br><br><a id="download" href="sigmaandroid.apk" mimetype="application/vnd.android.package-archive" download>Baixe o app</a>';
    	
    	//Envia e-mail para Abrahão, Henrique, Carolina...
		$headers = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
		$headers .= 'From: <comercial@redeindustrial.com.br>'."\r\n"; 
		$headers .= 'CC: <henriquesschmitt@gmail.com>'."\r\n"; //Henrique
		$headers .= 'CC: <carolina.lima@redeindustrial.com.br>'."\r\n"; //Carolina
		$headers .= 'CC: <comercial3@redeindustrial.com.br>'."\r\n"; //Juliana
		$headers .= 'CC: <brunodeboni@gmail.com.br>'."\r\n"; //Bruno
		$headers .= 'CC: <consultor@redeindustrial.com.br>'."\r\n"; //Márcio
		$headers .= 'CC: <cadastrados@live.com>'."\r\n"; //Danna

		$destinatario = 'abrahaolslima@gmail.com';
		
		$assunto = "Download SIGMA Android";
		$mensagem = '<!doctype html>
			<html>
			<head>
				<meta charset="utf-8">
			</head>
			<body>
			A empresa '.$_POST['empresa'].' acaba de realizar download do aplicativo SIGMA Android no site centralsigma.<br><br>
			CNPJ: '.$_POST['cnpj'].'<br>
			Endereço: '.$endereco.' '.$_POST['complemento'].'<br>
			Cidade: '.$_POST['cidade'].'/'.$_POST['uf'].'<br>
			Telefone: '.$_POST['telefone'].'<br>
			E-mail: '.$_POST['email'].'
			<body>
			</html>';
    	
    	mail($destinatario, $assunto, $mensagem, $headers);
    	
	    //Envia SMS avisando sobre o download 	
		$celular = $_POST['celular'];
		$celular = decode_telefone($celular);
		$mensagem = "Download do SIGMA Android concluido. Entre em contato conosco e solicite um curso GRATUITO de PCM - www.centralsigma.com.br";
		
    	try {
        	$db02 = new Database(
                'mysql:host=mysql.centralsigma.com.br;dbname=centralsigma02', 
               	'webadmin', 'webADMIN', 
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            $db02->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
        } catch ( PDOException $e ) {
            echo 'PDO Exception: '.$e->getMessage();
        }
        
		$sql2 = "INSERT INTO `sms` (`CELULAR_REMETENTE`, `CELULAR_DESTINO`, `MENSAGEM`, `STATUS`, `USUARIO`, `CODIGO_CLIENTE`)
		VALUES ('9999999999', :celular, :mensagem, '1', '151', '')";
		$query2 = $db02->prepare($sql2);
		$query2->execute(array(':celular' => $celular, ':mensagem' => $mensagem));
    	
    }else {
    	echo '<div class="div_erro2">Ocorreu um erro ao salvar seus dados. Por favor, tente novamente.</div>';
    }
	
}


function decode_telefone($telefone) {
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

?>
		</div>

    </div>

</body>
</html>
