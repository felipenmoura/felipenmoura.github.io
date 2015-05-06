<?php

// PERMISSÃO
$acessoWeb= 32;

require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/class_abas.php");

include("../../connections/flp_db_connection.php");
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
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<table style="width: 100%;
					  height: 100%;">
			<tr>
				<td>
					<?php
						$funcGuias= new guias();
						$funcGuias->guiaAdd('Recebidas', 'received.php');
						$funcGuias->guiaAdd('Enviadas', 'sent.php');
						$funcGuias->guiaAdd('Nova Mensagem', 'add.php');
						$funcGuias->setSelected(0);
						$funcGuias->write();
					?>
				</td>
			</tr>
		</table>
</div>