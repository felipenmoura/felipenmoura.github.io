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
	$insert= "INSERT INTO tb_ramo_atividade
						(
							s_nome,
							s_descricao
						)
				   VALUES
						(
							'".$_POST['nome']."',
							'".$_POST['descricao']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo ramo de atividade'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('ramo_atividade'); try{top.c.closeBlock('ramo_atividade_add', true);}catch(error){}</script>";
		 }
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="ramo_atividade_add.php"
		  target="ramo_atividade_addIframe"
		  method="POST"
		  id="ramoAtividadeAddForm">
		<input type="hidden"
			   name="nome"
			   id="ramoAtividadeAddDescricaoSub"
			   maxlength="90">
		<input type="hidden"
			   name="nome"
			   id="ramoAtividadeAddNomeSub"
			   maxlength="90">
	</form>
		<table>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type="text"
						   name="nome"
						   id="ramoAtividadeAddNome"
						   onkeyup="document.getElementById('ramoAtividadeAddNomeSub').value= this.value;"
						   maxlength="90">
				</td>
			</tr>
			<tr>
				<td>
					Descri&ccedil;&atilde;o
				</td>
				<td>
					<input type="text"
						   name="descricao"
						   id="ramoAtividadeAddDescricao"
						   onkeyup="document.getElementById('ramoAtividadeAddDescricaoSub').value= this.value;"
						   maxlength="200">
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('ramoAtividadeAddNome').value.replace(/ /g, '') == '') top.showAlert('alerta', 'O campo <i>nome</i>&eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('ramoAtividadeAddForm').submit();document.getElementById('ramoAtividadeAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="ramo_atividade_addIframe"
			name="ramo_atividade_addIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>