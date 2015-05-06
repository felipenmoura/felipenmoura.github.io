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
	$insert= "INSERT INTO tb_beneficio
						(
							s_nome
						)
				   VALUES
						(
							'".$_POST['nome']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo "<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo benefício'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('beneficio'); try{top.c.closeBlock('beneficio_add', true);}catch(error){}</script>";
		 }
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="rh/beneficio_add.php"
		  target="beneficioFrame"
		  method="POST"
		  id="beneficioForm">
		<input type="hidden"
			   name="nome"
			   id="beneficioNomeValue"
			   maxlength="90">
	</form>
		<table align="center">
			<tr>
				<td>
					Beneficio&nbsp;&nbsp;
				</td>
				<td>
					<input type="text"
						   name="nome"
						   id="beneficioNome"
						   onkeyup="document.getElementById('beneficioNomeValue').value= this.value;"
						   maxlength="90">
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('beneficioNome').value.replace(/ /g, '') == '') top.showAlert('alerta', 'O campo <i>beneficio</i>&eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('beneficioForm').submit();document.getElementById('beneficioForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="beneficioFrame"
			name="beneficioFrame"
			style="display: none;">
	</iframe>
<?php
?>
</div>