<?php
// PERMISSÃO
$acessoWeb = 1;

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
	$insert= "INSERT INTO tb_processo_nome_interno
						(
							s_nome_interno,
							s_descricao
						)
				   VALUES
						(
							'".$_POST['s_nome_interno']."',
							'".$_POST['s_descricao']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo tipo de telefone'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('tipoFone'); top.c.closeBlock('tipo_telefone_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="processo_nome_interno_add.php"
		  target="ProcessoNomeInternoAddIframe"
		  method="POST"
		  id="ProcessoNomeInternoAddForm">
		<table>
			<tr>
				<td>
					Nome Interno&nbsp;
				</td>
				<td>
					<input type="text"
						   name="s_nome_interno"
						   id="s_nome_interno_processo"
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
						   id="s_descricao_nome_interno_processo"
						   maxlength="90">
				</td>
				</form>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_nome_interno_processo').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Nome Interno</i>&eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('ProcessoNomeInternoAddForm').submit();document.getElementById('ProcessoNomeInternoAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="ProcessoNomeInternoAddIframe"
			name="ProcessoNomeInternoAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>