<table valign="top">
	<tr>
		<td class="gridTitle">
			Contato
		</td>
	</tr>
	<tr>
		<td>
			<input type="text" 
				   name="list_contatos"
				   id="<?php echo $PREID?>list_contatos" 
				   style="display: none"
				   oldvalue="">
			<table class="">
				<tbody id="<?php echo $PREID; ?>contatoList">
					<tr>
						<td style="padding-right: 3px;"
							class="gridCell">
							<?php
								$_GET['component']		= 'explorer';
								$_GET['componentId']	= $PREID.'contatoAdd_contatoDoFuncionario';
								$_GET['componentValue']	= '';
								$_GET['componentName']	= 'contatoAdd_contatoDoFuncionario';
								$_GET['componentTipo']	= 'contato';
								$_GET['codeValue'] = '';
								//$_GET['componentShowAdd']= '';
								include('../components.php');
							?>
						</td>
						<td class="gridCell">
							<input type="button"
								   value="+"
								   onclick="exploreLineAdd('<?php echo $PREID; ?>contatoList');"
								   class="botao_caract"
								   onmouseover="showtip(this, event, 'Adicionar Linha');">
						</td>
					</tr>
				<?php
					/*
					for($i=0; $i<count($linha_pess_juridica_contNome); $i++)
					{
						?>
							<tr id="<? echo $linha_pess_juridica_contNome[$i]['pk_contatos_empresa']; ?>_gerCliente_edit_contato">
								<td style="padding-right: 3px;
										   text-align: left;"
									class="gridCell">
						<?
							echo htmlentities($linha_pess_juridica_contNome[$i]['s_usuario']);
						?>
								</td>
								<td class="gridCell">
									<input type="button"
										   value="-"
										   onclick="if(confirm('Tem certeza que deseja desvincular este contato desta empresa?'))
														onlyEvalAjax('ger_cliente_edit_pess_juridica.php?del=<? echo $linha_pess_juridica_contNome[$i]['pk_contatos_empresa']; ?>', '', 'eval(ajax)')"
										   class="botao_caract">
								</td>
							</tr>
						<?
					}
					*/
				?>
				</tbody>
			</table>
		</td>
	</tr>
</table>