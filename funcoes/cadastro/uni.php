<html>
<head>
<title>Virtual SMS</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8_decode" />
</head>
<body>
<center><h2>Cadastros Universidades</h2></center>

 
	
         <?php
		 
		 
        $con = mysql_connect("mysql.centralsigma.com.br","centralsigma","cfbceee");
		mysql_select_db("centralsigma");
		
		
          
            $query = "SELECT * FROM jos_ckforms_15";
              
          
           
           //Inicio da impressão da tabela com os valores buscados
           $resultado = mysql_query($query);
        echo "<center>";        
        echo "<table  border=0 cellspacing=2 cellpadding=0><tr bgcolor=#000000><td><FONT COLOR=#FFFFFF>Codigo</td><td><FONT COLOR=#FFFFFF>Nome</td><td><FONT COLOR=#FFFFFF>E-mail</td><td><FONT COLOR=#FFFFFF>Celular</td><td><FONT COLOR=#FFFFFF>Uni</td><td><FONT COLOR=#FFFFFF>Professor</td><td><FONT COLOR=#FFFFFF>Telefone Uni</td></tr>";        
       while($dados = mysql_fetch_assoc($resultado)){
           
          
           
        if ($i %2==0){
		//tabela com uma cor  
            echo "<tr bgcolor=#CFCFCF>";   
        echo "<td>".$dados['id']."</td>";
        echo "<td>".$dados['F106']."</td>";
        echo "<td>".$dados['F109']."</td>";
        echo "<td>".$dados['F107']."</td>";
        echo "<td>".$dados['F111']."</td>";
        echo "<td>".$dados['F117']."</td>";
        echo "<td>".$dados['F118']."</td>";  
			echo "</tr>";
	  }
          // tabela com outra cor
	  else{
			echo "<tr bgcolor=#A9A9A9>";   
        echo "<td>".$dados['id']."</td>";
        echo "<td>".$dados['F106']."</td>";
        echo "<td>".$dados['F109']."</td>";
        echo "<td>".$dados['F107']."</td>";
        echo "<td>".$dados['F111']."</td>";
        echo "<td>".$dados['F117']."</td>";
        echo "<td>".$dados['F118']."</td>";  
			echo "</tr>";
		}   
        
         $i=$i+1;
       }
       echo"</table>";
       echo "</center>";
       echo "<b>Total de registros: " .$i."</b>";
      
       
    ?>
<center>
 <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

			
		
		Codigo do cliente:<input type="text" name="cd" >
		
	
			
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
	  
	  $con = mysql_connect("mysql.centralsigma.com.br","centralsigma","cfbceee");
		mysql_select_db("centralsigma");
		
        
         if (isset ($_POST['excluir']) ) { 
		$cd = $_POST['cd'];
		$query = "delete from jos_ckforms_15 where id = '".$cd."'";
		mysql_query($query);
		
		}
         ?>
    

       

</body>
</html>	