<?php
//session_start();
//$acessoWeb= 2;
require_once("inc/valida_sessao.php");
require_once("inc/styles.php");
require_once("inc/query_control.php");
require_once("inc/calendar_input.php");
require_once("inc/class_explorer.php");
include("../connections/flp_db_connection.php");
	$db_connection = connectTo();
	
	if ($_POST)
	{
		showPost();

		$db_connection = connectTo();
		include "inc/get_sequence.php";
		$next_code = getSequence('usuario_seq');
		$cliente_endereco_residencial = explode('|+|',$_POST['cliente_endereco_residencial']);
		$cliente_telefones = explode('|+|',$_POST['cliente_telefones']);
		$cliente_emails = explode('|+|',$_POST['cliente_emails']);
		if($_POST['op'] == 'fisica')
		{
			startQuery($db_connection);
			$dadosPessoaisCod= getSequence('dados_pessoais_seq');
			$insert= "INSERT INTO tb_usuario
					  (
						pk_usuario,
						s_login,
						s_senha,
						bl_cliente,
						bl_tipo_pessoa
					  )
					  VALUES
					  (
						".$next_code.",
						'".trim($_POST['clientLoginSub'])."',
						'".trim($_POST['clientLoginSubPwd'])."',
						1,
						'F'
					  );
					  
					  INSERT INTO tb_dados_pessoais
					  (
						pk_dados_pessoais,
						s_usuario,
						c_sexo,
						web_site,
						vfk_usuario,
						txt_obs
					  )
					  VALUES
					  (
						".$dadosPessoaisCod.",
						'".trim($_POST['nome'])."',
						'".trim($_POST['sexoCliente'])."',
						'".trim($_POST['site'])."',
						".$next_code.",
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
						".trim($_POST['estado_civil_cliente'])."
					  );
					  ";
					 $data= @pg_query($db_connection, $insert);
					 if(!$data)
					 {
						echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Fisica')</script>";
						echo pg_last_error($db_connection);
						cancelQuery($db_connection);
						exit;
					 }
					 
					// inserção de enderecos
					for ($i=0;$i<count($cliente_endereco_residencial)-1;$i++)
					{
						$endereco = explode('||',$cliente_endereco_residencial[$i]);
						$cep_cod = getSequence('cep_seq');
						if(trim(strtoupper($endereco[7]))== 'ON' || trim(strtoupper($endereco[7])) == 'TRUE' || trim($endereco[7]) == '1')
							$endereco[7]= '1';
						else
							$endereco[7]= '0';
						
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
										'".trim($endereco[7])."',
										'".trim($endereco[8])."',
										'".trim($endereco[9])."'
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
					
					// inserção de telefones
					for ($i=0;$i<count($cliente_telefones)-1;$i++)
					{
						$foneDados= explode('||', $cliente_telefones[$i]);
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
					
					// inserção de Emails
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
		}else{// se for juridica
				startQuery($db_connection);
				$dadosPessoaisCod= getSequence('dados_pessoais_seq');
				$_POST['clienteAdd_responsavel']= explode(' - ', $_POST['clienteAdd_responsavel']);
				$_POST['clienteAdd_responsavel']= $_POST['clienteAdd_responsavel'][0];
				$insert= "INSERT INTO tb_usuario
					  (
						pk_usuario,
						s_login,
						s_senha,
						bl_cliente,
						bl_tipo_pessoa
					  )
					  VALUES
					  (
						".$next_code.",
						'".trim($_POST['clientLoginSub'])."',
						'".trim($_POST['clientLoginSubPwd'])."',
						1,
						'J'
					  );
					
					 INSERT INTO tb_dados_pessoais
					  (
						pk_dados_pessoais,
						s_usuario,
						web_site,
						vfk_usuario,
						txt_obs
					  )
					  VALUES
					  (
						".$dadosPessoaisCod.",
						'".trim($_POST['nome_fantasia'])."',
						'".trim($_POST['site'])."',
						".$next_code.",
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
					 $data= @pg_query($db_connection, $insert);
					 if(!$data)
					 {
						echo $insert."<hr>";
						echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Juridica".str_replace('\n','',nl2br(pg_last_error($db_connection)))."')</script>";
						echo pg_last_error($db_connection);
						cancelQuery($db_connection);
						exit;
					 }
					 
					 echo "---- ".count($_POST['clienteAdd_filiais'])."<br>";
					 for($i=0; $i<count($_POST['clienteAdd_filiais']); $i++)
					 {
						echo $_POST['clienteAdd_filiais'][$i]."<br>";
						$insert=" INSERT INTO tb_filial_dados_pessoais
								  (
									fk_dados_pessoais,
									vfk_filial
								  )
								  VALUES
								  (
									".$dadosPessoaisCod.",
									".$_POST['clienteAdd_filiais'][$i]."
								  );";
						$data= @pg_query($db_connection, $insert);
						if(!$data)
						{
							echo $insert."<hr>";
							echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Juridica".str_replace('\n','',nl2br(pg_last_error($db_connection)))."')</script>";
							echo pg_last_error($db_connection);
							cancelQuery($db_connection);
							exit;
						}
					 }
					 echo "----";
					 echo "---- ".count($_POST['clienteAdd_contatoDaEmpresa'])."<br>";
					 for($i=0; $i<count($_POST['clienteAdd_contatoDaEmpresa']); $i++)
					 {
						echo $_POST['clienteAdd_contatoDaEmpresa'][$i]."<br>";
						$insert=" INSERT INTO tb_contatos_empresa
								  (
									fk_dados_pessoais,
									vfk_contato
								  )
								  VALUES
								  (
									".$dadosPessoaisCod.",
									".$_POST['clienteAdd_contatoDaEmpresa'][$i]."
								  )";
						$data= @pg_query($db_connection, $insert);
						if(!$data)
						{
							echo $insert."<hr>";
							echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Juridica".str_replace('\n','',nl2br(pg_last_error($db_connection)))."')</script>";
							echo pg_last_error($db_connection);
							cancelQuery($db_connection);
							exit;
						}
					 }
					 echo "----";
					 
					// inserção de enderecos
					for ($i=0;$i<count($cliente_endereco_residencial)-1;$i++)
					{
						$endereco = explode('||',$cliente_endereco_residencial[$i]);
						$cep_cod = getSequence('cep_seq');
						if(trim(strtoupper($endereco[7]))== 'ON' || trim(strtoupper($endereco[7])) == 'TRUE' || trim($endereco[7]) == '1')
							$endereco[7]= '1';
						else
							$endereco[7]= '0';
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
										'".trim($endereco[7])."',
										'".trim($endereco[8])."',
										'".trim($endereco[9])."'
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
					
					// inserção de telefones
					for ($i=0;$i<count($cliente_telefones)-1;$i++)
					{
						$foneDados= explode('||', $cliente_telefones[$i]);
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
					
					// inserção de Emails
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
					 
					  
			 }
		//$data= pg_query($db_connection, $insert);
		
		if($data)
		{
			?> 
				<script>
					alert('Cliente cadastrado');
					top.c.document.getElementById('novo_cliente').reload();
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
<iframe id="hiddenFrameClientAdd"
		name="hiddenFrameClientAdd"
		style="display: none;">
</iframe>

<?php
	// DADOS PARA EDICAO
	$insert= "SELECT
				  (
					pk_usuario,
					s_login,
					s_senha,
					bl_cliente,
					bl_tipo_pessoa
				  )
				  FROM tb_usuario
				  WHERE pk_usuario= ".$_GET['pk_usuario_edit'];
				 $data= @pg_query($db_connection, $insert);
				 if(!$data)
				 {
					echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Fisica')</script>";
					echo pg_last_error($db_connection);
					cancelQuery($db_connection);
					exit;
				 }
?>

<div style="width: 100%;
			height: 100%;
			overflow: auto;">
	<form name="form_cliente_add" 
		  target="hiddenFrameClientAdd"
		  id="form_cliente_add"
		  action="cliente_add.php"
		  method="POST">
	<div>
		<table style="width: 100%; height: 100%;" cellspacing="10">
			<tbody style="height: 20px;">
					<tr>
						<td id="clienteAdd_tb_visivel"
							colspan="2">
						
							<table id="tbodyClienteFisica">
								<tr>
									<td style="width:150px;">
										Nome
										<input type="text"
											   name="nome"
											   class="discret_input"
											   required="true"
											   label="Nome"><br>
									</td>
									<td style="width:150px;">
										Nacionalidade
										<input type="text"
											   name="nacionalidade"
											   class="discret_input"
											   value="Brasileiro"><br>
									</td>
									<td style="width:150px;">
										Estado civil
										<br>
										<?php
											$_GET['component']= 'estado_civil';
											$_GET['componentId']= 'estado_civil_cliente';
											$_GET['referencia']= 'conjugeCliente';
											include('components.php');
										?>	
										<!--<select name="estado_civil_cliente"
												id="estado_civil_cliente"
												class="discret_input"
												>
												<?
													$qr_select= "SELECT pk_estado_civil,
																		s_estado_civil
																   FROM tb_estado_civil
																";
													$data= pg_query($db_connection, $qr_select);
													while($linha= pg_fetch_array($data))
													{
														?>
															<option value="<? echo $linha['pk_estado_civil']; ?>">
																<?
																	echo htmlentities($linha['s_estado_civil']);
																?>
															</option>
														<?
													}
												?>
										</select>-->
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
									<td id="conjugeCliente"
										style="display: none;">
										C&ocirc;njuge<br>
										<input type="text"
											   maxlength="70"
											   id="conjugeNameCliente"
											   name="conjugeName"
											   class="discret_input">
									</td>
								</tr>
								<tr>
									<td>
										Profiss&atilde;o<br>
										<input type="text"
											   name="clienteProfissao"
											   maxlength="90"
											   class="discret_input">
									</td>
									<td>
										C.P.F<br>
										<input type="text"
											   name="clienteCPF"
											   maxlength="15"
											   class="discret_input"
											   onkeyup="mascaraCPF(this, event);"
											   required="true"
											   label="CPF">
									</td>
									<td>
										R.G.<br>
										<input type="text"
											   name="clienteRG"
											   maxlength="10"
											   class="discret_input"
											   required="true"
											   label="RG"
											   onkeyup="numOnly(this);">
									</td>
								</tr>
								<tr>
									<td colspan="3">
										Site <br>
											<input type="text"
										    name="site"
										    class="discret_input">
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
					<tr style="display: none;">
						<td colspan="3">
							<input id="cliente_endereco_residencial" type="text" name="cliente_endereco_residencial">
							<input id="cliente_telefones" type="text" name="cliente_telefones">
							<input id="cliente_emails" type="text" name="cliente_emails">
							<input id="clientLoginSub" type="text" name="clientLoginSub">
							<input id="clientLoginSubPwd" type="text" name="clientLoginSubPwd">
							<input id="clientObservacao" type="text" name="clientObservacao">
						</td>
					</tr>
				</form>
				<tr>
					<td colspan="3">
						<table id="clienteEndList"
							   style="width: 100%">
							<tr>
								<td class="gridTitle">
									Endere&ccedil;o
								</td>
							</tr>
							<tbody>
							<tr>
								<td id="clienteEnderecos">
									<table cellpadding="0"
										   cellspacing="0"
										   style="width: 100%"
										   id="clienteEnderecoTbody"
										   style="border-bottom: solid 1px #333366;">
										<tr id="clienteEnderecoModelLine"
											style="">
											<td class="gridCell"
												style="text-align: right;">
												CEP
												<input class="list_dados"
													   type="text"
													   name="cep"
													   style="width: 70px;"
													   id="clienteCEP"
													   onkeyup="mascaraCEP(this); if(this.value.length == 9 && this.lastChecked!=this.value){this.blur(); this.lastChecked=this.value; ajax= ''; top.setLoad(true); onlyEvalAjax('inc/cep.php?cep='+this.value.replace(/-/, ''), '', 'setCEPCliente(ajax);');}"
													   onblur="">
											</td>
											<td class="gridCell"
												style="text-align: right;">
												Rua
												<input type="text"
													   class="list_dados"
													   name="logradouro"
													   style="width: 120px;"
													   id="clienteLogradouro"
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
													   id="clienteNro"
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
													   id="clienteComplemento">
											</td>
											<td class="gridCell"
												style="text-align: right;">
												Bairro
												<input type="text"
													   class="list_dados"
													   name="bairro"
													   style="width: 90px;"
													   id="clienteBairro"
													   maxlength="240"
													   onmousemove="showtip(this, event, this.value);"
													   required="true"
													   label="Bairro">
											</td>
											<td class="gridCell" rowspan="2"
												style="text-align: right;">
												<input type="button"
													   value="+"
													   onclick="enderecoNewLine('clienteEnderecoTbody', 'clienteEnderecoList', 'clienteCEP,clienteLogradouro,clienteNro,clienteComplemento,clienteBairro,clienteCidade,clienteEstado,clientePostagem')
																document.getElementById('clientePostagem').checked = false;"
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
													   id="clienteCidade"
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
													   id="clienteEstado">
												-->
												<?php
													$_GET['component']= 'estado';
													$_GET['componentId']= 'clienteEstado';
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
													   id="clientePais"
													   required="true"
													   label="Pa&iacute;s">
											</td>
											<td class="gridCell"
												style="text-align: right;">
												Tipo
												<select name="clienteTipoEndereco"
														id="clienteTipoEndereco"
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
													   id="clientePostagem">
												Caixa postal
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td id="clienteEnderecoList">
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
										<tbody id="clienteEmailList">
											<tr>
												<td style="padding-right: 3px;"
													class="gridCell">
													<input type="text"
														   style=""
														   name="clienteEmail"
														   id="clienteEmail"> 
												</td>
												<td class="gridCell">
													<input type="button"
														   value="+"
														   onclick="if(document.getElementById('clienteEmail').value != ''
																		&& validaEMail(document.getElementById('clienteEmail')))
																	{
																		addToList('clienteEmailList', 'clienteEmail');
																		document.getElementById('clienteEmail').value='';
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
										<tbody id="clienteFoneList">
											<tr>
												<td style="padding-right: 3px;"
													class="gridCell">
													<input type="text"
														   style="width: 25px;"
														   name="clienteFoneDDD"
														   maxlength="2"
														   onkeyup="numOnly(this);"
														   required="true"
														   label="DDD"
														   id="clienteFoneDDD">
												</td>
												<td style="padding-right: 3px;"
													class="gridCell">
													<input type="text"
														   style="width: 90px;"
														   onkeyup="numOnly(this);"
														   maxlength="12"
														   required="true"
														   label="Telefone"
														   name="clienteFone"
														   id="clienteFone"> 
												</td>
												<td style="padding-right: 3px;
														   text-align: left;"
													class="gridCell">
													<?php
														$_GET['component']= 'tipoFone';
														$_GET['componentId']= 'clienteFoneTipo';
														include('components.php');
													?>
												</td>
												<td class="gridCell">
													<input type="button"
														   value="+"
														   onclick="addToList('clienteFoneList', 'clienteFoneDDD, clienteFone, clienteFoneTipo');"
														   class="botao_caract">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td style="vertical-align: top;">
									<table>
										<tr>
											<td class="gridTitle">
												Login
											</td>
											<td class="gridTitle">
												Senha
											</td>
										</tr>
										<tr>
											<td>
												<input type="text"
													   name="clientLogin"
													   style="width: 90px;"
													   id="clientLogin">
											</td>
											<td>
												<input type="password"
													   name="clientLoginPwd"
													   style="width: 90px;"
													   id="clientLoginPwd">
											</td>
										</tr>
										<tr>
											<td class="aviso"
												colspan="2">
												* Se <i>login</i> for nulo, o cliente n&atilde;o ter&aacute; acesso<br>
											</td>
										</tr>
									</table>
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
							  id="clienteObs"
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
						   onclick="if(validNewClient()) top.setLoad(true);"> 
					<input type="button"
						   class="botao"
						   value="Cancelar"
						   onclick="closeBlock(document.getElementById('novo_cliente'));">
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>








<div style="display:none;"
	 id="clienteAddInvisibleDiv">
		<table id="tbodyClienteJuridico">
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
						   required="true"
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
						   required="true"
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
						contatoAdd('clienteAdd_responsavel', '', 'clienteAdd_responsavel', 'cliente');
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
							<td colspan="2"
								class="gridTitle">
								Contatos
							</td>
						</tr>
						<tbody id="clienteContatoList">
							<tr>
								<td style="padding-right: 3px;"
									class="gridCell">
									<?php
										contatoAdd('clienteAdd_contatoDaEmpresa', '', 'clienteAdd_contatoDaEmpresa', 'cliente');
									?>
								</td>
								<td class="gridCell">
									<input type="button"
										   value="+"
										   onclick="addToList('clienteContatoList', 'clienteAdd_contatoDaEmpresa');
													//document.getElementById('clienteAdd_contatoDaEmpresa').value='';"
										   class="botao_caract">
								</td>
							</tr>
						</tbody>
					</table>
					
					
					
					
					
				</td>
				<td style="vertical-align: top;">
					<?php
						//filialAdd('clienteAdd_filiais', '', 'clienteAdd_filiais', 'cliente')
						/*
						$_GET['component']= 'filiais';
						$_GET['componentId']= 'clienteAdd_filiais';
						include('components.php');
						*/
					?>
					<table>
						<tr>
							<td colspan="2"
								class="gridTitle">
								Filiais
							</td>
						</tr>
						<tbody id="clienteAdd_filiaisList">
							<tr>
								<td style="padding-right: 3px;
										   text-align: left;"
									class="gridCell">
									<?php
										filialAdd('clienteAdd_filiais', '', 'clienteAdd_filiais', 'cliente');
									?>
								</td>
								<td class="gridCell">
									<input type="button"
										   value="+"
										   onclick="addToList('clienteAdd_filiaisList', 'clienteAdd_filiais');"
										   class="botao_caract">
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
</table>
</div>


