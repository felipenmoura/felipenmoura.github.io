<?
require_once("inc/valida_sessao.php");

include("../connections/flp_db_connection.php");
$db_connection= @connectTo();
if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
	<?
	exit;
}

include("inc/query_control.php");

?>
<?
	if($_POST)
	{
		$qr_delete= "DELETE from tb_load
					  WHERE fk_usuario = ".$_SESSION['pk_usuario']."
					";
		$data= pg_query($db_connection, $qr_delete);
		if(!$data)
			cancelQuery($db_connection);
		
		$ar_post['iptBlockId']  = explode(',', $_POST['iptBlockId']);
		$ar_post['iptBlockTt']  = explode(',', $_POST['iptBlockTt']);
		$ar_post['iptBlockUrl'] = explode(',', $_POST['iptBlockUrl']);
		$ar_post['iptBlockW']   = explode(',', $_POST['iptBlockW']);
		$ar_post['iptBlockH']   = explode(',', $_POST['iptBlockH']);
		$ar_post['iptBlockL']   = explode(',', $_POST['iptBlockL']);
		$ar_post['iptBlockT']   = explode(',', $_POST['iptBlockT']);
		$ar_post['iptBlockConf']= explode('|', $_POST['iptBlockConf']);
		$ar_post['iptBlockZ']   = explode(',', $_POST['iptBlockZ']);
		?>
			<script>
				top.setLoad(false);
			</script>
		<?
		for($i=0; $i<count($ar_post['iptBlockId']); $i++)
		{
			if(trim($ar_post['iptBlockId'][$i]) != ''
			   &&
			   trim($ar_post['iptBlockId'][$i]) != NULL
			   &&
			   trim($ar_post['iptBlockId'][$i]) != FALSE
			  )
			{
				$qr_insert= "INSERT INTO tb_load
								(
									fk_usuario,
									s_table_id,
									s_title,
									s_url,
									s_tam,
									s_pos,
									s_conf,
									i_zindex
								)
							 VALUES
								(
									 ".$_SESSION['pk_usuario']         .",
									'".$ar_post['iptBlockId'][$i]  ."',
									'".$ar_post['iptBlockTt'][$i]  ."',
									'".$ar_post['iptBlockUrl'][$i] ."',
									'".$ar_post['iptBlockW'][$i]   ."/" .$ar_post['iptBlockH'][$i]."',
									'".$ar_post['iptBlockL'][$i]   ."/" .$ar_post['iptBlockT'][$i]."',
									'".$ar_post['iptBlockConf'][$i]."',
									 ".$ar_post['iptBlockZ'][$i]   ."
								)
							";
				$data= pg_query($db_connection, $qr_insert);
				if(!$data)
				{
					cancelQuery($db_connection);
					exit;
				}
			}
		}
		$data= commitQuery($db_connection);
		if(!$data)
		{
			cancelQuery($db_connection);
			exit;
		}else{
				?>
					<script>
						top.setLoad(false);
					</script>
				<?
			 }
	}else{
			?>
				<script>
					top.setLoad(false);
				</script>
			<?
			$qr_delete= "DELETE from tb_load
						  WHERE fk_usuario = ".$_SESSION['pk_usuario']."
						";
			$data= pg_query($db_connection, $qr_delete);
			?>
				<script>
					alert('Ocorreu um erro durante uma transação com o banco');
					top.setLoad(false);
				</script>
				<!--
					<flp_script>
						alert('Ocorreu um erro durante uma transação com o banco');
				-->
			<?
			exit;
		 }
?>