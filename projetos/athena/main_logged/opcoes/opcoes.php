<?php

// PERMISSÃO
$acessoWeb= 34;

require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/class_abas.php");
if(!$db_connection)
{
	include("../../connections/flp_db_connection.php");
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
<div style="width: 100%;
			height: 100%;
			overflow: scroll-y">
	<?php
		$funcGuias= new guias();
		$funcGuias->guiaAdd('Geral', 'geral.php');
		$funcGuias->guiaAdd('Interface', 'interface.php');
		$funcGuias->guiaAdd('Atalhos', 'atalhos.php');
		$funcGuias->setSelected(0);
		$funcGuias->write();
	?>
</div>