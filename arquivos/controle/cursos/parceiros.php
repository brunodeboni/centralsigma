<?php
//session_start();
//if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");
?>



<script type="text/javascript">
checked=false;
function checkedAll (form) {
	var aa= document.getElementById('form_parc');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
</script>

<div>
	<h1 class="titulo">Controle de Parceiros</h1>
	<form id="form_parc" action="email_parc.php" method="post">
	<table>
		<tr class="firstline">
			<td><input type="checkbox" name="checkall" onclick="checkedAll(form_parc);">
			<td><b>Nome</b>
			<td><b>Empresa</b>
			<td><b>Cargo</b>
			<td><b>Telefone</b>
			<td><b>Celular</b>
			<td><b>E-mail</b>
			<td><b>Curr&iacute;culo</b>
<?php 


//Seleciona dados de usu�rios com role 3 (Parceiro)
$sql = "SELECT usuarios.id, nome, empresa, cargo, telefone, celular, email, curriculo
from cwk_users as usuarios

left join cwk_roles_users as roles
on usuarios.id=roles.user_id

where
roles.role_id=3";
$query = $db->query($sql);
$resultado = $query->fetchAll();

$rowq = true; //cores das linhas

foreach ($resultado as $res) {
	$id_user = $res['id'];
	$curriculo = $res['curriculo'];

	//cores das linhas
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;

	echo "<tr class=\"$class\">
	<td><input type=\"checkbox\" name=\"cb_parceiro[]\" value=\"".$id_user."\">
	<td>$res[nome]
	<td>$res[empresa]
	<td>$res[cargo]
	<td>$res[telefone]
	<td>$res[celular]
	<td>$res[email]
	<td><a href=\"http://centralsigma.com.br/cpcmteste/".$curriculo." \">Baixar</a>
	";
}

?>
	</table>
		<br><button type="submit">Enviar e-mail</button>
	</form>
	
</div>
<br>
<div>
<form action="#" method="post">
		<span>Pesquise os parceiros por UF:&nbsp;&nbsp;&nbsp;</span>
		<input name="uf_parc">
		<button type="submit">Pesquisar</button>
	</form>
<br>
<?php 

if (isset ($_POST['uf_parc'])) {
	$uf = $_POST['uf_parc'];
	
	$cons = "select usuarios.nome, usuarios.empresa, usuarios.cargo, usuarios.celular, usuarios.uf, usuarios.email
			from cwk_users as usuarios
			
			left join cwk_roles_users as roles
			on usuarios.id=roles.user_id
			
			where
			roles.role_id=3
			and usuarios.uf= :uf";
	$consulta = $db->prepare($cons);
	$consulta->execute(array(':uf' => $uf));
	$retorno = $consulta->fetchAll();
	
	if($consulta->rowCount() > 0) {
		echo '
			<table>
				<tr class="firstline">
					<td><b>Empresa</b>
					<td><b>UF</b>
					<td><b>Nome</b>
					<td><b>Cargo</b>
					<td><b>Celular</b>
					<td><b>E-mail</b>
		';
		
		$rowq = true; //Classe das cores das linhas
		foreach ($retorno as $dados) {
			$nome = $dados['nome'];
			$empresa = $dados['empresa'];
			$cargo = $dados['cargo'];
			$uf = $dados['uf'];
			$celular = $dados['celular'];
			$email = $dados['email'];
			
			//Classe das cores das linhas
			if($rowq) $class = "secondline";
			else $class = "firstline";
			$rowq = !$rowq;
			
			echo '
				<tr class="'.$class.'">
	    			<td>'.$empresa.'
					<td>'.$uf.'
					<td>'.$nome.'
	    			<td>'.$cargo.'
	          		<td>'.$celular.'
					<td>'.$email.'
			';
			}
			echo '</table>';
		}else echo 'A pesquisa n&atilde;o retornou resultados.';
}else echo ''; //se não foi feita pesquisa por uf

?>
</div>
<br>

