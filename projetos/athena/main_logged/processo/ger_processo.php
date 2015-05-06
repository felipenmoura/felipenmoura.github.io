<?php
// PERMISSÃO
$acessoWeb = 2;

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
	/*
	$PREID= date('ymdhis').microtime();
	$PREID= str_replace('.', '', str_replace(' ', '', $PREID));
	$PREID_component= $PREID;
	*/
	$_GET['PREID'] = "processo_add_ger_novo";
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<table style="width: 100%;
				  height: 100%;
				  overflow: auto;"
		   cellpadding="0"
		   cellspacing="0">
		<tr>
			<td id="list_processos"
				style="padding-left: 7px;
					   vertical-align:top;
					   padding: 0px;
					   margin: 0px;
					   text-align: left;"
				class="gridCell">
				<table height="100%">
					<tr>
						<td style="height: 10px;">
							<table width="100%">
								<tr onmouseover="this.style.backgroundColor= '#dedede'"
									onmouseout="this.style.backgroundColor= ''"
									onclick="getBlock(this).reload();">
									<td style="width: 32px;
											   height: 10px;">
										<span style="padding-left: 2px;">
											<img src="img/processo.gif"
												 style="width: 32px;"> 
										</span>
									</td>
									<td style="padding-left: 7px;">
										Novo processo
									</td>
								</tr>
								<tr onmouseover="this.style.backgroundColor= '#dedede'"
									onmouseout="this.style.backgroundColor= ''"
									onclick="creatBlock('Nova Pasta', 'pasta_add.php', 'pasta_add');">
									<td style="height: 10px;
											   width: 32px;">
										<span style="padding-left: 2px;">
											<img src="img/rel.png"
												 style="width: 32px;"> 
										</span>
									</td>
									<td style="padding-left: 7px;">
										Nova Pasta
									</td>
								</tr>
								<tr onmouseover="this.style.backgroundColor= '#dedede'"
									onmouseout="this.style.backgroundColor= ''"
									onclick="creatBlock('Novo Cliente', 'cliente_add.php', 'novo_cliente');">
									<td style="height: 10px;
											   width: 32px;">
										<span style="padding-left: 2px;">
											<img src="img/user_add.gif"
												 style="width: 32px;"> 
										</span>
									</td>
									<td style="padding-left: 7px;">
										Novo Cliente
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="height: 3px;
								   background-color: #dedede;">
						</td>
					</tr>
					<tr>
						<td>
							<div id="<?php echo $PREID; ?>ger_processoDivList"
								 style="width: 150px;
										height: 100%;
										float: left;
										overflow-y: auto;
										overflow-x: hidden;">
								Cliente
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td style="width: 5px;
					   height: 100%;
					   overflow: auto;
					   cursor: col-resize;
					   background-color: #dedede;"
				onmousedown="resizeDiv('<?php echo $PREID; ?>ger_processoDivList');">
				&nbsp;
			</td>
			<td style="vertical-align:top;
					   padding: 0px;
					   margin: 0px;
					   width: 100%;
					   height: 100%;
					   overflow: auto;"
				class="gridCell"
			    id="corpo_ger_processo_add">
				<div style="padding: 0px;
						    margin: 0px;
						    text-align: left;
							width: 100%;
							height: 100%;">
					<?php
						if ($_GET['pk_processo'])
						{
							require_once("edit_processo.php");
						}else
							 {
								require_once("processo_add.php");
							 }
					?>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php
	$_GET['apenasClientes'] = false;
	$_GET['component']= 'explorador';
	$_GET['on_click']= "gerenciarProcessosEdit";
	$_GET['containerId']= $PREID_component.'ger_processoDivList';
	include('../components.php');
?>