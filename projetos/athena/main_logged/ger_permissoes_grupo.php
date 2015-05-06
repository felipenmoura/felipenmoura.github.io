<?php

// PERMISSÃO
$acessoWeb= 21;

require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
require_once("inc/styles.php");
require_once("inc/query_control.php");

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
	<?
	exit;
}
?>
<?
	if($_POST['groupeCode'])
	{
		echo "grupo-> ".$_POST['groupeCode']."<br>";
		/*for($i=0; $i<count($_POST['permission_code']); $i++)
		{
			echo $_POST['permission_code'][$i].'<br>';
		}*/
		@startQuery($db_connection);
		
		$qr_delete= "DELETE from tb_grupo_permissao
					  WHERE fk_grupo = ".$_POST['groupeCode']."
					";
		$data= pg_query($db_connection, $qr_delete);
		if($data)
		{
			for($i=0; $i<count($_POST['permission_code']); $i++)
			{
				//$_POST['permission_code'][$i] = ($_POST['permission_code'][$i]== 'on')? 1:0;
				$qr_insert= "INSERT into tb_grupo_permissao
								(
									fk_permissao,
									fk_grupo
								)
							 VALUES
								(
									".$_POST['permission_code'][$i].",
									".$_POST['groupeCode']."
								)
							";
				echo $_POST['permission_code'][$i]." e ".$_POST['groupeCode']."<br>";
				$data= @pg_query($db_connection, $qr_insert);
				if(!$data)
				{
					@cancelQuery($db_connection);
					?>
						<script>
							alert('Ocorreu um erro ao tentar a atualização, tente novamente mais tarde');
						</script>
					<?
					exit;
				}
			}
			@commitQuery($db_connection);
		}else{
				@cancelQuery($db_connection);
				?>
						<script>
							alert('Ocorreu um erro ao tentar a atualização, tente novamente mais tarde');
						</script>
					<?
				exit;
			 }
		?>
			<script>
				top.setLoad(false);
			</script>
		<?
		exit;
	}
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="ger_permissoes_grupo.php"
		  method="POST"
		  target="hiddenFrameGerUsuarioGrupo">
		<table width="100%">
			<tr>
				<td class="gridTitle"
					style="width: 100px;">
					Grupo
				</td>
				<td class="gridTitle">
					Permiss&otilde;es
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;"
					class="gridCell">
					<table cellpadding="0"
						   cellspacing="0"
						   width="100%">
					<?
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
								<tr>
									<td <?
											if($pk_firstGroup == $ar_linha['pk_grupo'])
												echo " style='cursor: pointer;
															  font-weight: bold;'";
											else echo " style='cursor: pointer;'";
										?>
										onmouseover="this.style.backgroundColor= '<? echo $style['unSubItem']['bgMouseOver']; ?>'"
										onmouseout="this.style.backgroundColor= '<? echo $style['unSubItem']['backGround']; ?>';"
										onclick="setGrupoGerUsuarioGrupo(this); onlyEvalAjax('grupo_permissoes_lista.php?selectedGroup=<? echo $ar_linha['pk_grupo']; ?>', '', 'document.getElementById(\'listaDePermissoesDosGrupos\').innerHTML= ajax;');">
										<?
											echo htmlentities($ar_linha['s_label']);
										?>
									</td>
								</td>
							<?
						}
					?>
					</table>
				</td>
				<td style="vertical-align: top;
						   text-align: left;"
					class="gridCell"
					id="listaDePermissoesDosGrupos">
					<?
						$_GET['selectedGroup']= $pk_firstGroup;
						include('grupo_permissoes_lista.php');
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;
						   padding-top: 4px;">
					<input type="submit"
						   value="Aplicar"
						   class="botao"
						   onclick="top.setLoad(true);">
					<input type="button"
						   value="Cancelar"
						   class="botao"
						   onclick="closeBlock(document.getElementById('ger_permissoes_grupo'));">
				</td>
			</tr>
		</table>
	</form>
</div>
<iframe id="hiddenFrameGerUsuarioGrupo"
		name="hiddenFrameGerUsuarioGrupo"
		style="display: none;">
</iframe>
