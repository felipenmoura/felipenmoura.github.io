<?
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
	<?
	exit;
}
if($_POST['group_name'])
{
	$qr_insert= "UPDATE tb_grupo
					SET s_label   = '".$_POST['group_name']."', s_obs	  = '".$_POST['grupo_observacao_add']."'
				  WHERE pk_grupo = ".$_POST['pk_grupo_to_edit'];
	$data= pg_query($db_connection, $qr_insert);
	if($data)
	{
		?>
			<script>
				top.setLoad(false);
				try
				{
					top.c.closeBlock('usuario_grupo_edit', true);
				}catch(error){}
			</script>
		<?
	}else{
			?>
				<script>
					top.setLoad(false);
					alert('Ocorreu um erro ao tentar cadastrar o grupo');
				</script>
			<?
		 }
		 exit;
}
	$select= "SELECT s_label,
					 s_obs
				FROM tb_grupo
			   WHERE pk_grupo = ".$_GET['pk_grupo_to_edit'];
	$data= pg_query($db_connection, $select);
	$linha= pg_fetch_array($data);
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<br>
	<form id="usuarioGrupoEditForm"
		  name="usuarioGrupoEditForm"
		  method="POST"
		  action="usuario_grupo_edit.php"
		  target="hiddenFrame">
		<table>
			<tr>
				<td>
					Nome &nbsp;
				</td>
				<td>
					<input type="text"
						   name="group_name"
						   id="group_name_edit"
						   style="width: 170px;"
						   value="<? echo htmlentities($linha['s_label']); ?>"
						   oldvalue="<? echo htmlentities($linha['s_label']); ?>">
					<input type="hidden"
						   name="pk_grupo_to_edit"
						   id="group_pk_edit"
						   style="width: 170px;"
						   value="<? echo $_GET['pk_grupo_to_edit']; ?>"
						   oldvalue="<? echo $_GET['pk_grupo_to_edit']; ?>">
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;">
					Observa&ccedil;&atilde;o &nbsp;
				</td>
				<td>
					<textarea name="grupo_observacao_add"
							  id="grupo_observacao_edit"
							  style="width: 170px;
									 height: 100px;"
							  oldvalue="<? echo htmlentities($linha['s_obs']); ?>"><? echo htmlentities($linha['s_obs']); ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;
						   padding-top: 5px;">
					<input type="button"
						   value="Salvar"
						   class="botao"
						   onclick="if(document.getElementById('group_name_edit').value.replace(/ /g, '') == '') alert('O campo nome é obrigatório'); else {top.setLoad(true); document.getElementById('usuarioGrupoEditForm').submit()}">
				</td>
			</tr>
		</table>
	</form>
</div>
