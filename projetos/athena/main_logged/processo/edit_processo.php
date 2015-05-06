<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/class_explorer.php");
require_once("../../connections/flp_db_connection.php");
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
			       TO_CHAR(P.dt_data_distribuicao, 'DD/MM/YYYY') as data_distribuicao,
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
			       NA.s_nome as natureza_acao,
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
		
	$data= @pg_query($db_connection, $query);
	$linha = @pg_fetch_array($data);
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="processo/processo_update_post.php"
		  method="POST"
		  id="<?=$PREID?>processoUpdateForm"
		  target="processoHiddenFrame">
		<table style="margin-top: 0px;
					  width: 100%;">
			<?php
				$queryClientes= "SELECT s_usuario
								  FROM tb_processo_pasta
								  LEFT JOIN tb_pasta
								    ON  (
											pk_pasta = fk_pasta
										)
								 INNER JOIN tb_dados_pessoais
									ON	(
											vfk_usuario = fk_usuario
										)
								  WHERE fk_processo = ".$linha['pk_processo'];
				$dataClientes= @pg_query($db_connection, $queryClientes);
				while($linhaClientes = @pg_fetch_array($dataClientes))
				{
					?>
						<tr>
							<td>
								Cliente: 
								<span style="font-size: 15;
											 font-weight: bold;
											 text-decoration: underline;">
									<?=$linhaClientes['s_usuario']?>
								</span>
							<td>
						<tr>
					<?php
				}
			?>
			<tr>
				<td>
					<table>
						<tr>
							<td>
								N&uacute;mero :<br>
								<input class="discret_input"
									   type="text"
									   name="processoNumero"
									   id="<?=$PREID?>processoNumero"
									   onkeyup="if(document.getElementById('<?=$PREID?>processoNomeInterno').value == '' || document.getElementById('<?=$PREID?>processoNomeInterno').value.substring(0, 5) == 'Proc_') document.getElementById('<?=$PREID?>processoNomeInterno').value= 'Proc_'+this.value"
									   oldvalue="<?php echo $linha['numero_processo']; ?>"
									   value="<?php echo $linha['numero_processo']; ?>">
							</td>
							<td>
								Nome Interno :<br>
								<input class="discret_input"
									   type="text"
									   name="processoNomeInterno"
									   id="<?=$PREID?>processoNomeInterno"
									   required="true"
									   oldvalue="<?php echo $linha['nome_processo']; ?>"
									   value="<?php echo $linha['nome_processo']; ?>">
							</td>
							<td style="padding-left:10px;">
								Status<br>
								<?php
									$_GET['component']= 'statusProcesso';
									$_GET['componentId']= $PREID.'status_processo_add';
									$_GET['valor'] = $linha['status_processo'];
									include('../components.php');
								?>	
							</td>
							<td style="padding-left:10px;">
								Escrit&oacute;rio Associado<br>
								<?php
									$_GET['valor'] = '';
									$_GET['component']= 'escritorioAssociado';
									$_GET['componentId']= $PREID.'escritorio_associado_add';
									$_GET['code'] = $linha['fk_escritorio_associado'];
									include('../components.php');
								?>	
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td style="padding-right:10px">
								Inst&acirc;ncia do Processo<br>
								<?php
									$_GET['component']= 'instanciaProcesso';
									$_GET['componentId']= $PREID.'instancia_processo_add';
									$_GET['valor'] = $linha['isntancia_processo'];
									include('../components.php');
								?>	
							</td>
							<td>
								Data da Distribui&ccedil;&atilde;o<br>
								<?php
									makeCalendar('dataDistribuicao_add', $linha['data_distribuicao']);
								?>
							</td>
							<td style="padding-left:35px;">
								Tipo de A&ccedil;&atilde;o<br>
									<?php
										$_GET['component']= 'tipoAcao';
										$_GET['componentId']= $PREID.'novo_tipo_acao_add';
										$_GET['valor'] = $linha['tipo_acao'];
										include('../components.php');
									?>	
							</td>
							<td style="padding-left:10px;">
								Natureza da A&ccedil;&atilde;o<br>
									<?php
										$_GET['component']= 'naturezaAcao';
										$_GET['componentId']= $PREID.'natureza_acao_add';
										$_GET['valor'] = $linha['natureza_acao'];
										include('../components.php');
									?>	
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td>
								Rito<br>
									<?php
										$_GET['component']= 'rito';
										$_GET['componentId']= $PREID.'rito_add';
										$_GET['valor'] = $linha['rito'];
										include('../components.php');
									?>	
							</td>
							<td style="padding-left:10px;">
								Posi&ccedil;&atilde;o Processual<br>
									<?php
										$_GET['component']= 'posicaoProcessual';
										$_GET['componentId']= $PREID.'posicao_processual_add';
										$_GET['valor'] = $linha['posicao_processual'];
										include('../components.php');
									?>	
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td>
								Valor da Causa :<br>
								<input class="discret_input"
									   type="text"
									   name="processoValorCausa"
									   id="<?=$PREID?>processoValorCausa"
									   value="<?=$linha['valor_causa']?>"
									   oldvalue="<?=$linha['valor_causa']?>">
							</td>
							<td>
								Valor Real :<br>
								<input class="discret_input"
									   type="text"
									   name="processoValorReal"
									   id="<?=$PREID?>processoValorReal"
									   value="<?=$linha['valor_real']?>"
									   oldvalue="<?=$linha['valor_real']?>">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td>
								 Observa&ccedil;&atilde;o<br>
								<textarea class=""
										   cols="30"
										   rows="4"
										   type="text"
										   name="processoObs"
										   id="<?=$PREID?>processoObs"
										   oldvalue="<?=$linha['obs']?>"><?=$linha['obs']?></textarea>
							</td>
							<td>
								 Objetivo<br>
								<textarea class=""
										   cols="30"
										   rows="4"
										   type="text"
										   name="processoObjetivo"
										   id="<?=$PREID?>processoObjetivo"
										   oldvalue="<?=$linha['obs']?>"><?=$linha['obs']?></textarea>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<!--
					<input type="button"
						   value="Salvar"
						   class="botao"
						   onclick="insertDataProcesso()">
					-->
				</td>
			</tr>
		</table>
	</form>
</div>
<iframe id="<?=$PREID?>processoHiddenFrame"
		name="processoHiddenFrame"
		style="display: none;">
</iframe>