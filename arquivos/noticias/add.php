<?php
if(!isset($_GET["autenticacao"]) || $_GET["autenticacao"]!="redeindustrialsigma1"){
	die("<b>Acesso n&atilde;o autorizado</b>");
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Adicionar Noticia</title>
<style type="text/css">
*{margin:0;padding:0;}
body{
	background:url(./arquivos/background.jpg) repeat-x;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:14px;
}
.container{
	width:697px;
	margin:auto;
	padding:5px;
	background:#EEF;
	border:2px solid #AAF;
}
.center{text-align:center;display:block;}
.titulo{font-weight:bold;font-size:16px;color:#014;}
</style>
<script type="text/javascript" src="./arquivos/niceditor/nicEdit.js"></script>
<script type="text/javascript">
if(typeof jQuery == 'undefined'){
	var headID = document.getElementsByTagName("head")[0];         
	var newScript = document.createElement('script');
	newScript.type = 'text/javascript';
	newScript.src = './arquivos/jquery.js';
	headID.appendChild(newScript);
}

bkLib.onDomLoaded(function() {
	//nicEditors.allTextAreas()
	new nicEditor({
		iconsPath : './arquivos/niceditor/nicEditorIcons.gif',
		
		buttonList : ['save','bold','italic','underline','left','center','right','justify','image','upload','forecolor','link','unlink','fontSize','fontFamily','fontFormat','xhtml'],
		
		onSave : function(content, id, instance) {
			validarTexto(content,id,instance);
		}}).panelInstance('txteditor');
});

function validarTexto(conteudo)
{
	if(!confirm("Deseja mesmo salvar a noticia?"))return;
	autor = window.document.getElementById('autor').value;
	if(autor==""){alert("Preencha o nome do autor!");return;}
	
	$.post("./arquivos/ajaxnoticias.php",{action:'salvar',autor:autor,conteudo:conteudo},function(data){alert(data);});
}
</script>
</head>
<body>

<div class="container">
<div class="center titulo">Adicionar Noticia<hr></div>
<br>
<b>Autor:</b> <input type="text" id="autor" style="padding:5px;width:300px;"><br><br>
<div style="background:#FFF;">
<textarea id="txteditor" name="txteditor" style="width:100%;height:200px;"></textarea>
</div>
<br>
<div style="font-size:85%;color:#666;">
Adicione o autor e o conteúdo da notícia e clique no botão "salvar", é o primeiro botão do editor.
</div>
<br><br><br><br>
<hr>
<br>
<iframe src="./authctrlsgm12.php" style="width:100%;height:400px;border:0;"></iframe>
</div>

</body>
</html>