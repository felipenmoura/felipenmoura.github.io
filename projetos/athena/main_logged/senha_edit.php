<?
//session_start();
require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
require_once("inc/query_control.php");
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
	<?
	exit;
}
?>
<?
	if($_POST)
	{
		@startQuery($db_connection);
		$qr_update= "UPDATE tb_usuario 
						SET s_senha= '".$_POST['newPwd']."',
							bl_senha= '1'
					  WHERE pk_usuario = ".$_SESSION['pk_usuario']."
						AND s_senha = '".$_POST['oldPwd']."'
					";
		$data= pg_query($db_connection, $qr_update);
		if(pg_affected_rows($data) != 1)
		{
			?>
				<script>
					top.showAlert('alerta','A senha atual não confere')
				</script>
			<?
			@cancelQuery($db_connection);
			exit;
		}else{
				?>
					<script>
						top.showAlert('alerta','Senha alterada com sucesso')
					</script>
				<?
				@commitQuery($db_connection);
				exit;
			 }
		exit;
	}
?>
<form method="POST"
	  action="senha_edit.php"
	  target="senhaEditIframe"
	  name="senhaEditForm"
	  id="senhaEditForm">
	<table>
		<tr>
			<td>
				Senha atual
			</td>
			<td>
				<input type="password"
					   name="oldPwd"
					   id="oldPwd">
			</td>
		</tr>
		<tr>
			<td>
				Nova senha
			</td>
			<td>
				<input type="password"
					   name="newPwd"
					   id="newPwd">
			</td>
		</tr>
		<tr>
			<td>
				Confirma&ccedil;&atilde;o de senha
			</td>
			<td>
				<input type="password"
					   name="reTypeNewPwd"
					   id="reTypeNewPwd">
			</td>
		</tr>
		<tr>
			<td colspan="2"
				style="text-align: center;">
				<input type="button"
					   class="botao"
					   value="Salvar"
					   onclick="if(document.getElementById('oldPwd').value.replace(/ /g, '') == '')
									alert('A senha atual deve ser diferente de nulo');
								else if(document.getElementById('newPwd').value.replace(/ /g, '') == ''
										||
										document.getElementById('reTypeNewPwd').value.replace(/ /g, '') == ''
										||
										document.getElementById('reTypeNewPwd').value.replace(/ /g, '') != document.getElementById('newPwd').value.replace(/ /g, '')
										)
											alert('As novas senhas n&atilde;o conferem ou s&atilde;o nulas');
									  else document.getElementById('senhaEditForm').submit();">
			</td>
		</tr>
	</table>
</form>
<iframe name="senhaEditIframe"
		id="senhaEditIframe"
		style="display: none;">
</iframe>
