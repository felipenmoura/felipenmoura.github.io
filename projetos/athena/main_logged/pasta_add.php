<?
//session_start();
require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
require_once("inc/styles.php");
require_once("inc/query_control.php");
require_once("inc/class_explorer.php");
//if(!$db_connection= @connectTo())
	include("../connections/flp_db_connection.php");
$db_connection= connectTo();
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

if($_POST)
{
	showPost();
	$pasta= explode('|+|', $_POST['pastaPasta']);
	$cliente= $pasta[2];
	$tipo= $pasta[1];
	$pastaPai= $pasta[0];
	if($pastaPai == $cliente && trim($tipo == 'cliente'))
		$pastaPai= 'NULL';
	$qr_insert= "INSERT into tb_pasta
						(
							fk_usuario,
							s_nome,
							dt_criacao,
							vfk_pasta_pai
						)
				 VALUES
						(
							'".$cliente."',
							'".$_POST['pastaProcessoNome']."',
							now(),
							".$pastaPai."
						)
				";
	
	$data= pg_query($db_connection, $qr_insert);
	if(!$data)
	{
		?>
			<script>
				top.setLoad(false);
				alert("Erro ao tentar cadastrar o processo");
			</script>
		<?
		exit;
	}else{
			if($_GET['block'])
			{
				?>
					<script>
						top.setLoad(false);
						top.filho.closeBlock('<?php echo $_GET['block']; ?>');
					</script>
				<?php
			}else{
					?>
						<script>
							top.setLoad(false);
						</script>
					<?php
				 }
		 }
	?>
		</script>
	<?php
	exit;
}

?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="pasta_add.php"
		  method="POST"
		  target="pastaHiddenFrame__"
		  id="pasta_addForm">
		<table>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type="text"
						   name="pastaProcessoNome"
						   id="pastaProcessoNome"
						   maxlength="60">
				</td>
			</tr>
			<tr>
				<td>
					Cliente/Pasta
				</td>
				<td>
					<?php
						$_GET['component']= 'explorer';
						$_GET['componentId']= 'pastaPasta';
						$_GET['componentValue']= '';
						$_GET['componentName']= '';
						$_GET['componentTipo']= 'pasta, cliente';
						//$_GET['componentShowAdd']= '';
						require_once('components.php');
					?>
					<?
						//explorerAdd('pastaPasta', '', 'pastaPasta', 'cliente/pasta', false);
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   class="botao"
						   onclick="if(gebi('pastaProcessoNome').value != '' && gebi('pastaPasta').value.replace(/ /g, '') != '')
									{
										top.setLoad(true);
										gebi('pasta_addForm').submit();
									}"
						   Xonclick="top.setLoad(true);
									url=  'pasta_add.php?nome='+ document.getElementById('pastaProcessoNome').value;
									url+= '&cliente='+document.getElementById('pastaPasta').getAttribute('cliente');
									url+= '&tipo='+document.getElementById('pastaPasta').getAttribute('tipo');
									url+= '&code='+document.getElementById('pastaPasta').getAttribute('code');
									document.getElementById('processoPastaHiddenFrame').src= url;">
				</td>
			</tr>
		</table>
	</form>
</div>
<iframe id="pastaHiddenFrame"
		name="pastaHiddenFrame"
		style="display: none;">
</iframe>