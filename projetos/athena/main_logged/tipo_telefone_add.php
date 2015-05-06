<?php
//session_start();
require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");

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
	<?php
	exit;
}

if($_POST)
{
	$insert= "INSERT INTO tb_tipo_telefone
						(
							s_tipo_telefone
						)
				   VALUES
						(
							'".$_POST['nome']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo "<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo tipo de telefone'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('tipoFone'); try{top.c.closeBlock('tipo_telefone_add', true);}catch(error){}</script>";
		 }
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="tipo_telefone_add.php"
		  target="tipoTelefoneAddIframe"
		  method="POST"
		  id="tipoTelefoneAddForm">
		<input type="hidden"
			   name="nome"
			   id="tipoTelefoneAddNomeSub"
			   maxlength="90">
	</form>
		<table align="center">
			<tr>
				<td>
					Nome&nbsp;&nbsp;
				</td>
				<td>
					<input type="text"
						   name="nome"
						   id="tipoTelefoneAddNome"
						   onkeyup="document.getElementById('tipoTelefoneAddNomeSub').value= this.value;"
						   maxlength="90">
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('tipoTelefoneAddNomeSub').value.replace(/ /g, '') == '') top.showAlert('alerta', 'O campo <i>nome</i>&eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('tipoTelefoneAddForm').submit();document.getElementById('tipoTelefoneAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="tipoTelefoneAddIframe"
			name="tipoTelefoneAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>