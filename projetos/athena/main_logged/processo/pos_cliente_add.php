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
	$insert= "INSERT INTO tb_pos_cliente
						(
							s_nome
						)
				   VALUES
						(
							'".$_POST['s_nome']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar nova Posição do Cliente'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('pos_cliente'); top.c.closeBlock('nova_pos_cliente_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="processo/pos_cliente_add.php"
		  target="PosClienteAddIframe"
		  method="POST"
		  id="PosClienteAddForm">
		<table>
			<tr>
				<td>
					Nome&nbsp;&nbsp;
				</td>
				<td>
					<input type="text"
						   name="s_nome"
						   id="s_nome_pos_cliente_add"
						   maxlength="90">
				</td>
			</tr>
			</form>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   class="botao"
						   onclick="if(document.getElementById('s_nome_pos_cliente_add').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Nome</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('PosClienteAddForm').submit();document.getElementById('PosClienteAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="PosClienteAddIframe"
			name="PosClienteAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>