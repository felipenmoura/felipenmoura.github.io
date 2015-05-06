<?
	require_once("inc/valida_sessao.php");
	require_once("inc/calendar_input.php");
	require_once("inc/styles.php");
	require_once("inc/query_control.php");
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
?>
<?php
	//$PREID= $_GET['preId'];
	if(!$_GET['explorerReturn'])
	{
		$PREID= date('ymdhis').microtime();
		$PREID= str_replace('.', '', str_replace(' ', '', $PREID));
	}else $PREID= "returning_";
	//echo $PREID;
?>

	<table style="width: 100%;
				  height: 100%;">
		<tr>
			<td style="">
				<div id="<?php echo $PREID; ?>div_tree"
					 style="<?php
								if(!$_GET['explorerReturn'])
									echo "width: 200px;";
								else
									echo "width: 100%;";
							?>
							height: 100%;
							overflow: auto;
							background-color:#f5f5f5;
							border: 1px solid Silver;
							float: left;">
					Filiais
				</div>
				<div style="width: 5px;
							height: 100%;
							float: left;
							cursor: col-resize;"
					 onmousedown="resizeDiv('<?php echo $PREID; ?>div_tree');">
				</div>
				<div id="<?php echo $PREID; ?>div_nav"
					 style="width: 100%;
							height: 100%;
							overflow: auto;
							background-color:#f5f5f5;
							border: 1px solid Silver;">
					aqui virao as pastas e as op&ccedil;&otilde;es
				</div>
			</td>
		</tr>
		<tr>
			<td style="height: 30px;
					   text-align: center;">
				<div style="width: 100%;
							height: 100%;
							overflow-y: auto;
							background-color:#f5f5f5;
							border :1px solid Silver;
							text-aqlign: center;">
				<?php
					if($_GET['explorerReturn'])
					{
						?>
							<input type="button"
								   class="botao"
								   value="Ok"
								   onclick="retornaSelecao(this)">
							<input type="button"
								   class="botao"
								   value="Cancelar"
								   onclick="closeBlock(getBlock(this).id);">
						<?php
					}else{
							?>
								<input type="button"
									   class="botao"
									   value="Fechar"
									   onclick="closeBlock(getBlock(this).id);">
							<?php
						 }
				?>
				</div>
			</td>
		</tr>
	</table>
<?php
	$_GET['component']= 'exploradorFilial';
	//$_GET['apenasClientes']= 'true';
	//$_GET['dpl_click']= "gercontatoClick";
	//$_GET['componentId']= 'status_processo_add';
	$_GET['containerId']= $PREID.'div_tree';
	include('components.php');
	exit;
?>