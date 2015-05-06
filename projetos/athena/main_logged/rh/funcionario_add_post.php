<?php
//session_start();
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/query_control.php");
require_once("../inc/class_explorer.php");
include("../../connections/flp_db_connection.php");
$db_connection= connectTo();
if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		<script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		</script>
	<?php
	exit;
}

if($_POST)
{
	require_once("../../connections/flp_db_connection.php");
	require_once("../inc/get_sequence.php");
	startQuery($db_connection);
	$next_code = getSequence('usuario_seq');
	
	?>
		<script>
			//top.showAlert= function (a, b){ alert(b); }
		</script>
	<?php
	
	//INSERINDO DADOS DO USUARIO
	// Tipo de Pessoa tem que botar F ou J que vem de dados contratuais ...
	$qr_insert_tb_usuario = " INSERT INTO tb_usuario
							  (
								    pk_usuario,
									s_login,
									s_senha,
									bl_cliente,
									bl_tipo_pessoa,
									bl_senha
							  ) 
							  VALUES
							  (
								   ".$next_code.",
								   '".trim($_POST['funcionarioLogin'])."',
								   '".trim($_POST['funcionarioSenha'])."',
								   0,
								   '".trim($_POST['bl_tipo_pessoa'])."', 
								   0
							  )
								
							";
	$data= @pg_query($db_connection, $qr_insert_tb_usuario);
	if(!$data)
	{
		?>
			<script>
				top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! usuarios');
			</script>
		<?php
		cancelQuery($db_connection);
		exit;
	}
	//INSERINDO  DADOS PESSOAIS
	$dadosPessoaisCod = getSequence('dados_pessoais_seq');
	//$next_code é a pk_usuario
	$qr_insert_tb_dados_pessoais = " INSERT INTO tb_dados_pessoais
									  (
										pk_dados_pessoais,
										s_usuario,
										c_sexo,
										web_site,
										vfk_usuario
									  )
									  VALUES
									  (
										".$dadosPessoaisCod.",
										'".trim($_POST['funcionarioNome'])."',
										'".trim($_POST['funcionarioSexo'])."',
										'".trim($_POST['funcionarioSite'])."',
										".$next_code."
									  );
								   ";
	$data= @pg_query($db_connection, $qr_insert_tb_dados_pessoais);
	if(!$data)
	{
		?>
			<script>
				top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! dados pessoais');
			</script>
		<?php
		cancelQuery($db_connection);
		exit;
	}
	//$next_code é a pk_usuario
	if ($_POST['bl_deficiencia'] == 'on')
	{
		$_POST['bl_deficiencia'] = 1;
	}else
		 {
		    $_POST['bl_deficiencia'] = 0;
		 }
	//INSERINDO DADOS DO FUNCIONARIO
	$qr_insert_tb_funcionario= "INSERT INTO tb_funcionario
								(
									fk_usuario,
									bl_deficiencia_fisica,
									s_deficiencia_fisica,
									s_rg,
									dt_rg_data,
									s_rg_orgao_emissor,
									s_cnpj,
									s_cpf,
									s_ctps,
									s_serie_ctps,
									s_uf_ctps,
									s_data_ctps,
									s_pis_pasep,
									s_cnh,
									s_tipo_cnh,
									s_tit_eleitoral,
									s_zona_tit_eleitoral,
									s_secao_tit_eleitoral,
									s_num_reservista,
									s_serie_reservista,
									s_categoria_reservista,
									fk_grau_instrucao,
									s_foto_url,
									fk_departamento,
									fk_cargo,
									dt_admicao,
									dt_demissao,
									vfk_banco,
			 						vfk_operacao,
									s_conta,
									s_agencia,
									s_pai,
									s_mae,
									s_obs
								)
						 VALUES
								(
									".$next_code.",
									".$_POST['bl_deficiencia'].",
									'".$_POST['funcionarioDeficiencia']."',
									'".$_POST['funcionarioRG']."',
									TO_DATE('".$_POST['func_add_funcionarioRgDataEmissao']."', 'DD/MM/YYYY'),
									'".$_POST['funcionarioRgOrgaoEmissor']."',
									'".$_POST['funcionarioCNPJ']."',
									'".$_POST['funcionarioCPF']."',
									'".$_POST['funcionarioCtpsNum']."',
									'".$_POST['funcionarioCtpsSerie']."',
									'".$_POST['func_add_funcionarioEstado']."',
									TO_DATE('".$_POST['funcionarioCtpsDataEmissao']."', 'DD/MM/YYYY'),
									'".$_POST['funcionarioPis']."',
									'".$_POST['funcionarioHabilitacaoNum']."',
									'".$_POST['funcionarioHabilitacaoTipo']."',
									'".$_POST['funcionarioTituloNum']."',
									'".$_POST['funcionarioTituloZona']."',
									'".$_POST['funcionarioTituloSessao']."',
									'".$_POST['funcionarioReservistaNum']."',
									'".$_POST['funcionarioReservistaSerie']."',
									'".$_POST['funcionarioReservistaCategoria']."',
									".toNull($_POST['func_add_funcionarioEscolaridade']).",
									NULL,
									".$_POST['func_add_departamento'].",
									".$_POST['func_add_cargo'].",
									TO_DATE('".$_POST['func_add_dataAdmissao']."', 'DD/MM/YYYY'),
									NULL,
									".toNull($_POST['func_add_funcionarioBanco']).",
									".toNull($_POST['func_add_funcionarioOperacao']).",
									'".$_POST['funcionarioContaCorrente']."',
									'".$_POST['funcionarioAgencia']."',
									'".$_POST['funcionarioNomePai']."',
									'".$_POST['funcionarioNomeMae']."',
									'".$_POST['obs']."'
								)
						";
		$data= pg_query($db_connection, $qr_insert_tb_funcionario);
		if(!$data)
		{
			echo "<pre>".$qr_insert_tb_funcionario;
			?>
				<script>
					top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! funcionario');
				</script>
			<?php
			cancelQuery($db_connection);
			exit;
		}
		
	
	//                  INSERINDO ENDEREÇOS 	
	//                  Pega-se todos endereços da tela de cadastro e insere no BD.

		$enderecos_full = explode('|+|',$_POST['enderecos']); 
		for ($i=0;$i<count($enderecos_full)-1;$i++)
		{
			$endereco = explode('||',$enderecos_full[$i]);
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
				trim($endereco[5]) != ''
			   )
			{
				$qr_insert_enderecos= "  INSERT INTO tb_cep
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
										  );
										  
										  INSERT INTO tb_cep_dados_pessoais
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
										  "
										  ;
								$data= @pg_query($db_connection, $qr_insert_enderecos);
								if(!$data)
								{
									?>
										<script>
											top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! enderecos');
										</script>
									<?php
									cancelQuery($db_connection);
									exit;
								}
			}
			echo "<b>TB_CEP > </b><br>".$qr_insert_enderecos."<br><br>";
		}

		
	//       INSERINDO TELEFONES
	$telefones= explode(';;;;;;|+|', $_POST['telefones']);
	for ($i=0; $i<(count($telefones)-1); $i++)
	{
		$foneDados= explode(';;;', $telefones[$i]);
		$telefone_cod = getSequence('telefone_seq');
		if(trim($foneDados[2]) != '' && trim($foneDados[1]) != '' && trim($foneDados[0])!= '')
		{
			$qr_insert_telefones= "INSERT INTO tb_telefone
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
											".$dadosPessoaisCod.",
											".trim($telefone_cod)."
										  )
									  ";
			echo "<b>TB_TELEFONE > </b><br>".$qr_insert_telefones."<br><br>";
			$data= @pg_query($db_connection, $qr_insert_telefones);
			if(!$data)
			{
				?>
					<script>
						top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! telefones');
					</script>
				<?php
				cancelQuery($db_connection);
				exit;
			}
		}
	}
	
	
	//INSERINDO EMAILS		
	$func_emails = explode(';;;;;;|+|',$_POST['emails']);
	for ($i=0;$i<count($func_emails);$i++)
	{
		if(trim($func_emails[$i]) != '')
		{
			$qr_insert_tb_email= "INSERT INTO tb_email
								 (
									s_email,
									fk_dados_pessoais
								  )
								  VALUES
								  (
									'".$func_emails[$i]."',
									".$dadosPessoaisCod."
								  );";
			echo "<b>TB_EMAIL > </b><br>".$qr_insert_tb_email."<br><br>";
			$data= @pg_query($db_connection, $qr_insert_tb_email);
			if(!$data)
			{
				?>
					<script>
						top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! e-mails');
					</script>
				<?php
				cancelQuery($db_connection);
				exit;
			}
		}
	}
	
	//INSERINDO DEPENDENTES
	echo "****************";
	$func_dependentes = explode(';;;;;;|+|',$_POST['func_add_dependenteList']);
	for ($i=0;$i<count($func_dependentes);$i++)
	{
		$dep= explode(';;;', $func_dependentes[$i]);
		if(trim($dep[0]) != '' && trim($dep[1]) != '' )
		{
			$next_code_dependente = getSequence('dependente_seq');
			$qr_insert_dependentes= "INSERT INTO tb_dependente
								  (
									pk_dependente,
									s_nome
								  )
								  VALUES
								  (
									'".$next_code_dependente."',
									'".$dep[0]."'
								  );";
			echo "<b>TB_dependentes > </b><br>".$qr_insert_dependentes."<br><br>";
			$data= @pg_query($db_connection, $qr_insert_dependentes);
			if(!$data)
			{
				?>
					<script>
						top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! dependentes');
					</script>
				<?php
				cancelQuery($db_connection);
				exit;
			}
			
			
			$qr_insert_dependentes= "INSERT INTO tb_funcionario_dependente
								  (
									fk_dependente,
									fk_dependencia
								  )
								  VALUES
								  (
									'".$next_code_dependente."',
									".$dep[1]."
								  );";
			echo "<b>TB_dependentes > </b><br>".$qr_insert_dependentes."<br><br>";
			$data= @pg_query($db_connection, $qr_insert_dependentes);
			if(!$data)
			{
				?>
					<script>
						top.showAlert('erro', 'N&atilde;o foi poss&iacute;vel o cadastro ! dependentes');
					</script>
				<?php
				cancelQuery($db_connection);
				exit;
			}
		}
	}
	echo "<br>****************";
 	echo "<b>TB_USUARIO > </b><br>".$qr_insert_tb_usuario."<br><br>";	
	echo "<b>TB_DADOS_PESSOAIS > </b><br>".$qr_insert_tb_dados_pessoais."<br><br>";		
	echo "<b>TB_FUNCIONARIO > </b><br>".$qr_insert_tb_funcionario."<br><br>";
	showPost();
	commitQuery($db_connection);
	?>
		<script>
			top.showAlert('informativo', 'Cadastro efetuado com sucesso');
		</script>
	<?php
}else 
	 {
		echo "Erro ao tentar inserir funcion&aacute;rio ... ou forma de acesso inv&aacute;lida";
	 }