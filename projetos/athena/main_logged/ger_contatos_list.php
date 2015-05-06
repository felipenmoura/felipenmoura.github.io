<?
	if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		
	if($_GET['delContato'])
	{
		$qr = "UPDATE tb_dados_pessoais set bl_status= 0 where pk_dados_pessoais= ".$_GET['delContato'];
		$data= pg_query($db_connection, $qr);
		if(!$data)
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o'); ";
		echo " top.filho.atualiza(top.filho.document.getElementById('corpo_ger_contato_add')); ";
		exit;
	}
	
?>

<table style="width: 100%;">
		<tr>
			<td style="text-align: left;"
				colspan="2">
				<table width="100%">
					<tr onmouseover="this.style.backgroundColor= '#dedede'"
						onmouseout="this.style.backgroundColor= ''"
						onclick="creatBlock('Novo cliente', 'cliente_add.php', 'novo_cliente')">
						<td style="width: 32px;
								   height: 10px;">
							<span style="padding-left: 2px;">
								<img src="img/user_add.gif"
									 style="width: 32px;"> 
							</span>
						</td>
						<td style="padding-left: 7px;">
							Novo Cliente
						</td>
					</tr>
					<tr onmouseover="this.style.backgroundColor= '#dedede'"
						onmouseout="this.style.backgroundColor= ''"
						onclick="getBlock(this).reload();">
						<td style="height: 10px;
								   width: 32px;">
							<span style="padding-left: 2px;">
								<img src="img/contato_add.gif"
									 style="width: 32px;"> 
							</span>
						</td>
						<td style="padding-left: 7px;">
							Novo Contato
						</td>
					</tr>
					<tr onmouseover="this.style.backgroundColor= '#dedede'"
						onmouseout="this.style.backgroundColor= ''"
						onclick="creatBlock('Nova filial', 'agenda_contato_filial.php', 'agenda_contato_filial');">
						<td style="height: 10px;
								   width: 32px;">
							<span style="padding-left: 2px;">
								<img src="img/filial_add.gif"
									 style="width: 32px;"> 
							</span>
						</td>
						<td style="padding-left: 7px;">
							Nova Filial
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width: 130px;
					   text-align: left;
					   height: 3px;
					   background-color: #dedede;"
				colspan="2">
			</td>
		</tr>
		<tr>
			<td>
				<div id="gerContatoList_div_tree">
					Contatos
					<?php
					/*
						$qr_selectCliente= "SELECT pk_dados_pessoais,
												  s_usuario,
												  bl_status
											 FROM tb_dados_pessoais,
												  tb_pess_fisica f
											WHERE vfk_usuario isnull
											  AND f.fk_dados_pessoais = pk_dados_pessoais
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
									<td onclick="top.setLoad(true);onlyEvalAjax('ger_contato_edit.php?pk_contato=<?php echo $linhaCli['pk_dados_pessoais']; ?>', '', 'document.getElementById(\'corpo_ger_contato_add\').innerHTML=ajax')">
										<nobr>
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
											 onmouseover="showtip(this, event, 'Remover Contato');"
											 onclick="if(confirm('Tem certeza que deseja excluir este Contato ?'))
													  {
														top.setLoad(true);
														onlyEvalAjax('ger_contatos_list.php?delContato=<? echo $linhaCli['pk_dados_pessoais']; ?>', '', 'eval(ajax)');
													  }">
									</td>
								</tr>
							<?php
						}
					*/
					?>
				</div>
			</td>
		</tr>
</table>