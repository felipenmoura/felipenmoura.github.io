<?php
	session_save_path('logados');
	session_name('athenas');
	session_cache_expire(1);
	session_start();
	$_SESSION['lastAccess']= date('His');
	$_SESSION['refreshRate']= ($_SESSION['refreshRate'] == 2)? 1: 2;
	if(trim($_SESSION['pk_usuario'])=="")
	{
		echo " alert('Sua ".urlencode('sessão')." expirou!'); top.close(); ";
	}else{
		 }
	include('config.php');
	include("../connections/flp_db_connection.php");
	$db_connection= @connectTo();
	if(!$db_connection)
	{
		?>
			alert("Ocorreu um problema ao tentar verificar o login !"); 
		<?
		exit;
	}
	//echo ' alert("auto_bkp/'.$_SESSION['pk_usuario'].'_'.$_SESSION['s_usuario'].'.php"); ';	//	AUTO BKP AUTOBKP AUTOSAVE
	// if($conf_autoBKP == 'ON' && $_SESSION['refreshRate'] == 2)
	// {
		// $autoBKP= @fopen("auto_bkp/".$_SESSION['pk_usuario']."_".$_SESSION['s_usuario'].".php", 'wb');
		// @fwrite($autoBKP, $_POST['auto_bkp']);
		//echo $_POST['auto_bkp'];
		//echo "<script>";
		/* echo " top.filho.aplyVariations('".str_replace('
', '', nl2br($_POST['auto_bkp']))."'); "; */
		//echo "</script>";
	//}
?>
<?php
	//	buscando mensagens nao lidas
	$qr_select= "SELECT max(pk_mensagem_usuario) as max
				   FROM tb_mensagem m,
						tb_mensagem_usuario mu
				  WHERE m.pk_msg = mu.fk_msg 
				    AND mu.bl_lida = 0
				    AND mu.fk_usuario = ".$_SESSION['pk_usuario'];
	$data= pg_query($db_connection, $qr_select);
	$linha= pg_fetch_array($data);
	if($_SESSION['lastMsg'] < $linha['max'] && $linha['max']>0)
	{
		$_SESSION['lastMsg']= $linha['max'];
		$qr_select= "SELECT fk_sender,
							pk_msg,
							s_login,
							s_titulo,
							s_msg,
							dt_time,
							TO_CHAR(dt_time, 'DD/MM/YYYY - HH:MI:SS') as data
					   FROM tb_mensagem m,
							tb_mensagem_usuario mu,
							tb_usuario u
					  WHERE m.pk_msg = mu.fk_msg
						AND u.pk_usuario = m.fk_sender
						AND pk_mensagem_usuario = ".$_SESSION['lastMsg']."
				  ";
		$data= @pg_query($db_connection, $qr_select);
		$linhaMsg= pg_fetch_array($data);
		?> 
			top.sideBarAdd('Mensagem recebida', "<span onclick=\"top.filho.creatBlock('Mensagens ', 'mensagens/ger_mensagem.php', 'ger_mensagens', false, false, '520/360'); this.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode);\" style='cursor: pointer;'><b>De: </b><?php echo htmlentities($linhaMsg['s_login']); ?><br>-------------------<br><?php echo htmlentities($linhaMsg['s_titulo']); ?></span>");
			top.callSideBar(0); 
		<?php
	}
?>
<?php
	//echo ' -- '.$_SESSION['grupos'].' -- ';
	$circularesToshow= Array();
	foreach($_SESSION['grupos'] as $grupo)
	{
		
		$qr_select= " SELECT MAX(pk_circular) as max_circular
						FROM tb_circulares c,
							 tb_circular_grupo cg,
							 tb_usuario u
					   WHERE cg.fk_circular = c.pk_circular
						 AND cg.fk_grupo = ".$grupo."
						 AND u.pk_usuario = c.fk_sender
						 AND c.bl_status= 1";
		// $qr_select= " SELECT pk_circular,
							 // s_titulo,
							 // s_login,
							 // fk_sender,
							 // TO_CHAR(dt_time, 'DD/MM/YYYY - HH:MI:SS') as data
						// FROM tb_circulares c,
							 // tb_circular_grupo cg,
							 // tb_usuario u
					   // WHERE cg.fk_circular = c.pk_circular
						 // AND cg.fk_grupo = ".$grupo."
						 // AND u.pk_usuario = c.fk_sender
						 // AND c.bl_status= 1
					// ";
		$data= @pg_query($db_connection, $qr_select);
		$linha= @pg_fetch_array($data);
		if(!$_SESSION['max_circular'] || $linha['max_circular'] > $_SESSION['max_circular'])
		{
			$qr_selectOption= " SELECT pk_opcao_marcada
								  FROM tb_opcao_marcada
								 WHERE fk_usuario = ".$_SESSION['pk_usuario']."
								   AND s_tabela = 'tb_circulares'
								   AND s_campo = 'pk_circular'
								   AND s_valor_campo='".$linha['max_circular']."'";
			$dataOptions= @pg_query($db_connection, $qr_selectOption);
			if(@pg_num_rows($dataOptions) == 0 && $linha['max_circular'])
			{
				$_SESSION['max_circular']= $linha['max_circular'];
				?>
					top.sideBarAdd('Nova Circular', "<span onclick=\"top.filho.creatBlock('Circulares ', 'circulares/ger_circulares.php', 'ger_circulares', false, false, '520/360'); this.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode);\" style='cursor: pointer;'>Clique aqui para visualizar<br>a(s) nova(s) circular(es)</span>");
					top.callSideBar(0);
				<?php
				break;
			}
		}
	}
?>














