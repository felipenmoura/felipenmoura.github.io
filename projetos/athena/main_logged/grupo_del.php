<?php
	//session_start();
	require_once("inc/valida_sessao.php");
	if(!$db_connection)
	{
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
	}
	$qr_delete= "DELETE
				   FROM tb_grupo
				  WHERE pk_grupo=".$_GET['pk_grupo'];
	$data= @pg_query($db_connection, $qr_delete);
	if(@pg_num_rows($data) > 0)
	{
		echo "top.showAlert('erro', 'Este grupo ainda contem usu&aacute;rio(s) cadastrado(s)');";
		exit;
	}
	if(!$data)
	{
		echo "top.showAlert('erro', 'Falha ao tentar excluir este grupo !');";
		exit;
	}else{
			echo "top.filho.getBlock(top.filho.document.getElementById('ger_usuario_user_list')).reload();";
			exit;
		 }
?>