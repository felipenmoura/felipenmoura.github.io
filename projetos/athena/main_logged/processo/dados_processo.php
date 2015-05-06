<?php $PREID = $_GET['PREID'] ?>

<div style="width: 100%;
			height: 100%;
			padding: 6px;
			overflow: auto;">
<table>
	<tr>
		<td style="padding-right:12px;vertical-align:top">
			Cliente
		</td>
		<td>
			<fieldset style="padding:3px;">
				<table>
					<tbody id="<?php echo $PREID;?>_tbodyCliente">
						<tr id="<?php echo $PREID;?>_trCliente">
							<td>
								
								<?php
									$_GET['component']= 'explorer';
									$_GET['componentId']= $PREID.'clienteAddProcesso';
									$_GET['componentValue']= '';
									$_GET['componentName']= '';
									$_GET['componentTipo']= 'cliente,pasta';
									$_GET['componentCliente']= 'cliente';
									//$_GET['componentShowAdd']= '';
									require_once('../components.php');
								?>
							</td>
							<td>
								<input type="button"
									   value="+"
									   onclick="if(document.getElementById('<?php echo $PREID; ?>clienteAddProcesso').value != '')
												{
													addLine('<?php echo $PREID; ?>_tbodyCliente','<?php echo $PREID;?>_trCliente',false);
												}"
									   class="botao_caract">
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td style="padding-right:12px;vertical-align:top">
			Parte contr&aacute;ria
		</td>
		<td>
			<fieldset style="padding:3px;">
				<table>
					<tbody id="<?php echo $PREID;?>_tbodyParteContraria">
						<tr id="<?php echo $PREID;?>_trParteContraria">
							<td>
								<?php
									$_GET['component']		= 'explorer';
									$_GET['componentId']	= $PREID.'parteContraria';
									$_GET['componentValue']	= '';
									$_GET['componentName']	= $PREID.'parteContraria';
									$_GET['componentTipo']	= 'contato';
									//$_GET['componentShowAdd']= '';
									include('../components.php');
								?>
							</td>
							<td>
								<input type="button"
									   value="+"
									   onclick="if(document.getElementById('<?php echo $PREID; ?>parteContraria').value != '')
												{
													addLine('<?php echo $PREID; ?>_tbodyParteContraria','<?php echo $PREID;?>_trParteContraria',false)
												}"
									   class="botao_caract">
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td style="padding-right:12px">
			N&uacute;mero / Nome Interno
		</td>
		<td>
			<input class="discret_input"
				   type="text"
				   name="processoNomeInterno"
				   id="<?=$PREID?>processoNomeInterno"
				   required="true"
				   oldvalue="">
		</td>
	</tr>
	<tr>
		<td>
			N&uacute;mero Original
		</td>
		<td>
			<input class="discret_input"
				   type="text"
				   name="processoNumeroOriginal"
				   id="<?=$PREID?>processoNumeroOriginal"
				   required="true"
				   oldvalue="">
		</td>
	</tr>
	<tr>
		<td>
			N&uacute;mero Atual
		</td>
		<td>
			<input class="discret_input"
				   type="text"
				   name="processoNumeroAtual"
				   id="<?=$PREID?>processoNumeroAtual"
				   required="true"
				   oldvalue="">
		</td>
	</tr>
	<tr>
		<td>
			Status
		</td>
		<td>
			<span>
			<?php
				$_GET['component']= 'statusProcesso';
				$_GET['componentId']= $PREID.'status_processo_add';
				include('../components.php');
			?>	
			</span>
		</td>
	</tr>
	<tr>
		<td style="padding-right:12px">
			Natureza
		</td>
		<td>
			<span>
				<?php
					$_GET['component']= 'naturezaAcao';
					$_GET['componentId']= $PREID.'natureza_acao_add';
					include('../components.php');
				?>	
			</span>
		</td>
	</tr>
	<tr>
		<td style="padding-right:12px">
			Org&atilde;o Judicial
		</td>
		<td>
			<span>
				<?php
					$_GET['component']= 'orgaoJudicial';
					$_GET['componentId']= $PREID.'orgao_judicial_add';
					include('../components.php');
				?>	
			</span>
		</td>
	</tr>
	<tr>
		<td>
			Advogado respons&aacute;vel
		</td>
		<td>
			<input class="discret_input"
				   type="text"
				   name="advogadoResponsavel"
				   id="<?=$PREID?>advogadoResponsavel"
				   required="true"
				   oldvalue="">
		</td>
	</tr>
	<tr>
		<td>
			Inst&acirc;ncia do Processo
		</td>
		<td>
			<span>
			<?php
				$_GET['component']= 'instanciaProcesso';
				$_GET['componentId']= $PREID.'instancia_processo_add';
				include('../components.php');
			?>	
			</span>
		</td>
	</tr>
	<tr>
		<td>
			Data da distribui&ccedil;&atilde;o
		</td>
		<td style="padding-top:5px">
			 <?php
				makeCalendar($PREID.'dataDistribuicao_add', '');
			 ?>
		</td>
	</tr>
	<tr>
		<td>
			Data Protocolo
		</td>
		<td style="padding-top:5px">
			<?php
				makeCalendar($PREID.'dataProtocolo', '');
			 ?>	 
		</td>
	</tr>
	<tr>
		<td style="padding-right:12px">
			Escrit&oacute;rio associado
		</td>
		<td>
			<input class="discret_input"
				   type="text"
				   name="escritorioAssociado"
				   id="<?=$PREID?>escritorioAssociado"
				   required="true"
				   oldvalue="">
		</td>
	</tr>
	<tr>
		<td>
			Fase
		</td>
		<td>
			<span>
				<?php
					$_GET['component']= 'fase';
					$_GET['componentId']= $PREID.'fase_add';
					include('../components.php');
				?>	
			</span>
		</td>
	</tr>
	<tr>
		<td>
			Rito
		</td>
		<td>
			<span>
				<?php
					$_GET['component']= 'rito';
					$_GET['componentId']= $PREID.'rito_add';
					include('../components.php');
				?>	
			</span>
		</td>
	</tr>
	<tr>
		<td>
			Posi&ccedil;&atilde;o do Cliente
		</td>
		<td>
			<span>
				<?php
					$_GET['component']= 'pos_cliente';
					$_GET['componentId']= $PREID.'pos_cliente_add';
					include('../components.php');
				?>	
			</span>
		</td>
	</tr>
	<tr>
		<td>
			Valor da causa
		</td>
		<td>
			<input class="discret_input"
				   type="text"
				   name="processoValorCausa"
				   id="<?=$PREID?>valor_causa"
				   required="true"
				   oldvalue="">
		</td>
	</tr>
	<tr>
		<td>
			Valor envolvido
		</td>
		<td>
			<input class="discret_input"
				   type="text"
				   name="processoValorEnvolvido"
				   id="<?=$PREID?>valor_envolvido"
				   required="true"
				   oldvalue="">
		</td>
	</tr>
	<tr>
		<td>
			Probabilidade de &ecirc;xito
		</td>
		<td>
			<span>
				<?php
					$_GET['component']= 'prob_exito';
					$_GET['componentId']= $PREID.'prob_exito_add';
					include('../components.php');
				?>	
			</span>
		</td>
	</tr>
	<tr>
		<td style="padding-right:12px">
			Data Encerramento
		</td>
		<td style="padding-top:5px">
			<?php
				makeCalendar($PREID.'dataEncerramento', '');
			 ?>
		</td>
	</tr>
</table>
</div>