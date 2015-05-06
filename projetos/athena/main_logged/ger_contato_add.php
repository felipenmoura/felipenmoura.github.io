<?php
//session_start();
//$acessoWeb= 2;
require_once("inc/valida_sessao.php");
require_once("inc/styles.php");
require_once("inc/query_control.php");
require_once("inc/calendar_input.php");
require_once("inc/class_explorer.php");

	if(!$db_connection)
	{
		include("../connections/flp_db_connection.php");
		if(!$db_connection = connectTo())
		{
			echo " Ocorreu um Erro tentar conectar !";
			exit;
		}
	}
	
	$PREID= "ace_";
	if($_POST)
	{
		showPost();
		$db_connection = connectTo();
		include "inc/get_sequence.php";
		$cliente_endereco_residencial = explode('|+|',$_POST['cliente_endereco_residencial']);
		$cliente_telefones = explode('|+|',$_POST['cliente_telefones']);
		$cliente_emails = explode('|+|',$_POST['cliente_emails']);
		
			startQuery($db_connection);
			$dadosPessoaisCod= getSequence('dados_pessoais_seq');
			$insert= "
					  INSERT INTO tb_dados_pessoais
					  (
						pk_dados_pessoais,
						s_usuario,
						c_sexo,
						web_site,
						txt_obs
					  )
					  VALUES
					  (
						".$dadosPessoaisCod.",
						'".trim($_POST['nome'])."',
						'".trim($_POST['sexoCliente'])."',
						'".trim($_POST['site'])."',
						'".trim($_POST['clientObservacao'])."'
					  );
					  
					  INSERT INTO tb_pess_fisica
					  (
						fk_dados_pessoais,
						cpf,
						s_rg,
						s_profissao,
						s_nascionalidade,
						dt_nascimento,
						fk_estado_civil
					  )
					  VALUES
					  (
						".$dadosPessoaisCod.",
						'".trim($_POST['clienteCPF'])."',
						'".trim($_POST['clienteRG'])."',
						'".trim($_POST['clienteProfissao'])."',
						'".trim($_POST['nacionalidade'])."',
						TO_DATE('".trim($_POST['clienteNasc'])."','DD/MM/YYYY'),
						".trim($_POST['ace_estado_civil_cliente'])."
					  );
					  ";
					 echo $insert;
					 $data= @pg_query($db_connection, $insert);
					 if(!$data)
					 {
						echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Fisica')</script>";
						echo pg_last_error($db_connection);
						cancelQuery($db_connection);
						exit;
					 }
					 
					// inser��o de enderecos
					for ($i=0;$i<count($cliente_endereco_residencial)-1;$i++)
					{
						$endereco = explode('||',$cliente_endereco_residencial[$i]);
						$cep_cod = getSequence('cep_seq');
						if(trim(strtoupper($endereco[8]))== 'ON' || trim(strtoupper($endereco[8])) == 'TRUE' || trim($endereco[8]) == '1')
							$endereco[8]= '1';
						else
							$endereco[8]= '0';
						
						if(
							trim($endereco[0]) != '' ||
							trim($endereco[1]) != '' ||
							trim($endereco[2]) != '' ||
							trim($endereco[3]) != '' ||
							trim($endereco[4]) != '' ||
							trim($endereco[5]) != '' ||
							trim($endereco[6]) != ''
						   )
						{
							$insert= "INSERT INTO tb_cep
									 (
										pk_cep,
										s_cep,
										s_logradouro,
										s_complemento,
										s_bairro,
										s_cidade,
										s_pais,
										bl_caixa_postal,
										s_estado_sigla,
										c_tipo_endereco
									  )
									  VALUES
									  (
										".$cep_cod.",
										'".trim($endereco[0])."',
										'".trim($endereco[1])."',
										'".trim($endereco[3])."',
										'".trim($endereco[4])."',
										'".trim($endereco[5])."',
										'".trim($endereco[6])."',
										'".trim($endereco[8])."',
										'".trim($endereco[9])."',
										'".trim($endereco[10])."'
									  )";
							echo $insert."<hr>";
							$data= @pg_query($db_connection, $insert);
							 if(!$data)
							 {
								echo"<script>alert('Falha na tentativa de Cadastro - CEP')</script>";
								echo pg_last_error($db_connection);
								cancelQuery($db_connection);
								exit;
							 }
							$insert= "INSERT INTO tb_cep_dados_pessoais
									 (
										fk_dados_pessoais,
										fk_cep,
										s_num
									  )
									  VALUES
									  (
										'".$dadosPessoaisCod."',
										'".$cep_cod."',
										'".trim($endereco[2])."'
									  )
									  ";
							echo $insert."<hr>";
							$data= @pg_query($db_connection, $insert);
							 if(!$data)
							 {
								echo"<script>alert('Falha na tentativa de Cadastro - Dados Pessoais')</script>";
								echo pg_last_error($db_connection);
								cancelQuery($db_connection);
								exit;
							 }
						}
					}
					
				// inser��o de telefones
					for($i=0;$i<count($cliente_telefones)-1;$i++)
					{
						$foneDados= explode('||', $cliente_telefones[$i]);
						$telefone_cod = getSequence('telefone_seq');
						if(trim($foneDados[0]) != '' && trim($foneDados[1]) != '' && trim($foneDados[2]) != '')
						{
							echo '|||'.urlencode($foneDados[2]).'<br>';
							$insert= "INSERT INTO tb_telefone
										 (
											pk_telefone,
											s_ddd,
											s_numero,
											fk_tipo_telefone
										  )
										  VALUES
										  (
											'".$telefone_cod."',
											'".trim($foneDados[0])."',
											'".trim($foneDados[1])."',
											'".trim($foneDados[2])."'
										  );
										  
										  INSERT INTO tb_telefone_usuario
											  (
												fk_dados_pessoais,
												fk_telefone
											  )
											  VALUES
											  (
												'".$dadosPessoaisCod."',
												'".trim($telefone_cod)."'
											  )
										  ";
								$data= @pg_query($db_connection, $insert);
								echo $insert."<hr>";
							 if(!$data)
							 {
								echo"<script>alert('Falha na tentativa de Cadastro - Telefone')</script>";
								echo pg_last_error($db_connection);
								cancelQuery($db_connection);
								exit;
							 }
						}
					}
					
					// inser��o de Emails
					for ($i=0;$i<count($cliente_emails)-1;$i++)
					{
						$email_cod = getSequence('email_seq');
						if(trim($cliente_emails[$i]) != '')
						{
							$insert= "INSERT INTO tb_email
										 (
											s_email,
											fk_dados_pessoais
										  )
										  VALUES
										  (
											'".$cliente_emails[$i]."',
											'".$dadosPessoaisCod."'
										  );";
							$data= @pg_query($db_connection, $insert);
							echo $insert."<hr>";
							 if(!$data)
							 {
								echo"<script>alert('Falha na tentativa de Cadastro - Email')</script>";
								echo pg_last_error($db_connection);
								cancelQuery($db_connection);
								exit;
							 }
						}
					}
			commitQuery($db_connection);
		?> 
			<script>
				top.setLoad(false);
				top.filho.atualizaComponents('componentContatoDaEmpresa');
				//try{top.filho.atualizaLista('list_contatos','ger_contatos_list.php');}catch(error){};
				top.showAlert('informativo', "Contato cadastrado com sucesso");
				//top.filho.document.getElementById('ger_contato_add').reload();
				//top.filho.getBlock('ace_clienteAdd_tb_visivel').reload();
				top.filho.document.getElementById('ger_contatos').reload();
			</script>
		<?php
		exit;
	}
