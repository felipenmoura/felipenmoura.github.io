<?php
//session_start();

require_once("inc/valida_sessao.php");

require_once("../connections/flp_db_connection.php");
$db_connection= @connectTo();
?>
<?
	$qr_select= "SELECT g.pk_agenda_grupo,
						g.s_grupo_nome
				   FROM tb_agenda_grupo g
				  WHERE fk_usuario = ".$_SESSION['pk_usuario']."
				  ORDER BY UPPER(s_grupo_nome)
				";
	$data= @pg_query($db_connection, $qr_select);
?>
	<table width="100%"
		   cellpadding="0"
		   cellspacing="0">
<?
	while($linha= @pg_fetch_array($data))
	{
		//	GRUPOS
		?>
				<tr>
					<td class="leftInnerTitle"
						id="left_group_contact_<? echo $linha['s_grupo_nome']; ?>"
						onclick="expandContactGroup('<? echo $linha['s_grupo_nome']; ?>')">+</td>
					<td onclick="expandContactGroup('<? echo $linha['s_grupo_nome']; ?>')" 
						class="InnerTitle"
						colspan="2"
						pk_agenda_grupo="<? echo $linha['pk_agenda_grupo'] ?>"
						rhtmenuclass="rhtGrupoAgendaContato">
						<?
							echo htmlentities($linha['s_grupo_nome']);
						?>
					</td>
				</tr>
				<tbody id="group_contact_<? echo $linha['s_grupo_nome']; ?>" 
						style="display:none;">
					<?
						$qr_select_contato = "SELECT p.pk_dados_pessoais,
													 p.s_usuario
												FROM tb_dados_pessoais p,
													 tb_dados_pessoais_agenda_grupo dpg
											   WHERE p.pk_dados_pessoais = dpg.fk_dados_pessoais
												 AND dpg.fk_agenda_grupo =".$linha['pk_agenda_grupo'];
						$data_contato= pg_query($db_connection, $qr_select_contato);
					if (pg_num_rows($data_contato) > 0 )	//	CONTATOS
					{
						while($linha_contato = @pg_fetch_array($data_contato))
						{
						?>
								<tr onmouseover="this.style.backgroundColor='#e6e6e6'"
									onmouseout="this.style.backgroundColor='#efefef'"
									style="background-color: #efefef;">
									<td colspan="2"
										class="contatos"
										style="border-left: solid 1px #333333;
											   border-bottom: solid 1px #bbbbbb;
											   cursor: pointer;
											   padding-left: 7px;
											   padding-right: 4px;"
										onclick="document.getElementById('iframe_agenda_contato').src='agenda_contatos.php?pk_contato=<? echo $linha_contato['pk_dados_pessoais']; ?>'">
										<? echo htmlentities($linha_contato['s_usuario']); ?>
									</td>
									<td width="20"
										style="20px; border-bottom: solid 1px #bbbbbb;">
										<img src="img/file_delete.gif"
											 width="15"
											 style="cursor: pointer;"
											 onclick="if(confirm('Tem certeza que deseja excluir este contato ?')) excluiContatoAgenda('<? echo $linha_contato['pk_dados_pessoais']; ?>')">
									</td>
								</tr>
						<? 
						}
					}else{
							echo "<tr><td style='border-left: solid 1px #333333;' class='contatos' colspan='2'>N&atilde;o h&aacute; contatos para este Grupo</td></tr>";
						 }
						?>
				</tbody>
		<?
	}
	?>
		<!-- CONTATOS PUBLICOS -->
		<tr class="leftInnerTitle">
			<td onclick="expandContactGroup('agenda_contatos_publicos')"
				class="leftInnerTitle"
				id="left_group_contact_agenda_contatos_publicos">+</td>
			<td onclick="expandContactGroup('agenda_contatos_publicos')" 
				class="InnerTitle">
				P&uacute;blicos
			</td>
			<td width="20"
				style="20px;
					   border-left: none;"
				class="gridCell">
			</td>
		</tr>
		<tbody id="group_contact_agenda_contatos_publicos" 
				style="display:none;">
			<? 
				$qr_select_contato = "SELECT p.pk_dados_pessoais,
											 p.s_usuario
										FROM tb_dados_pessoais p,
											 tb_dados_pessoais_agenda_grupo dpg
									   WHERE p.pk_dados_pessoais = dpg.fk_dados_pessoais
									     AND dpg.s_privacidade= '0'";
				$data_contato= pg_query($db_connection, $qr_select_contato);
			if (pg_num_rows($data_contato) > 0 )
			{
				while($linha_contato = @pg_fetch_array($data_contato))
				{
				?>

						<tr>
							<td class="contatos"
								style="border-left: solid 1px #333333;
									   border-bottom: solid 1px #000000;
									   cursor: pointer;
									   padding-left: 7px;
									   padding-right: 4px;
									   background-color: #efefef;"
								colspan="2"
								onmouseover="this.style.backgroundColor='#e6e6e6'"
								onmouseout="this.style.backgroundColor='#efefef'"
								onclick="document.getElementById('iframe_agenda_contato').src='agenda_contatos.php?pk_contato=<? echo $linha_contato['pk_dados_pessoais']; ?>'">
								<? echo htmlentities($linha_contato['s_usuario']); ?>
							</td>
							<td width="20"
								style="20px;"
								class="gridCell">
								<img src="img/file_delete.gif"
									 width="15"
									 style="cursor: pointer;"
									 onclick="if(confirm('Tem certeza que deseja excluir este contato ?')) excluiContatoAgenda('<? echo $linha_contato['pk_dados_pessoais']; ?>')">
							</td>
						</tr>
				<? 
				}
			}else{
					echo "<tr><td style='border-left: solid 1px #333333;' class='contatos' colspan='2'>N&atilde;o h&aacute; contatos para este Grupo</td></tr>";
				 }
				?>
		</tbody>
	</table>
	<?
?>