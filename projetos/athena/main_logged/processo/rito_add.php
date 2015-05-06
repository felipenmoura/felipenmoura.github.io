<?php

// PERMISSÃO
$acessoWeb = 1;

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
	$insert= "INSERT INTO tb_rito
						(
							s_nome,
							s_descricao
						)
				   VALUES
						(
							'".$_POST['s_nome']."',
							'".$_POST['s_descricao']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); top.showAlert('erro', 'Falha ao tentar cadastrar novo Rito'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('rito'); top.c.closeBlock('novo_rito_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="processo/rito_add.php"
		  target="RitoAddIframe"
		  method="POST"
		  id="RitoAddForm">
		<table>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type="text"
						   name="s_nome"
						   id="s_nome_rito_add"
						   maxlength="90">
				</td>
			</tr>
		</form>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_nome_rito_add').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Nome</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('RitoAddForm').submit();document.getElementById('RitoAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="RitoAddIframe"
			name="RitoAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>