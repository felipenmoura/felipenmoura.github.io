<?php
	$PREID= 'func_add_';
	$_GET['$PREID'] = $PREID;
?>
<table cellpadding="0"
	   cellspacing="0"
	   style="width: 100%;
			  height: 100%;">
	<tr>
		<td style="height: 25px;">
			Login
			<input type="text"
				   name="funcionarioLogin"
				   class="discret_input"
				   id="<?php echo $PREID; ?>funcionarioLogin"
				   style="width:100px;">
			 
			Senha
			<input type="password"
				   name="funcionarioSenha"
				   id="<?php echo $PREID; ?>funcionarioSenha"
				   class="discret_input"
				   style="width:100px;">
		</td>
	</tr>
	<tr>
		<td style="vertical-align: center;">
			<fieldset style="height: 100%;">
				<legend>
					Grupos
				</legend>
				<div id="funcionarioAddGruposList">
				<?php
					require_once("funcionario_add_grupos_list.php");
				?>
				</div>
			</fieldset>
		</td>
	</tr>
	<?php
		if(!hasPermission(''))
		{
			?>
				<tr>
					<td style="height: 40px;">
						<table onclick="creatBlock('Grupo de Funcion&aacute;rios ', 'usuario_grupo_add.php', 'novo_grupo_funcionario');"
							   style="cursor: pointer;">
							<tr>
								<td>
									<img src="img/group_add.gif"><br>
								</td>
								<td>
									&nbsp;Novo grupo de Funcion&aacute;rios
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php
		}
	?>
</table>