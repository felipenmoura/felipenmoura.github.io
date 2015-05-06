<?php

// PERMISSÃO
$acessoWeb= 30;

require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");

include("../connections/flp_db_connection.php");
$db_connection= @connectTo();
if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		<script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		</script>
	<?
	exit;
}
?>
<center>
	<input type="hidden" id="agenda_eventos_calendar">
	<div id="idAgenda_eventos_calendar"
				 style="width: 175px;
						text-align: center;
						padding-top: 7px;">
	</div>
</center>
<div style="width:100%;
			height:100%;
			overflow:auto;"
	 id="conteudo_agenda_eventos">
	<?
		require_once('agenda_eventos_cadastrados.php');
	?>
</div>
	<?
?>
<flp_script>
	document.getElementById('idAgenda_eventos_calendar').innerHTML= buildCal('idAgenda_eventos_calendar', curmonth, curyear, "main", "month", "daysofweek", "days", 0);





