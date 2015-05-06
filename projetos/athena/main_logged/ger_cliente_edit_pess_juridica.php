<?php
	//  Excluir Cliente
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
	
$PREID= 'ger_jur_';
if($_POST)
{
	require_once("inc/valida_sessao.php");
	require_once("inc/query_control.php");
	include("../connections/flp_db_connection.php");
	include "inc/get_sequence.php";
	$db_connection = connectTo();
	showPost();
	
//	UPDATE EM DADOS PESSOAIS
	$_POST['clienteAdd_responsavel'] = explode('|+|',$_POST['responsavelEditEmpresa']);
	$_POST['clienteAdd_responsavel'] = $_POST['clienteAdd_responsavel'][0];
	if($_POST['clienteAdd_responsavel'] == '')
		$_POST['clienteAdd_responsavel']= 'NULL';
	$cliente_endereco_residencial = explode('|+|',$_POST['cliente_endereco_residencial']);
	
	startQuery($db_connection);
	$qr= "	  UPDATE tb_usuario
				 SET s_login= '".trim($_POST['clientLoginSub'])."',
					 s_senha= '".trim($_POST['clientLoginSubPwd'])."'
			   WHERE pk_usuario= ".trim($_POST['pk_usuario'])."
			  ;
					  
			  UPDATE tb_dados_pessoais
				 SET
				s_usuario= '".trim($_POST['nome_fantasia'])."',
				web_site= '".trim($_POST['site'])."',
				txt_obs= '".trim($_POST['clientObservacao'])."'
			  WHERE vfk_usuario= ".trim($_POST['pk_usuario'])."
			  AND pk_dados_pessoais= ".trim($_POST['pk_dados_pessoais'])."
			  ;
					  
			  UPDATE tb_pess_juridica
			  SET
					razao_social= '".trim($_POST['razao_social'])."',	
					nome_fantasia= '".trim($_POST['nome_fantasia'])."',
					inscr_estadual='".trim($_POST['inscr_estadual'])."',
					inscr_municipal='".trim($_POST['inscr_municipal'])."',
					cnpj= '".trim($_POST['cnpj'])."',
					fk_ramo_atividade= '".trim($_POST['cliente_add_ramo_atividade'])."',
					vfk_responsavel= ".trim($_POST['clienteAdd_responsavel'])."
			  WHERE fk_dados_pessoais= ".trim($_POST['pk_dados_pessoais'])."
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

		
//                  INSERINDO CONTATOS 
		$_POST['cliente_contatos']= explode(';;;;;;|+|', $_POST['cliente_contatos']);
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
										".$_POST['pk_dados_pessoais'].",
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
						}
					 }
		 
