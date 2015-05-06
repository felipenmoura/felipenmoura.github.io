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
	$insert= "INSERT INTO tb_banco_operacao
						(
							s_operacao
						)
				   VALUES
						(
							'".$_POST['s_operacao']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar nova opera&ccedil;&atilde;o'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('operacao'); top.c.closeBlock('operacao_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="rh/operacao_add.php"
		  target="operacaoAddFormFrame"
		  method="POST"
		  id="operacaoAddForm">
		<table>
			<tr>
				<td>
					Opera&ccedil;&atilde;o
				</td>
				<td>
					<input type="text"
						   name="s_operacao"
						   id="s_operacao"
						   maxlength="90">
				</td>
			</tr>
	</form>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_operacao').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Operacao</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('operacaoAddForm').submit(); document.getElementById('operacaoAddFormFrame').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="operacaoAddFormFrame"
			name="operacaoAddFormFrame"
			style="display: none;">
	</iframe>
<?php
?>
</div>