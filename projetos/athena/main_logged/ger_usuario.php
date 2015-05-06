<?php

// PERMISSÃO
$acessoWeb= 12;

require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");

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
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
<?php
	$qr_select= "SELECT pk_grupo,
						s_label
				   FROM tb_grupo
				";
	$data= @pg_query($db_connection, $qr_select);
?>
	<table width="100%"
		   height="100%">
		<tr>
			<td style="vertical-align: top;
					   width: 40px;">
				<br>
				<table>
					<tr>
						<td onclick="creatBlock('Novo grupo de usu&aacute;rios', 'usuario_grupo_add.php', 'usuario_grupo_add', 'noresize')"
						    onmouseover="showtip(this, event, 'Criar um novo grupo');
										 this.style.borderColor= '#333366';"
							onmouseout="this.style.borderColor= '#efefef';"
						    style="cursor: pointer;
								   border: solid 2px #efefef;">
							<img src="img/group_add.gif">
						</td>
					</tr>
					<tr>
						<td style="height: 1px;">
						</td>
					</tr>
					<tr>
						<td onclick="creatBlock('Novo cliente', 'cliente_add.php', 'novo_cliente')"
						    onmouseover="showtip(this, event, 'Cadastrar cliente');
										 this.style.borderColor= '#333366';"
							onmouseout="this.style.borderColor= '#efefef';"
						    style="cursor: pointer;
								   border: solid 2px #efefef;">
							<img src="img/new_juridico.gif">
						</td>
					</tr>
					<tr>
						<td style="height: 1px;">
						</td>
					</tr>
					<tr>
						<td onclick="creatBlock('Novo funcion&aacute;rio', 'rh/funcionario_add.php', 'novo_funcionario', false, false, '780/400')"
						    onmouseover="showtip(this, event, 'Cadastrar funcion&aacute;rio');
										 this.style.borderColor= '#333366';"
							onmouseout="this.style.borderColor= '#efefef';"
						    style="cursor: pointer;
								   border: solid 2px #efefef;">
							<img src="img/new_funcionario.gif">
						</td>
					</tr>
					<tr>
						<td style="height: 1px;">
						</td>
					</tr>
					<tr>
						<td onclick="showHelp('ger_usuario')"
						    onmouseover="showtip(this, event, 'Cadastrar funcion&aacute;rio');
										 this.style.borderColor= '#333366';"
							onmouseout="this.style.borderColor= '#efefef';"
						    style="cursor: pointer;
								   border: solid 2px #efefef;">
							<img src="img/help_ico.gif">
						</td>
					</tr>
				</table>
			</td>
			<td style="vertical-align: top;
					   border: outset 2px;
					   width: 190px;">
				<table align="left"
					   width="100%"
					   cellpadding="0"
					   cellspacing="0">
					<tr>
						<td class="gridTitle">
							Grupo
						</td>
						<td class="gridTitle"
							style="width: 24">
							<br>
						</td>
						<td class="gridTitle"
							style="width: 24">
							<br>
						</td>
					</tr>
					<?php
						while($ar_linha= @pg_fetch_array($data))
						{
							?>
								<tr onmouseover="this.style.backgroundColor= '#dedede';"
									onmouseout="this.style.backgroundColor= '';">
									<td style="padding-left: 3px;
											   padding-right: 3px;"
										onclick="showUsersFromGroup('<?php echo $ar_linha['pk_grupo']; ?>', '<?php echo htmlentities($ar_linha['s_label']); ?>')">
										<?php
											echo htmlentities($ar_linha['s_label']);
										?>
									</td>
									<td style="padding-left: 3px;
											   padding-right: 3px;
											   text-align: center;">
										<?php
											if($ar_linha['pk_grupo'] < 3)
												echo '<img src="img/edit_false.gif"
															 width="16"
															 style="cursor: default;"
															 onmouseover="showtip(this, event, \'Este grupo n&atilde;o pode ser alterado\');"
															 onclick="">';
											else
											{
												?>
													<img src="img/edit.gif"
														 width="16"
														 style="cursor: pointer;"
														 onmouseover="showtip(this, event, 'Editar os dados deste grupo');"
														 onclick="creatBlock('Editar grupo de usu&aacute;rios', 'usuario_grupo_edit.php?pk_grupo_to_edit=<?php echo $ar_linha['pk_grupo']; ?>', 'usuario_grupo_edit', 'noresize')">
												<?php
											}
											?>
									</td>
									<td style="padding-left: 3px;
											   padding-right: 3px;
											   text-align: center;">
										<?php
											if($ar_linha['pk_grupo'] < 3)
												echo '<img src="img/file_delete_false.gif"
															 width="16"
															 style="cursor: default;"
															 onmouseover="showtip(this, event, \'Este grupo n&atilde;o pode ser excluido\');"
															 onclick="">';
											else
											{
											?>
												<img src="img/file_delete.gif"
													 width="16"
													 style="cursor: pointer;"
													 onmouseover="showtip(this, event, 'Excluir este grupo');"
													 onclick="if(confirm('Tez certeza deseja excluir este grupo de acesso?\nO grupo precisa estar vazio')){ deleteUsersGroup('<?php echo $ar_linha['pk_grupo']; ?>')}">
											<?php
											}
										?>
									</td>
								</tr>
							<?php
						}
					?>
				</table>
			</td>
			<td style="vertical-align: top;
					   border: outset 2px;">
				<table width="100%"
					   height="100%">
					<tr>
						<td class="gridTitle"
						    style="height: 15px;">
							Usu&aacute;rios
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;"
							id="ger_usuario_user_list">
							<?php
								$_GET['pk_grupo']= '1';
								$_GET['s_grupo']= 'Administradores';
								include_once('usuarios_list.php');
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>