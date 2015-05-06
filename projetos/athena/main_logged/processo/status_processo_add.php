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
	$insert= "INSERT INTO tb_status_processo
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
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo status de processo'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('statusProcesso'); top.c.closeBlock('novo_status_processo_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;
			padding-top:15px;
			padding-left:15px;">
	<form action="processo/status_processo_add.php"
		  target="StatusProcessAddIframe"
		  method="POST"
		  id="StatusProcessoAddForm">
		<table>
			<tr>
				<td>
					Nome&nbsp;&nbsp;
				</td>
				<td>
					<input type="text"
						   name="s_nome"
						   id="s_nome_status_processo"
						   maxlength="90">
				</td>
			</tr>
	</form>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   class="botao"
						   value="Salvar"
						   onclick="if(document.getElementById('s_nome_status_processo').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Nome</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('StatusProcessoAddForm').submit();document.getElementById('StatusProcessoAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="StatusProcessAddIframe"
			name="StatusProcessAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>