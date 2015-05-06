<?php

// PERMISSÃO
$acessoWeb= 8;

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
			overflow: auto;">
	<table style="width: 100%;
				  height: 100%;
				  overflow: auto;"
		   cellpadding="0"
		   cellspacing="0">
		<tr>
			<td id="list_clientes"
				style="padding-left: 7px;
					   vertical-align:top;
					   padding: 0px;
					   margin: 0px;
					   text-align: left;"
				class="gridCell">
				<?php
					//include("ger_clientes_list.php");
				?>
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
											<img src="img/user_add.gif"
												 style="width: 32px;"> 
										</span>
									</td>
									<td style="padding-left: 7px;">
										Novo Cliente
									</td>
								</tr>
								<tr onmouseover="this.style.backgroundColor= '#dedede'"
									onmouseout="this.style.backgroundColor= ''"
									onclick="creatBlock('Novo contato para empresa', 'agenda_contato_empresa.php', 'agenda_contato_empresa');">
									<td style="height: 10px;
											   width: 32px;">
										<span style="padding-left: 2px;">
											<img src="img/contato_add.gif"
												 style="width: 32px;"> 
										</span>
									</td>
									<td style="padding-left: 7px;">
										Novo Contato
									</td>
								</tr>
								<tr onmouseover="this.style.backgroundColor= '#dedede'"
									onmouseout="this.style.backgroundColor= ''"
									onclick="creatBlock('Nova filial', 'agenda_contato_filial.php', 'agenda_contato_filial');">
									<td style="height: 10px;
											   width: 32px;">
										<span style="padding-left: 2px;">
											<img src="img/filial_add.gif"
												 style="width: 32px;"> 
										</span>
									</td>
									<td style="padding-left: 7px;">
										Nova Filial
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
							<div id="gerClientesList"
								 style="width: 150px;
										height: 100%;
										float: left;
										overflow-y: auto;
										overflow-x: hidden;">
								Clientes
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
				onmousedown="resizeDiv('<?php echo $PREID; ?>gerClientesList');">
				&nbsp;
			</td>
			<td style="vertical-align:top;
					   padding: 0px;
					   margin: 0px;
					   width: 100%;
					   height: 100%;
					   overflow: auto;"
				class="gridCell"
			    id="corpo_ger_cliente_add">
				<div style="padding: 0px;
						    margin: 0px;
						    text-align: left;
							width: 100%;
							height: 100%;">
					<?php
						if ($_GET['pk_usuario'])
						{
							include("ger_cliente_edit.php");
						}else
							 {
								require_once("ger_cliente_add.php");
							 }
					?>
				</div>
			</td>
		</tr>
	</table>
	
</div>
<?php
	$_GET['component']= 'explorador';
	$_GET['apenasClientes']= true;
	$_GET['dpl_click']= "gerClienteClick";
	$_GET['containerId']= 'gerClientesList';
	$_GET['on_click']= "gerClienteClick";
	include('components.php');
?>