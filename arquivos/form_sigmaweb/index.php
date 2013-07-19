<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <title>Cadastro</title>
    <link href="../default.css" rel="stylesheet">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
	<script type="text/javascript">		
		
		$(document).ready(function(){
			$("#inp_cnpj").mask("99.999.999/9999-99");
		});

		function validarCNPJ(cnpj) {
 
			cnpj = cnpj.replace(/[^\d]+/g,'');
			
			if(cnpj == '') return false;
			 
			if (cnpj.length != 14)
				return false;
		 
			// Elimina CNPJs invalidos conhecidos
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
			tamanho = cnpj.length - 2
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
		
		function validaEmail(email){
			var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
			var check=/@[\w\-]+\./;
			var checkend=/\.[a-zA-Z]{2,3}$/;
			if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){
				return false;
			}else{
				return true;
			}
		}
		
		/*
		function valida_dados(nomeform){
			if(nomeform.empresa.value == ""){
				alert('Por favor digite o Nome da Empresa.');
				return false;
			}
			
			if(nomeform.fantasia.value == ""){
				alert('Por favor digite o Nome Fantasia.');
				return false;
			}
			
			if (validarCNPJ(nomeform.cnpj.value) == false){
				alert('CNPJ inv\u00e1lido.')
				return false;
			}
			
			if(nomeform.endereco.value == ""){
				alert('Por favor digite o Endere\u00e7o.');
				return false;
			}
			
			if(nomeform.bairro.value == ""){
				alert('Por favor digite o Bairro.');
				return false;
			}
			
			if(nomeform.cidade.value == ""){
				alert('Por favor digite a Cidade.');
				return false;
			}
			
			if(nomeform.UF.selectedIndex == 0){
				alert('Por favor selecione o Estado.');
				return false;
			}
			
			if(nomeform.cep.value == ""){
				alert('Por favor digite o CEP.');
				return false;
			}
			
			if(nomeform.fone1.value.length == 0){
				alert('Por favor digite o Telefone.');
				return false;
			}
			
			if(nomeform.fone2.value == ""){
				alert('Por favor digite o Celular.');
				return false;
			}
			
			if (validaEmail(nomeform.email.value) == false){
				alert('E-mail inv\u00e1lido.')
				return false;
			}
			
			if(nomeform.usuario.value.indexOf(' ',0) != - 1){
				alert('Usu\u00e1rio n\u00e3o pode conter espa\u00e7os em branco.');
				return false;
			}
			
			if(nomeform.usuario.value == ""){
				alert('Por favor digite o Usu\u00e1rio.');
				return false;
			}
			
			if(nomeform.usuario.value.length < 5 || nomeform.usuario.value.length > 15){
				alert('Usu\u00e1rio deve conter entre 5 e 15 caracteres.');
				return false;
			}
			
			/** validador colocado por Giovanne ** /
			if(validador_validauser(nomeform.usuario.value)) {
				alert('Seu nome de usuário deve conter apenas letras e números');
				return false;
			}
			
			if(nomeform.senha.value.length > 0){
				if(nomeform.senha.value.length < 5 || nomeform.senha.value.length > 15){
					alert('Senha deve conter entre 5 e 15 caracteres.');
					return false;
				}
				
				if(nomeform.senha.value.indexOf(' ',0) != -1){
					alert('Senha n\u00e3o pode conter espa\u00e7os em branco.');
					return false;
				}
				
				if(nomeform.senha.value != nomeform.confirmacao.value){
					alert('Senha n\u00e3o confere com a confirma\u00e7\u00e3o.');
					return false;
				}
				
				/** validador colocado por Giovanne ** /
				if(validador_validasenha(nomeform.senha.value)) {
					alert('Sua senha contém caracteres inválidos');
					return false;
				}
				
			}else{
				alert('Por favor digite a Senha.');
				return false;
			}
		} */
		
		function SomenteNumero(e){
			var tecla=(window.event)?event.keyCode:e.which;   
			if((tecla>47 && tecla<58)) return true;
			else{
				if (tecla==8 || tecla==0) return true;
			else  return false;
			}
		}
		
		function validador_validasenha($senha)
		{
			var regx = /^[a-z0-9._-]+$/i;
			return regx.test($senha);
		}
		
		function validador_validauser($user)
		{
			var regx = /^[a-z0-9_]+$/i;
			return regx.test($user);
		}
		
		function validar_formulario()
		{
			var continuar = true;
			
			/* Exibe o erro e manda o focus pra lá */
			function disp_err(elem, msg) {
				if(msg) alert(msg);
				else    alert('Erro, o campo "'+elem.attr('name')+'" não pode ficar em branco');
				elem.focus();
				continuar = false;
				return false;
			}
			
			/** Campos em branco **/
			$('.campo_obrigatorio').each(function(index,element) {
				var el = $(element);
				if(el.val()=='') {
					disp_err(el);
					return false;
				}
			});
			if(!continuar) return false;
			
			/** CNPJ **/
			var cnpj = $('#inp_cnpj');
			if(validarCNPJ(cnpj.val()) == false) {
				disp_err(cnpj, 'CNPJ Inválido');
				return false;
			}
			
			/** Usuário **/
			var regUser = /^[a-z0-9]+$/i;
			var eleUser = $('#inp_usuario');
			if(!regUser.test(eleUser.val())) {
				disp_err(eleUser, 'O nome de usuário deve conter apenas letras e números e não pode ficar em branco.');
				return false;
			}
			
			/** Senha **/
			var regSenha = /^[a-z0-9._]+$/i;
			var eleSenha = $('#inp_senha');
			var senhaLen = eleSenha.val().length;
			if(!regSenha.test(eleSenha.val()) || senhaLen < 5 || senhaLen > 15) {
				disp_err(eleSenha, 'SENHA INVÁLIDA...\r\nA senha deve conter '
					+ 'entre 5 e 15 caracteres\nA senha deve conter apenas: letras, '
					+ 'números, pontos (.) e underlines (_)');
				return false;
			}
			
			/** Confirmação de Senha **/
			var confSenha = $('#inp_confirmacao');
			if(confSenha.val() != eleSenha.val()) {
				disp_err(confSenha, 'A confirmação de senha não está igual a senha');
				return false;
			}
			
			return true;
		}
		
	</script>
