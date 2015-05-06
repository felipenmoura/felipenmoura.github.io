<?php
//session_start();
require_once("inc/valida_sessao.php");
require_once("inc/calendar_input.php");
require_once("inc/styles.php");
require_once("inc/class_explorer.php");
include("../connections/flp_db_connection.php");
$db_connection= @connectTo();
$PREID= 'cliente_view_data';
	
	// SELECIONA DADOS PESSOAIS ( Tanto para Fisica quanto para Juridica )
	if($_GET['pk_contato'])
	{
		$select_dados_pessoais = "select  D.s_usuario,
										  D.c_sexo,
										  D.web_site as web_site,
										  D.txt_obs,
										  D.pk_dados_pessoais
								  from tb_dados_pessoais D
								  where pk_dados_pessoais = ".$_GET['pk_contato'];
	}else{
			$select_dados_pessoais = "select  U.s_login,
											  U.s_senha,
											  U.bl_tipo_pessoa,
											  D.s_usuario,
											  U.pk_usuario,
											  D.c_sexo,
											  D.web_site as web_site,
											  D.txt_obs,
											  D.bl_status,
											  D.pk_dados_pessoais
									  from tb_usuario U
									  inner join tb_dados_pessoais D
									  on (D.vfk_usuario = U.pk_usuario)
									  where U.bl_cliente=1
									  and D.bl_status=1
									  and D.pk_dados_pessoais = ".$_GET['pk_dados_pessoais'];
		 }
	$r_dados_pessoais= pg_query($db_connection, $select_dados_pessoais);
	$linha_dados_pessoais=pg_fetch_array($r_dados_pessoais);
	
	if(!$_GET['pk_dados_pessoais'])
	{
		$_GET['pk_dados_pessoais'] = $_GET['pk_contato'];
	}	

