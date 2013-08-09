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
	<link rel="stylesheet" type="text/css" href="../default.css">
	<link rel="stylesheet" type="text/css" href="novo.css">
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
	<div id="titulo">
		<h1>CPCM - Centro de Formação para Planejamento e Controle de Manutenção</h1>
	</div>
	<span id="frase">Acompanhe a grade de cursos online gratuitos:</span>
	<div id="lista">
		<?php 

		$cursos = mesclarCursos($cursos_agora, $cursos_depois);
		
		foreach($cursos as $curso){
		
			if($curso['turma_acontecendo_agora']){
				// está acontecendo agora
				$reclink = $curso['link'];
				$linkinscrito = '<a href="'.$reclink.'" id="btn" onclick="return acessarconvidado()" target="_blank">Acesse agora</a>';
		
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
				$linkinscrito = '<a href="http://centralsigma.com.br/cpcm/cursos/inscricao/'.$reclink.'" id="btn" target="_blank">Saiba mais</a>';
		
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
		
	</div>
	 
	<div class="acesse_cpcm">
		<a href="http://centralsigma.com.br/cpcm/" id="acesse" target="_blank">Acesse o site CPCM</a>
	</div>
	<img id="homem" src="imagens/homem.png">
	
</div>

</body>
</html>