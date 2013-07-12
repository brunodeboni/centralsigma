<html>
<head>
<title>Virtual SMS</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<center><h2>Cadastros Video Conferencia</h2></center>

 <center><form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

			
		
		ID do curso:<input type="text" name="id" >
		
	
			<input type="submit" name="listar" value="Listar" >
			
	</form >
	 </center>
	
         <?php
		 
		 if (isset ($_POST['listar']) ) { 
        $con = mysql_connect("mysql.centralsigma.com.br","centralsigma02","S4k813042012");
		mysql_select_db("centralsigma02");
		
		$id_curso = $_POST['id'];
          
            $query = "SELECT * FROM vsms_documento where usuario = '151' and referencia = '".$id_curso."' order by codigo";
              
          
           
           //Inicio da impressão da tabela com os valores buscados
           $resultado = mysql_query($query);
        echo "<center>";        
        echo "<table  border=0 cellspacing=2 cellpadding=0><tr bgcolor=#000000><td><FONT COLOR=#FFFFFF>Codigo</td><td><FONT COLOR=#FFFFFF>Nome</td><td><FONT COLOR=#FFFFFF>Empresa</td><td><FONT COLOR=#FFFFFF>E-mail</td><td><FONT COLOR=#FFFFFF>Celular</td><td><FONT COLOR=#FFFFFF>Status</td><td><FONT COLOR=#FFFFFF>Data/Hora</td><td><FONT COLOR=#FFFFFF>Turma</td></tr>";        
       while($dados = mysql_fetch_assoc($resultado)){
           
          
           
        if ($i %2==0){
		//tabela com uma cor  
            echo "<tr bgcolor=#CFCFCF>";   
        echo "<td>".$dados['codigo']."</td>";
        echo "<td>".$dados['destino_nome']."</td>";
        echo "<td>".$dados['destino_empresa']."</td>";
        echo "<td>".$dados['destino_email']."</td>";
        echo "<td>".$dados['destino_celular']."</td>";
        echo "<td>".$dados['status']."</td>";
        echo "<td>".$dados['dh_entrada']."</td>";  
		echo "<td>".$dados['destino_departamento']."</td>";
        echo "</tr>";
	  }
          // tabela com outra cor
	  else{
	echo "<tr bgcolor=#A9A9A9>";   
        echo "<td>".$dados['codigo']."</td>";
        echo "<td>".$dados['destino_nome']."</td>";
        echo "<td>".$dados['destino_empresa']."</td>";
        echo "<td>".$dados['destino_email']."</td>";
        echo "<td>".$dados['destino_celular']."</td>";
        echo "<td>".$dados['status']."</td>";
        echo "<td>".$dados['dh_entrada']."</td>";
		echo "<td>".$dados['destino_departamento']."</td>";
        echo "</tr>";
		}   
        
         $i=$i+1;
       }
       echo"</table>";
       echo "</center>";
       echo "<b>Total de registros: " .$i."</b>";
      
       }
    ?>
<center>
 <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

			
		
		Codigo do cliente:<input type="text" name="cd" >
		
	
			<input type="submit" name="libera" value="Liberar SMS" >
			<button onclick="window.location.reload();">Atualizar</button>
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			<input type="submit" name="excluir" onClick="return confirm('Tem certeza que deseja excluir esse registro ?')" value="Excluir" >
		
	</form >
</center>
      <?php
	  
	  $con = mysql_connect("mysql.centralsigma.com.br","centralsigma02","S4k813042012");
		mysql_select_db("centralsigma02");
		
        if (isset ($_POST['libera']) ) { 
		$cd = $_POST['cd'];
		$query = "UPDATE vsms_documento set preso = 'F' where codigo = '".$cd."'";
		mysql_query($query);
		
		}
         if (isset ($_POST['excluir']) ) { 
		$cd = $_POST['cd'];
		$query = "delete from vsms_documento where codigo = '".$cd."'";
		mysql_query($query);
		
		}
         ?>
    

       

</body>
</html>	