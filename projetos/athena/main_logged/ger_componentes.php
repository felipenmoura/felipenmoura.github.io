<?php

// PERMISS�O
$acessoWeb= 20;

require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
require_once("inc/styles.php");
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
	<?php
	exit;
}
?>
ger_componentes.php<br>
Em constru&ccedil;&atilde;o