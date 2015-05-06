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
	$insert= "INSERT INTO tb_departamento
						(
							s_departamento
						)
				   VALUES
						(
							'".urlencode($_POST['nome'])."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo "<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo departamento'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('departamento'); try{top.c.closeBlock('departamento_add', true);}catch(error){}</script>";
		 }
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="rh/departamento_add.php"
		  target="departamentoFrame"
		  method="POST"
		  id="departamentoForm">
		<input type="hidden"
			   name="nome"
			   id="departamentoNomeValue"
			   maxlength="90">
	</form>
		<table align="center">
			<tr>
				<td>
					Departamento&nbsp;&nbsp;
				</td>
				<td>
					<input type="text"
						   name="nome"
						   id="departamentoNome"
						   onkeyup="document.getElementById('departamentoNomeValue').value= this.value;"
						   maxlength="90">
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('departamentoNome').value.replace(/ /g, '') == '') top.showAlert('alerta', 'O campo <i>departamento</i>&eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('departamentoForm').submit();document.getElementById('departamentoForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="departamentoFrame"
			name="departamentoFrame"
			style="display: none;">
	</iframe>
<?php
?>
</div>