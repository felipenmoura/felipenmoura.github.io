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
	
	$qr_delete= "DELETE from tb_atalho
				 WHERE  fk_usuario= ".$_SESSION['pk_usuario']." AND
						s_titulo= '".$receivedIco['tt']."' AND
						s_img_src= '".$receivedIco['imageURL']."' AND
						s_table_id= '".$receivedIco['idToOpen']."' AND
						s_title= '".$receivedIco['ttToOpen']."' AND
						s_url= '".$receivedIco['urlToOpen']."' AND
						s_conf= '".$receivedIco['especificToOpen']."' AND
						s_tam= '".$receivedIco['tamToOpen']."'
				";
	$data= pg_query($db_connection, $qr_delete);
	if(!$data)
	{
		echo "false";
		exit;
	}
	//print_r($receivedIco);
	echo "true";
?>