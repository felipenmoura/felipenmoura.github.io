<?
	if(!$db_connection)
	{
		include("../connections/flp_db_connection.php");
		$db_connection = connectTo();
	}
		
	if($_GET['delContato'])
	{
		$qr = "UPDATE tb_dados_pessoais set bl_status= 0 where pk_dados_pessoais= ".$_GET['delContato'];
		$data= pg_query($db_connection, $qr);
		if(!$data)
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o'); ";
		echo " top.filho.atualiza(top.filho.document.getElementById('corpo_ger_contato_add')); ";
		exit;
	}
?>