<?php
if(isset($_POST['acao'],$_POST['CODIGO']) && $_POST['acao']=="verifica"){
	if($_POST['CODIGO']=='apr573456')
	{
		echo '<script type="text/javascript">(function(){window.location="http://meet59087562.adobeconnect.com/apresentacao/";})();</script>';
		echo '<a href="http://meet59087562.adobeconnect.com/apresentacao/">Clique aqui para entrar</a>';
		die();
	}
	else
	{
		echo("<font color=\"#FF0000\">Código informado incorreto!</font>");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Verificação</title>
</head>

<body>
<div align="center">
<div align="center" style="width:400px">
</br>Informe o código de verficação
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
  
  <p>
  <input name="CODIGO" type="text" />
  </p>
  <p>*O código de verificação é enviado ao seu celular por mensagem, de acordo com o número inserido em sua inscrição. Caso não tenha realizado a inscrição, <a href="http://www.centralsigma.com.br/index.php/sigma/sigma/apresentacaoonlinesigma" target="_new">faça aqui</a>. Se houver dúvidas, entre em contato neste <a href="http://redeindustrial.mysuite.com.br/clientlegume.php?param=hd_chat_gc_cad_chatdep&inf=&sl=rdi&lf=&ca=&cr=&redirect=http://redeindustrial.mysuite.com.br/empresas/rdi/central.php" target="_new">link</a> e acesse o atendimento online.
    <input name="acao" type="hidden" value="verifica"/>
  </p>
  <p>
    <input type="submit" name="Entrar" id="Entrar" value="Acessar" />
  </p>
</form>
</div>
</div>
</body>
</html>