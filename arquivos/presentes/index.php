<link rel="stylesheet" type="text/css" href="css/estilos.css">

<script type="text/javascript">
$(document).ready(function( e ) {
 $("#tooltip-presente-link").hover(function(){
  console.log('mouseover');
        $("#tooltip-presente-tooltip").stop(true).fadeTo(400,1);
    }).mouseout(function(){
  console.log('mouseout');
        $("#tooltip-presente-tooltip").stop(true).fadeTo(400,0);
    });
});
</script>


 <div id="tooltip-presente">
    <a id="tooltip-presente-link" href="form.php"><img src="presente de natal 3.png" height="50" width="50"></a>
    <table id="tooltip-presente-tooltip" class="tabela">
        <tr>
            <td><img src="presente de natal 3.png" height="50" width="50"></td>
            <td><?php include 'mensagem.php'; ?></td>
        </tr>
    </table>
</div>