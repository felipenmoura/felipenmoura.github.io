<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/class_abas.php");
if(!$db_connection)
{
	require_once("../../connections/flp_db_connection.php");
	$db_connection = connectTo();
}


if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		<script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		</script>
	<?php
	exit;
}
?>
<table>
	<tr>
		<td>
			<input type="checkbox"
				   name="autobkp">
				Backup Autom&aacute;tico
			<img src="img/help.gif"
				 style="cursor: pointer;"
				 onmouseover="showtip(this, event, 'Ajuda');"
				 onclick="top.showHelp();">
		</td>
	</tr>
</table>