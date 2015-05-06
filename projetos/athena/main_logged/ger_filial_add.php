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
	$db_connection = connectTo();
}
$PREID= 'ger_filial_';
	if ($_POST)
	{
		showPost();

		$db_connection = connectTo();
		include "inc/get_sequence.php";
		$cliente_endereco_residencial = explode('|+|',$_POST['cliente_endereco_residencial']);
		$cliente_telefones = explode('|+|',$_POST['cliente_telefones']);
		$cliente_emails = explode('|+|',$_POST['cliente_emails']);
		
				startQuery($db_connection);
				$dadosPessoaisCod= getSequence('dados_pessoais_seq');
				$_POST['clienteAdd_responsavel']= explode('|+|', $_POST['clienteAdd_responsavel']);
				$_POST['clienteAdd_responsavel']= $_POST['clienteAdd_responsavel'][0];
				if($_POST['clienteAdd_responsavel'] == '')
					$_POST['clienteAdd_responsavel']= 'NULL';
				if(trim($_POST['nome_fantasia']) == '')
					$_POST['nome_fantasia']= $_POST['razao_social'];
				$insert= "
					
					 INSERT INTO tb_dados_pessoais
					  (
						pk_dados_pessoais,
						s_usuario,
						web_site,
						txt_obs
					  )
					  VALUES
					  (
						".$dadosPessoaisCod.",
						'".trim($_POST['nome_fantasia'])."',
						'".trim($_POST['site'])."',
						'".trim($_POST['clientObservacao'])."'
					  );
					  
					  INSERT INTO tb_pess_juridica
							  (
								fk_dados_pessoais,
								razao_social,
								nome_fantasia,
								inscr_estadual,
								inscr_municipal,
								cnpj,
								fk_ramo_atividade,
								vfk_responsavel
							  )
							  VALUES
							  (
								".$dadosPessoaisCod.",
								'".trim($_POST['razao_social'])."',
								'".trim($_POST['nome_fantasia'])."',
								'".trim($_POST['inscr_estadual'])."',
								'".trim($_POST['inscr_municipal'])."',
								'".trim($_POST['cnpj'])."',
								'".trim($_POST['cliente_add_ramo_atividade'])."',
								 ".trim($_POST['clienteAdd_responsavel'])."
							  );
					";
					 $data= pg_query($db_connection, $insert);
					 if(!$data)
					 {
						echo $insert."<hr>";
						echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Juridica".str_replace('\n','',nl2br(pg_last_error($db_connection).' - '.str_replace('
', '', $insert)))."')</script>";
						echo pg_last_error($db_connection);
						cancelQuery($db_connection);
						exit;
					 }
					 
					 echo "---- ".$_POST['cliente_filiais']."<br>";
					 $filiais= explode('|+|', $_POST['cliente_filiais']);
					 for($i=0; $i<count($_POST['cliente_filiais']); $i++)
					 {
						$filiais[$i]= explode(' - ', $filiais[$i]);
						$filiais[$i]= $filiais[$i][0];
						echo $filiais[$i];
						if(trim($filiais[$i]) != '')
						{
							$insert=" INSERT INTO tb_filial_dados_pessoais
									  (
										fk_dados_pessoais,
										vfk_filial
									  )
									  VALUES
									  (
										".$dadosPessoaisCod.",
										".$filiais[$i]."
									  );";
							$data= @pg_query($db_connection, $insert);
							if(!$data)
							{
								echo $insert."<hr>";
								echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Juridica".str_replace('\n','',nl2br(pg_last_error($db_connection).' - '.str_replace('
', '', $insert)))."')</script>";
								echo pg_last_error($db_connection);
								cancelQuery($db_connection);
								exit;
							}
						}
					 }
					 echo "----------------------------------------------------------------";
					 echo "---- ".count($_POST['cliente_contatos'])."<br>";
					$_POST['cliente_contatos']= explode(';;;;;;|+|', $_POST['list_contatos']);
					 for($i=0; $i<count($_POST['cliente_contatos'])-1; $i++)
					 {
						$contatos= explode('|+|', $_POST['cliente_contatos'][$i]);
						if(trim(str_replace(';','',$contatos[0])) != '')
						{
							$insert=" INSERT INTO tb_contatos_empresa
									  (
										fk_dados_pessoais,
										vfk_contato
									  )
									  VALUES
									  (
										".$dadosPessoaisCod.",
										".$contatos[0]."
									  )";
							$data= @pg_query($db_connection, $insert);
							if(!$data)
							{
								echo $insert."<hr>";
								echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Juridica".str_replace('\n','',nl2br(pg_last_error($db_connection).' - '.str_replace('
', '', $insert)))."')</script>";
								echo pg_last_error($db_connection);
								cancelQuery($db_connection);
								exit;
							}
							echo $insert;
						}
					 }
					 echo "----";
					 
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
					echo 'XXXXXXXXXXXXXXXX'.$_POST['cliente_telefones'].'<br>';
					$telefones= explode('|+|', $_POST['cliente_telefones']);
					for ($i=0;$i<count($cliente_telefones)-1;$i++)
					{
						$foneDados= explode('||', $telefones[$i]);
						$telefone_cod = getSequence('telefone_seq');
						if(trim($foneDados[0]) != '' && trim($foneDados[1]) != '' && trim($foneDados[2]) != '')
						{
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
		//$data= pg_query($db_connection, $insert);
		
		if($data)
		{
			?> 
				<script>
					//try{top.filho.atualizaLista('list_filiais','ger_filiais_list.php');}catch(error){};
					top.filho.document.getElementById('ger_filiais').reload();
					alert('Filial cadastrada com sucesso');
				</script>
			<?php
		}else{
			?> 
				<script>alert('Ocorreu um erro ao tentar cadastrar o novo cliente !');</script>
			<?php
		}
		exit;
	}
?>
<iframe id="<?php echo $PREID; ?>hiddenFrameClientAdd"
		name="<?php echo $PREID; ?>hiddenFrameClientAdd"
		style="display: none;">
</iframe>
<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form name="form_cliente_add" 
		  target="<?php echo $PREID; ?>hiddenFrameClientAdd"
		  id="<?php echo $PREID; ?>form_cliente_add"
		  action="ger_filial_add.php"
		  method="POST">
	<div>
		<table style="width: 100%; " cellspacing="10">
			<tbody style="height: 20px;">
			<tr>
				<td style="width:150px;">
					Raz&atilde;o Social
					<input type="text"
						   name="razao_social"
						   class="discret_input"
						   name="sad"
						   required="true"
						   label="Raz&atilde;o social"><br>
				</td>
				<td style="width:150px;">
					Nome Fantasia
					<input type="text"
						   name="nome_fantasia"
						   class="discret_input"
						   label="Nome fantasia">
				</td>
			</tr>
			<tr>
				<td style="width:150px;">
					CNPJ
					<input type="text"
						   name="cnpj"
						   class="discret_input"
						   onkeyup="numOnly(this);"
						   maxlength="18"
						   label="CNPJ">
				</td>
				<td style="width:150px;">
					Inscri&ccedil;&atilde;o Estadual
					<input type="text"
						   name="inscr_estadual"
						   class="discret_input"
						   maxlength="40"
						   onkeyup="numOnly(this);">
				</td>
					<td style="width:150px;">
					Inscri&ccedil;&atilde;o Municipal
					<input type="text"
						   name="inscr_municipal"
						   class="discret_input"
						   maxlength="40"
						   onkeyup="numOnly(this);">
				</td>
			</tr>
			<tr>
				<td style="width:150px;">
					WebSite<br>
					<input type="text" name="site" class="discret_input"><br>
				</td>
				<td style="width:150px;">
					Ramo de Atividade<br>
					<?php
						$_GET['component']='ramo_atividade';
						$_GET['componentId']='cliente_add_ramo_atividade';
						include "components.php";
					?>
				</td>
				<td style="width:150px;">
					Respons&aacute;vel<br>
					<?php
						//contatoAdd($PREID.'clienteAdd_responsavel', '', 'clienteAdd_responsavel', 'cliente');
						$_GET['component']		= 'explorer';
						$_GET['componentId']	= $PREID.'clienteAdd_responsavel';
						$_GET['componentValue']	= $content;
						$_GET['componentName']	= 'clienteAdd_responsavel';
						$_GET['componentTipo']	= 'contato';
						//$_GET['componentShowAdd']= '';
						include('components.php');
					?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;">
					<?php
						//contatoAdd('clienteAdd_contatoDaEmpresa', '', 'clienteAdd_contatoDaEmpresa', 'cliente');
						/*
						$_GET['component']= 'contatoDaEmpresa';
						$_GET['componentId']= 'clienteAdd_contatoDaEmpresa';
						include('components.php');
						*/
					?>
					<table>
						<tr>
							<td>
								Contato<br>
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
											<td style="padding-right: 3px;">
												<?php
													$_GET['component']		= 'explorer';
													$_GET['componentId']	= $PREID.'contatoAdd_contatoDaEmpresa';
													$_GET['componentValue']	= '';
													$_GET['componentName']	= 'contatoAdd_contatoDaEmpresa';
													$_GET['componentTipo']	= 'contato';
													//$_GET['componentShowAdd']= '';
													include('components.php');
												?>
											</td>
											<td>
												<input type="button"
													   value="+"
													   onclick="exploreLineAdd('<?php echo $PREID; ?>contatoList');"
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
				<td style="vertical-align: top;"
					colspan="4">
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
														   maxlength="2"
														   onkeyup="numOnly(this);"
														   label="DDD"
														   id="<?php echo $PREID; ?>clienteFoneDDD">
												</td>
												<td style="padding-right: 3px;"
													class="gridCell">
													<input type="text"
														   style="width: 90px;"
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
														   onclick="addToList('<?php echo $PREID; ?>clienteFoneList', '<?php echo $PREID; ?>clienteFoneDDD, <?php echo $PREID; ?>clienteFone, <?php echo $PREID; ?>clienteFoneTipo, iptComponentFone<?php echo $_GET['componentId'] ?>');"
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
					<tr style="display: none;">
						<td colspan="3">
							<input id="<?php echo $PREID; ?>cliente_endereco_residencial" type="text" name="cliente_endereco_residencial">
							<input id="<?php echo $PREID; ?>cliente_telefones" type="text" name="cliente_telefones">
							<input id="<?php echo $PREID; ?>cliente_contatos" type="text" name="cliente_contatos">
							<input id="<?php echo $PREID; ?>cliente_filiais" type="text" name="cliente_filiais">
							<input id="<?php echo $PREID; ?>cliente_emails" type="text" name="cliente_emails">
							<input id="<?php echo $PREID; ?>clientLoginSub" type="text" name="clientLoginSub">
							<input id="<?php echo $PREID; ?>clientLoginSubPwd" type="text" name="clientLoginSubPwd">
							<input id="<?php echo $PREID; ?>clientObservacao" type="text" name="clientObservacao">
						</td>
					</tr>
				</form>
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
					</td>
				</tr>
			</tbody>
			<tr>
				<td colspan="4"
					style="padding: 7px">
					Obs<br>
					<textarea class="discret_input"
						      name="clienteObs"
							  id="<?php echo $PREID; ?>clienteObs"
							  style="width: 100%;
									 height: 70px;
							         background-color:white"></textarea>
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
						   onclick="closeBlock(top.c.document.getElementById('ger_filiais'));">
					
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>