</head>
<body>
<div id="container">
	<h1>Cadastro para o SIGMA WEB</h1>
	
	<form action="processa_cadastro.php" method="post" id="form_processa_contato" onSubmit="return valida_dados(this)">
	
		<span class="sp_nome">Nome da Empresa</span>:<br/>
		<input type="text" name="empresa" id="inp_empresa" size="50" class="block campo_obrigatorio" /><br/>

		<span class="sp_empresa">Nome Fantasia</span>:<br/>
		<input type="text" name="fantasia" id="inp_fantasia" size="50" class="block campo_obrigatorio" /><br/>
		
		<span class="sp_empresa">CNPJ</span>:<br/>
		<input type="text" name="cnpj" id="inp_cnpj" size="15" class="block campo_obrigatorio" /><br/>

		<span class="sp_endereco">Endere&ccedil;o</span>:<br/>
		<input type="text" name="endereco" id="inp_endereco" size="50" class="block campo_obrigatorio" /><br/>

		<span class="sp_bairro">Bairro</span>:<br/>
		<input type="text" name="bairro" id="inp_bairro" size="30" class="block campo_obrigatorio"  /><br/>

		<span class="sp_cidade">Cidade</span>:<br/>
		<input type="text" name="cidade" id="inp_cidade" size="50" class="block campo_obrigatorio" /><br/>

		<span class="sp_estado">Estado</span>:<br/>
		<select name="UF" id="UF" style="width:170px;" class="campo_obrigatorio">
		<option value="" class="sp_selecione" selected>Selecione...</option>
		<option value="AC">AC</option>
		<option value="AL">AL</option>
		<option value="AM">AM</option>
		<option value="AP">AP</option>
		<option value="BA">BA</option>
		<option value="CE">CE</option>
		<option value="DF">DF</option>
		<option value="ES">ES</option>
		<option value="GO">GO</option>
		<option value="MA">MA</option>
		<option value="MG">MG</option>
		<option value="MS">MS</option>
		<option value="MT">MT</option>
		<option value="PA">PA</option>
		<option value="PB">PB</option>
		<option value="PE">PE</option>
		<option value="PI">PI</option>
		<option value="PR">PR</option>
		<option value="RJ">RJ</option>
		<option value="RN">RN</option>
		<option value="RO">RO</option>
		<option value="RR">RR</option>
		<option value="RS">RS</option>
		<option value="SC">SC</option>
		<option value="SE">SE</option>
		<option value="SP">SP</option>
		<option value="TO">TO</option>
		</select><br/><br/>

		<span class="sp_cep">CEP</span>:<br/>
		<input type="text" name="cep" id="inp_cep" class="block campo_obrigatorio" /><br/>

		<span class="sp_telefone1">Telefone</span>: <span style="color:#666;font-size:14px;float:right;">*somente números</span><br/>
		<input type="text" name="telefone1" id="inp_telefone1" class="block telefone campo_obrigatorio" onkeydown="return SomenteNumero(event)" maxlength="14" /><br/>

		<span class="sp_telefone2">Celular</span>: <span style="color:#666;font-size:14px;float:right;">*somente números</span><br/>
		<input type="text" name="telefone2" id="inp_telefone2" class="block telefone campo_obrigatorio" onkeydown="return SomenteNumero(event)" maxlength="14" /><br/>
		
		<span class="sp_email">Email</span>:<br/>
		<input type="text" name="email" id="inp_email" size="50" class="block campo_obrigatorio" /><br/>
		
		<span class="sp_usuario">Usuário</span>:<br/>
		<input type="text" name="usuario" id="inp_usuario" class="block campo_obrigatorio" /><br/>
		
		<span class="sp_senha">Senha</span>:<br/>
		<input type="password" name="senha" id="inp_senha" class="block campo_obrigatorio" /><br/>
		
		<span class="sp_senha">Confirmar Senha</span>:<br/>
		<input type="password" name="confirmacao" id="inp_confirmacao" class="block campo_obrigatorio" /><br/><br/>
		
		<span>* Os campos Usuário e Senha serão o seu administrador do SIGMA WEB</span><br/><br/>
		
		<button type="submit" onclick="return validar_formulario();">Cadastrar</button>
	</form>
</div>

</body>