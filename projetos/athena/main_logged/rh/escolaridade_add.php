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
	$insert= "INSERT INTO tb_grau_instrucao
						(
							s_grau_instrucao
						)
				   VALUES
						(
							'".$_POST['s_escolaridade']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar nova Escolaridade'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('escolaridade'); top.c.closeBlock('escolaridade_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="rh/escolaridade_add.php"
		  target="EscolaridadeAddIframe"
		  method="POST"
		  id="EscolaridadeAddForm">
		<table>
			<tr>
				<td>
					Escolaridade
				</td>
				<td>
					<input type="text"
						   name="s_escolaridade"
						   id="s_escolaridade"
						   maxlength="90">
				</td>
			</tr>
	</form>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_escolaridade').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Escolaridade</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('EscolaridadeAddForm').submit();document.getElementById('EscolaridadeAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="EscolaridadeAddIframe"
			name="EscolaridadeAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>