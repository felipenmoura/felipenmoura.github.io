<?php

// PERMISSÃO
$acessoWeb= 31;

require_once("inc/valida_sessao.php");
include("../connections/flp_db_connection.php");
$db_connection= connectTo();

if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
	<?
	exit;
}
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
<?
	if($_POST)
	{
		// Atualiza Agenda de Contatos
		$qr_update = " UPDATE tb_agenda_contatos
						  SET  s_nome = '".$_POST['s_edit_agenda_contato_nome']."',
							   s_email_1 = '".$_POST['s_edit_email_1']."',
							   s_email_2 = '".$_POST['s_edit_email_2']."',
							   s_telefone_1 = '".$_POST['s_edit_telefone_1']."',
							   s_telefone_2 = '".$_POST['s_edit_telefone_2']."',
							   s_telefone_3 = '".$_POST['s_edit_telefone_3']."',
							   s_endereco = '".$_POST['s_edit_complemento']."',
							   s_nro = '".$_POST['s_edit_nro']."',
							   s_complemento = '".$_POST['s_edit_complemento']."',
							   s_cidade = '".$_POST['s_edit_cidade']."',
							   s_bairro = '".$_POST['s_edit_bairro']."',
							   s_estado = '".$_POST['s_edit_estado']."',
							   s_pais = '".$_POST['s_edit_pais']."',
							   s_obs = '".$_POST['s_edit_obs']."',
							   fk_agenda_grupo = ".$_POST['fk_agenda_grupo'].",
							   s_privacidade ='".(($_POST['s_edit_privacidade'] == 'on')? 1 : 0) ."'
						 WHERE pk_contato = ".$_POST['pk_contato'];

		$data= @pg_query($db_connection, $qr_update);
		if(!$data)
		{
			?>
				<script>
					alert('Erro ao tentar fazer a atualização !');
				</script>
			<?
		}else{
				?>
					<script>
						alert('Dados atualizados com sucesso');
						top.setLoad(false);
						parent.onlyEvalAjax('agenda_contatos_grupos_lista.php', 'top.setLoad(true)', 'top.setLoad(false); document.getElementById("agenda_contatos_grupos_lista").innerHTML= ajax');
					</script>
				<?
			 }
		exit;
				  
	
	}else{
			if($_GET['pk_contato'])		//	LISTA os dados do usuario clicado
			{
					$qr_select= "SELECT fk_agenda_grupo,
										s_nome,
										s_email_1,
										s_email_2,
										s_telefone_1,
										s_telefone_2,
										s_telefone_3,
										s_endereco,
										s_nro,
										s_complemento,
										s_bairro,
										s_cidade,
										s_estado,
										s_pais,
										s_obs,
										CASE WHEN s_privacidade = '0' OR s_privacidade = '' OR s_privacidade = NULL
												THEN ''
												ELSE ' checked '
										END AS s_privacidade
								   FROM tb_agenda_contatos
								  WHERE pk_contato = ". $_GET['pk_contato'];
					$data= @pg_query($db_connection, $qr_select);
					$linha= @pg_fetch_array($data);
				?>
					<div id="conteudo_agenda_contato">
					<input  type="text"
							value="<? echo $_GET['pk_contato']; ?>"
							name="pk_contato"
							style="display: none">
						<table>
							<tr>
								<td>
									Nome
								</td>
								<td>
									<input type="text"
										   name="s_edit_agenda_contato_nome"
										   id="s_edit_nome"
										   maxlength="50"
										   value="<? echo trim($linha['s_nome']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									E-mail
								</td>
								<td>
									<input type="text"
										   name="s_edit_email_1"
										   id="s_edit_email_1"
										   maxlength="160"
										   value="<? echo trim($linha['s_email_1']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									E-mail secund&aacute;rio
								</td>
								<td>
									<input type="text"
										   name="s_edit_email_2"
										   id="s_edit_email_2"
										   maxlength="160"
										   value="<? echo trim($linha['s_email_2']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Telefone Residencial
								</td>
								<td>
									<input type="text"
										   name="s_edit_telefone_1"
										   id="s_edit_telefone_1"
										   maxlength="15"
										   value="<? echo trim($linha['s_telefone_1']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Telefone profissional
								</td>
								<td>
									<input type="text"
										   name="s_edit_telefone_2"
										   id="s_edit_telefone_2"
										   maxlength="15"
										   value="<? echo trim($linha['s_telefone_2']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Celular
								</td>
								<td>
									<input type="text"
										   name="s_edit_telefone_3"
										   id="s_edit_telefone_3"
										   maxlength="15"
										   value="<? echo trim($linha['s_telefone_3']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Endere&ccedil;o
								</td>
								<td>
									<input type="text"
										   name="s_edit_endereco"
										   id="s_edit_endereco"
										   maxlength="160"
										   value="<? echo trim($linha['s_endereco']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Nro
								</td>
								<td>
									<input type="text"
										   name="s_edit_nro"
										   id="s_edit_nro"
										   maxlength="9"
										   value="<? echo trim($linha['s_nro']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Complemento
								</td>
								<td>
									<input type="text"
										   name="s_edit_complemento"
										   id="s_edit_complemento"
										   maxlength="40"
										   value="<? echo trim($linha['s_complemento']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Cidade
								</td>
								<td>
									<input type="text"
										   name="s_edit_cidade"
										   id="s_edit_cidade"
										   maxlength="60"
										   value="<? echo trim($linha['s_cidade']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Bairro
								</td>
								<td>
									<input type="text"
										   name="s_edit_bairro"
										   id="s_edit_bairro"
										   maxlength="60"
										   value="<? echo trim($linha['s_bairro']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Estado
								</td>
								<td>
									<input type="text"
										   name="s_edit_estado"
										   id="s_edit_estado"
										   maxlength="2"
										   value="<? echo trim($linha['s_estado']); ?>">
								</td>
							</tr>
							<tr>
								<td>
									Pa&iacute;s
								</td>
								<td>
									<input type="text"
										   name="s_edit_pais"
										   id="s_edit_pais"
										   maxlength="40"
										   value="<? echo trim($linha['s_pais']); ?>">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="checkbox" 
										   name="s_edit_privacidade"
										   <?
											echo $linha['s_privacidade'];
										   ?>>
									Privado
								</td>
							</tr>
							<?
								$qr_select= "SELECT pk_agenda_grupo,
													s_grupo_nome
											   FROM tb_agenda_grupo g
											  WHERE fk_usuario = ".$_SESSION['pk_usuario']."
											";
								$data= @pg_query($db_connection, $qr_select);
							?>
							<tr>
								<td>
									Grupo
								</td>
								<td>
									<select name="fk_agenda_grupo">
										<?
											while($linhaGroup= pg_fetch_array($data))
											{
												?>
													<option value="<? echo $linhaGroup['pk_agenda_grupo']; ?>" <? if($linhaGroup['pk_agenda_grupo'] == $linha['fk_agenda_grupo']) echo 'selected ' ?>>
														<?
															echo $linhaGroup['s_grupo_nome'];
														?>
													</option>
												<?
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Obs
									<center>
									<textarea  type="text"
											   name="s_edit_obs"
											   id="s_edit_obs"
											   onkeyup="charCount(this, 2048, 'agenda_adit_usuario_obs')"></textarea>
										<br>
										<span id="agenda_adit_usuario_obs">
											0
										</span> 
										caracteres de 2048
									</center>
								</td>
							</tr>
							<tr>
								<td colspan="2"
									style="text-align: center;
										   padding: 10px;">
									<input type="button"
										   class="botao"
										   value="Editar"
										   onclick="top.setLoad(true, 'Atualizando dados'); agenda_contato_edit()">
								</td>
							</tr>
						</table>
					</div>
					<script>
						parent.document.getElementById('dados_agenda_contato').innerHTML= "<form method='POST' action='agenda_contatos.php' target='iframe_agenda_contato' id='agenda_contato_edit_form' name='agenda_contato_edit_form'  margin: 2px;'>"+document.getElementById('conteudo_agenda_contato').innerHTML+"</form>";
					</script>
				<?
			}else{
					?>
					<div style="width: 50px;
								float: left;">
						<table>
							<tr>
								<td onmouseover="showtip(this, event, 'Novo grupo')
												 this.style.backgroundColor='#bbbbdd';
												 this.style.borderColor= '#333366';"
									onmouseout="this.style.backgroundColor=''; this.style.borderColor= '#ffffff';"
									style="border: solid 1px #ffffff;
										   cursor: pointer;"
									onclick="creatBlock('Novo grupo de contatos ', 'agenda_grupo.php', 'novo_grupo_contatos');">
									<img src="img/icone_grupo.gif">
								</td>
							</tr>
							<tr>
								<td onmouseover="showtip(this, event, 'Novo contato')
												 this.style.backgroundColor='#bbbbdd';
												 this.style.borderColor= '#333366';"
									onmouseout="this.style.backgroundColor=''; this.style.borderColor= '#ffffff';"
									style="border: solid 1px #ffffff;
										   cursor: pointer;"
									onclick="creatBlock('Novo contato', 'agenda_contato.php', 'novo_usuario_contatos');">
									<img src="img/icone_contato.gif">
								</td>
							</tr>
							<tr>
								<td onmouseover="showtip(this, event, 'Novo contato')
												 this.style.backgroundColor='#bbbbdd';
												 this.style.borderColor= '#333366';"
									onmouseout="this.style.backgroundColor=''; this.style.borderColor= '#ffffff';"
									style="border: solid 1px #ffffff;
										   cursor: pointer;
										   text-align: center;"
									onclick="creatBlock('Nova filial', 'filial_add.php', 'nova_filial_contatos');">
									<img src="img/filial.gif">
								</td>
							</tr>
						</table>
					</div>
					<table cellpadding="0"
						   cellspacing="0">
						<tr>
							<td class="gridTitle"
								style="width: 175px;">
								Grupos
							</td>
							<td class="gridTitle"
								style="width: 500px;">
								Contatos
							</td>
						</tr>
						<tr>
							<td class="gridCell"
								style="margin: 0px;
									   padding: 0px;
									   vertical-align: top;"
								id="agenda_contatos_grupos_lista">
								<?
									$qr_select= "SELECT g.pk_agenda_grupo,
														g.s_grupo_nome
												   FROM tb_agenda_grupo g
												  WHERE fk_usuario = ".$_SESSION['pk_usuario']."
												";
									$data= @pg_query($db_connection, $qr_select);
									require_once('agenda_contatos_grupos_lista.php');
								?>
							</td>
							<td id="dados_agenda_contato"
								class="gridCell"
								style="text-align: left;">
							</td>
						</tr>
					</table>
					<iframe id="iframe_agenda_contato"
							name="iframe_agenda_contato"
							src="false"
							style="display: none;"
							frameborder="0">
					</iframe>
			<?
				}
			?>
	<?
		}
	?>
</div>

