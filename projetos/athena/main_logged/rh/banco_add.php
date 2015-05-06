<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
include("../../connections/flp_db_connection.php");
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

if($_POST)
{
	$insert= "INSERT INTO tb_banco
						(
							s_banco
						)
				   VALUES
						(
							'".$_POST['s_banco_nome']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); top.showAlert('erro', 'Falha ao tentar cadastrar novo Banco'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('banco'); top.c.closeBlock('banco_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="rh/banco_add.php"
		  target="BancoAddIframe"
		  method="POST"
		  id="BancoAddForm">
		<table>
			<tr>
				<td>
					Banco
				</td>
				<td>
					<input type="text"
						   name="s_banco_nome"
						   id="s_banco_nome"
						   maxlength="90">
				</td>
			</tr>
	</form>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_banco_nome').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Banco</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('BancoAddForm').submit();document.getElementById('BancoAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="BancoAddIframe"
			name="BancoAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>