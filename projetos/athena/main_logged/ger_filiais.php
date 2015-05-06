<?php

// PERMISSÃO
$acessoWeb= 14;

require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
require_once("inc/styles.php");
if(!$db_connection)
{
	include("../connections/flp_db_connection.php");
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
			overflow: auto;">
	<table style="width: 100%;
				  height: 100%;"
		   cellpadding="0"
		   cellspacing="0">
		<tr>
			<td id="list_filiais"
				style="padding-left: 7px;
					   vertical-align:top;
					   padding: 0px;
					   margin: 0px;"
				class="gridCell">
				<table height="100%">
					<tr>
						<td style="height: 10px;">
							<table width="100%">
								<tr onmouseover="this.style.backgroundColor= '#dedede'"
									onmouseout="this.style.backgroundColor= ''"
									onclick="creatBlock('Novo cliente', 'cliente_add.php', 'novo_cliente')">
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
									onclick="getBlock(this).reload();">
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
							<div id="gerFiliaisList"
								 style="width: 150px;
										height: 100%;
										float: left;
										overflow-y: auto;">
								Filiais
							</div>
						</td>
					</tr>
				</table>
				<?php
					//include("ger_filiais_list.php");
				?>
			</td>
			<td style="width: 5px;
					   height: 100%;
					   overflow: auto;
					   cursor: col-resize;
					   background-color: #dedede;"
				onmousedown="resizeDiv('gerFiliaisList');">
				&nbsp;
			</td>
			<td style="vertical-align:top;
					   padding: 0px;
					   margin: 0px;
					   padding-bottom: 10px;"
				class="gridCell"
			    id="corpo_ger_filial_add">
				<?php
					if ($_GET['pk_usuario'])
					{
						include("ger_filiais_edit.php");
					}else
						 {
							require_once("ger_filial_add.php");
						 }
				?>
			</td>
		</tr>
	</table>
</div>
<?php
	$_GET['component']= 'exploradorFilial';
	//$_GET['apenasClientes']= 'true';
	$_GET['on_click']= "gerFiliaisClick";
	//$_GET['componentId']= 'status_processo_add';
	$_GET['containerId']= 'gerFiliaisList';
	include('components.php');
?>