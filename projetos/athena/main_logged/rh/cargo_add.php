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
	$insert= "INSERT INTO tb_cargo
						(
							s_cargo
						)
				   VALUES
						(
							'".urlencode($_POST['nome'])."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo "<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo cargo'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('cargo'); try{top.c.closeBlock('cargo_add', true);}catch(error){}</script>";
		 }
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="rh/cargo_add.php"
		  target="cargoFrame"
		  method="POST"
		  id="cargoForm">
		<input type="hidden"
			   name="nome"
			   id="cargoNomeValue"
			   maxlength="90">
	</form>
		<table align="center">
			<tr>
				<td>
					Cargo&nbsp;&nbsp;
				</td>
				<td>
					<input type="text"
						   name="nome"
						   id="cargoNome"
						   onkeyup="document.getElementById('cargoNomeValue').value= this.value;"
						   maxlength="90">
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('cargoNome').value.replace(/ /g, '') == '') top.showAlert('alerta', 'O campo <i>cargo</i>&eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('cargoForm').submit();document.getElementById('cargoForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="cargoFrame"
			name="cargoFrame"
			style="display: none;">
	</iframe>
<?php
?>
</div>