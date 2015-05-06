<?

// PERMISSÃO
$acessoWeb= 19;

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
	$qr_insert= "INSERT INTO tb_grupo
						(
							fk_agencia,
							s_label,
							s_obs
						)
					  VALUES
					    (
							".$_SESSION['pk_agencia'].",
							'".$_POST['group_name']."',
							'".$_POST['grupo_observacao_add']."'
						)
				";
	$data= pg_query($db_connection, $qr_insert);
	if($data)
	{
		?>
 		    <script>
				top.setLoad(false);
				top.filho.atualizaComponents('usuario_grupo');
				if(top.filho.document.getElementById('funcionarioAddGruposList'))
				{
					top.filho.document.getElementById('funcionarioAddGruposList').innerHTML= "Carregando dados...";
					top.filho.onlyEvalAjax('rh/funcionario_add_grupos_list.php', '', "top.filho.document.getElementById('funcionarioAddGruposList').innerHTML= ajax; ");
				}
				//top.c.closeBlock('usuario_grupo_add');
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
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<br>
	<form id="usuarioGrupoAddForm"
		  name="usuarioGrupoAddForm"
		  method="POST"
		  action="usuario_grupo_add.php"
		  target="hiddenFrame">
		<table>
			<tr>
				<td>
					Nome &nbsp;
				</td>
				<td>
					<input type="text"
						   name="group_name"
						   id="group_name_add"
						   maxlength="30"
						   style="width: 170px;">
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;">
					Observa&ccedil;&atilde;o &nbsp;
				</td>
				<td>
					<textarea name="grupo_observacao_add"
							  id="grupo_observacao_add"
							  style="width: 170px;
									 height: 100px;"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;
						   padding-top: 5px;">
					<input type="button"
						   value="Salvar"
						   class="botao"
						   onclick="if(document.getElementById('group_name_add').value.replace(/ /g, '') == '') alert('O campo nome é obrigatório'); else {top.setLoad(true); document.getElementById('usuarioGrupoAddForm').submit(); document.getElementById('usuarioGrupoAddForm').reset(); }">
				</td>
			</tr>
		</table>
	</form>
</div>
