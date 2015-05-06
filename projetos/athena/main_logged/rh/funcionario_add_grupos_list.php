<?
	require_once("../inc/valida_sessao.php");
	require_once("../../connections/flp_db_connection.php");
	$db_connection= @connectTo();
	$qr_select= "SELECT pk_grupo,
						s_label
				   FROM tb_grupo
				  WHERE fk_agencia = ".$_SESSION['pk_agencia']."
				  ORDER BY pk_grupo
				";
	$data= @pg_query($db_connection, $qr_select);
	$pk_firstGroup= 0;
	while($ar_linha= @pg_fetch_array($data))
	{
		if($pk_firstGroup> $ar_linha['pk_grupo'] || $pk_firstGroup == 0)
		{
			$pk_firstGroup = $ar_linha['pk_grupo'];
		}
		?>
			<div style="width: 110px;
						overflow: hidden;
						float: left;
						white-space: nowrap"
				 onmouseover="showtip(this, event, '<?php echo htmlentities($ar_linha['s_label']); ?>');">
				<input type="checkbox"
					   name="grupo[]"
					   value="<?php echo $ar_linha['pk_grupo']; ?>"
					   <?php
							if($ar_linha['pk_grupo'] == 2)
								echo " checked disabled ";
					   ?>> 
				<?
					echo htmlentities($ar_linha['s_label']);
				?>
			</div>
		<?
	}
?>