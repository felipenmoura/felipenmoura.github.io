<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/class_abas.php");
if(!@include("../connections/flp_db_connection.php"))
	@require_once("../../connections/flp_db_connection.php");
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
<?php
	if($_GET['msgToDel'])
	{
		$qr_update= "UPDATE tb_circulares
						SET bl_status= 0
					  WHERE pk_circular = ".$_GET['msgToDel']."
				  ";
		$dataUp= @pg_query($db_connection, $qr_update);
		if(!$dataUp)
		{
			?>
				top.showAlert('erro', 'Ocorreu um erro ao tentar excluir esta mensagem !');
			<?php
		}else{
				?>
					try
					{
						top.filho.document.getElementById('mensagens').reload();
					}catch(error){}
					try
					{
						top.filho.closeBlock('LendoMsg_<?php echo $_GET['msgToDel']; ?>', true);
					}catch(error){}
				<?php
			 }
		exit;
	}
	if($_GET['msgToRead'])
	{
		$qr_select= " SELECT DISTINCT ON (pk_circular)
							 pk_circular,
							 s_titulo,
							 s_login,
							 s_circular,
							 fk_sender,
							 TO_CHAR(dt_time, 'DD/MM/YYYY - HH:MI:SS') as data
						FROM tb_circulares c,
							 tb_circular_grupo cg,
							 tb_usuario u
					   WHERE cg.fk_circular = c.pk_circular
						 AND u.pk_usuario = c.fk_sender
						 AND pk_circular = ". $_GET['msgToRead'] ."
					";
		$data= @pg_query($db_connection, $qr_select);
		
		$qr_selectOptions= " SELECT s_tabela,
									s_campo,
									s_valor_campo,
									fk_usuario
							   FROM tb_opcao_marcada
							  WHERE s_tabela= 'tb_circulares'
							    AND s_campo= 'pk_circular'
								AND s_valor_campo = '".$_GET['msgToRead']."'
								AND fk_usuario= ".$_SESSION['pk_usuario']."
						   ";
		$dataOption= @pg_query($db_connection, $qr_selectOptions);
		if(@pg_num_rows($dataOption) == 0)
		{
			$qr_insert= "INSERT INTO tb_opcao_marcada
									(
										s_tabela,
										s_campo,
										s_valor_campo,
										fk_usuario
									)
								VALUES
									(
										'tb_circulares',
										'pk_circular',
										'".$_GET['msgToRead']."',
										".$_SESSION['pk_usuario']."
									)
					  ";
			$dataIns= @pg_query($db_connection, $qr_insert);
		}
		$linha= pg_fetch_array($data);
		?>
		<div style="width: 100%;
					height: 100%;
					overflow: auto;">
			<table style="width: 100%;
						  height: 100%;"
					border="1">
				<tr>
					<td style="height: 20px;
							   text-align: left;">
						<table>
							<tr>
								<td style="height: 20px;
										   width: 40px;
										   text-align: left;">
									<b>
										T&iacute;tulo:
									</b>
								</td>
								<td>
									<nobr>
										<?php
											echo htmlentities($linha['s_titulo']);
										?>
									</nobr>
								</td>
							</tr>
							<tr>
								<td style="height: 20px;
										   text-align: left;">
									<b>
										De:
									</b>
								</td>
								<td>
									<nobr>
										<?php
											echo htmlentities($linha['s_login']);
										?>
									</nobr>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="height: 20px;">
						<div style="background-color: #ffffce;
								    border: solid 1px black;
								    height: 17px;
									padding-left: 4px;
									padding-right: 4px;">
							<span style="float: left;">
								Data / Hora &nbsp;&nbsp;&nbsp;
							<?php
								echo $linha['data'];
							?>
							</span>
							<?php
								if($_SESSION['pk_usuario'] == $linha['fk_sender'])
								{
									?>
										<span style="float: right;">
											<img src="img/file_delete.gif"
												 style="cursor: pointer;"
												 onmouseover="showtip(this, event, 'Excluir mensagem');"
												 onclick="if(confirm('Tem certeza que deseja excluir esta circular?'))
															{
																onlyEvalAjax('circulares/received_circulares.php?msgToDel=<?php echo $_GET['msgToRead']; ?>', '', 'eval(ajax)');
															}">
										</span>
									<?php
								}
							?>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<textarea style="width: 100%;
										 height: 100%;
										 border: solid 1px black;
										 border-top: none;"
								  readonly><?php
							echo htmlentities($linha['s_circular']);
						?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<?php
		exit;
	}
