<table id="<?php echo $PREID; ?>contatos"
	   style="width: 100%">
	<tr>
		<td class="gridTitle">
			Endere&ccedil;o
		</td>
	</tr>
	<tbody id="<?php echo $PREID; ?>cliente_endereco_tbody_pai">
	<tr>
		<td id="<?php echo $PREID; ?>clienteEnderecos">
			<table cellpadding="0"
				   cellspacing="0"
				   style="width: 100%"
				   id="<?php echo $PREID; ?>clienteEnderecoTbody"
				   style="border-bottom: solid 1px #333366;">
				<tr id="<?php echo $PREID; ?>clienteEnderecoModelLine"
					style="">
					<td class="gridCell"
						style="text-align: right;">
						CEP
						<input class="list_dados"
							   type="text"
							   name="cep"
							   style="width: 70px;"
							   id="<?php echo $PREID; ?>clienteCEP"
							   pre="<?php echo $PREID; ?>"
							   onkeyup="mascaraCEP(this); if(this.value.length == 9 && this.lastChecked!=this.value){this.blur(); this.lastChecked=this.value; ajax= ''; top.setLoad(true); onlyEvalAjax('inc/cep.php?cep='+this.value.replace(/-/, ''), '', 'setCEP(ajax, \''+this.getAttribute('pre')+'\');');}"
							   onblur="">
					</td>
					<td class="gridCell"
						style="text-align: right;">
						Rua
						<input type="text"
							   class="list_dados"
							   name="logradouro"
							   style="width: 120px;"
							   id="<?php echo $PREID; ?>clienteLogradouro"
							   maxlength="240"
							   required="true"
							   onmousemove="showtip(this, event, this.value);"
							   label="Logradouro">
					</td>
					<td class="gridCell"
						style="text-align: right;">
						Nro
						<input type="text"
							   class="list_dados"										
							   name="nro"
							   style="width: 60px;"
							   id="<?php echo $PREID; ?>clienteNro"
							   required="true"
							   maxlength="8"
							   label="N&uacute;mero"
							   onkeyup="//numOnly(this);">
					</td>
					<td class="gridCell"
						style="text-align: right;">
						Comp.
						<input type="text"
							   class="list_dados"
							   name="complemento"
							   style="width: 60px;"
							   maxlength="240"
							   onmousemove="showtip(this, event, this.value);"
							   id="<?php echo $PREID; ?>clienteComplemento">
					</td>
					<td class="gridCell"
						style="text-align: right;">
						Bairro
						<input type="text"
							   class="list_dados"
							   name="bairro"
							   style="width: 90px;"
							   id="<?php echo $PREID; ?>clienteBairro"
							   maxlength="240"
							   onmousemove="showtip(this, event, this.value);"
							   required="true"
							   label="Bairro">
					</td>
					<td class="gridCell" rowspan="2"
						style="text-align: right;">
						<input type="button"
							   value="+"
							   onclick="enderecoNewLine('<?php echo $PREID; ?>clienteEnderecoTbody', '<?php echo $PREID; ?>clienteEnderecoList', '<?php echo $PREID; ?>clienteCEP,<?php echo $PREID; ?>clienteLogradouro,<?php echo $PREID; ?>clienteNro,<?php echo $PREID; ?>clienteComplemento,<?php echo $PREID; ?>clienteBairro,<?php echo $PREID; ?>clienteCidade,<?php echo $PREID; ?>clienteEstado,<?php echo $PREID; ?>clientePostagem')
										document.getElementById('<?php echo $PREID; ?>clientePostagem').checked = false;"
							   class="botao_caract">
					</td>
				</tr>
				<tr>
					<td class="gridCell"
						style="text-align: right;">
						Cidade
						<input type="text"
							   class="list_dados"
							   name="cidade"
							   maxlength="240"
							   style="width: 90px;"
							   id="<?php echo $PREID; ?>clienteCidade"
							   onmousemove="showtip(this, event, this.value);"
							   required="true"
							   label="Cidade">
					</td>
					<td class="gridCell"
						style="text-align: right;">
						UF
						<!--
						<input type="text"
							   name="estado"
							   style="width: 30px;"
							   id="<?php echo $PREID; ?>clienteEstado">
						-->
						<?php
							$_GET['component']= 'estado';
							$_GET['componentId']= $PREID.'clienteEstado';
							include('../components.php');
						?>								
					</td>
					<td class="gridCell"
						style="text-align: right;">
						Pa&iacute;s
						<input type="text"
							   class="list_dados"
							   name="pais"
							   style="width: 70px;"
							   value="Brasil"
							   oldValue="Brasil"
							   id="<?php echo $PREID; ?>clientePais"
							   required="true"
							   label="Pa&iacute;s">
					</td>
					<td class="gridCell"
						style="text-align: right;">
						Tipo
						<select name="clienteTipoEndereco"
								id="<?php echo $PREID; ?>clienteTipoEndereco"
								class="list_dados"
								required="true"
								label="Tipo de endere&ccedil;o">
							<option value="R">
								Residencial
							</option>
							<option value="C">
								Comercial
							</option>
						</select>
					</td>
					<td class="gridCell"
						style="text-align: right;">
						<input type="checkbox"
							   class="list_dados"
							   name="clientePostagem"
							   id="<?php echo $PREID; ?>clientePostagem">
						Caixa postal
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td id="<?php echo $PREID; ?>clienteEnderecoList">
		</td>
	</tr>
	</tbody>
</table>