//                    INSERINDO FILIAIS
		 $filiais= explode(';;;;;;|+|', $_POST['cliente_filiais']);
					 for($i=0; $i<count($filiais); $i++)
					 {
						$filiais[$i]= explode('|+|', $filiais[$i]);
						$filiais[$i]= $filiais[$i][0];

						if(trim(str_replace(';','',$filiais[$i]) != ''))
						{
							$insert=" INSERT INTO tb_filial_dados_pessoais
									  (
										fk_dados_pessoais,
										vfk_filial
									  )
									  VALUES
									  (
										".$_POST['pk_dados_pessoais'].",
										".$filiais[$i]."
									  );";
							$data= @pg_query($db_connection, $insert);
							echo $insert.'<br>';
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

//                                                 INSERINDO TELEFONES
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
					
//                                                   INSERINDO EMAILS
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
					 
		commitQuery($db_connection);
		?>
		<script> try{top.filho.atualizaLista('gerClientesList','ger_clientes_list.php');}catch(error){}</script>
	<?php
	exit;
}

//       DELETAR CONTATO  ( Na verdade disvincula um contato de uma Empresa ) ------------------------------------------------------------------------------------------------------------------			
	if($_GET['del'])
	{
		if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		$qr= "DELETE FROM tb_contatos_empresa where pk_contatos_empresa= ".$_GET['del'];
		$data= pg_query($db_connection, $qr);
		if($data)
			echo "document.getElementById('".$_GET['del']."_gerCliente_edit_contato').parentNode.removeChild(document.getElementById('".$_GET['del']."_gerCliente_edit_contato'));";
		else
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o')";
		exit;
	}
	
//       DELETAR FILIAL  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------			
	if($_GET['delFilial'])
	{
		if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		$qr= "DELETE FROM tb_filial_dados_pessoais where pk_filial_dados_pessoais= ".$_GET['delFilial'];
		$data= pg_query($db_connection, $qr);
		if($data)
			echo "document.getElementById('".$_GET['delFilial']."_gerCliente_edit_filial').parentNode.removeChild(document.getElementById('".$_GET['delFilial']."_gerCliente_edit_filial'));";
		else
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o')";
		exit;
	}
	
//       DELETAR EMAIL  ---------------------------------- ----------------------------------------------------------------------------------------------------------------------------------------------------------			
	if($_GET['delMail'])
	{
		if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		$qr= "DELETE FROM tb_email where pk_email= ".$_GET['delMail'];
		$data= pg_query($db_connection, $qr);
		if($data)
			echo "document.getElementById('".$_GET['delMail']."_clienteEmail').parentNode.removeChild(document.getElementById('".$_GET['delMail']."_clienteEmail'));";
		else
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o')";
		exit;
	}
	
//       DELETAR TELEFONE-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------		
	if($_GET['delFone'])
	{
		if(!$db_connection)
		{
			include("../connections/flp_db_connection.php");
			$db_connection = connectTo();
		}
		$qr = "DELETE FROM tb_telefone_usuario where fk_telefone= ".$_GET['delFone']."; ";
		$qr.= "DELETE FROM tb_telefone where pk_telefone= ".$_GET['delFone']."; ";
		$data= pg_query($db_connection, $qr);
		if($data)
			echo "document.getElementById('".$_GET['delFone']."_clienteFoneList').parentNode.removeChild(document.getElementById('".$_GET['delFone']."_clienteFoneList'));";
		else
			echo "alert('Ocorreu um erro inesperado nesta requisi&ccedil;&atilde;o')";
		exit;
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
	
// SELECIONANDO DADOS PARA PREENCHER OS CAMPOS DO FORMULÁRIO --------------------------------------------------------------------------------------------------------------------	
	
//       SELECIONA DADOS DA PESSOA JURIDICA ----------------------------------------------------------------------------------------------------------------------------------------------------------	
	$select_pess_juridica = "select 
								pk_pes_juridica,
								fk_dados_pessoais,
								razao_social,
								nome_fantasia,
								inscr_estadual,
								inscr_municipal,
								cnpj,
								fk_ramo_atividade,
								vfk_responsavel
								from tb_pess_juridica
								where fk_dados_pessoais = ".$_GET['pk_dados_pessoais'];
	$r_pess_juridica= pg_query($db_connection,$select_pess_juridica);
	$linha_pess_juridica=pg_fetch_array($r_pess_juridica);
	
//       SELECIONA RESPONSAVEL  -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	$select_pess_juridica_Resp = "   select vfk_responsavel as cod,
												s_usuario as nome
										   from tb_dados_pessoais,
												tb_pess_juridica
										  WHERE vfk_responsavel = pk_dados_pessoais
											AND pk_pes_juridica = ".$linha_pess_juridica['pk_pes_juridica']."
							";
	$r_pess_juridica_resp= pg_query($db_connection,$select_pess_juridica_Resp);
	$linha_pess_juridica_resp=pg_fetch_array($r_pess_juridica_resp);
	
//       SELECIONA CONTATOS  -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$select_pess_juridica_cont = "    select vfk_contato,
											 pk_contatos_empresa
										from tb_contatos_empresa ce,
										     tb_dados_pessoais dp
									   where ce.fk_dados_pessoais = dp.pk_dados_pessoais
										 and dp.pk_dados_pessoais = ".$_GET['pk_dados_pessoais']."
							";
	$r_pess_juridica_cont= pg_query($db_connection,$select_pess_juridica_cont);
	$counter= 0;
	while($linha_pess_juridica_cont= pg_fetch_array($r_pess_juridica_cont))
	{
		$select_pess_juridica_cont = "select ".$linha_pess_juridica_cont['pk_contatos_empresa']." as pk_contatos_empresa, pk_dados_pessoais, s_usuario from tb_dados_pessoais where pk_dados_pessoais = ".$linha_pess_juridica_cont['vfk_contato'];
		$r_pess_juridica_contNome= pg_query($db_connection, $select_pess_juridica_cont);
		$linha_pess_juridica_contNome[$counter]= pg_fetch_array($r_pess_juridica_contNome);
		$counter++;
	}
	
//       SELECIONANA FILIAIS  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	$qr_filiais= "select pk_filial_dados_pessoais,
						 vfk_filial
				    from tb_dados_pessoais,
						 tb_filial_dados_pessoais
				   where fk_dados_pessoais = ".$_GET['pk_dados_pessoais']."
				     and fk_dados_pessoais = pk_dados_pessoais
				 ";
	$data_filiais= @pg_query($db_connection, $qr_filiais);
	
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
<div id="<?php echo $PREID; ?>clienteAddInvisibleDiv"
	 style="margin-top:10px;
			padding-left:10px;
			padding-right:10px;
			width: 100%;
			height: 100%;
			overflow: auto;">
<iframe id="<?php echo $PREID; ?>hiddenFrameClientAdd"
		name="hiddenFrameClientAdd"
		style="display: none;">
</iframe>
	<form name="<?php echo $PREID; ?>form_cliente_add" 
		  target="hiddenFrameClientAdd"
		  id="<?php echo $PREID; ?>form_cliente_add"
		  action="ger_cliente_edit_pess_juridica.php"
		  method="POST">
		<input type="hidden"
			   name="pk_dados_pessoais"
			   value="<?php echo $_GET['pk_dados_pessoais']; ?>">
		<input type="hidden"
			   name="pk_usuario"
			   value="<?php echo $linha_dados_pessoais['pk_usuario']; ?>">
		<div style="display: none;">
			<input id="<?php echo $PREID; ?>cliente_endereco_residencial" type="hidden" name="cliente_endereco_residencial">
			<input id="<?php echo $PREID; ?>cliente_telefones" type="hidden" name="cliente_telefones">
			<input id="<?php echo $PREID; ?>cliente_contatos" type="hidden" name="cliente_contatos">
			<input id="<?php echo $PREID; ?>cliente_filiais" type="hidden" name="cliente_filiais">
			<input id="<?php echo $PREID; ?>cliente_emails" type="hidden" name="cliente_emails">
			<input id="<?php echo $PREID; ?>clientLoginSub" type="hidden" name="clientLoginSub">
			<input id="<?php echo $PREID; ?>clientLoginSubPwd" type="hidden" name="clientLoginSubPwd">
			<input id="<?php echo $PREID; ?>clientObservacao" type="hidden" name="clientObservacao">
		</div>
		<table width="100%" id="<?php echo $PREID; ?>tbodyClienteJuridico">
			<tr>
				<td style="width:150px;">
					Raz&atilde;o Social
					<input type="text"
						   name="razao_social"
						   class="discret_input"
						   required="true"
						   label="Raz&atilde;o social"
						   onmouseover="showtip(this,event,'<?php echo htmlentities($linha_pess_juridica['razao_social']) ?>')"
						   value="<?php echo htmlentities($linha_pess_juridica['razao_social']) ?>" 
						   oldValue="<?php echo htmlentities($linha_pess_juridica['razao_social']); ?>"><br>
				</td>
				<td style="width:150px;">
					Nome Fantasia
					<input type="text"
						   name="nome_fantasia"
						   class="discret_input"
						   label="Nome fantasia"
						   onmouseover="showtip(this,event,'<?php echo str_replace("'", "\'", htmlentities($linha_pess_juridica['nome_fantasia'])) ?>')"
						   oldValue="<?php echo $linha_pess_juridica['nome_fantasia'] ?>"
						   value="<?php echo htmlentities($linha_pess_juridica['nome_fantasia']) ?>">
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
						   label="CNPJ"
						   onmouseover="showtip(this,event,'<?php echo htmlentities($linha_pess_juridica['cnpj']) ?>')"
						   oldValue="<?php echo $linha_pess_juridica['cnpj'] ?>"
						   value="<?php echo htmlentities($linha_pess_juridica['cnpj']) ?>">
				</td>
				<td style="width:150px;">
					Inscri&ccedil;&atilde;o Estadual
					<input type="text"
						   name="inscr_estadual"
						   class="discret_input"
						   maxlength="40"
						   onkeyup="numOnly(this);"
						   onmouseover="showtip(this,event,'<?php echo htmlentities($linha_pess_juridica['inscr_estadual']) ?>')"
						   oldValue="<?php echo $linha_pess_juridica['inscr_estadual'] ?>"
						   value="<?php echo htmlentities($linha_pess_juridica['inscr_estadual']) ?>">
				</td>
					<td style="width:150px;">
					Inscri&ccedil;&atilde;o Municipal
					<input type="text"
						   name="inscr_municipal"
						   class="discret_input"
						   maxlength="40"
						   onkeyup="numOnly(this);"
						   onmouseover="showtip(this,event,'<?php echo htmlentities($linha_pess_juridica['inscr_municipal']) ?>')"
						   oldValue="<?php echo $linha_pess_juridica['inscr_municipal'] ?>"
						   value="<?php echo htmlentities($linha_pess_juridica['inscr_municipal']) ?>">
				</td>
			</tr>
			<tr>
				<td style="width:150px;">
					WebSite<br>
					<input type="text" 
						   name="site" 
						   class="discret_input"
						   onmouseover="showtip(this,event,'<?php echo htmlentities($linha_dados_pessoais['web_site']); ?>')"
						   oldValue="<?php echo $linha_dados_pessoais['web_site']; ?>"
						   value="<?php echo $linha_dados_pessoais['web_site']; ?>"><br>
				</td>
				<td style="width:150px;">
					Ramo de Atividade<br>
					<?php
						$_GET['component']='ramo_atividade';
						$_GET['componentId']='cliente_add_ramo_atividade';
						$_GET['valor'] = $linha_pess_juridica['fk_ramo_atividade'];
						include "components.php";
					?>
				</td>
				<td style="width:150px;">
					Respons&aacute;vel<br>
					<?php
						if($linha_pess_juridica_resp['cod'])
							$content= htmlentities($linha_pess_juridica_resp['nome']);
						else $content= '';
						//contatoAdd('clienteAdd_responsavel', $content, 'clienteAdd_responsavel', 'cliente');
					?>
					<?php
						$_GET['component']		= 'explorer';
						$_GET['componentId']	= $PREID.'responsavelEditEmpresa';
						$_GET['componentValue']	= $content;
						$_GET['componentName']	= 'responsavelEditEmpresa';
						$_GET['componentTipo']	= 'contato';
						$_GET['codeValue']		= $linha_pess_juridica_resp['cod'];
						//$_GET['componentShowAdd']= '';
						include('components.php');
					?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;" colspan="4">
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
							<td style="vertical-align: top;" >
								<input type="text" 
									   name="list_contatos"
									   id="<?php echo $PREID?>list_contatos" 
									   style="display: none"
									   oldvalue="">
								<table width="100%" valign="top">
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
																$_GET['codeValue'] = '';
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
										<?php
											for($i=0; $i<count($linha_pess_juridica_contNome); $i++)
											{
												?>
													<tr id="<? echo $linha_pess_juridica_contNome[$i]['pk_contatos_empresa']; ?>_gerCliente_edit_contato">
														<td style="padding-right: 3px;
																   text-align: left;"
															class="gridCell">
												<?
													echo /*$linha_pess_juridica_contNome[$i]['pk_dados_pessoais'].' - '.*/htmlentities($linha_pess_juridica_contNome[$i]['s_usuario']);
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
										?>
									</tbody>
								</table>
								</td>
								</tr>
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
								<table valign="top">
										<tr>
											<td>
												Filiais<br>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" 
													   name="list_filiais"
													   id="<?php echo $PREID; ?>list_filiais" 
													   style="display: none"
													   oldvalue="">
												<table class="">
													<tbody id="<?php echo $PREID; ?>filialList">
														<tr>
															<td style="padding-right: 3px;">
																<?php
																	$_GET['component']		= 'explorer';
																	$_GET['componentId']	= $PREID.'filialAdd_contatoDaEmpresa';
																	$_GET['componentValue']	= '';
																	$_GET['componentName']	= 'filialAdd_contatoDaEmpresa';
																	$_GET['componentTipo']	= 'filial';
																	//$_GET['componentShowAdd']= '';
																	include('components.php');
																?>
															</td>
															<td>
																<input type="button"
																	   value="+"
																	   onclick="exploreLineAdd('<?php echo $PREID; ?>filialList');"
																	   class="botao_caract"
																	   onmouseover="showtip(this, event, 'Adicionar Linha');">
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<?php
											while($linha_pess_juridica_filiais= @pg_fetch_array($data_filiais))
											{
												$qr_filiaisNomes = "select ".$linha_pess_juridica_filiais['pk_filial_dados_pessoais']." as pk_filial_dados_pessoais, pk_dados_pessoais, s_usuario from tb_dados_pessoais where pk_dados_pessoais = ".$linha_pess_juridica_filiais['vfk_filial'];
												$filiaisData= pg_query($db_connection, $qr_filiaisNomes);
												$counter++;
												?>
													<tr id="<? echo $linha_pess_juridica_filiais['pk_filial_dados_pessoais']; ?>_gerCliente_edit_filial">
														<td style="padding-right: 3px;
																   text-align: left;"
															class="gridCell">
															<?	
																$dados_filial = pg_fetch_array($filiaisData);
																echo /*$dados_filial['pk_filial_dados_pessoais'].' - '.*/htmlentities($dados_filial['s_usuario']);
															?>
														</td>
														<td class="gridCell">
															<input type="button"
																   value="-"
																   onclick="if(confirm('Tem certeza que deseja desvincular este contato desta empresa?'))
																				onlyEvalAjax('ger_cliente_edit_pess_juridica.php?delFilial=<? echo $dados_filial['pk_filial_dados_pessoais']; ?>', '', 'eval(ajax)')"
																   class="botao_caract">
														</td>
													</tr>
												<?
											}
										?>
									</tbody>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table>
			<tr style="display: none;">
						<td colspan="3">
							
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
													$_GET['valor']= '';
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
													   value="CU"
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
									$idCount= 0;
									while ($linha_enderecos = pg_fetch_array($data_enderecos))
									{
										$idCount++;
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
																	$_GET['componentId']= $PREID.'clienteEstado'.$idCount;
																	$_GET['valor'] = $linha_enderecos['s_estado_sigla'];
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
																	   oldValue="<?php echo htmlentities($linha_enderecos['bl_caixa_postal']); ?>"
																	   id="<?php echo $PREID; ?>clientePostagem"
																	   <?php
																			if ($linha_enderecos['bl_caixa_postal'] == '1')
																				echo ' checked ';
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
														<td class="gridCell"
															style="text-align: left;">
															<?php
																echo $mailList['s_email'];
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
															echo $foneList['fk_tipo_telefone'];
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
													   value="<?php echo $linha_dados_pessoais['s_login'] ?>"
													   oldValue="<?php echo $linha_dados_pessoais['s_login'] ?>">
											</td>
											<td>
												<input type="password"
													   name="clientLoginPwd"
													   style="width: 90px;"
													   id="<?php echo $PREID; ?>clientLoginPwd"
													   value="<?php echo $linha_dados_pessoais['s_senha'] ?>"
													   oldValue="<?php echo $linha_dados_pessoais['s_senha'] ?>">
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
										   onclick="top.setLoad(true);onlyEvalAjax('ger_cliente_add.php', '', 'document.getElementById(\'corpo_ger_cliente_add\').innerHTML=ajax')">
									<input type="button"
										   class="botaoExcluir"
										   value=""
										   onclick="if(confirm('Tem certeza que deseja excluir este cliente ?'))
													{
														top.setLoad(true, 'Excluindo cliente');
														onlyEvalAjax('ger_cliente_edit_pess_juridica.php?delCode=<?php echo $_GET['pk_dados_pessoais']; ?>&preid=<?php echo $PREID; ?>', '', ' eval(ajax); ');
													}">
								</td>
							</tr>
						</table>
						<br>
						<br>
						<br>
					</td>
				</tr>
			</tbody>
		</table>
	</table>
</div>