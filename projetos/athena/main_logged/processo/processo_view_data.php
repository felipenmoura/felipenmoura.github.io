<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/class_explorer.php");
include("../../connections/flp_db_connection.php");
$db_connection= @connectTo();
$PREID= 'processo_view_data';


$query = "
			SELECT 
			       P.pk_processo as pk_processo,
			       P.s_nome as nome_processo,
			       P.s_numero as numero_processo,
			       P.f_valor_causa as valor_causa,
			       P.f_valor_real as valor_real,
			       P.s_obs as obs,
			       P.s_objetivo as obj,
			       P.dt_update,
			       P.dt_criacao,
			       P.dt_data_distribuicao as data_distribuicao,
			       P.fk_criador,
			       P.fk_status,
			       P.fk_escritorio_associado,
			       P.fk_instancia_processo,
			       P.fk_tipo_acao,
			       P.fk_natureza_acao,
			       P.fk_rito,
			       P.fk_posicao_processual,
			       P.vfk_user_atualizacao,
			       DP.s_usuario,
			       DP.vfk_usuario,
			       SP.pk_status_processo,
			       SP.s_nome as status_processo,
			       EA.pk_escritorio_associado,
			       EA.s_nome as escritorio_associado,
			       IP.pk_instancia_processo,
			       IP.s_nome as isntancia_processo,
			       TA.pk_tipo_acao,
			       TA.s_nome as tipo_acao,
			       NA.pk_natureza_acao,
			       NA.s_nome as natureza_acao	,
			       TR.pk_rito,
			       TR.s_nome as rito,
			       PP.pk_posicao_processual,
			       PP.s_nome as posicao_processual
			FROM
				tb_processo P
			INNER JOIN 
				tb_dados_pessoais DP
			ON 
				(DP.vfk_usuario = P.fk_criador)
			INNER JOIN 
				tb_status_processo SP
			ON 
				(SP.pk_status_processo = P.fk_status)
			INNER JOIN
				tb_escritorio_associado EA
			ON
				(EA.pk_escritorio_associado = P.fk_escritorio_associado)
			INNER JOIN 
				tb_instancia_processo IP
			ON 
				(IP.pk_instancia_processo = P.fk_instancia_processo)
			INNER JOIN 
				tb_tipo_acao TA
			ON
				(TA.pk_tipo_acao = P.fk_tipo_acao)
			INNER JOIN 
				tb_natureza_acao NA
			ON
				(NA.pk_natureza_acao = P.fk_natureza_acao)
			INNER JOIN 
				tb_rito TR
			ON	
				(TR.pk_rito = P.fk_rito)
			INNER JOIN
				tb_posicao_processual PP
			ON
				(PP.pk_posicao_processual =  P.fk_posicao_processual)
			WHERE pk_processo = ".$_GET['pk_processo']."
		";
		
	$data= pg_query($db_connection, $query);
	$linha = pg_fetch_array($data);
	
	if ($data)
	{
		?>
			<table style="height: 100%;
						  width: 100%">
				<tr>
					<td style="vertical-align: top;">
						<table style="margin-top:10px;
							          width: 100%;"
							   class="gridCellAtLeft">
							  <tr>
									<td class="gridCell">
										<span style="font-weight:bold">Nome Interno: </span> <?php echo $linha['nome_processo'];?>
									</td>
							  </tr>
							  <tr>
									<td class="gridCell">
										<span style="font-weight:bold">N&uacute;mero: </span> <?php echo $linha['numero_processo'];?>
									</td>
							  </tr>
							  <tr>
									<td class="gridCell">
										<span style="font-weight:bold">Status: </span> <?php echo $linha['status_processo'];?>
									</td>
							  </tr>
									<td class="gridCell">
										<span style="font-weight:bold">Escrit&oacute;rio Associado: </span> <?php echo $linha['escritorio_associado'];?>
									</td>
							  </tr>
							  <tr>
									<td class="gridCell">
										<span style="font-weight:bold">Inst&acirc;ncia do Processo: </span><?php echo $linha['isntancia_processo'];?>
									</td>
							  </tr>
							  <tr>
									<td class="gridCell">
										<span style="font-weight:bold">Data da Distribui&ccedil;&atilde;o: </span> <?php echo $linha['data_distribuicao'];?>
									</td>
							  </tr>
							  <tr>
									<td class="gridCell">	
										<span style="font-weight:bold">Tipo de A&ccedil;&atilde;o: </span> <?php echo $linha['tipo_acao'];?>
									</td>
							  <tr>
									<td class="gridCell">
										<span style="font-weight:bold">Natureza da A&ccedil;&atilde;o: </span> <?php echo $linha['natureza_acao'];?>
									</td>
							  </tr>
							  <tr>
									<td class="gridCell">
										<span style="font-weight:bold">Rito: </span> <?php echo $linha['rito'];?>
									</td>
							   </tr>
							   <tr>
									<td class="gridCell">
										<span style="font-weight:bold">Posi&ccedil;&atilde;o Processual: </span> <?php echo $linha['posicao_processual'];?>
									</td>
								</tr>
								<tr>
									<td class="gridCell">
										<span style="font-weight:bold">Valor da Causa: </span> <?php echo $linha['valor_causa'];?>
									</td>
								</tr>
								<tr>
									<td class="gridCell">
										<span style="font-weight:bold">Valor Real : </span> <?php echo $linha['valor_real'];?>
									</td>
								</tr>
								<tr>
									<td style="vertical-align: top;">
										<table>
											<tr>
												<td>
													 Observa&ccedil;&atilde;o<br>
													<textarea class=""
															   cols="30"
															   rows="4"
															   type="text"
															   name="processoObs"
															   readonly=readonly
															   id="processoObs"
															   oldvalue=""><?php echo $linha['obs'];?></textarea>
												</td>
												<td>
													 Objetivo<br>
													<textarea class=""
															   cols="30"
															   rows="4"
															   type="text"
															   name="processoObjetivo"
															   readonly=readonly
															   id="processoObjetivo"
															   oldvalue=""><?php echo $linha['obj'];?></textarea>
												</td>
											</tr>
										</table>
									</td>
								</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<div style="font-size:14px;
								    text-decoration:underline;
									cursor:pointer;
									width:110px;"
									onclick="creatBlock('Alterar - <?php echo $linha['nome_processo']; ?>', 'processo/ger_processo.php?pk_processo=<?php echo $linha['pk_processo']; ?>&nome=<?php echo $linha['nome_processo']; ?>','edit_processo',false,false,'750/500');">
						<img src="img/edit.gif">
						Alterar Dados
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
		<?php
	}
?>