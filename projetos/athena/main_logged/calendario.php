<?
//session_start();
$acessoWeb= 9; // calendario
require_once("inc/valida_sessao.php");
?>

<input type="hidden" id="tmpCalendar">
<center>
	<div id="calendario_padrao"
		 style="width: 175px;
				text-align: center;
				padding-top: 7px;">
	</div>
</center>
<flp_script>
	document.getElementById('calendario_padrao').innerHTML= buildCal('calendario_padrao', curmonth, curyear, "main", "month", "daysofweek", "days", 0);