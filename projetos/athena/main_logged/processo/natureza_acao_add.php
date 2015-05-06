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
	$insert= "INSERT INTO tb_natureza_acao
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
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo tipo de Natureza da Ação'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('naturezaAcao'); top.c.closeBlock('nova_natureza_da_acao_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="processo/natureza_acao_add.php"
		  target="NaturezaAcaoAddIframe"
		  method="POST"
		  id="NaturezaAcaoAddForm">
		<table>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type="text"
						   name="s_nome"
						   id="s_nome_natureza_da_acao_add"
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
						   id="s_descricao_natureza_da_acao_add"
						   maxlength="90">
				</td>
				</form>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('s_nome_natureza_da_acao_add').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Nome</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('NaturezaAcaoAddForm').submit();document.getElementById('NaturezaAcaoAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="NaturezaAcaoAddIframe"
			name="NaturezaAcaoAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>