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
	$insert= "INSERT INTO tb_mov_processo
						(
							fk_processo,
							dt_data,
							s_texto
						)
				   VALUES
						(
							'".$_POST['']."',
							'".$_POST['']."',
							'".$_POST['']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar nova movimentação'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('naturezaAcao'); top.c.closeBlock('nova_natureza_da_acao_add');</script>";
		 }
		 exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;
			padding:5px">
	<form action="processo/mov_proc_add.php"
		  target="MovProcAddIframe"
		  method="POST"
		  id="MovProcAddForm">
		<table>
			<tr>
				<td>
					Data
				</td>
				<td>
				   <?php
						makeCalendar($PREID.'dt_data_mov_proc_add', '');
					?>
				</td>
			</tr>
			<tr>
				<td>
					Texto
				</td>
				<td>
					<textarea style="width:147px;height:45px"
							  type="text"
						      name="s_texto"
						      id="s_texto_mov_proc_add"></textarea>
				</td>
				</form>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   onclick="if(document.getElementById('dt_data_mov_proc_add').value.replace(/ /g, '') == '') top.showAlert('Alerta', 'O campo <i>Data</i> &eacute; obrigat&oacute;rio'); else{ top.setLoad(true); document.getElementById('MovProcAddForm').submit();document.getElementById('MovProcAddForm').reset();}">
				</td>
			</tr>
		</table>
	<iframe id="MovProcAddIframe"
			name="MovProcAddIframe"
			style="display: none;">
	</iframe>
<?php
?>
</div>