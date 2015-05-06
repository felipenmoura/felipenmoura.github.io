<?php

// PERMISSÃO
$acessoWeb = 1;

require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/query_control.php");
require_once("../inc/class_explorer.php");


//if(!$db_connection= @connectTo())
	include("../../connections/flp_db_connection.php");
$db_connection= connectTo();
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
<div style="width:100%;
			height: 100%;
			overflow: auto;">
<form action="processo/search_process.php" name="search_process" method="POST" target="hidden_frame">
Processo:<br>
	<input type="text" name="key_search" id="key_searchProcess">
	<input type="submit" value="Pesquisar" class="botao"
		   Xonclick="onlyEvalAjax('processo/search_process.php?key_search='+document.getElementById('key_searchProcess').value, '', 'document.getElementById(\'processos_viewer_list\').innerHTML=ajax')">
</form>
<div id="processos_viewer_list">
	<br>&nbsp;
</div>
<iframe name="hidden_frame" style="display:none"></iframe>
</div>