?>
<?php
	$circularesToshow= Array();
	foreach($_SESSION['grupos'] as $grupo)
	{
		$qr_select= " SELECT pk_circular,
							 s_titulo,
							 s_login,
							 fk_sender,
							 TO_CHAR(dt_time, 'DD/MM/YYYY - HH:MI:SS') as data
						FROM tb_circulares c,
							 tb_circular_grupo cg,
							 tb_usuario u
					   WHERE cg.fk_circular = c.pk_circular
						 AND cg.fk_grupo = ".$grupo."
						 AND u.pk_usuario = c.fk_sender
						 AND c.bl_status= 1
					";
		$data= @pg_query($db_connection, $qr_select);
		while($linha= @pg_fetch_array($data))
		{
			if(!in_array($linha, $circularesToshow))
				array_push($circularesToshow, $linha);
		}
	}
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<table style="width: 100%;">
		<tr>
			<td class="gridTitle">
				De
			</td>
			<td class="gridTitle">
				T&iacute;tulo
			</td>
			<td class="gridTitle">
				Data
			</td>
			<td class="gridTitle"
				style="width: 50px;"
				colspan="1">
				<br>
			</td>
		</tr>
		<?php
			if(@count($circularesToshow) < 1)
			{
				?>
					<tr>
						<td class="gridCell"
							colspan="4">
							N&atilde;o h&aacute; mensagens n&atilde;o lidas
						</td>
					</tr>
				<?php
			}else{
					foreach($circularesToshow as $linha)
					{
						?>
							<tr style=""
								onmouseover="this.style.backgroundColor= '#dedede';"
								onmouseout="this.style.backgroundColor= '';"
								ondblclick="creatBlock('<?php echo htmlentities($linha['s_titulo']); ?>', 'circulares/received_circulares.php?msgToRead=<?php echo $linha['pk_circular']; ?>', 'LendoMsg_<?php echo $linha['pk_circular']; ?>', false, false, '400/300');">
								<td class="gridCell"
									style="text-align: left;">
									<?php
										echo htmlentities($linha['s_login']);
									?>
								</td>
								<td class="gridCell"
									style="text-align: left;">
									<?php
										echo htmlentities($linha['s_titulo']);
									?>
								</td>
								<td class="gridCell">
									<?php
										echo htmlentities($linha['data']);
									?>
								</td>
								<td class="gridCell"
									style="width: 25px;">
									<img src="img/icon_view.gif"
										 style="cursor: pointer;"
										 onmouseover="showtip(this, event, 'Ler Circular')"
										 onclick="creatBlock('<?php echo htmlentities($linha['s_titulo']); ?>', 'circulares/received_circulares.php?msgToRead=<?php echo $linha['pk_circular']; ?>', 'LendoMsg_<?php echo $linha['pk_circular']; ?>', false, false, '400/300');">
								</td>
								<!--
									<td class="gridCell"
										style="width: 25px;">
										<img src="img/file_delete.gif"
										 style="cursor: pointer;"
										 onmouseover="showtip(this, event, 'Excluir mensagem');"
										 onclick="if(confirm('Tem certeza que deseja excluir esta mensagem?'))
													{
														onlyEvalAjax('circulares/received_circulares.php?msgToDel=<?php echo $linha['pk_mensagem_usuario']; ?>', '', 'eval(ajax)');
													}">
									</td>
								-->
							</tr>
						<?php
					}
				 }
		?>
	</table>
</div>