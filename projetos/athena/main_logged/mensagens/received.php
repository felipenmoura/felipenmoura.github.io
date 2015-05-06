<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/class_abas.php");

if($_POST)
{
	@include("../../connections/flp_db_connection.php");
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
						$msgGuias= new guias();
						$msgGuias->guiaAdd('N&atilde;o Lidas', 'nao_lidas.php');
						$msgGuias->guiaAdd('Lidas', 'lidas.php');
						//$msgGuias->guiaAdd('Pesquisar', 'find.php');
						//$funcGuias->setSelected(0);
						$msgGuias->write();
					?>
				</td>
			</tr>
		</table>
</div>