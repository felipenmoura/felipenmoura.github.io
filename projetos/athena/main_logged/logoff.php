<?php
	//include('inc/valida_sessao.php');
	if(is_dir('main_logged/logados'))
		@session_save_path('main_logged/logados');
	else
		@session_save_path('logados');
	@session_name('athenas');
	@session_start(1);
	include("../connections/flp_db_connection.php");
	$db_connection= connectTo();
	if(!$db_connection)
	{
		?>
			<flp_script>
				alert("Ocorreu um problema ao tentar verificar o login !");
		<?
		exit;
	}
	$obs= '';
	$qr_insert= "INSERT INTO tb_logs
					(
						fk_usuario,
						s_obs,
						s_ip,
						bl_movimento
					)
				 VALUES
					(
						".$_SESSION['pk_usuario'].",
						'".$obs."',
						'".$_SERVER[REMOTE_ADDR]."',
						'out'
					)";
	$data= @pg_query($db_connection, $qr_insert);
	$_SESSION['pk_usuario'] = false;
	session_destroy();
	session_unset();
	//echo "Ocorreu um erro inesperado ao tentar o logoff<br>&eacute; poss&iacute;vel que sua sess&atilde;o ainda esteja ativa";
	//@header("Location: http://".$_SERVER['HTTP_HOST']."".$_SERVER['PHP_SELF']."../../../index.php");
?>
<script>
	top.location.href= "http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'../../../index.php';?>";
</script>