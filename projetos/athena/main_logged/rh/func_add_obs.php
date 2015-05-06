<?php
	$PREID= 'func_add_';
	$_GET['$PREID'] = $PREID;
	
	// if($_GET['pk_usuario'])
	// {
		//include("../connections/flp_db_connection.php");
		// $db_connection = connectTo();
		// $qr= "SELECT s_obs
				// FROM tb_funcionario
			   // WHERE fk_usuario = ".$_GET['pk_usuario'];
		// $data= pg_query($db_connection, $qr);
		// $linha= pg_fetch_array($data);
	// }
?>
<textarea name="obs"
		  style="width: 100%;
				 height: 100%;"><?php echo $linha['s_obs']; ?></textarea>