<?php
	//session_start();
	require_once("inc/valida_sessao.php");
	require_once("inc/calendar_input.php");
	require_once("inc/class_explorer.php");
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
	
	if($_GET['userToAdd'])
	{
		if($_GET['mode'] == 'del')
		{
			if($_GET['pk_grupo'] == 1)
			{
				$qr_select= "SELECT fk_usuario,
									fk_grupo
							   FROM tb_usuario_grupo
							  WHERE fk_grupo=".$_GET['pk_grupo']."
								";
				$data= @pg_query($db_connection, $qr_select);
				if(@pg_num_rows($data) == 1)
				{
					$qr_select= "retornar falso";
					$errorMsg= '&Eacute; necess&aacute;rio ao menos 1(um) usu&aacute;rio no grupo administradores';
				}else{
						$qr_select= "DELETE FROM tb_usuario_grupo
										   WHERE fk_usuario= ".$_GET['userToAdd']."
											 AND fk_grupo= ".$_GET['pk_grupo']."
									";
						$errorMsg= 'Ocorreu um erro ao tentar remover o usu&aacute;rio do grupo';
					 }
			}else{
					$qr_select= "DELETE FROM tb_usuario_grupo
									   WHERE fk_usuario= ".$_GET['userToAdd']."
										 AND fk_grupo= ".$_GET['pk_grupo']."
								";
					$errorMsg= 'Ocorreu um erro ao tentar remover o usu&aacute;rio do grupo';
				 }
		}else{
				$qr_select= "SELECT fk_usuario,
									fk_grupo
							   FROM tb_usuario_grupo
							  WHERE fk_usuario= ".$_GET['userToAdd']."
								AND fk_grupo=".$_GET['pk_grupo']."
							";
				$data= @pg_query($db_connection, $qr_select);
				if(@pg_num_rows($data) == 0)
				{
					$qr_select= "INSERT into tb_usuario_grupo
									(
										fk_usuario,
										fk_grupo
									)
							 VALUES
									(
										".$_GET['userToAdd'].",
										".$_GET['pk_grupo']."
									)
							";
					$errorMsg= 'Ocorreu um erro ao tentar inserir o usu&aacute;rio no grupo';
				}else{
						$qr_select= "retornar falso";
						$errorMsg= 'Este usu&aacute;rio j&aacute; est&aacute; neste grupo';
					 }
				$data= false;
			 }
		$data= @pg_query($db_connection, $qr_select);
		if(!$data)
		{
			echo "false<flp_script> top.showAlert('erro', '".$errorMsg."')";
			exit;
		}
	}
	
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;"
	 id="div_pai_usuarios_list">
	<table style='height: 100%; width: 100%;'>
		<tr>
			<td style='vertical-align: top;
					   height: 20px;'>
				<div style="text-align: center;
							font-weight: bold;
							width: 100%;
							border-bottom: solid 1px #000000;">
				<?php
					echo htmlentities($_GET['s_grupo']);
				?>
				</div>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
<?php
	$qr_select= " SELECT DISTINCT ON(dp.s_usuario)
						 u.pk_usuario,
						 dp.s_usuario
				    FROM tb_usuario u,
					 	 tb_dados_pessoais dp,
						 tb_usuario_grupo ug
				   WHERE bl_cliente =0
				     AND ug.fk_usuario = u.pk_usuario
					 AND ug.fk_usuario = dp.vfk_usuario
				";
	/*if($_GET['pk_grupo'] != 2)
	{
		$qr_select.= "	 AND ug.fk_grupo = ".$_GET['pk_grupo'];
	}*/
	if($_GET['pk_grupo'] != 2)
		$qr_select.= "	 AND ug.fk_grupo = ".$_GET['pk_grupo'];
	$qr_select.= " ORDER BY dp.s_usuario";
	$data= @pg_query($db_connection, $qr_select);
	if(@pg_num_rows($data)<1)
	{
		echo "<span class='message'>&nbsp;&nbsp;N&atilde;o foram encontrados usu&aacute;rios neste grupo</span>";
	}
	echo "<div style='height: 100%; width: 100%; overflow: auto;'><table style='width: 100%;'>";
	while($ar_linha= @pg_fetch_array($data))
	{
			?>
							<tr onmouseover="this.style.backgroundColor= '#dedede';"
								onmouseout="this.style.backgroundColor= '';">
								<td style="padding-left: 4px;">
									<?php
										echo htmlentities($ar_linha['s_usuario']);
									?>
								</td>
								<td style="width: 20px;">
									<img src="img/edit.gif"
										 width="16"
										 style="cursor: pointer;"
										 onmouseover="showtip(this, event, 'Editar os dados deste usu&aacute;rio');"
										 onclick="creatBlock('Editar funcion&aacute;rio', 'rh/funcionario_edit.php?pk_usuario=<?php echo $ar_linha['pk_usuario']; ?>', 'funcionario_edit<?php echo $ar_linha['pk_usuario']; ?>', '')">
								</td>
								<?php
									if($_GET['pk_grupo'] != 2)
									{
								?>
										<td style="width: 20px;">
											<img src="img/file_delete.gif"
													 width="16"
													 style="cursor: pointer;"
													 onmouseover="showtip(this, event, 'Remover deste grupo');"
													 onclick="if(confirm('Tem certeza que deseja remover este usu&aacute;rio deste grupo ?\nUm usu&aacute;rio que n&atilde;o estiver em nenhum grupo, n&atilde;o ter&aacute; acesso ao sistema, at&eacute; ser inserido e um grupo de acesso')){ showUsersFromGroup('<?php echo $_GET['pk_grupo']; ?>', '<?php echo htmlentities($_GET['s_grupo']); ?>', '<?php echo $ar_linha['pk_usuario']; ?>', 'del'); top.setLoad(true, 'Realizando altera&ccedil;&otilde;es');}">
										</td>
								<?php
									}
								?>
							</tr>
			<?php
	}
?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td style="height: 25px;
						   text-align: center;
						   border-top: solid 1px #000000;
						   padding-top: 3px;">
					<table>
						<tr>
							<td>
								<?
									//contatoFuncionario('func_usuario_list', '', 'func_usuario_list');
									$_GET['component']= 'explorerFunc';
									$_GET['componentId']= 'func_usuario_list';
									$_GET['componentValue']= '';
									require_once('components.php');
								?>
							</td>
							<td style="padding-left: 17px;">
								<input type="button"
									   value="Adicionar"
									   class="botao"
									   onmouseover="showtip(this, event, 'Adicionar ao grupo selecionado')"
									   onclick="if(document.getElementById('func_usuario_list').value.replace(/ /g, '') != '')
												{
													code= document.getElementById('func_usuario_list').value.split('|+|');
													code= code[0];
													try
													{
														showUsersFromGroup('<?php echo $_GET['pk_grupo']; ?>', '<?php echo htmlentities($_GET['s_grupo']); ?>', code);
														top.setLoad(true, 'Realizando altera&ccedil;&otilde;es');
													}catch(error){}
												}">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		<table>
</div>