if ($_GET['tipo_pess'] == 'F') // Se for Pessoa Física
{
							  
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
	<iframe id="<?php echo $PREID; ?>hiddenFrameClientAdd"
			name="hiddenFrameClientAdd"
			style="display: none;">
	</iframe>
	<div style="width: 100%;
				height: 100%;
				padding-left:10px;
				padding-right:10px;
				overflow: auto;">
				
			<!-- DADOS PESSOAIS-->	
			<table style="width: 100%; height: 100%;" cellspacing="10">
				<tbody style="height: 20px;">
						<tr>
							<td id="<?php echo $PREID; ?>clienteAdd_tb_visivel"
								colspan="2">
							
								<table width="100%" >
									<tr>
										<td class="gridTitle" colspan="2">
											Dados Pessoais
										</td>
									</tr>
									<tr>
										<td>
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="gridText">
											Nome 
										</td>
										<td class="gridText">
											<input style="border:none;
													      color:#666666;
														  font-family: Arial;
														  font-size: 12px;
														  background-color:#f0f0f0;
														  width:250px"
												   type="text"
												   readonly="readonly"
												   oldvalue="<?php echo htmlentities($linha_dados_pessoais['s_usuario']); ?>"
												   value="<?php echo htmlentities($linha_dados_pessoais['s_usuario']); ?>">

										</td>
									</tr>
									<tr>
										<td class="gridText">
											Nacionalidade
										</td>
										<td class="gridText">
											<input style="border:none;
														      color:#666666;
															  font-family: Arial;
															  font-size: 12px;
															  width:250px;
															  background-color:#f0f0f0"
													   type="text"
													   readonly="readonly"
													   oldvalue="<?php echo htmlentities($linha_pess_fisica['s_nascionalidade']); ?>"
													   value="<?php echo htmlentities($linha_pess_fisica['s_nascionalidade']); ?>">
										</td>
									</tr>
									<tr>
										<td class="gridText">
											Estado civil
										</td>
										<td class="gridText"> 	
											<?php
											// SELECIONA ESTADO CIVIL
												$qr_select= "SELECT pk_estado_civil,
																	s_estado_civil
															   FROM tb_estado_civil
															";
												$data= @pg_query($db_connection, $qr_select);
												while($linha= @pg_fetch_array($data))
												{
													if($linha['pk_estado_civil'] == $linha_pess_fisica['fk_estado_civil'])
													{
														?>
															<input style="border:none;
																	      color:#666666;
																		  font-family: Arial;
																		  width:250px
																		  font-size: 12px;
																		  background-color:#f0f0f0"
																   type="text"
																   readonly="readonly"
																   oldvalue="<?php echo htmlentities($linha['s_estado_civil']); ?>"
																   value="<?php echo htmlentities($linha['s_estado_civil']); ?>">
														<?php
													}
												}
											?>	
										</td>
										<?php
											if($linha_pess_fisica['fk_estado_civil'] == 2 || $linha['pk_estado_civil'] == 6)
											{
												?>
													<tr>
														<td class="gridText">
															C&ocirc;njuge
														</td>
														<td class="gridText"> 
															<input style="border:none;
																	      color:#666666;
																		  width:250px
																		  font-family: Arial;
																		  font-size: 12px;
																		  background-color:#f0f0f0"
																   type="text"
																   readonly="readonly"
																   oldvalue="<?php echo htmlentities($linha_pess_fisica['s_conjuge']); ?>"
																   value=<?php echo htmlentities($linha_pess_fisica['s_conjuge']); ?>>
														</td>
													</tr>
												<?php
											}
										?>
									</tr>
									<tr>
										<td class="gridText">
											Nascimento
										</td>
										<td class="gridText">
											<input style="border:none;
														  color:#666666;
														  font-family: Arial;
														  width:250px
														  font-size: 12px;
														  background-color:#f0f0f0"
												   type="text"
												   readonly="readonly"
												   oldvalue="<?php echo htmlentities($linha_pess_fisica['dt_nascimento']); ?>"
												   value=<?php echo htmlentities($linha_pess_fisica['dt_nascimento']);?>>
										</td>
									</tr>
									<tr>
										<td class="gridText">
											Sexo
										</td>
										<td class="gridText">	
											<?php 
												if (strtoupper(trim($linha_dados_pessoais['c_sexo'])) == "F")
												{
													?>
														<input style="border:none;
																	  color:#666666;
																	  width:250px
																	  font-family: Arial;
																	  font-size: 12px;
																	  background-color:#f0f0f0"
															   type="text"
															   readonly="readonly"
															   oldvalue="<?php echo 'Feminino' ?>"
															   value="<?php echo 'Feminino' ?>">
													<?php
												}else
													 {
														?>
															<input style="border:none;
																	  color:#666666;
																	  width:250px
																	  font-family: Arial;
																	  font-size: 12px;
																	  background-color:#f0f0f0"
															   type="text"
															   readonly="readonly"
															   oldvalue="<?php echo 'Masculino' ?>"
															   value="<?php echo 'Masculino' ?>">
														<?php
													 }
											?>
										</td>
									</tr>
									<tr>
										<td class="gridText">
											Profiss&atilde;o
										</td>
										<td class="gridText">
											<input style="border:none;
														  color:#666666;
														  width:250px
														  font-family: Arial;
														  font-size: 12px;
														  background-color:#f0f0f0"
												   type="text"
												   readonly="readonly"
												   oldvalue="<?php echo htmlentities($linha_pess_fisica['s_profissao']); ?>"
												   value="<?php echo htmlentities($linha_pess_fisica['s_profissao']); ?>">
										</td>
									</tr>
									<tr>
										<td class="gridText">
											C.P.F
										</td>
										<td class="gridText">
											<input style="border:none;
														  color:#666666;
														  width:250px
														  font-family: Arial;
														  font-size: 12px;
														  background-color:#f0f0f0"
												   type="text"
												   readonly="readonly"
												   oldvalue="<?php echo htmlentities($linha_pess_fisica['cpf']); ?>"
												   value="<?php echo htmlentities($linha_pess_fisica['cpf']) ?>">
										</td>
									</tr>
									<tr>
										<td class="gridText">
											R.G
										</td>
										<td class="gridText">
												<input style="border:none;
															  color:#666666;
															  width:250px
															  font-family: Arial;
															  font-size: 12px;
															  background-color:#f0f0f0"
													   type="text"
													   readonly="readonly"
													   oldvalue="<?php echo htmlentities($linha_pess_fisica['s_rg']); ?>"
													   value="<?php echo htmlentities($linha_pess_fisica['s_rg']) ?>">
										</td>
									</tr>
									<tr>
										<td class="gridText">
											Site
										</td>
										<td class="gridText">
											<input style="border:none;
														  color:#666666;
														  width:250px
														  font-family: Arial;
														  font-size: 12px;
														  background-color:#f0f0f0"
												   type="text"
												   readonly="readonly"
												   oldvalue="<?php echo htmlentities($linha_dados_pessoais['web_site']); ?>"
												   value="<?php echo htmlentities($linha_dados_pessoais['web_site']); ?>">
												   <?php 
														if($linha_dados_pessoais['web_site']) 
													    {
															?>
																<a style="font-family: Arial;
																		  font-size: 11px;
																		  color:blue;"
																   target="_&quot"
																   href="http://<?php echo htmlentities($linha_dados_pessoais['web_site']); ?>">Ir para P&aacute;gina</a>
															<?php
														}
												   ?>
										</td>
									</tr>
							</table>
							<br>
<?php
	} // Fim se for Pessoa Fisica 
	else{   // Se for Pessoa Juridica
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
		
	<div style="width: 100%;
				height: 100%;
				padding-left:10px;
				padding-right:10px;
				overflow: auto;">
				
		<!--  DADOS DA EMPRESA-->
			<table width="100%">
					<tr>
						<td class="gridTitle" colspan="2">
							Dados da Empresa
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td class="gridText">
							Raz&atilde;o Social 
						</td>
						<td class="gridText">
							<input style="border:none;
										  color:#666666;
										  width:250px
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_pess_juridica['razao_social']) ?>"><br>
						</td>
					</tr>
					<tr>
						<td class="gridText">
							Nome Fantasia
						</td>
						<td class="gridText">
							<input style="border:none;
										  color:#666666;
										  width:250px
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_pess_juridica['nome_fantasia']) ?>"><br>
						</td>
					</tr>
					<tr>
						<td class="gridText">
							CNPJ
						</td>
						<td class="gridText">
							<input style="border:none;
										  color:#666666;
										  width:250px
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_pess_juridica['cnpj']) ?>"><br>
						</td>
					</tr>
					<tr>
						<td class="gridText">
							Inscri&ccedil;&atilde;o Estadual
						</td>
						<td class="gridText">
							<input style="border:none;
										  color:#666666;
										  width:250px
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_pess_juridica['inscr_estadual']) ?>"><br>
						</td>
					</tr>
					<tr>
						<td class="gridText">
							Inscri&ccedil;&atilde;o Municipal
						</td>
						<td class="gridText">
							<input style="border:none;
										  color:#666666;
										  width:250px
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_pess_juridica['inscr_municipal']) ?>"><br>
						</td>
					</tr>
					<tr>
						<td class="gridText">
							WebSite
						</td>
						<td class="gridText">
							<input style="border:none;
										  color:#666666;
										  width:250px
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_dados_pessoais['web_site']) ?>">
								    <?php 
										if($linha_dados_pessoais['web_site']) 
										{
											?>
												<a style="font-family: Arial;
														  font-size: 11px;
														  color:blue;
														  padding-left:12px;"
												   target="_&quot"
												   href="http://<?php echo htmlentities($linha_dados_pessoais['web_site']); ?>">Ir para P&aacute;gina</a>
											<?php
										}
								   ?>
						</td>
					</tr>
					<tr>
						<td class="gridText">
							Ramo de Atividade
						</td>
						<td class="gridText">
							
							<?php
								$qr_select= "SELECT pk_ramo_atividade,
													s_nome
											   FROM tb_ramo_atividade
											  ORDER BY pk_ramo_atividade
											";
								$data= pg_query($db_connection, $qr_select);
								while($linha= pg_fetch_array($data))
								{
									if($linha_pess_juridica['fk_ramo_atividade'] == $linha['pk_ramo_atividade'])
									{
									?>
										<input style="border:none;
													  color:#666666;
													  width:250px
													  font-family: Arial;
													  font-size: 12px;
													  background-color:#f0f0f0"
											   type="text"
											   readonly="readonly"
											   value="<?php echo htmlentities($linha['s_nome']); ?>">
									<?php
									}
								}
							?>
						</td>
					</tr>
					<tr>
						<td class="gridText">
							Respons&aacute;vel
						</td>
						<td class="gridText">
							<input style="border:none;
										  color:#666666;
										  width:250px
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_pess_juridica_resp['nome'])?>"><br>
						</td>
					</tr>
			</table>
			<br>
			
			<!-- CONTATOS-->
			<table width="100%">
					<tr>
						<td class="gridTitle" colspan="2">
							Contatos
						</td>
							<?php
								for($i=0; $i<count($linha_pess_juridica_contNome); $i++)
								{
									?>
										<tr>
											<td class="gridText">
												<input style="border:none;
															  color:#666666;
															  width:250px
															  font-family: Arial;
															  font-size: 12px;
															  background-color:#f0f0f0"
													   type="text"
													   readonly="readonly"
													   value="<?php echo htmlentities($linha_pess_juridica_contNome[$i]['pk_dados_pessoais']).' - '.htmlentities($linha_pess_juridica_contNome[$i]['s_usuario']);?>">
												<span style="padding-left:12px;">
														<a href="#"
														   onclick="creatBlock('<?php echo htmlentities($linha_pess_juridica_contNome[$i]['s_usuario']);?>', 'cliente_view_data.php?pk_contato=<?php echo $linha_pess_juridica_contNome[$i]['pk_dados_pessoais'] ?>&tipo_pess=F&contato=true','cliente_filial_view_data_<?php echo $arrayCli['pk_usuario']?>');"
														   style="font-family: Arial;
																  font-size: 11px;
																  color:blue;">Ir para Contato
														</a>
												</span>
											</td>
										</tr>
									<?
								}
							?>
					</tr>
			</table>
			<br>
			
			<!--  FILIAIS -->
			<br>
			<table width="100%">
					<tr>
						<td class="gridTitle" colspan="2">
							Filiais
						</td>
							<?php
								while($linha_pess_juridica_filiais= @pg_fetch_array($data_filiais))
								{
									$qr_filiaisNomes = "select ".$linha_pess_juridica_filiais['pk_filial_dados_pessoais']." as pk_filial_dados_pessoais, pk_dados_pessoais, s_usuario from tb_dados_pessoais where pk_dados_pessoais = ".$linha_pess_juridica_filiais['vfk_filial'];
									$filiaisData= pg_query($db_connection, $qr_filiaisNomes);
									$filiaisList= pg_fetch_array($filiaisData);
									$counter++;
									?>
										<tr id="<? echo $filiaisList['pk_filial_dados_pessoais']; ?>_gerCliente_edit_filial">
											<td style="padding-right: 3px;
													   text-align: left;"
												class="gridCell">
												<input style="border:none;
															  color:#666666;
															  width:250px
															  font-family: Arial;
															  font-size: 12px;
															  background-color:#f0f0f0"
													   type="text"
													   readonly="readonly"
													   value="<?php echo $filiaisList['pk_dados_pessoais'].' - '.htmlentities($filiaisList['s_usuario']);?>">
													   <span style="padding-left:12px;">
															<a href="#"
															   onclick="creatBlock('<?php echo htmlentities($filiaisList['s_usuario']);?>', 'cliente_view_data.php?pk_contato=<?php echo $filiaisList['pk_dados_pessoais'] ?>&tipo_pess=J&filial=true','cliente_view_data_<?php echo $arrayCli['pk_usuario']?>');"
															   style="font-family: Arial;
																	  font-size: 11px;
																	  color:blue;">Ir para Filial
															</a>
													   </span>
											</td>
										</tr>
									<?
								}
							?>
					</tr>
			</table>
			<br>
		<?php
	   }
	
