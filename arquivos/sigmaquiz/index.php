<?php
if(!isset($_SESSION)) session_start();
if(isset($_SESSION["id"])) header("Location: quiz.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>SigmaQuiz</title>
<link rel="stylesheet" href="./css/layout.css">
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript">function falar(texto){}</script>
</head>
<body>

<div id="sq-container">
	<nav id="sq-left-bar" class="inline-block">
    	<ul>
        	<li class="current"><a href="">Início</a></li>
            <li><a href="">Como Funciona</a></li>
            <li><a href="">Contato</a></li>
        </ul>
    </nav><!-- /#sq-left-bar --><div id="sq-main-content" class="inline-block"><div style="display:block;padding:10px;">
    	<h1 id="sq-title">Seja Bem Vindo(a)</h1><!-- /#sq-title -->
        <div id="sq-speaker" class="inline-block">
            <script language="JavaScript" type="text/javascript" src="https://vhss.oddcast.com/vhost_embed_functions_v2.php?acc=3077602&js=1"></script>
			<script language="JavaScript" type="text/javascript">AC_VHost_Embed(3077602,225,300,'',1,1, 2271749, 0,1,0,'f91aff42dbc1ded656950096deb7056c',9);</script>
            <script type="text/javascript">
			function falar(texto){/* */ if(typeof sayText != 'undefined') /* */ sayText(texto,5,6,2);/* */}
			setTimeout(function(){
				falar("Bem vindo ao PCM Dráiver, um local onde você pode testar seus conhecimentos sobre PCM e se divertir ao mesmo tempo!");
			},5000);
			</script>
        </div><!-- /#sq-speaker --><div id="sq-content" class="inline-block"><div style="display:block;padding:0 10px;">
        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris urna leo, condimentum sed vestibulum vel, ornare id massa. Nam dictum risus et mauris rutrum ut placerat tortor volutpat. Duis nunc magna, hendrerit vel pharetra et, iaculis vitae massa. Duis rutrum cursus turpis ut adipiscing. Etiam ante turpis, eleifend id tincidunt et, viverra non enim.
            <br><br><br>
            
            <form id="sq-main-form" action="quiz.php" method="POST">
            	<div id="sqmf-title">Comece a responder o Sigma Quiz</div><!-- /#sqmf-title -->
                <div id="sqmf-content">
                    <div class="sqmf-field">
                        <label>Nome Completo</label>
                        <input type="text" name="nome" id="input_nome">
                    </div>
                    <div class="sqmf-field">
                        <label>E-mail Institucional</label>
                        <input type="text" name="email" id="input_email">
                    </div>
                    <div class="sqmf-field">
                        <label>Telefone</label>
                        <input type="text" name="celular" id="input_celular">
                    </div>
                    
                    <div class="sqmf-field" style="margin-top:20px;font-size:12px;">
                    	<button class="sqmf-bt">Responder QUIZ</button>
                        ou <a href="javascript:void(0);">Continue de onde você parou</a>
                    </div>
                </div><!-- /#sqmf-content -->
            </form>
        </div><!-- [style] --></div><!-- /#sq-content -->
    </div><!-- [style] --></div><!-- /#sq-main-content -->
</div>

</body>
</html>