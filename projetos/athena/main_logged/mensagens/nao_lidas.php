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
		$qr_update= "UPDATE tb_mensagem_usuario
						SET bl_lida= -1
					  WHERE pk_mensagem_usuario = ".$_GET['msgToDel']."
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
						top.filho.document.getElementById('ger_mensagens').reload();
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
		$qr_select= "SELECT fk_sender,
						pk_msg,
						s_login,
						s_titulo,
						s_msg,
						dt_time,
						TO_CHAR(dt_time, 'DD/MM/YYYY - HH:MI:SS') as data
				   FROM tb_mensagem m,
						tb_mensagem_usuario mu,
						tb_usuario u
				  WHERE m.pk_msg = mu.fk_msg
					AND u.pk_usuario = m.fk_sender
					AND pk_mensagem_usuario = ".$_GET['msgToRead']."
				  ";
		$data= @pg_query($db_connection, $qr_select);
		
		$qr_update= "UPDATE tb_mensagem_usuario
						SET bl_lida= 1
					  WHERE pk_mensagem_usuario = ".$_GET['msgToRead']."
				  ";
		$dataUp= @pg_query($db_connection, $qr_update);
		
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
							<span style="float: right;">
								<img src="img/file_delete.gif"
									 style="cursor: pointer;"
									 onmouseover="showtip(this, event, 'Excluir mensagem');"
									 onclick="if(confirm('Tem certeza que deseja excluir esta mensagem?'))
												{
													onlyEvalAjax('mensagens/nao_lidas.php?msgToDel=<?php echo $_GET['msgToRead']; ?>', '', 'eval(ajax)');
												}">
							</span>
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
							echo htmlentities($linha['s_msg']);
						?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<flp_script>
			try
			{
				document.getElementById('ger_mensagens').reload();
			}catch(error){}
		<?php
		exit;
	}
?>
<?php
	$qr_select= "SELECT pk_mensagem_usuario,
						fk_sender,
						pk_msg,
						s_login,
						s_titulo,
						dt_time,
						TO_CHAR(dt_time, 'DD/MM/YYYY - HH:MI:SS') as data
				   FROM tb_mensagem m,
						tb_mensagem_usuario mu,
						tb_usuario u
				  WHERE m.pk_msg = mu.fk_msg
				    AND mu.fk_usuario = ".$_SESSION['pk_usuario']."
					AND u.pk_usuario = m.fk_sender
					AND bl_lida = 0
				  ORDER BY dt_time desc";
	$data= @pg_query($db_connection, $qr_select);
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
				colspan="2">
				<br>
			</td>
		</tr>
		<?php
			if(@pg_num_rows($data) < 1)
			{
				?>
					<tr>
						<td class="gridCell"
							colspan="5">
							N&atilde;o h&aacute; mensagens n&atilde;o lidas
						</td>
					</tr>
				<?php
			}else{
					while($linha= @pg_fetch_array($data))
					{
						?>
							<tr style=""
								onmouseover="this.style.backgroundColor= '#dedede';"
								onmouseout="this.style.backgroundColor= '';"
								ondblclick="creatBlock('<?php echo htmlentities($linha['s_titulo']); ?>', 'mensagens/nao_lidas.php?msgToRead=<?php echo $linha['pk_mensagem_usuario']; ?>', 'LendoMsg_<?php echo $linha['pk_mensagem_usuario']; ?>', false, false, '400/300');">
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
										 onmouseover="showtip(this, event, 'Ler mensagem')"
										 onclick="creatBlock('<?php echo htmlentities($linha['s_titulo']); ?>', 'mensagens/nao_lidas.php?msgToRead=<?php echo $linha['pk_mensagem_usuario']; ?>', 'LendoMsg_<?php echo $linha['pk_mensagem_usuario']; ?>', false, false, '400/300');">
								</td>
								<td class="gridCell"
									style="width: 25px;">
									<img src="img/file_delete.gif"
									 style="cursor: pointer;"
									 onmouseover="showtip(this, event, 'Excluir mensagem');"
									 onclick="if(confirm('Tem certeza que deseja excluir esta mensagem?'))
												{
													onlyEvalAjax('mensagens/nao_lidas.php?msgToDel=<?php echo $linha['pk_mensagem_usuario']; ?>', '', 'eval(ajax)');
												}">
								</td>
							</tr>
						<?php
					}
				 }
		?>
	</table>
</div>