?>
<!-- ENDEREÇOS-->
<table width="100%">
		<tr>
			<td class="gridTitle" colspan="2">
				Endere&ccedil;o(s)
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<?php 
			while ($linha_enderecos = pg_fetch_array($data_enderecos))
			{
				?>
					<tr>	
						<td>
							<?php 
								if ($linha_enderecos['c_tipo_endereco'] == 'C')
								{
									echo "<font class='gridText'> Endere&ccedil;o Comercial</font>";
								}else
									 {
										echo " <font class='gridText'>Endere&ccedil;o Residencial</font>";
									 }
								if ($linha_enderecos['bl_caixa_postal'] == 1)
								{
									echo "<span style='font-size:10px;font-style:italic'>&nbsp;&nbsp;Caixa Postal</span>";
								}
							?>
						</td>
					</tr>
					</tr>
						<td colspan="8"
							class="gridText"> 
							<nobr>CEP&nbsp; 
							<input style="border:none;
										  color:#666666;
										  width:300px;
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo  $linha_enderecos['s_cep']." - ".htmlentities($linha_enderecos['s_logradouro']).", ".$linha_enderecos['s_num'] ?>">
							<br>	   
							<input style="border:none;
										  color:#666666;
										  width:300px;
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo "Bairro ".htmlentities($linha_enderecos['s_bairro'])." , ".htmlentities($linha_enderecos['s_cidade'])." ".htmlentities(trim($linha_enderecos['s_estado_sigla']))." ".htmlentities($linha_enderecos['s_pais'])?>">
							<br>
							<input style="border:none;
										  color:#666666;
										  width:300px;
										  font-family: Arial;
										  font-size: 12px;
										  background-color:#f0f0f0"
								   type="text"
								   readonly="readonly"
								   value="<?php echo htmlentities($linha_enderecos['s_complemento']);?>">
							<?php
								//echo  $linha_enderecos['s_cep']." - ".htmlentities($linha_enderecos['s_logradouro']).", ".$linha_enderecos['s_num']."<br> Bairro ".htmlentities($linha_enderecos['s_bairro'])." , ".htmlentities($linha_enderecos['s_cidade'])." ".htmlentities(trim($linha_enderecos['s_estado_sigla']))." ".htmlentities($linha_enderecos['s_pais'])."<br>".htmlentities($linha_enderecos['s_complemento']);
							?>
							</nobr>
						</td>
					</tr>
				<?php
			}
		?>
	</table>
	<br>
				<!-- EMAILS-->
				<table width="100%">
					<tr>
						<td class="gridTitle" colspan="2">
							E-mail(s)
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
					</tr>
					<?php
						$qr_mails= "SELECT pk_email,
										   s_email
									  FROM tb_email
									 WHERE fk_dados_pessoais = ".$_GET['pk_dados_pessoais']."
								   ";
						$mailData= pg_query($db_connection, $qr_mails);
						while($mailList= pg_fetch_array($mailData))
						{
							?>
							<tr>
								<td class="gridText">
									<input style="border:none;
											  color:#666666;
											  width:300px;
											  font-family: Arial;
											  font-size: 12px;
											  background-color:#f0f0f0"
									   type="text"
									   readonly="readonly"
									   value="<?php echo htmlentities($mailList['s_email']);?>">
								</td>
							</tr>
						<?
						}
						?>
				</table>
				<br>
				
				<!-- TELEFONES-->
				<table width="100%">
					<tr>
						<td class="gridTitle" colspan="2">
							Telefone(s)
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td>
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
								<tr>
									<td style="padding-right: 3px;"
										class="gridText">
										<input style="border:none;
													  color:#666666;
													  width:300px;
													  font-family: Arial;
													  font-size: 12px;
													  background-color:#f0f0f0"
											   type="text"
											   readonly="readonly"
											   value="<?php echo "(".$foneList['s_ddd'].")"." ".$foneList['s_numero'] ?>" >
										<span style='font-size:10px;font-style:italic'> <?php echo htmlentities($foneList['fk_tipo_telefone']);?></span>
									</td>
								</tr>
							<?
								}
							?>
						</td>
					</tr>
			</table>
			<br>
			
			<!--PROCESSOS-->
				<?php 
					$qr_select_processos = "
											 SELECT pk_processo,
												    p1.s_nome
											   FROM tb_processo p1,
												    tb_processo_pasta pp,
												    tb_pasta p2
											  WHERE pp.fk_processo = p1.pk_processo
											    AND pp.fk_pasta = p2.pk_pasta
											    AND p2.fk_usuario = ".$_GET['pk_usuario']."			
										   ";
					if ($_GET['pk_usuario'])
					{
						$result_proc = pg_query($db_connection, $qr_select_processos);
						?>
						<table width="100%">
							<tr>
								<td class="gridTitle" colspan="2">
									Processo(s)
								</td>
							</tr>
							<tr>
								<td>
									&nbsp;
								</td>
							</tr>
							<tr>
								<td>
									<table>
										<?php
											while($linha = pg_fetch_array($result_proc))
											{
												?>
													<tr>
														<td>
															<img src="img/proc.gif">
															<?php
																echo $linha['s_nome'];
															?>
														</td>
													</tr>
												<?php
											}
										?>
									</table>
								</td>
							</tr>
						</table>
					 <?php 
					}else{
							$result_proc ="";	
						 }
					 ?>
				<br>
					<!-- OBSERVAÇÃO-->
					<table width="100%">
						<tr>
							<td style="font-size:12px;
									   font-weight:bold;
									   text-decoration:underline'">
								Obs:
							</td>
						</tr>
						<tr>
							<td style="border-top:solid 1px;"
								class="">
								<textarea style="width:360px;height:120px;" 
								          class="discret_input" readonly><?php echo htmlentities($linha_dados_pessoais['txt_obs']) ?></textarea>
							</td>
						</tr>
					<table>
</div>
<br>
<div style="font-size:14px;
		    text-decoration:underline;
			cursor:pointer;"
	<?php 
		if ($_GET['contato'] == 'true')
		{
			?>
				onclick="creatBlock('Gerenciar Contatos', 'ger_contatos.php?pk_usuario=<?php echo $_GET['pk_dados_pessoais']; ?>','ger_contatos',false,false,'400/600');">
			<?php
		}else if ($_GET['filial'] == 'true')
			  {
				 ?>
					onclick="creatBlock('Gerenciar Filiais', 'ger_filiais.php?pk_usuario=<?php echo $_GET['pk_dados_pessoais']; ?>','ger_filiais',false,false,'400/600');">
				 <?php
			  }else {
						?>
						     onclick="creatBlock('Gerenciar Clientes', 'ger_clientes.php?pk_usuario=<?php echo $_GET['pk_usuario']; ?>','ger_clientes',false,false,'400/600');">
						<?php
					}
	?>
	
<img src="img/edit.gif">
Alterar Dados
</div>

	