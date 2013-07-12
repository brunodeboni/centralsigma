<?php
//OBSERVE QUE SE A STRING CONTER " aspas duplas deve estar entre aspas simples ' pq o PHP  reconheçe string tanto com uma ou outra
$stringJson = '[{"Nome":"DELMAR","Cidade":"AJURICABA","Bairro":"CENTRO"},{"Nome":"DALVAN","Cidade":"IJUÍ","Bairro":"JARDIM"}]';
$obj = json_decode($stringJson);
//percorrer linhas
foreach($obj as $linha){
	//ou se já souber os nomes das colunas não precisa do segundo for
	echo "aqui nome : $linha->Nome</br>";
	echo "aqui cidade : $linha->Cidade</br>";
	echo "aqui bairro : $linha->Bairro</br>";
	echo "</br> final linha</br>";
}
/*
	//percorrer colunas
	foreach($linha as $campo=>$valor){
		echo "<pre>$campo = $valor      </pre>";
	}

*/
?>