<?php

// PERMISSÃO
$acessoWeb = 1;

require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/query_control.php");
require_once("../inc/class_explorer.php");

$PREID= "processo_add";

//if(!$db_connection= @connectTo())
	require_once("../../connections/flp_db_connection.php");
$db_connection= connectTo();
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
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form action="processo/processo_add_post.php?PREID=<?=$PREID?>"
		  method="POST"
		  id="<?=$PREID?>processoAddForm"
		  target="processoHiddenFrame___">
		<table style="margin-top: 0px;
					  width: 100%;">
			<tr>
				<td>
					<table>
						<tr>
							<td>
								Cliente / Pasta<br>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" 
									   name="list_clientes"
									   id="<?=$PREID?>list_clientes" 
									   style="display: none"
									   oldvalue="">
								<table class="">
									<tbody id="<?=$PREID?>processoClienteList">
										<tr>
											<td style="padding-right: 3px;">
												<?php
													$_GET['component']		= 'explorer';
													$_GET['componentId']	= $PREID.'pastaPasta0';
													$_GET['componentValue']	= '';
													$_GET['componentName']	= '';
													$_GET['componentTipo']	= 'pasta';
													//$_GET['componentShowAdd']= '';
													include('../components.php');
												?>
											</td>
											<td id="<?=$PREID?>td_litis_consorcio"
												style="display:none">
												Litis Cons&oacute;rcio<br>
												<input class="discret_input"
													   type="text"
													   name="litisConsorcio"
													   id="<?=$PREID?>litisConsorcio"
													   oldvalue="">
											</td>
											<td>
												<input type="button"
													   value="+"
													   onclick="exploreLineAdd('<?php echo $PREID; ?>processoClienteList');"
													   class="botao_caract"
													   onmouseover="showtip(this, event, 'Adicionar Linha');">
											</td>
										</tr>
									</tbody>
								</table>
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
								Nome Interno :<br>
								<input class="discret_input"
									   type="text"
									   name="processoNomeInterno"
									   id="<?=$PREID?>processoNomeInterno"
									   required="true"
									   oldvalue="">
							</td>
							<td>
								N&uacute;mero Original:<br>
								<input class="discret_input"
									   type="text"
									   name="processoNumero"
									   id="<?=$PREID?>processoNumero"
									   onkeyup="if(document.getElementById('<?=$PREID?>processoNomeInterno').value == '' || document.getElementById('<?=$PREID?>processoNomeInterno').value.substring(0, 5) == 'Proc_') document.getElementById('<?=$PREID?>processoNomeInterno').value= 'Proc_'+this.value"
									   oldvalue="">
							</td>
							<td>
								N&uacute;mero Atual:<br>
								<input class="discret_input"
									   type="text"
									   name="processoNumeroAtual"
									   id="<?=$PREID?>processoNumero"
									   onkeyup="if(document.getElementById('<?=$PREID?>processoNumeroAtual').value == '' || document.getElementById('<?=$PREID?>processoNumeroAtual').value.substring(0, 5) == 'Proc_') document.getElementById('<?=$PREID?>processoNumeroAtual').value= 'Proc_'+this.value"
									   oldvalue="">
							</td>
						</tr>
						<tr>
							<td>
								Status<br>
								<span>
								<?php
									$_GET['component']= 'statusProcesso';
									$_GET['componentId']= $PREID.'status_processo_add';
									include('../components.php');
								?>	
								</span>
							</td>
							<td>
								Escrit&oacute;rio Associado<br>
								<span>
								<?php
									$_GET['component']= 'escritorioAssociado';
									$_GET['componentId']= $PREID.'escritorio_associado_add';
									include('../components.php');
								?>	
								</span>
							</td>
							<td style="padding-right:10px">
								Inst&acirc;ncia do Processo<br>
								<span>
								<?php
									$_GET['component']= 'instanciaProcesso';
									$_GET['componentId']= $PREID.'instancia_processo_add';
									include('../components.php');
								?>	
								</span>
							</td>
							<td>
								Data da Distribui&ccedil;&atilde;o<br>
								<?php
									makeCalendar('dataDistribuicao_add', '');
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
				
							
							<td style="padding-left:35px;">
								Tipo de A&ccedil;&atilde;o<br>
								<span>
									<?php
										$_GET['component']= 'tipoAcao';
										$_GET['componentId']= $PREID.'novo_tipo_acao_add';
										include('../components.php');
									?>	
								</span>
							</td>
							<td style="padding-left:10px;">
								Natureza da A&ccedil;&atilde;o<br>
								<span>
									<?php
										$_GET['component']= 'naturezaAcao';
										$_GET['componentId']= $PREID.'natureza_acao_add';
										include('../components.php');
									?>	
								</span>
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
								<span>
									<?php
										$_GET['component']= 'rito';
										$_GET['componentId']= $PREID.'rito_add';
										include('../components.php');
									?>	
								</span>
							</td>
							<td style="padding-left:10px;">
								Posi&ccedil;&atilde;o Processual<br>
								<span>
									<?php
										$_GET['component']= 'posicaoProcessual';
										$_GET['componentId']= $PREID.'posicao_processual_add';
										include('../components.php');
									?>	
								</span>
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
									   oldvalue="">
							</td>
							<td>
								Valor Real :<br>
								<input class="discret_input"
									   type="text"
									   name="processoValorReal"
									   id="<?=$PREID?>processoValorReal"
									   oldvalue="">
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
										   oldvalue=""></textarea>
							</td>
							<td>
								 Objetivo<br>
								<textarea class=""
										   cols="30"
										   rows="4"
										   type="text"
										   name="processoObjetivo"
										   id="<?=$PREID?>processoObjetivo"
										   oldvalue=""></textarea>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"
					style="text-align: center;">
					<input type="button"
						   value="Salvar"
						   class="botao"
						   onclick="insertDataProcesso('<?=$PREID?>');">
				</td>
			</tr>
		</table>
	</form>
</div>
<iframe id="<?=$PREID?>processoHiddenFrame"
		name="processoHiddenFrame"
		style="display: none;">
</iframe>