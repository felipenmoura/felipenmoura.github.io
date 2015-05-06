<?php
	if(!$db_connection)
	{
		include("../connections/flp_db_connection.php");
		$db_connection = connectTo();
	}
		
		
	if($_GET['delCli'])
	{
		if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		$qr = "UPDATE tb_dados_pessoais set bl_status= 0 where pk_dados_pessoais= ".$_GET['delCli'];
		$data= pg_query($db_connection, $qr);
		if(!$data)
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o'); ";
		//echo "alert('excluindo ".$_GET['delCli']."'); ";
		echo " top.filho.atualiza(top.filho.document.getElementById('corpo_ger_cliente_add')); ";
		exit;
	}
	
?>
<?php
	$_GET['component']		= 'explorador';
	$_GET['apenasClientes']	= true;
	$_GET['dpl_click']		= "gerClienteClick";
	$_GET['containerId']	= 'gerClientesList';
	$_GET['on_click']		= "gerClienteClick";
	$_GET['componentTipo']	= 'cliente';
	include('components.php');
?>