?>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<iframe id="<?php echo $PREID; ?>hiddenFrameClientAdd"
			name="hiddenFrameClientAdd"
			style="display: none;">
	</iframe>
	<form target="hiddenFrameClientAdd"
		  id="<?php echo $PREID; ?>form_cliente_add"
		  action="ger_contato_add.php"
		  method="POST">
	<div>
		<table style="width: 100%;" cellspacing="10">
			<tbody style="height: 20px;">
					<tr>
						<td id="<?php echo $PREID; ?>clienteAdd_tb_visivel"
							colspan="2">
						
							<table id="<?php echo $PREID; ?>tbodyClienteFisica">
								<tr>
									<td style="width:150px;">
										Nome
										<input type="text"
											   name="nome"
											   class="discret_input"
											   oldvalue=""
											   label="Nome"><br>
									</td>
									<td style="width:150px;">
										Nacionalidade
										<input type="text"
											   name="nacionalidade"
											   class="discret_input"
											   oldvalue=""
											   value="Brasileiro"><br>
									</td>
									<td style="width:150px;">
										Estado civil
										<br>
										<?php
											$_GET['component']= 'estado_civil';
											$_GET['componentId']= $PREID.'estado_civil_cliente';
											$_GET['referencia']= $PREID.'conjugeCliente';
											include('components.php');
										?>	
									</td>
								</tr>
								<tr>
									<td>
										Nascimento<br>
										<?php
											makeCalendar('clienteNasc', '');
										?>
									</td>
									<td>
										Sexo<br>
										<select name="sexoCliente"
												class="discret_input">
											<option value="m">
												Masculino
											</option>
											<option value="f">
												Feminino
											</option>
										</select>
									</td>
									<td id="<?php echo $PREID; ?>conjugeCliente"
										style="display: none;">
										C&ocirc;njuge<br>
										<input type="text"
											   maxlength="70"
											   id="<?php echo $PREID; ?>conjugeNameCliente"
											   name="conjugeName"
											   oldvalue=""
											   class="discret_input">
									</td>
								</tr>
								<tr>
									<td>
										Profiss&atilde;o<br>
										<input type="text"
											   name="clienteProfissao"
											   maxlength="90"
											   oldvalue=""
											   class="discret_input">
									</td>
									<td>
										C.P.F<br>
										<input type="text"
											   name="clienteCPF"
											   maxlength="15"
											   oldvalue=""
											   class="discret_input"
											   onkeyup="mascaraCPF(this, event);"
											   label="CPF">
									</td>
									<td>
										R.G.<br>
										<input type="text"
											   name="clienteRG"
											   maxlength="10"
											   oldvalue=""
											   class="discret_input"
											   label="RG"
											   onkeyup="numOnly(this);">
									</td>
								</tr>
								<tr>
									<td colspan="3">
										Site <br>
											<input type="text"
										    name="site"
											oldvalue=""
										    class="discret_input">
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
					<tr style="display: none;">
						<td colspan="3">
							<input id="<?php echo $PREID; ?>cliente_endereco_residencial" type="text" name="cliente_endereco_residencial">
							<input id="<?php echo $PREID; ?>cliente_telefones" type="text" name="cliente_telefones">
							<input id="<?php echo $PREID; ?>cliente_emails" type="text" name="cliente_emails">
							<input id="<?php echo $PREID; ?>clientLoginSub" type="text" name="clientLoginSub">
							<input id="<?php echo $PREID; ?>clientLoginSubPwd" type="text" name="clientLoginSubPwd">
							<input id="<?php echo $PREID; ?>clientObservacao" type="text" name="clientObservacao">
						</td>
					</tr>
				<tr>
					<td colspan="3">
					
					
					
						<table id="<?php echo $PREID; ?>clienteEndList"
							   style="width: 100%">
							<tr>
								<td class="gridTitle">
									Endere&ccedil;o
								</td>
							</tr>
							<tbody>
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
													include('components.php');
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
													   label="Pa&iacute;s">
											</td>
											<td class="gridCell"
												style="text-align: right;">
												Tipo
												<select name="clienteTipoEndereco"
														id="<?php echo $PREID; ?>clienteTipoEndereco"
														class="list_dados"
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
						
						
					</td>
				</tr>
				<tr>
					<td colspan="4"
						style="vertical-align: top;">
						<table width="100%">
							<tr>
								<td style="vertical-align: top;">
									<table>
										<tr>
											<td colspan="2"
												class="gridTitle">
												E-mail
											</td>
										</tr>
										<tbody id="<?php echo $PREID; ?>clienteEmailList">
											<tr>
												<td style="padding-right: 3px;"
													class="gridCell">
													<input type="text"
														   style=""
														   oldvalue=""
														   name="clienteEmail"
														   id="<?php echo $PREID; ?>clienteEmail"> 
												</td>
												<td class="gridCell">
													<input type="button"
														   value="+"
														   onclick="if(document.getElementById('<?php echo $PREID; ?>clienteEmail').value != ''
																		&& validaEMail(document.getElementById('<?php echo $PREID; ?>clienteEmail')))
																	{
																		addToList('<?php echo $PREID; ?>clienteEmailList', '<?php echo $PREID; ?>clienteEmail');
																		document.getElementById('<?php echo $PREID; ?>clienteEmail').value='';
																	}"
														   class="botao_caract">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td style="vertical-align: top;">
									<table>
										<tr>
											<td colspan="4"
												class="gridTitle">
												Telefone
											</td>
										</tr>
										<tbody id="<?php echo $PREID; ?>clienteFoneList">
											<tr>
												<td style="padding-right: 3px;"
													class="gridCell">
													<input type="text"
														   style="width: 25px;"
														   name="clienteFoneDDD"
														   oldvalue=""
														   maxlength="2"
														   onkeyup="numOnly(this);"
														   
														   label="DDD"
														   id="<?php echo $PREID; ?>clienteFoneDDD">
												</td>
												<td style="padding-right: 3px;"
													class="gridCell">
													<input type="text"
														   style="width: 90px;"
														   oldvalue=""
														   onkeyup="numOnly(this);"
														   maxlength="12"
														   
														   label="Telefone"
														   name="clienteFone"
														   id="<?php echo $PREID; ?>clienteFone"> 
												</td>
												<td style="padding-right: 3px;
														   text-align: left;"
													class="gridCell">
													<?php
														$_GET['component']= 'tipoFone';
														$_GET['componentId']= $PREID.'clienteFoneTipo';
														include('components.php');
													?>
												</td>
												<td class="gridCell">
													<input type="button"
														   value="+"
														   onclick="addToList('<?php echo $PREID; ?>clienteFoneList', '<?php echo $PREID; ?>clienteFoneDDD, <?php echo $PREID; ?>clienteFone, <?php echo $PREID; ?>clienteFoneTipo, iptComponentFone<?php echo $PREID; ?>clienteFoneTipo');"
														   class="botao_caract">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td style="vertical-align: top;">
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
			<tr>
				<td colspan="4"
					style="padding: 7px">
					Obs<br>
					<textarea name="clienteObs"
							  id="<?php echo $PREID; ?>clienteObs"
							  oldvalue=""
							  style="width: 100%;
									 height: 150px;
									 "></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4"
					style="text-align: center; height: 15px;">
					<input type="button"
						   class="botao"
						   value="Salvar"
						   onclick="validNewClient('<?php echo $PREID; ?>')"> 
					<input type="button"
						   class="botao"
						   value="Cancelar"
						   onclick="getBlock(this).reload();">
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>