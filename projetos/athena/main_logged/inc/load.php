<?
	//		CARREGANDO CONFIGURAÇÕES PESSOAIS
	if($_SESSION['adm']==1)
	{
		$_nvAcs= 'A';
	}elseif($_SESSION['gerente'] ==1)
		$_nvAcs= 'G';
		elseif ($_SESSION['funcionario']==1)
			$_nvAcs= 'F';
			elseif ($_SESSION['agenciador']==1)
				$_nvAcs= 'a';
				elseif ($_SESSION['RH'] == 1)
					$_nvAcs= 'R';
	
	$qr_select= "SELECT fk_usuario,
						s_table_id,
						s_title,
						s_url,
						s_tam,
						s_pos,
						CASE WHEN s_conf = '' OR s_conf = NULL
							 THEN 'false'
							 ELSE s_conf
						END as s_conf,
						i_zindex,
						s_padrao
						FROM tb_load
						WHERE CASE WHEN (SELECT COUNT(*) from tb_load where fk_usuario= ". $_SESSION['pk_usuario'] .") = 0
								THEN s_padrao = '". $_nvAcs ."'
							   ELSE fk_usuario = ". $_SESSION['pk_usuario'] ."
							  END
						ORDER BY i_zindex
				";
	$data= @pg_query($db_connection, $qr_select);
	if(@pg_num_rows($data) > 0)
	{
		?>
			<script>
		<?
		$i=0;
		while($linha= @pg_fetch_array($data))
		{
			if($linha['s_conf'] == 'false' || trim($linha['s_conf']) == '')
				$linha['s_conf']= 'false';
			else
				$linha['s_conf']= "'".$linha['s_conf']."'";
			
					$command= " creatBlock('".$linha['s_title'] ."', '".$linha['s_url'] ."','".$linha['s_table_id']  ."',".$linha['s_conf'].",'".$linha['s_pos'] ."','".$linha['s_tam'] ."');";
					//$command.= "zMax= '".($linha['i_zindex'])? $linha['i_zindex'].'; ': 'zMax; '."'";
			echo "try{ ".$command." }catch(error){}";
			$i++;
		}
		?>
			</script>
		<?
	}
?>
<?php
	$qr_select= "SELECT	pk_atalho,
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
				   FROM tb_atalho
				  WHERE fk_usuario = ".$_SESSION['pk_usuario']."
				";
	$data= @pg_query($db_connection, $qr_select);
	if(@pg_num_rows($data) > 0)
	{
		?>
		<script>
			<?php
				while($linha= @pg_fetch_array($data))
				{
					echo " ar= Array(); ";
					//echo " ar['pk_atalho']= '".$linha['pk_atalho']."'; ";
					echo " ar['s_titulo']= '".urldecode($linha['s_titulo'])."'; ";
					echo " ar['s_img_src']= '".$linha['s_img_src']."'; ";
					echo " ar['s_table_id']= '".$linha['s_table_id']."'; ";
					echo " ar['s_url']= '".$linha['s_url']."'; ";
					echo " ar['s_conf']= '".$linha['s_conf']."'; ";
					echo " ar['s_tam']= '".$linha['s_tam']."'; ";
					echo " ar['i_left']= '".$linha['i_left']."'; ";
					echo " ar['i_top']= '".$linha['i_top']."'; ";
					echo " addShortCut(false, ar); ";
					echo " delete ar; ";
				}
			?>
		</script>
		<?php
	}
?>