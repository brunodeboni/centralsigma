<?php

	require "cursos_para_convidados.inc.php";
	$cc = new cursos_convidados();
	$cursos_agora = $cc->recursos_agora();
	$cursos_depois = $cc->recursos();
	
	require "querycursos.php";
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cursos CPCM</title>
	<link rel="stylesheet" type="text/css" href="banner.css">
	<script type="text/javascript">
		function acessarconvidado(){
			var cmsg = "Para acessar a sala virtual selecione a opção CONVIDADO e insira o seu nome completo.\r\n \r\n";
			cmsg += "Se você não realizou sua inscrição previamente poderá assistir a toda a aula e interagir com o instrutor, porém não terá acesso às atividades e recursos complementares do curso.";
			
			return confirm(cmsg);
		}
	</script>
</head>
<body>

<div id="banner_container">
	<img id="titulo" src="imagens/titulo.png">
	<img id="estude" src="imagens/estude.png">
	<span id="frase">Acompanhe a grade de cursos online gratuitos:</span>
	<div id="lista">
		<?php 

		$cursos = mesclarCursos($cursos_agora, $cursos_depois);
		
		foreach($cursos as $curso){
		
			if($curso['turma_acontecendo_agora']){
				// está acontecendo agora
				$reclink = $curso['link'];
				$linkinscrito = '<a href="'.$reclink.'" class="btn-destaque" style="padding: 7px 5px;" onclick="return acessarconvidado()" target="_blank">Acesse agora</a>';
		
				echo "
					<div class=\"aula_agora\">
						<div class=\"botao\">
							$linkinscrito
						</div>
						<div class=\"aula\">
							<span><b>".$curso['nome']."</b></span><br>
							<span><b>Aula em Andamento - ".$curso['horarios']."</b></span>
						</div>
					</div>
					<img src=\"imagens/linha.png\">
				";
		
			}else{
				// não está acontecendo agora
				$reclink = $curso['id_curso'];
				$linkinscrito = '<a href="http://centralsigma.com.br/cpcm/cursos/inscricao/'.$reclink.'" class="btn-red" style="padding:7px 5px;" target="_blank">Saiba mais</a>';
		
				echo "
					<div class=\"inscreva_se\">
						<div class=\"botao\">
							$linkinscrito
						</div>
						<div class=\"aula\">
							<span><b>".$curso['nome']."</b></span><br>
							<span>".$curso['periodo']." - ".$curso['horarios']."</span>
						</div>
					</div>
					<img src=\"imagens/linha.png\">
				";
			}
		
		}
		
		?>
	<!-- 
		<div class="inscreva_se">
			<div class="botao">
				<a href="http://centralsigma.com.br/cpcm/cursos/inscricao/'.$reclink.'" class="btn-red" style="padding:7px 5px;" target="_blank">Inscreva-se</a>
			</div>
			<div class="aula">
				<span><b>Conceitos Básicos de PCM</b></span><br>
				<span>Dias 15, 16 e 17 de Abril - 13h - 16h</span>
			</div>
		</div>
		<img src="imagens/linha.png">
		
		<div class="inscreva_se">
			<div class="botao">
				<a href="http://centralsigma.com.br/cpcm/cursos/inscricao/'.$reclink.'" class="btn-red" style="padding:7px 5px;" target="_blank">Inscreva-se</a>
			</div>
			<div class="aula">
				<span><b>Formação de Representantes Comerciais Sigma</b></span><br>
				<span>Dias 11, 13 e 15 de março - 13h - 16h</span>
			</div>
		</div>
		<img src="imagens/linha.png">
		
		<div class="aula_agora">
			<div class="botao">
				<a href="" class="btn-destaque" style="padding: 7px 5px;" onclick="return acessarconvidado()" target="_blank">Acesse agora</a>
			</div>
			<div class="aula">
				<span><b>Instalação e Operação do PCM/SIGMA</b></span><br>
				<span><b>Aula em Andamento - 08h - 12h</b></span>
			</div>
		</div>
		<img src="imagens/linha.png">
		
		<div class="inscreva_se">
			<div class="botao">
				<a href="http://centralsigma.com.br/cpcm/cursos/inscricao/'.$reclink.'" class="btn-red" style="padding:7px 5px;" target="_blank">Inscreva-se</a>
			</div>
			<div class="aula">
				<span><b>Operação de aplicativos do Universo de PCM/SIGMA</b></span><br>
				<span>Dias 08, 09 e 10 de Abril - 19h - 22h</span>
			</div>
		</div>
		<img src="imagens/linha.png">
		
		<div class="aula_agora">
			<div class="botao">
				<a href="" class="btn-destaque" style="padding: 7px 5px;" onclick="return acessarconvidado()" target="_blank">Acesse agora</a>
			</div>
			<div class="aula">
				<span><b>Avançado para Planejadores de Manutenção Sigma</b></span><br>
				<span><b>Aula em Andamento - 08h - 12h</b></span>
			</div>
		</div>
		-->
	</div>
	 
	<div class="acesse_cpcm">
		<a id="site" href="http://centralsigma.com.br/cpcm/" class="btn-red" style="font-size: 12px; padding: 7px 5px;" target="_blank">Acesse o site CPCM</a>
	</div>
	<img id="homem" src="imagens/homem.png">
	
</div>

</body>
</html>