<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
*{font-family:Tahoma, Geneva, sans-serif;padding:0;margin:0;color:#FFF}
#content{
	margin:auto;
	width:173px;
	padding: 5px 5px 5px 5px;
	font-size:14px;
	font-weight:bold;
	border: 5px solid; /* As 4 bordas sólidas com 25px de espessura */
	border-color: #09C #09C #09C #09C; /* cores: topo, direita, inferior, esquerda */
	border-radius: 5px;
	background-color:#09C;
}
</style>
</head>
<body>
<div id="content"> 
<SCRIPT LANGUAGE="JAVASCRIPT">
<!--
 
var now = new Date();
var mName = now.getMonth() +1 ;
var dName = now.getDay() +1;
var dayNr = now.getDate();
var yearNr=now.getYear();
if(dName==1) {Day = "Domingo";}
if(dName==2) {Day = "Segunda-feira";}
if(dName==3) {Day = "Terça-feira";}
if(dName==4) {Day = "Quarta-feira";}
if(dName==5) {Day = "Quinta-feira";}
if(dName==6) {Day = "Sexta-feira";}
if(dName==7) {Day = "Sábado";}
if(mName==1){Month = "01";}
if(mName==2){Month = "02";}
if(mName==3){Month = "03";}
if(mName==4){Month = "04";}
if(mName==5){Month = "05";}
if(mName==6){Month = "06";}
if(mName==7){Month = "07";}
if(mName==8){Month = "08";}
if(mName==9){Month = "09";}
if(mName==10){Month = "10";}
if(mName==11){Month = "11";}
if(mName==12){Month = "12";}
if(yearNr < 2000) {Year = 1900 + yearNr;}
else {Year = yearNr;}
//var todaysDate =(" " + Day + ", " + dayNr + "/" + Month + "/" + Year);
var todaysDate =(" " + dayNr + "/" + Month + "/" + Year);
 
document.write(todaysDate);
 
//-->
</SCRIPT>
 
&nbsp;&nbsp;
<SPAN ID="Clock">00:00:00</SPAN>
 
<SCRIPT LANGUAGE="JavaScript">
<!--
  var Elem = document.getElementById("Clock");
  function Horario(){
    var Hoje = new Date();
    var Horas = Hoje.getHours();
    if(Horas < 10){
      Horas = "0"+Horas;
    }
    var Minutos = Hoje.getMinutes();
    if(Minutos < 10){
      Minutos = "0"+Minutos;
    }
    var Segundos = Hoje.getSeconds();
    if(Segundos < 10){
      Segundos = "0"+Segundos;
    }
    Elem.innerHTML = Horas+":"+Minutos+":"+Segundos;
    }
    window.setInterval("Horario()",1000);
//-->
</SCRIPT>
</div> 
</body>
</html>