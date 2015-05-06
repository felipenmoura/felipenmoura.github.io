<?php
if($_GET['delCode'])
{
	require_once("inc/valida_sessao.php");
	require_once("inc/query_control.php");
	include("../connections/flp_db_connection.php");
	include "inc/get_sequence.php";
	$db_connection = connectTo();
	
	$updt= "UPDATE tb_dados_pessoais
			   SET bl_status = 0
			 WHERE pk_dados_pessoais = ".$_GET['delCode']."
		   ";
	$data= @pg_query($db_connection, $updt);
	if(!$data)
	{
		echo"alert('Falha ao tentar excluir este cliente !'); ";
		//echo @pg_last_error($db_connection);
		cancelQuery($db_connection);
		exit;
	}
	?>
	try
	{
		obj= top.filho.gebi('<?php echo $_GET['preid']; ?>hiddenFrameClientAdd'); 
		getBlock(obj).reload(); 
	}catch(error)
	{
	}
	<?php
	exit;
}

if ($_POST)
{
	require_once("inc/valida_sessao.php");
	require_once("inc/query_control.php");
	include("../connections/flp_db_connection.php");
	include "inc/get_sequence.php";
	$db_connection = connectTo();
	showPost();

	
//       INSERINDO EMAILS
	$cliente_emails = explode('|+|',$_POST['cliente_emails']);
	for ($i=0;$i<count($cliente_emails)-1;$i++)
	{
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
							".$_POST['pk_dados_pessoais']."
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

//       INSERINDO TELEFONES
	echo '- - - - - - - - - -<br>';
	echo $_POST['cliente_telefones'].'<br>';
	$telefones= explode('|+|', $_POST['cliente_telefones']);
	echo count($telefones);
	for ($i=0; $i<(count($telefones)-1); $i++)
	{
		echo $i.'<br>';
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
								".$_POST['pk_dados_pessoais'].",
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
	

//                  INSERINDO ENDEREÇOS 
//                 Primeiro são removidos todos enderços existentes

		$cliente_endereco_residencial = explode('|+|',$_POST['cliente_endereco_residencial']);
		$qr_delete_enderecos = "
								DELETE FROM tb_cep_dados_pessoais WHERE fk_dados_pessoais = ".$_POST['pk_dados_pessoais'].";
							   ";
		$result_delete = pg_query($db_connection,$qr_delete_enderecos);
	
//                  Pega-se todos endereços da tela de cadastro e insere no BD.

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
				trim($endereco[5]) != ''
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
							'".$_POST['pk_dados_pessoais']."',
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

		
//       DELETAR ENDEREÇO-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------		
	if($_GET['delEnd'])
	{
		if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		$qr = "DELETE FROM tb_cep_dados_pessoais WHERE pk_cep_dados_pessoais = ".$_GET['delEnd'];
		$data= pg_query($db_connection, $qr);
		if(!$data)
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o')";
		exit;
	}
	
//	UPDATE EM DADOS PESSOAIS
	startQuery($db_connection);
	$qr= "	  UPDATE tb_usuario
				 SET s_login= '".trim($_POST['clientLoginSub'])."',
					 s_senha= '".trim($_POST['clientLoginSubPwd'])."'
			   WHERE pk_usuario= ".trim($_POST['pk_usuario'])."
			  ;
					  
			  UPDATE tb_dados_pessoais
				 SET
				s_usuario= '".trim($_POST['nome'])."',
				c_sexo= '".trim($_POST['sexoCliente'])."',
				web_site= '".trim($_POST['site'])."',
				txt_obs= '".trim($_POST['clientObservacao'])."'
			  WHERE vfk_usuario= ".trim($_POST['pk_usuario'])."
			  AND pk_dados_pessoais= ".trim($_POST['pk_dados_pessoais'])."
			  ;
					  
					  UPDATE tb_pess_fisica
					  SET
							cpf= '".trim($_POST['clienteCPF'])."',
							s_rg= '".trim($_POST['clienteRG'])."',
							s_profissao= '".trim($_POST['clienteProfissao'])."',
							s_nascionalidade= '".trim($_POST['nacionalidade'])."',
							dt_nascimento= TO_DATE('".trim($_POST['ger_fis_clienteNasc'])."','DD/MM/YYYY'),
							s_conjuge= '".trim($_POST['conjugeName'])."',
							fk_estado_civil= ".trim($_POST['ger_fis_estado_civil_cliente'])."
					  WHERE fk_dados_pessoais= ".trim($_POST['pk_dados_pessoais']).";
					  ";
		echo $qr;
		$data= @pg_query($db_connection, $qr);
		if(!$data)
		{
			echo"<script>alert('Falha na tentativa de Cadastro - Pessoa Fisica')</script>";
			echo pg_last_error($db_connection);
			cancelQuery($db_connection);
			exit;
		}
		commitQuery($db_connection);
	?>
		<script> try{top.filho.atualizaLista('gerClientesList','ger_clientes_list.php');}catch(error){}</script>
	<?php
	exit;
}

$PREID= 'ger_fis_';
//       SELECIONA DADOS DA PESSOA FISICA ----------------------------------------------------------------------------------------------------------------------------------------------------------	
	$select_pess_fisica = "select 
								fk_dados_pessoais,
								cpf,
								s_conjuge,
								s_rg,
								s_profissao,
								s_nascionalidade,
								fk_estado_civil,
								TO_CHAR(dt_nascimento,'DD/MM/YYYY') as dt_nascimento
							from tb_pess_fisica
							where fk_dados_pessoais = ".$_GET['pk_dados_pessoais'];
	$r_pess_fisica= pg_query($db_connection,$select_pess_fisica);
	$linha_pess_fisica=pg_fetch_array($r_pess_fisica);
	
//       SELECIONANA ENDEREÇOS  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	$qr_enderecos= "  SELECT     
						  C.pk_cep,
						  C.s_logradouro,
			              C.s_bairro,
						  C.s_cidade,
			              C.s_estado_sigla,
			              C.c_tipo_endereco,
			              C.s_pais,
			              C.s_cep,
			              C.s_complemento,
			              C.bl_caixa_postal,
						  CDP.pk_cep_dados_pessoais,
				          CDP.s_num
				    FROM       
						  tb_cep C
					INNER JOIN 
						  tb_cep_dados_pessoais CDP
					ON         
						  (CDP.fk_cep = C.pk_cep)
					INNER JOIN 
						  tb_dados_pessoais DP
					ON         
						  (DP.pk_dados_pessoais = CDP.fk_dados_pessoais)

					WHERE
						  DP.pk_dados_pessoais = ".$_GET['pk_dados_pessoais']."
				 ";
	$data_enderecos= @pg_query($db_connection, $qr_enderecos);
	
?>
<div style="width: 100%;
			height: 100%;
			padding-left:10px;
			padding-right:10px;
			overflow: auto;">
<iframe id="<?php echo $PREID; ?>hiddenFrameClientAdd"
		name="hiddenFrameClientAdd"
		style="display: none;">
</iframe>
	<form name="<?php echo $PREID; ?>form_cliente_add" 
		  target="hiddenFrameClientAdd"
		  id="<?php echo $PREID; ?>form_cliente_add"
		  action="ger_cliente_edit_pess_fisica.php"
		  method="POST">
		<input type="hidden"
			   name="pk_dados_pessoais"
			   value="<?php echo $_GET['pk_dados_pessoais']; ?>">
		<input type="hidden"
			   name="pk_usuario"
			   value="<?php echo $linha_dados_pessoais['pk_usuario']; ?>">
		<table style="width: 100%; height: 100%;" cellspacing="10">
			<tbody style="height: 20px;">
					<tr>
						<td id="<?php echo $PREID; ?>clienteAdd_tb_visivel"
							colspan="2">
						
							<table width="100%" id="<?php echo $PREID; ?>tbodyClienteFisica">
								<tr>
									<td style="width:150px;">
										Nome
										<input type="text"
											   name="nome"
											   class="discret_input"
											   required="true"
											   label="Nome"
											   oldValue="<?php echo htmlentities($linha_dados_pessoais['s_usuario']); ?>"
											   value="<?php echo htmlentities($linha_dados_pessoais['s_usuario']); ?>"><br>
									</td>
									<td style="width:150px;">
										Nacionalidade
										<input type="text"
											   name="nacionalidade"
											   class="discret_input"
											   oldValue="<?php echo htmlentities($linha_pess_fisica['s_nascionalidade']); ?>"
											   value="<?php echo htmlentities($linha_pess_fisica['s_nascionalidade']); ?>"><br>
									</td>
									<td style="width:150px;">
										Estado civil
										<br>
										<?php
											$_GET['component']= 'estado_civil';
											$_GET['componentId']= $PREID.'estado_civil_cliente';
											$_GET['referencia']= $PREID.'conjugeCliente';
											$_GET['valor'] = $linha_pess_fisica['fk_estado_civil'];
											include('components.php');
										?>	
									</td>
								</tr>
								<tr>
									<td>
										Nascimento<br>
										<?php
											makeCalendar($PREID.'clienteNasc', $linha_pess_fisica['dt_nascimento']);
										?>
									</td>
									<td>
										Sexo<br>
										<select name="sexoCliente"
												class="discret_input">
											<option value="m">
												Masculino
											</option>
											<option value="f"
											<?php if(trim(strtoupper($linha_dados_pessoais['c_sexo'])) == 'F') echo ' selected '; ?>>
												Feminino
											</option>
										</select>
									</td>
									<td id="<?php echo $PREID; ?>conjugeCliente"
										style="<?php if ($linha_pess_fisica['fk_estado_civil'] != 2 && $linha_pess_fisica['fk_estado_civil'] != 6) echo 'display:none;' ?>">
										C&ocirc;njuge<br>
										<input type="text"
											   maxlength="70"
											   id="<?php echo $PREID; ?>conjugeNameCliente"
											   name="conjugeName"
											   class="discret_input"
											   oldValue="<?php echo htmlentities($linha_pess_fisica['s_conjuge']); ?>"
											   value="<?php echo htmlentities($linha_pess_fisica['s_conjuge']); ?>">
									</td>
								</tr>
								<tr>
									<td>
										Profiss&atilde;o<br>
										<input type="text"
											   name="clienteProfissao"
											   maxlength="90"
											   class="discret_input"
											   oldValue="<?php echo htmlentities($linha_pess_fisica['s_profissao']); ?>"
											   value="<?php echo htmlentities($linha_pess_fisica['s_profissao']); ?>">
									</td>
									<td>
										C.P.F<br>
										<input type="text"
											   name="clienteCPF"
											   maxlength="15"
											   class="discret_input"
											   onkeyup="mascaraCPF(this, event);"
											   label="CPF"
											   oldValue="<?php echo $linha_pess_fisica['cpf'] ?>"
											   value="<?php echo $linha_pess_fisica['cpf'] ?>">
									</td>
									<td>
										R.G.<br>
										<input type="text"
											   name="clienteRG"
											   maxlength="10"
											   class="discret_input"
											   label="RG"
											   onkeyup="numOnly(this);"
											   oldValue="<?php echo $linha_pess_fisica['s_rg'] ?>"
											   value="<?php echo $linha_pess_fisica['s_rg'] ?>">
									</td>
								</tr>
								<tr>
									<td colspan="3">
										Site <br>
											<input type="text"
										    name="site"
										    class="discret_input"
											value="<?php echo htmlentities($linha_dados_pessoais['web_site']); ?>">
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
													$_GET['component']	= 'estado';
													$_GET['componentId']= $PREID.'clienteEstado';
													$_GET['valor']		="";
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
							<tbody>
							<tr>	
								<td id="<?php echo $PREID; ?>clienteEnderecos">
								<?php 
									while ($linha_enderecos = pg_fetch_array($data_enderecos))
									{
											?>
									<table cellpadding="0"
										   cellspacing="0"
										   style="width: 100%"
										   id="<?php echo $PREID; ?>clienteEnderecoTbody"
										   style="border-bottom: solid 1px #333366;">
															<tbody>
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
																	   oldValue="<?php echo trim($linha_enderecos['s_cep']); ?>"
																	   value="<?php echo trim($linha_enderecos['s_cep']); ?>"
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
																	   oldValue="<?php echo trim(htmlentities($linha_enderecos['s_logradouro'])); ?>"
																	   value="<?php echo trim(htmlentities($linha_enderecos['s_logradouro'])); ?>"
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
																	   oldValue="<?php echo trim(htmlentities($linha_enderecos['s_num'])); ?>"
																	   value="<?php echo trim(htmlentities($linha_enderecos['s_num'])); ?>"
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
																	   oldValue="<?php echo trim(htmlentities($linha_enderecos['s_complemento'])); ?>"
																	   value="<?php echo trim(htmlentities($linha_enderecos['s_complemento'])); ?>"
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
																	   oldValue="<?php echo trim(htmlentities($linha_enderecos['s_bairro'])); ?>"
																	   value="<?php echo trim(htmlentities($linha_enderecos['s_bairro'])); ?>"
																	   onmousemove="showtip(this, event, this.value);"
																	   required="true"
																	   label="Bairro">
															</td>
															<td rowspan="2"
																class="gridCell">
																<input type="button"
																	   value="-"
																	   onclick="if(confirm('Tem certeza que deseja retirar este endere&ccedil;o da lista?'))
																					{
																						this.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode);
																						onlyEvalAjax('ger_cliente_edit_pess_juridica.php?delEnd=<? echo $linha_enderecos['pk_cep_dados_pessoais']; ?>', '', 'eval(ajax)');
																					}"
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
																	   oldValue="<?php echo trim(htmlentities($linha_enderecos['s_cidade'])); ?>"
																	   value="<?php echo trim(htmlentities($linha_enderecos['s_cidade'])); ?>"
																	   onmousemove="showtip(this, event, this.value);"
																	   required="true"
																	   label="Cidade">
															</td>
															<td class="gridCell"
																style="text-align: right;">
																<span>
																	UF
																</span>
																
																<?php
																	$_GET['component']= 'estado';
																	$_GET['componentId']= $PREID.'clienteEstado';
																	$_GET['valor'] = trim($linha_enderecos['s_estado_sigla']);
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
																	   oldValue="<?php echo trim(htmlentities($linha_enderecos['s_pais'])); ?>"
																	   value="<?php echo trim(htmlentities($linha_enderecos['s_pais'])); ?>"
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
																	<option value="C"
																			<?php
																				if ($linha_enderecos['c_tipo_endereco'] == 'C')
																					echo 'selected';
																			?>>
																		Comercial
																	</option>
																</select>
															</td>
															<td class="gridCell"
																style="text-align: right;">
																<input type="checkbox"
																	   class="list_dados"
																	   name="clientePostagem"
																	   oldValue="<?php echo trim(htmlentities($linha_enderecos['bl_caixa_postal'])); ?>"
																	   id="<?php echo $PREID; ?>clientePostagem"
																	   <?php
																			if ($linha_enderecos['bl_caixa_postal'] == 1)
																				echo 'checked';
																	   ?>>
																Caixa postal
															</td>
														</tr>
														</tbody>
											<!-- Para inserir novo endereço-->
									</table>
									<?php
										}
									?>
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
											<?
												$qr_mails= "SELECT pk_email,
																   s_email
															  FROM tb_email
															 WHERE fk_dados_pessoais = ".$_GET['pk_dados_pessoais']."
														   ";
												$mailData= pg_query($db_connection, $qr_mails);
												while($mailList= pg_fetch_array($mailData))
												{
													?>
													<tr id="<?php echo $mailList['pk_email']; ?>_clienteEmail">
														<td class="gridCell">
															<?php
																echo htmlentities($mailList['s_email']);
															?>
														</td>
														<td class="gridCell">
															<input type="button"
																   value="-"
																   onclick="if(confirm('Tem certeza que deseja desvincular este contato desta empresa?'))
																				onlyEvalAjax('ger_cliente_edit_pess_juridica.php?delMail=<?php echo $mailList['pk_email']; ?>', '', 'eval(ajax)')"
																   class="botao_caract">
														</td>
													</tr>
												<?
												}
												?>
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
														   required="true"
														   label="DDD"
														   id="<?php echo $PREID; ?>clienteFoneDDD">
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
														   onclick="addToList('<?php echo $PREID; ?>clienteFoneList', '<?php echo $PREID; ?>clienteFoneDDD, <?php echo $PREID; ?>clienteFone, <?php echo $PREID; ?>clienteFoneTipo');"
														   class="botao_caract">
												</td>
											</tr>
											<?php
												$qr_fones= "SELECT pk_telefone,
																   s_ddd,
																   s_numero,
																   fk_tipo_telefone
															  FROM tb_telefone t,
																   tb_telefone_usuario u
															 WHERE t.pk_telefone = u.fk_telefone
															   AND u.fk_dados_pessoais = ".$_GET['pk_dados_pessoais']."
														   ";
												$fonesData= pg_query($db_connection, $qr_fones);
												while($foneList= pg_fetch_array($fonesData))
												{
											?>
												<tr id="<? echo $foneList['pk_telefone']; ?>_clienteFoneList">
													<td style="padding-right: 3px;"
														class="gridCell">
														<?
															echo $foneList['s_ddd'];
														?>
													</td>
													<td style="padding-right: 3px;"
														class="gridCell">
														<?
															echo $foneList['s_numero'];
														?>
													</td>
													<td style="padding-right: 3px;
															   text-align: left;"
														class="gridCell">
														<?
															echo htmlentities($foneList['fk_tipo_telefone']);
														?>
													</td>
													<td class="gridCell">
														<input type="button"
															   value="-"
															   onclick="if(confirm('Tem certeza que deseja desvincular este contato desta empresa?'))
																			onlyEvalAjax('ger_cliente_edit_pess_juridica.php?delFone=<?php echo $foneList['pk_telefone']; ?>', '', 'eval(ajax)')"
															   class="botao_caract">
													</td>
												</tr>
											<?
												}
											?>
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
													   id="<?php echo $PREID; ?>clientLogin"
													   value="<?php echo htmlentities($linha_dados_pessoais['s_login']) ?>"
													   oldValue="<?php echo htmlentities($linha_dados_pessoais['s_login']) ?>">
											</td>
											<td>
												<input type="password"
													   name="clientLoginPwd"
													   style="width: 90px;"
													   id="<?php echo $PREID; ?>clientLoginPwd"
													   value="<?php echo htmlentities($linha_dados_pessoais['s_senha']) ?>"
													   oldValue="<?php echo htmlentities($linha_dados_pessoais['s_senha']) ?>">
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
							<tr>
								<td colspan="4"
									style="">
									Obs<br>
									<textarea class="discret_input"
											  name="clienteObs"
											  id="<?php echo $PREID; ?>clienteObs"
											  style="width: 100%;
													 height: 70px;
													 background-color:white"><?php echo htmlentities($linha_dados_pessoais['txt_obs']) ?></textarea>
								</td>
							</tr>
							<tr>
								<td colspan="4"
									style="text-align: center; height: 15px;">
									<input type="button"
										   class="botao"
										   value="Atualizar"
										   onclick="if(validNewClient('<?php echo $PREID; ?>')) top.setLoad(true);"> 
									<input type="button"
										   class="botao"
										   value="Novo"
										   onclick="top.setLoad(true); onlyEvalAjax('ger_cliente_add.php', '', 'document.getElementById(\'corpo_ger_cliente_add\').innerHTML=ajax')">
									<input type="button"
										   class="botaoExcluir"
										   value=""
										   onclick="if(confirm('Tem certeza que deseja excluir este cliente ?'))
													{
														top.setLoad(true, 'Excluindo cliente');
														onlyEvalAjax('ger_cliente_edit_pess_fisica.php?delCode=<?php echo $_GET['pk_dados_pessoais']; ?>&preid=<?php echo $PREID; ?>', '', ' eval(ajax); ');
													}">
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
			<tr>
				<td>
					&nbsp;
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>

	