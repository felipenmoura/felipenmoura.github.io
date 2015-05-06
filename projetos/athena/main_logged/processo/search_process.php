<?php 
// PERMISSÃO
//$acessoWeb= ; // Incluir nas Permissões

require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/class_explorer.php");
require_once("../inc/class_abas.php");
require_once("../../connections/flp_db_connection.php");
$db_connection= @connectTo();
$PREID= 'processo_viewer_id';

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

//if ($_GET['key_search'])
if ($_POST)
{
	$key = $_POST['key_search'];
	//$key = $_GET['key_search'];
	$qr = "SELECT pk_processo,
				  s_nome,
				  s_numero
			 FROM tb_processo
			WHERE upper(s_nome) like upper('%".$key."%')
			   OR s_numero like'%".$key."%'";	
	$data= pg_query($db_connection, $qr);
	$numRows = pg_num_rows($data);
	if ($data)
	{
		?>
			<div id="processosViewerDivPai"
				  style="width:100%;
						 height: 100%;
						 overflow: auto;">
				<table width="100%">
					<tr>
						<td class="gridTitle">
							Nome
						</td>
						<td class="gridTitle">
							N&uacute;mero
						</td>
					</tr>
				<?php
				if (!$numRows)
				{
					echo "	<tr>
								<td class='gridCell'>
									<font color='red'>
										Nenhum Registro Encontrado...
									</font>
								</td>
							</tr>";
				}
				
				while($arrayProc = pg_fetch_array($data))
				{
					?>
						<tr onmouseover="this.style.backgroundColor= '<? echo $style['unSubItem']['bgMouseOver']; ?>'"
							onmouseout="this.style.backgroundColor= '<? echo $style['unSubItem']['backGround']; ?>';"
							onclick="creatBlock('<?php echo $arrayProc['s_nome'] ;?>', 'processo/processo_view_data.php?pk_processo=<?php echo $arrayProc['pk_processo'] ?>')">
							<td class="gridCell"
								style="text-align:left;
									   cursor:pointer">
								<?php
									{
										echo str_replace("'", "\'", htmlentities($arrayProc['s_nome']));
									}
								?>
							</td>
							<td class="gridCell"
								style="text-align:center;
									   cursor:pointer;
									   width: 40px;">
								<?php
									echo $arrayProc['s_numero'];
								?>
							</td>
						</tr>
					<?php
				}
				?>
				</table>
			</div>
			<script>
				top.filho.document.getElementById('processos_viewer_list').innerHTML = document.getElementById('processosViewerDivPai').innerHTML; 
			</script>
		<?php
	}
}
?>