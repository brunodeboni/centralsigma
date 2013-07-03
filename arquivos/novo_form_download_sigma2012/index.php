<?php
$pais    = @file("http://api.hostip.info/country.php?ip=".$_SERVER['REMOTE_ADDR']);
$origem  = isset($_GET["origem"])?$_GET["origem"]:"centralsigma";
$arquivo = isset($_GET["arquivo"])?$_GET["arquivo"]:1;
$arquivo_nome = "";
switch($arquivo){
	case 1:
		$arquivo_nome = "Free";
		break;
	case 2:
		$arquivo_nome = "Professional";
		break;
	case 3:
		$arquivo_nome = "Enterprise";
		break;
	default:
		$arquivo_nome = "| Free |";
		break;
}
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Formulário de Download do Sigma 2012 - <?php echo $arquivo_nome; ?></title>
	<link rel="stylesheet" type="text/css" href="default.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="default.js"></script>
</head>

<body>

<div id="content">
	<div id="form-titulo">Formulário de Download do Sigma 2012 - <span style="color:#369;"><?php echo $arquivo_nome; ?></span></div>
    
	<div class="content">
		<ul class="menubar">
			<li class="parent"><a style="text-align:center;"><span class="sp_linguagem" style="font-size:85%;font-weight:bold;">Linguagem</span></a>
            	<ul class="submenu">
				<li><a href="javascript:void(0)" onClick="window.language='pt'">Português</a></li>
				<li><a href="javascript:void(0)" onClick="window.language='en'">English</a></li>
                </ul>
			</li>
		</ul>
	</div>
    
    <br class="clear" />
    <form action="download.php?aid=<?php echo $arquivo; ?>" method="post" id="form_download">
        <span class="sp_nome">Nome</span>:<br/>
        <input type="text" name="nome" id="inp_nome" class="block" /><br/>
        <span class="sp_email">E-Mail</span>:<br/>
        <input type="text" name="email" id="inp_email" class="block" /><br/>
        <span class="sp_empresa">Empresa</span>:<br/>
        <input type="text" name="empresa" id="inp_empresa" class="block" /><br/>
        
        <div style="float:left;width:170px;margin-right:10px;">
            <span class="sp_pais">País</span>:<br/>
            <select name="pais" id="pais" style="width:170px;">
            <option value="" class="sp_selecione">Selecione...</option>
            <option value="BR" <?php if($pais[0]!="PT") echo "selected"; ?>>Brasil</option>
            <option value="PT" <?php if($pais[0]=="PT") echo "selected"; ?>>Portugal</option>
            <option value="XX">Outro...</option>
            </select>
        </div>
        
        <div style="display:block;">
            <span style="position:relative;left:15px;"><span class="sp_estado">Estado</span>:</span><br/>
            
            <div id="ufdiv">
                <select name="UF" id="UF" style="width:320px;position:relative;left:15px;">
                <option value="" class="sp_selecione" selected>Selecione...</option>
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
                </select>
            </div><!--#ufdiv-->
        
        </div><!-- [Display:Block] -->
        
        <span class="sp_telefone">Telefone</span>: <span style="color:#666;font-size:14px;float:right;">(XX) XXXX-XXXX</span><br/>
        <input type="text" name="telefone" id="inp_telefone" class="block telefone" /><br/>
        <span class="sp_celular">Celular</span>: <span style="color:#666;font-size:14px;float:right;">(XX) XXXX-XXXX</span><br/>
        <input type="text" name="celular" id="inp_celular" class="block telefone" /><br/>
        
        <br class="clear" /><br/>
        <input type="hidden" name="origem" value="<?php echo $origem; ?>" />
        <button type="button" onClick="verificaDados()">Download</button>
    </form>
</div>


</body>
</html>