<?
	if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		
	if($_GET['delFilial'])
	{	
		$qr = "UPDATE tb_dados_pessoais set bl_status= 0 where pk_dados_pessoais= ".$_GET['delFilial'];
		$data= pg_query($db_connection, $qr);
		if(!$data)
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o'); ";
		echo " top.filho.atualiza(top.filho.document.getElementById('corpo_ger_filial_add')); ";
		exit;
	}
?>

<table style="width: 100%;">
		<tr>
			<td class="gridTitle"
				style="cursor: pointer;
					   text-align: left;"
				colspan="2"
				onclick="getBlock(this).reload();">
				
				Nova
			</td>
		</tr>
		<tr>
			<td class="gridTitle"
				style="width: 130px;
					   text-align: left;"
				colspan="2"
				onclick="">
				Todas Filiais
			</td>
		</tr>
				<tbody>
					<?php
						$qr_selectCliente= "SELECT pk_dados_pessoais,
										  s_usuario
									 FROM tb_dados_pessoais,
										  tb_pess_juridica j
									WHERE vfk_usuario isnull
									  AND j.fk_dados_pessoais = pk_dados_pessoais
									  AND bl_status = 1
									ORDER BY s_usuario";
									//$qr_selectCliente.= " ORDER BY s_usuario";
					$dataCli= pg_query($db_connection, $qr_selectCliente);
		
						while($linhaCli= @pg_fetch_array($dataCli))
						{
							?>
								<tr onmouseover="this.style.backgroundColor= '<? echo $style['unSubItem']['bgMouseOver']; ?>';
												 showtip(this,event,'<?php echo str_replace("'", "\'", htmlentities($linhaCli['s_usuario']));?>')"
									onmouseout="this.style.backgroundColor= '<? echo $style['unSubItem']['backGround']; ?>';">
									<td onclick="top.setLoad(true,'Carregando Dados de <?php echo $linhaCli['s_usuario'] ?>');onlyEvalAjax('ger_filiais_edit.php?pk_contato=<?php echo $linhaCli['pk_dados_pessoais']; ?>', '', 'document.getElementById(\'corpo_ger_filial_add\').innerHTML=ajax')">
										<nobr>
										<img src="img/pessoa_j.gif">
										<?php
											echo htmlentities(substr($linhaCli['s_usuario'],0,20));
											if (strlen($linhaCli['s_usuario']) > 20)
												echo '...';
										?>
										</nobr>
									</td>
									<td style="width: 20px;">
										<img src="img/file_delete.gif"
											 width="16"
											 style="cursor: pointer;"
											 onmouseover="showtip(this, event, 'Remover Filial');"
											 onclick="if(confirm('Tem certeza que deseja excluir esta Filial ?'))
													  {
														top.setLoad(true);
														onlyEvalAjax('ger_filiais_list.php?delFilial=<? echo $linhaCli['pk_dados_pessoais'];?>', '', 'eval(ajax)');
													  }">
									</td>
								</tr>
							<?php
						}
					?>
				</tbody>
</table>