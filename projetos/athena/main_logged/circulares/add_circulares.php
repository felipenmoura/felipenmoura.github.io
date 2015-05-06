<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/class_abas.php");

?>
<?php
	if($_POST)
	{
		@include("../../connections/flp_db_connection.php");
		include("../inc/query_control.php");
		include("../inc/get_sequence.php");
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
		showPost();
		echo '<hr>';
		startQuery($db_connection);
		$pk_msg= getSequence('circulares_seq');
		$_POST['msg_title']= (trim($_POST['msg_title'])== '')? substr(trim($_POST['circularToSend']), 0, 30): $_POST['msg_title'];
		$qr_insert= "INSERT into tb_circulares
							(
								pk_circular,
								s_circular,
								s_titulo,
								fk_sender
							)
					 VALUES (
								".$pk_msg.",
								'".$_POST['circularToSend']."',
								'".$_POST['msg_title']."',
								".$_SESSION['pk_usuario']."
							)";
		$data= @pg_query($db_connection, $qr_insert);
		if(!$data)
		{
			echo $insert."<hr>";
			echo"<script>alert('Falha ao tentar enviar a mensagems')</script>";
			cancelQuery($db_connection);
			exit;
		}
		$destinatarios= $_POST['groupsToSend'];
		echo count($destinatarios);
		for($i=0; $i< count($destinatarios); $i++)
		{
			$qr_insert= "INSERT into tb_circular_grupo
								(
									fk_circular,
									fk_grupo
								)
						 VALUES (
									".$pk_msg.",
									".$destinatarios[$i]."
								)";
			echo $qr_insert;
			$dataMsg= @pg_query($db_connection, $qr_insert);
			if(!$dataMsg)
			{
				?>
					<script>
						top.showAlert('erro', 'Ocorreu um erro inseperado ao tentar enviar esta circular !');
					</script>
				<?php
				exit;
			}
		}
		commitQuery($db_connection);
		?>
			<script>
				top.showAlert('informativo', 'Circular adicionada');
			</script>
		<?php
		exit;
	}
?>
<iframe name="newcircularIframe"
	    style="display: none;">
</iframe>
<form action="circulares/add_circulares.php"
	  target="newcircularIframe"
	  method="POST"
	  id="newcircularForm">
	<table style="height: 100%;
				  width: 100%;">
		<tr>
			<td style="height: 40px;
					   width: 140px;
					   vertical-align: top;
					   overflow: none;"
				rowspan="2">
				Destinat&aacute;rio(s)<br>
				<div style="height: 100%;
							overflow-y: auto;">
					<table width="100%">
						<tr>
							<td colspan="2"
								class="gridCell">
								<input type="checkbox"
									   style=""
									   checked
									   onclick="if(this.checked==true)
												{
													for(var i=0; i< gebi('groupCircularList').getElementsByTagName('INPUT').length; i++)
													{
														gebi('groupCircularList').getElementsByTagName('INPUT')[i].checked = true;
													}
												}else{
														for(var i=0; i< gebi('groupCircularList').getElementsByTagName('INPUT').length; i++)
														{
															gebi('groupCircularList').getElementsByTagName('INPUT')[i].checked = false;
														}
													 }">
								Todos
							</td>
						</tr>
						<tbody id="groupCircularList">
							<?php
								$qr_select= "SELECT pk_grupo,
													dt_update,
													s_label,
													s_obs
											   FROM tb_grupo g
											  ORDER BY s_label";
								$data= @pg_query($db_connection, $qr_select);
								
								while($linha= @pg_fetch_array($data))
								{
									?>
										<tr>
											<td>
												<input type="checkbox"
													   style=""
													   checked
													   value="<?php echo $linha['pk_grupo']; ?>"
													   name="groupsToSend[]">
											</td>
											<td>
												<?php
													echo $linha['s_label'];
												?>
											</td>
										</tr>
									<?php
								}
								
							?>
						</tbody>
					</table>
				</div>
			</td>
			<td style="vertical-align: top;
					   height: 30px;">
				T&iacute;tulo<br>
				<Input type="text"
					   name="msg_title"
					   style="width: 100%;"
					   maxlength="100">
			</td>
		</tr>
		<tr>
			<td>
				<textarea name="circularToSend"
						  id="circularToSend"
						  style="width: 100%;
								 height: 100%;
								 overflow: auto;"
						  onkeyup="if(this.value.length>2000){ this.value= this.value.substring(0,2000); } gebi('circularToSendCharCounter').innerHTML= this.value.length + ' / '+ 2000"></textarea>
			</td>
		</tr>
		<tr>
			<td id="circularToSendCharCounter"
				style="height: 40px;">
				0 / 2000
			</td>
			<td style="text-align: right;
					   padding-right: 7px;
					   height: 40px;">
				<input type="button"
					   value="Enviar"
					   class="botao"
					   onclick="sendCircular('newcircularForm', 'groupCircularList', 'circularToSend');">
			</td>
		</tr>
	</table>
</form>












