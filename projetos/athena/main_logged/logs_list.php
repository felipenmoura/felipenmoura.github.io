<?
	if(!$db_connection)
	{
		include("../Connections/flp_db_connection.php");
		$db_connection= connectTo();
	}
?>
				<table class="gridCell"
					   width="100%">
					<tr>
						<td class="gridTitle">
							Usu&aacute;rio
						</td>
						<td class="gridTitle">
							Movimenta&ccedil;&atilde;o
						</td>
						<td class="gridTitle">
							IP
						</td>
						<td class="gridTitle">
							Hora
						</td>
						<td class="gridTitle">
							Data
						</td>
						<td class="gridTitle">
							OBS
						</td>
					</tr>
					<?php
						$qr_select= "SELECT tb_usuario.s_login,
											TO_CHAR(tb_logs.tmp_hora, 'HH24:MI:SS') as tmp_hora,
											TO_CHAR(tb_logs.dt_login, 'DD/MM/YYYY') as dt_login,
											tb_logs.s_ip,
											tb_logs.s_obs,
											CASE WHEN tb_logs.bl_movimento = 'in'
													THEN 'Logou-se'
												 ELSE	 'Deslogou-se'
											END as movimentacao
									   FROM tb_logs,
											tb_usuario
									  WHERE tb_logs.fk_usuario = tb_usuario.pk_usuario";
						if($_GET['logs_viewer_PkUsuario'])
							$qr_select.= " AND tb_usuario.pk_usuario= ".$_GET['logs_viewer_PkUsuario'];
						if($_GET['logs_viewer_dtFin'])
							$qr_select.= " AND tb_logs.dt_login <= TO_DATE('".$_GET['logs_viewer_dtFin']."', 'DD/MM/YYYY')";
						if($_GET['logs_viewer_dtIni'])
							$qr_select.= " AND tb_logs.dt_login > TO_DATE('".$_GET['logs_viewer_dtIni']."', 'DD/MM/YYYY')";
						$qr_select.= " ORDER BY dt_login, tmp_hora";
						$data= pg_query($db_connection, $qr_select);
						$i=0;
						while ($linha = pg_fetch_array($data))
						{
							$i++;
							?>
								<tr>
									<td class="gridCell"
										style="text-align: left;">
										<?php
											echo $linha['s_login'];
										?>
									</td>
									<td class="gridCell"
										style="text-align: left;">
										<?php
											echo $linha['movimentacao'];
										?>
									</td>
									<td class="gridCell"
										style="text-align: right;">
										<?php
											echo $linha['s_ip'];
										?>
									</td>
									<td class="gridCell">
										<?php
											if($linha['s_obs'] != 'Falha na conexão')
												echo $linha['tmp_hora'];
										?>
									</td>
									<td class="gridCell">
										<?php
											if($linha['s_obs'] != 'Falha na conexão')
												echo $linha['dt_login'];
										?>
									</td>
									<td class="gridCell"
										style="text-align: left;">
										<?php
											echo htmlentities($linha['s_obs']);
										?>
									</td>
								</tr>
							<?php
						}
					?>
				</table>