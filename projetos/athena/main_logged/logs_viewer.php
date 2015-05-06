<?

// PERMISSÃO
$acessoWeb= 25;

	require_once("inc/valida_sessao.php");
	require_once("inc/calendar_input.php");
	include("../Connections/flp_db_connection.php");
	$db_connection= @connectTo();
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
	<table width="100%">
		<tr>
			<td class="gridCell"
				style="vertical-align: top;
					   text-align: left;">
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
					$qr_select.= " ORDER BY dp.s_usuario";
					$data= @pg_query($db_connection, $qr_select);
				?>
				<select id="logs_viewer_PkUsuario"
						oldValue=''>
					<option value=""
							selected>
					</option>
					<?
						while ($linha = pg_fetch_array($data))
						{
						?>
							<option value="<? echo $linha['pk_usuario']; ?>">
									<?
										echo htmlentities($linha['s_usuario']);
									?>
							</option>
						<?
						}
					?>
				</select>
				<?php
					makeCalendar('logs_viewer_dtIni', (date('d')-1) . '/'.date('m/Y'));
				?>
				<?php
					makeCalendar('logs_viewer_dtFin', date('d') . '/'.date('m/Y'));
				?>
				<input type="button"
					   class="botao"
					   value="Buscar"
					   onclick="document.getElementById('logs_viewer_contents').innerHTML= 'Buscando dados...';
								showLogs(document.getElementById('logs_viewer_PkUsuario').value, document.getElementById('logs_viewer_dtIni').value, document.getElementById('logs_viewer_dtFin').value)">
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;"
				id="logs_viewer_contents">
				<?
					$_GET['logs_viewer_dtIni']= (date('d')-1) . '/'.date('m/Y');
					$_GET['logs_viewer_dtFin']= date('d') . '/'.date('m/Y');
					include("logs_list.php");
				?>
			</td>
		</tr>
	</table>
</div>