<?php
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
	$insert= "INSERT INTO tb_dependencia
						(
							s_nome_tipo
						)
				   VALUES
						(
							'".$_POST['s_nome_tipo']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo Grau de Dependencia'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('dependencia'); top.c.closeBlock('dependencia_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="rh/dependencia_grau_add.php"
		  target="DependenciaGrauAddIframe"
		  method="POST"
		  id="DependenciaGrauAddForm">
		<table>
			<tr>
				<td>
					Grau de Depend&ecirc;ncia
				</td>
				<td>
					<input type="text"
						   name="s_nome_tipo"
						   id="s_nome_tipo"
						   maxlength="90">
				</td>
			</tr>
	</form>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_nome_tipo').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Grau de Dependencia</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('DependenciaGrauAddForm').submit();document.getElementById('DependenciaGrauAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="DependenciaGrauAddIframe"
			name="DependenciaGrauAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>