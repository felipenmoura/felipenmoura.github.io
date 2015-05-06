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
		$pk_msg= getSequence('mensagem_seq');
		$_POST['msg_title']= (trim($_POST['msg_title'])== '')? substr(trim($_POST['messageToSend']), 0, 30): $_POST['msg_title'];
		$qr_insert= "INSERT into tb_mensagem
							(
								pk_msg,
								s_titulo,
								s_msg,
								fk_sender
							)
					 VALUES (
								".$pk_msg.",
								'".$_POST['msg_title']."',
								'".$_POST['messageToSend']."',
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
		$destinatarios= explode('|@@@|', $_POST['list_funcionarios_msg']);
		$ar_errorAtSend= Array();
		for($i=0; $i< count($destinatarios)-1; $i++)
		{
			$dado= explode('|+|', $destinatarios[$i]);
			$qr_insert= "INSERT into tb_mensagem_usuario
								(
									fk_msg,
									fk_usuario
								)
						 VALUES (
									".$pk_msg.",
									".$dado[0]."
								)";
			echo $qr_insert;
			$dataMsg= @pg_query($db_connection, $qr_insert);
			if(!$dataMsg)
			{
				//cancelQuery($db_connection);
				$dadoTmp= explode('@@@', $dado[$i]);
				array_push($ar_errorAtSend, $dadoTmp[1]);
				echo $dadoTmp[1];
			}
		}
		if(count($ar_errorAtSend) > 0)
		{
			echo"<script>
					top.setLoad(false);
					top.showAlert('erro', 'Falha ao tentar enviar a mensagems para os seguintes destinat&aacute;rios:<br>";
					echo $ar_errorAtSend[1].'<br>';
				for($c=0; $c < count($ar_errorAtSend); $c++)
				{
					$carac= (count($ar_errorAtSend)==0)? '': ($c==count($ar_errorAtSend)-2)? ' e ': ', ';
					echo $ar_errorAtSend[$c].$carac;
				}
			echo"')</script>";
		}else{
				echo"<script>
						top.setLoad(false);
						top.showAlert('informativo', 'Mensagem enviada com sucesso');
						top.filho.document.getElementById('ger_mensagens').reload();
					 </script>";
			 }
		commitQuery($db_connection);
		exit;
	}
?>
<iframe name="newMessageIframe"
	    style="display: none;">
</iframe>
<form action="mensagens/add.php"
	  target="newMessageIframe"
	  method="POST"
	  id="newMessageForm">
	<table style="height: 100%;
				  width: 100%;">
		<tr>
			<td style="height: 40px;
					   width: 230px;">
				<input type="text" 
					   name="list_funcionarios_msg"
					   id="funcMsgListData" 
					   style="display: none;
							  text-align: left;"
					   oldvalue="">
				Destinat&aacute;rio(s)<br>
				<table>
					<tbody id="funcMsgList">
						<tr>
							<td style="padding-right: 3px;">
								<?php
									$_GET['component']= 'explorerFunc';
									$_GET['componentId']= 'msgUserSendFunc';
									$_GET['componentValue']= '';
									require_once('../components.php');
								?>
							</td>
							<td>
								<input type="button"
									   value="+"
									   onclick="exploreLineAdd('<?php echo $PREID; ?>funcMsgList');"
									   class="botao_caract"
									   onmouseover="showtip(this, event, 'Adicionar Linha');">
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td style="vertical-align: top;">
				T&iacute;tulo<br>
				<Input type="text"
					   name="msg_title"
					   style="width: 100%;"
					   maxlength="100">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="messageToSend"
						  id="messageToSend"
						  style="width: 100%;
								 height: 100%;
								 overflow: auto;"
						  onkeyup="if(this.value.length>2000){ this.value= this.value.substring(0,2000); } gebi('messageToSendCharCounter').innerHTML= this.value.length + ' / '+ 2000"></textarea>
			</td>
		</tr>
		<tr>
			<td id="messageToSendCharCounter"
				style="height: 40px;">
				0 / 2000
			</td>
			<td style="text-align: right;
					   padding-right: 7px;">
				<input type="button"
					   value="Enviar"
					   class="botao"
					   onclick="sendUserMessage('newMessageForm', 'funcMsgList', 'messageToSend');">
			</td>
		</tr>
	</table>
</form>












