<?PHP	
	include('adodb5/adodb.inc.php');
	
	
	/*$db = ADONewConnection('ado_mssql');
	$db->debug = true;
		
	$myDSN="PROVIDER=MSDASQL;DRIVER={SQL Server};"
		. "SERVER=187.0.218.34\SQLEXPRESSR2;DATABASE=NEWITALIAN;UID=sa;PWD=Sigma2012;"  ;
	$db->Connect($myDSN);
	
	$rs = $db->Execute("select * from TIP_OS");
	$arr = $rs->GetArray();
	print_r($arr);
	
	$db = ADONewConnection('mssql');
	$db->debug = true;
	$db->Execute('187.0.218.34', 'sa', 'Sigma2012', 'NEWITALIAN');
	$rs = $db->Execute("select * from TIP_OS");
	var_dump($db);*/


$server="187.0.218.34";
$username="sa";
$password="Sigma2012";


$sqlconnect=mssql_connect($server, $username, $password);
if(!$sqlconnect)
die("Não conectou com o banco de dados.");

$sqldb=mssql_select_db("NEWITALIAN",$sqlconnect);
if(!$sqldb)
die("Não foi possivel selecionar a base de dados.");

$sqlquery = 'SELECT * FROM TIP_OS;';

$results= mssql_query($sqlquery);

while ($row=mssql_fetch_array($results)){
echo $row['TIP_OS_COD'].' - '.$row['TIP_OS_DES']."<br>\n";}
mssql_close($sqlconnect);
?>