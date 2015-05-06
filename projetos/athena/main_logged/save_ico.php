<?php
	include("inc/valida_sessao.php");
	include("../connections/flp_db_connection.php");
	include("inc/f2j_elo.php");
	$db_connection= @connectTo();
	if(!$db_connection)
	{
		?>
			<flp_script>
				alert("Ocorreu um problema ao tentar verificar o login !");
		<?
		exit;
	}
	
	$receivedIco= f2j_elo($_POST['icone']);
	if($_GET['move'])
	{
		$qr_delete= "DELETE FROM tb_atalho WHERE fk_usuario = ".$_SESSION['pk_usuario']."
							 AND s_titulo= '".$receivedIco['tt']."'
							 AND s_img_src= '".$receivedIco['imageURL']."'
							 AND s_table_id= '".$receivedIco['idToOpen']."'
							 AND s_title= '".$receivedIco['ttToOpen']."'
							 AND s_url= '".$receivedIco['urlToOpen']."'
							 AND s_conf= '".$receivedIco['especificToOpen']."'
							 AND s_tam='".$receivedIco['tamToOpen']."'";
		$data= pg_query($db_connection, $qr_delete);
		if(!$data)
		{
			echo "false";
			exit;
		}
	}
	$qr_insert= "INSERT INTO tb_atalho
					(
						fk_usuario,
						s_titulo,
						s_img_src,
						s_table_id,
						s_title,
						s_url,
						s_conf,
						s_tam,
						i_left,
						i_top
					)
				 VALUES
					(
						".$_SESSION['pk_usuario'].",
						'".$receivedIco['tt']."',
						'".$receivedIco['imageURL']."',
						'".$receivedIco['idToOpen']."',
						'".$receivedIco['ttToOpen']."',
						'".$receivedIco['urlToOpen']."',
						'".$receivedIco['especificToOpen']."',
						'".$receivedIco['tamToOpen']."',
						'".$receivedIco['offsetLeft']."',
						'".$receivedIco['offsetTop']."'
					)
				";
	$data= pg_query($db_connection, $qr_insert);
	if(!$data)
	{
		echo "false";
		exit;
	}
	//print_r($receivedIco);
	echo "true";
?>