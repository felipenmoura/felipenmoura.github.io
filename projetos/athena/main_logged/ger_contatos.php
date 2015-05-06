<?php

// PERMISSÃO
$acessoWeb= 11;

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
<div style="width: 100%;
			height: 100%;
			overflow-x: auto;">
	<table style="width: 100%;
				  height: 100%;"
		   cellpadding="0"
		   cellspacing="0">
		<tr>
			<td style="vertical-align: top;">
				<div style="padding-left: 7px;
							vertical-align:top;
							padding: 0px;
							margin: 0px;
							float: left;">
					<?php
						include("ger_contatos_list.php");
					?>
				</div>
			</td>
			<td style="width: 5px;
					   height: 100%;
					   overflow: auto;
					   cursor: col-resize;
					   background-color: #dedede;"
				onmousedown="resizeDiv('gerContatoList_div_tree');">
				&nbsp;
			</td>
			<td style="vertical-align:top;
					   padding: 0px;"
				class="gridCell"
			    id="corpo_ger_contato_add">
				<?php
					if ($_GET['pk_usuario'])
					{
						include("ger_contato_edit.php");	
					}else
						 {
							require_once("ger_contato_add.php");
						 }
				?>
			</td>
		</tr>
	</table>
</div>
<?php
	$_GET['component']= 'exploradorContatos';
	//$_GET['apenasClientes']= 'true';
	$_GET['on_click']= "gerContatoClick";
	//$_GET['componentId']= 'status_processo_add';
	
	$_GET['containerId']= 'gerContatoList_div_tree';
	include('components.php');
?>