<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Teste da API de fala</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

</head>

<body>
<!--  -->
<div style="width: 690px;">
	<div style="float: left; margin: 5px; width: 420px;">
		<h1 style="font-size: 18px;">SIGMA ANDROID</h1>
	
		<p>Aplicativo desenvolvido em JAVA para uso em tablets e smartphones, no sistema operacional mais popular do mundo para estes aparelhos: o sistema ANDROID, desenvolvido pelo Google. Este aplicativo possui recursos para Solicitação de Serviços e aprovação de serviços de forma simples e intuitiva.</p>
	
		<p>Com o lançamento do SIGMA ANDROID previsto para o mês de agosto de 2013, a Rede Industrial marca o início de uma Nova Geração para o PCM – Planejamento e controle da Manutenção em todo BRASIL, tendo em vista seu ineditismo e as características modernas de gestão do PCM.</p>
	
	</div>
	<div style="float: right; margin: 5px; width: 250px;">
		<!-- Carrega avatar -->
		<script language="JavaScript" type="text/javascript" src="http://vhss-d.oddcast.com/vhost_embed_functions_v2.php?acc=3077602&js=1"></script>
		<script language="JavaScript" type="text/javascript">AC_VHost_Embed(3077602,188,250,'',1,1, 2324145, 0,1,0,'a8308acc77e3a6d4d4e686c36e2afc1c',9);</script>
		
		<br>
		<button id="btn-falar" style="background: #1F5775; color: #FFF; border: 0; padding: 5px 10px; font-weight: bold; cursor: pointer;">Clique Play para ouvir</button>
		<button id="btn-parar" style="background: #1F5775; color: #FFF; border: 0; padding: 5px 10px; font-weight: bold; cursor: pointer;">Parar</button>
		
		<!-- Fala do avatar -->
		<script type="text/javascript">
				$('#btn-falar').click(function() {
					//texto = $('#itexto').val();
					texto = 'Sigma Andróide é um aplicativo desenvolvido em JAVA, para uso em tablets e smartfones no sistema andróide, desenvolvido pelo Gúgol. Este aplicativo possui recursos para Solicitação de Serviços, e aprovação de serviços de forma simples e intuitiva. Os Recursos da geração andróide são incomparáveis. Portabilidade, e automação de serviços do PCM, são a marca forte da nova geração sigma andróide.';
					sayText(texto,5,6,2);
				});
		
				$('#btn-parar').click(function() {
					stopSpeech();
				});
		
		</script>
	</div>
</div>
<div style="clear: both; display: hidden;"></div>
<p>Os Recursos da geração ANDROID são incomparáveis. Portabilidade e automação de serviços do PCM são a marca forte da nova geração SIGMA ANDROID.</p>


</body>
</html>