<?php
	if(!$_GET['$PREID'])
	{
		$PREID= 'func_add_';
		$_GET['$PREID'] = $PREID;
	}else{
			$PREID= $_GET['$PREID'];
		 }
	// if($_GET['pk_usuario'])
	// {
		// $PREID= $PREID.$_GET['pk_usuario'];
	// }
	// echo $PREID;
?>
<table id="<?php echo $PREID; ?>tbodyDadosPessoais"
	   align="center">
	<tr>
		<td>
		   <table>
				<tr>
					<td style="width:150px;">
						Nome	
						<input type="text"
							   name="funcionarioNome"
							   class="discret_input"
							   required="true"
							   id="<?php echo $PREID; ?>novoFuncNome"
							   label="Nome"
							   onblur="choseSystemAccess(this);"><br>
					</td>	
					<td style="width:150px;">
						Nacionalidade
						<input type="text"
							   name="funcionarioNacionalidade"
							   class="discret_input"
							   value="Brasileiro"
							   oldValue='Brasileiro'><br>
					</td>
					<td style="padding-left:10px;
							   padding-right:5px;">
						Estado civil
						<br>
						<?php
							$_GET['component']= 'estado_civil';
							$_GET['componentId']= $PREID.'funcionarioEstadoCivil';
							$_GET['referencia']= $PREID.'conjugeCliente';
							require_once('../components.php');
						?>	
					</td>
					<td id="<?php echo $PREID; ?>conjugeCliente"
						style="display: none;
							   padding-left:8px;">
						C&ocirc;njuge<br>
						<input type="text"
							   maxlength="70"
							   id="<?php echo $PREID; ?>conjugeNameCliente"
							   name="funcionarioConjuge"
							   class="discret_input"
							   style="width:120px">
					</td>
				</tr>
		   </table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td style="width:150px;">
						Nascimento<br>
						<?php
							makeCalendar($PREID.'clienteNasc', '','80px');
						?>
					</td>
					<td style="padding-left:5px;
							   padding-right:5px;">
						Sexo<br>
						<select name="funcionarioSexo"
								id="funcionarioSexo"
								class="discret_input"
								style="display: none;">
							<option value=""></option>
							<option value="m">
								Masculino
							</option>
							<option value="f">
								Feminino
							</option>
						</select>
						
						
						
						
						
						
						
						
						
						<!--<ul type="none"
							style="padding: 0;
								   margin: 0;">
							<li>
								MENUS
								<ul style=" display: non;
											padding: 0;
											margin: 0;">
									<li>
										AAA
									</li>
									<li>
										BBB
									</li>
									<li>
										CCC
									</li>
								</ul>
							</li>
						</ul>-->
						<input type="text"
							   id="iptSexofuncionarioSexo"
							   readonly
							   class="selectIpt"
							   style="width: 110px;"
							   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
							   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
							   onclick="showSelectOptions(this, 'funcionarioSexo')">
					</td>
					<td style="padding-left:0px;
							   padding-right:5px;">
						Tipo de Pessoa
						<br>
						<select name="bl_tipo_pessoa"
								id="selectTipoPessoa"
								class="discret_input"
								style="width:120px; display: none;">
							<option value=""></option>
							<option value="F"
								    selected="selected">
								F&iacute;sica
							</option>	
							<option value="J">
								Jur&iacute;dica
							</option>
						</select>
						<input type="text"
							   id="iptSexoselectTipoPessoa"
							   readonly
							   class="selectIpt"
							   style="width: 110px;"
							   value="F&iacute;sica"
							   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
							   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
							   clickVal= "showFuncionarioTipoDoc(gebi('selectTipoPessoa'))"
							   onclick="showSelectOptions(this, 'selectTipoPessoa', this.clickVal);">
					</td>
					<td id="td_funcionario_cpf"
						style="display:;
							   padding-left:8px;">
						CPF<br>
						<input type="text"
							   maxlength="70"
							   id="funcionarioCPF"
							   name="funcionarioCPF"
							   class="discret_input"
							   style="width:120px">
					</td>
					
					<td id="td_funcionario_cnpj"
						style="display: none;
							   padding-left:8px;">
						CNPJ<br>
						<input type="text"
							   maxlength="70"
							   id="funcionarioCNPJ"
							   name="funcionarioCNPJ"
							   class="discret_input"
							   style="width:120px">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding-top:5px;">
			<table>
				<tr>
					<td>
						R.G.<br>
						<input type="text"
							   name="funcionarioRG"
							   maxlength="10"
							   class="discret_input"
							   label="RG"
							   onkeyup="numOnly(this);">
					</td>
					<td>
						Org&atilde;o Emissor:<br>
						<input type="text"
							   name="funcionarioRgOrgaoEmissor"
							   maxlength="10"
							   class="discret_input"
							   label="RGOrgao"
							   style="width: 100px"
							   onkeyup="">
					</td>
					<td>
						Data Emiss&atilde;o:<br>
						<?php
							makeCalendar($PREID.'funcionarioRgDataEmissao', '','80px');
						?>
					</td>
					<td rowspan="5"
						align="center"
						style="width:250px;">
						<div style="width:100px;
									height:120px;
									border:solid 1px #000000;">
							<table style="width: 100%;
										  height: 100%;">
								<tr>
									<td style="text-align: center;">
										<img id="foto_func"
											 src="img/no_foto.gif"
											 style="width: 100px;"><br>
									</td>
								</tr>
							</table>
						</div>
						<span style="font-size:10px">Foto 100x120 (jpg,gif,png)</span><br>
						<input type="file" 
							   name="funcionarioFoto"
							   id="funcionarioFoto"
							   onchange="loadFoto();"
							   style="width: 150px;
									  display: none;">
						<br>
						<input type="button"
							   value="Procurar ..."
							   class="botao"
							   onclick="document.getElementById('funcionarioFoto').click();">
					</td>
				</tr>
				<tr>
					<td>
						Tit. Eleitoral <br>
							<input  type="text"
									name="funcionarioTituloNum"
									class="discret_input">
					</td>
					<td>
						Zona <br>
							<input  type="text"
									name="funcionarioTituloZona"
									class="discret_input"
									style="width: 100px">
					</td>
					<td style="padding-right:5px;">
						Sess&atilde;o <br>
							<input  type="text"
									name="funcionarioTituloSessao"
									class="discret_input"
									style="width: 100px">
					</td>
				</tr>
				<tr>
					<td>
						Reservista <br>
							<input  type="text"
									name="funcionarioReservistaNum"
									class="discret_input">
					</td>
					<td>
						S&eacute;rie <br>
							<input  type="text"
									name="funcionarioReservistaSerie"
									class="discret_input"
									style="width:100px">
					</td>
					<td>
						Categoria <br>
							<input  type="text"
									name="funcionarioReservistaCategoria"
									class="discret_input"
									style="width:100px;">
					</td>
				</tr>
				<tr>
					<td style="padding-right:5px;">
						Habilita&ccedil;&atilde;o<br>
						<input  type="text"
								name="funcionarioHabilitacaoNum"
								class="discret_input">
					</td>
					<td>
						Tipo<br>
						
						<select name="funcionarioHabilitacaoTipo"
								id="funcionarioHabilitacaoTipo"
								style="width: 70px;
									   display: none;">
							<option value="A">
								A
							</option>
							<option value="B">
								B
							</option>
							<option value="AB">
								AB
							</option>
							<option value="C">
								C
							</option>
							<option value="AC">
								AC
							</option>
							<option value="D">
								D
							</option>
							<option value="AD">
								AD
							</option>
						</select>
						<input type="text"
						   id="iptComponentDependenciafuncionarioHabilitacaoTipo"
						   style="width: 100px;
								  height: 20px;
								  background-image: url(img/bt_select.gif);
								  background-repeat: no-repeat;
								  background-position: right center;
								  background-color: none;
								  border: none;
								  border: solid 1px #999999;
								  padding: 1px;
								  padding-left: 2px;
								  padding-right: 20px;
								  cursor: default;"
						   readonly
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, 'funcionarioHabilitacaoTipo')">
					</td>
					<td>
						PIS<br>
						<input type="text"
							   name="funcionarioPis"
							   maxlength="10"
							   class="discret_input"
							   onkeyup="numOnly(this);"
							   style="width:120px;">
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
						Carteira Profissional<br>
						<input type="text"
							   name="funcionarioCtpsNum"
							   maxlength="90"
							   class="discret_input">
					</td>
					<td>
						S&eacute;rie<br>
						<input type="text"
							   name="funcionarioCtpsSerie"
							   maxlength="15"
							   class="discret_input"
							   style="width:80px;">
					</td>
					<td>
						Data Emiss&atilde;o:<br>
						<?php
							makeCalendar($PREID.'clienteDataEmissaoCtps', '','80px');
						?>
					</td>
					<td style="padding-left:5px;
							   padding-right:5px;">
						UF<br>
						<?php
							$_GET['component']= 'estado';
							$_GET['componentId']= $PREID.'funcionarioEstado';
							include('../components.php');
						?>
					</td>
				</tr>
			</table>
		<td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td colspan="">
						Site <br>
							<input  type="text"
									name="funcionarioSite"
									class="discret_input">
					</td>
					<td style="padding-left:5px;">
						Escolaridade<br>
						<span>
							<?php
								$_GET['component']= 'escolaridade';
								$_GET['componentId']= $PREID.'funcionarioEscolaridade';
								include('../components.php');
							?>
						</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3"
			style="padding-top: 10px;
				   padding-bottom: 5px;">
			<b>
				Filia&ccedil;&atilde;o
			</b>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>
						Nome do pai<br>
						<input  type="text"
								name="funcionarioNomePai"
								class="discret_input"
								style="width: 250px">
					</td>
					<td>
					Nome da m&atilde;e<br>
					<input  type="text"
							name="funcionarioNomeMae"
							class="discret_input"
							style="width: 250px">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3"
			style="padding-top: 10px;
				   padding-bottom: 5px;">
			<b>
				Dados Banc&aacute;rios
			</b>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td style="text-align: left;">
						<?php
							include("../components/dados_bancarios.php");
						?>
					</td>
				</tr>
			</table>
			<br>
			<table>
				<tr>
					<td>
						<input type="checkbox"
							   name="bl_deficiencia"
							   id="bl_deficiencia"
							   onclick="showFieldDeficiencia()">
						Deficiente F&iacute;sico
					</td>
					<td id="td_deficiencia"
						style="display:none;
							   padding-left:8px;">
						<input type="text"	
							   name="funcionarioDeficiencia"
							   id="funcionarioDeficiencia"
							   class="discret_input"
							   style="width: 140px;">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
