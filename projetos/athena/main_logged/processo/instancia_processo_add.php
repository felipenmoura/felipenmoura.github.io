<?php
// PERMISS�O
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
	$insert= "INSERT INTO tb_instancia_processo
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
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar nova Instancia do Processo'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('instanciaProcesso'); top.c.closeBlock('nova_instancia_processo_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="processo/instancia_processo_add.php"
		  target="InstanciaProcessoAddIframe"
		  method="POST"
		  id="InstanciaProcessoAddForm">
		<table>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type="text"
						   name="s_nome"
						   id="s_nome_instancia_processo_add"
						   maxlength="90">
				</td>
			</tr>
			<tr>
				<td>
					Descri&ccedil;&atilde;o&nbsp;
				</td>
				<td>
					<input type="text"
						   name="s_descricao"
						   id="s_descricao_instancia_processo_add"
						   maxlength="90">
				</td>
				</form>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_nome_instancia_processo_add').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Nome</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('InstanciaProcessoAddForm').submit();document.getElementById('InstanciaProcessoAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="InstanciaProcessoAddIframes"
			name="InstanciaProcessoAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>