<?php
	switch($_GET['component'])
	{
		case 'usuario_grupo':
		{
			?>
				<select name="<? echo $_GET['componentId']; ?>"
						id="<? echo $_GET['componentId']; ?>"
						componentType="usuario_grupo">
						<?
							if(!$db_connection)
							{
								include("../connections/flp_db_connection.php");
								$db_connection= @connectTo();
							}
							$qr_select= "SELECT pk_grupo,
												s_label
										   FROM tb_grupo
										";
							$data= @pg_query($db_connection, $qr_select);
							while($linhaComponent= pg_fetch_array($data))
							{
								?>
									<option value="<? echo $linhaComponent['pk_grupo']; ?>">
										<?
											echo htmlentities($linhaComponent['s_label']);
										?>
									</option>
								<?
							}
						?>
				</select>
			<?
			break;
		}
		case 'agenda_grupo':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="agenda_grupo">
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT g.pk_agenda_grupo as cod,
													g.s_grupo_nome as label,
													g.s_descricao as desc
											   FROM tb_agenda_grupo g
											  WHERE vfk_usuario = ".$_SESSION['pk_usuario']."
											     OR vfk_usuario ISNULL
											  ORDER BY UPPER(s_grupo_nome)
											";
								$data= pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data)) 
								{
									?>
										<option value="<? echo $linhaComponent['cod']; ?>">
											<?
												echo htmlentities($linhaComponent['label']);	
											?>
										</option>
									<?
								}
							?>
					</select>
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo grupo de contatos ', 'agenda_grupo.php', 'novo_grupo_contatos');">
				</nobr>
			<?
			break;
		}
		case 'estado_civil':
		{
			$db_connection= @connectTo();
			if(!$db_connection)
			{
				
				if(include("../connections/flp_db_connection.php"))
				{
					echo 'a1';
				}
				else
				{
					echo 'a2';
					//@include("connections/flp_db_connection.php");
				}
			}
			?>
				<select name="<? echo $_GET['componentId']; ?>"
						style="width:120px;
							   display: none;"
						id="<? echo $_GET['componentId']; ?>"
						componentType="estado_civil">
						<option value=""></option>
						<?
							$qr_select= "SELECT pk_estado_civil,
												s_estado_civil
										   FROM tb_estado_civil
										";
							$data= @pg_query($db_connection, $qr_select);
							while($linhaComponent= @pg_fetch_array($data))
							{
								?>
									<option value="<? echo $linhaComponent['pk_estado_civil'];?>"
											<?php
												if($_GET['valor'] == $linhaComponent['pk_estado_civil'])
													echo ' selected ';
											?>>
										<?
											echo htmlentities($linhaComponent['s_estado_civil']);
										?>
									</option>
								<?
							}
						?>
				</select>
				<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
			<?
			break;
		}
		
		
		
		case 'ramo_atividade':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="ramo_atividade">
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_ramo_atividade,
													s_nome
											   FROM tb_ramo_atividade
											  ORDER BY pk_ramo_atividade
											";
								$data= pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo $linhaComponent['pk_ramo_atividade']; ?>"
											<?php
												if($_GET['valor'] == $linhaComponent['pk_ramo_atividade'])
													echo ' selected ';
											?>>
											<?
												echo htmlentities($linhaComponent['s_nome']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo ramo de atividade', 'ramo_atividade_add.php', 'ramo_atividade_add', 'noresize');">
				</nobr>
			<?
			break;
		}
		
		case 'estado':
		{
			?>
				<select name="<? echo $_GET['componentId']; ?>"
						id="<? echo $_GET['componentId']; ?>"
						label="Estado"
						style="display: none;">
					<option value="">
						
					</option>
					<option value="AC"
							<?php if($_GET['valor'] == 'AC')
								 {
									echo " selected ";
								 }
							?>>
						AC
					</option>
					<option value="AL" 
							<?php if($_GET['valor'] == 'AL')
								 {
									echo " selected ";
								 }
							?>>
						AL
					</option>
					<option value="AP"  
							<?php if($_GET['valor'] == 'AP')
								 {
									echo " selected ";
								 }
							?>>
						AP
					</option>
					<option value="AM"  
							<?php if($_GET['valor'] == 'AM')
								 {
									echo " selected ";
								 }
							?>>
						AM
					</option>
					<option value="BA"  
							<?php if($_GET['valor'] == 'BA')
								 {
									echo " selected ";
								 }
							?>>
						BA
					</option>
					<option value="CE"  
							<?php if($_GET['valor'] == 'CE')
								 {
									echo " selected ";
								 }
							?>>
						CE
					</option>
					<option value="DF"  
							<?php if($_GET['valor'] == 'DF')
								 {
									echo " selected ";
								 }
							?>>
						DF
					</option>
					<option value="ES"  
							<?php if($_GET['valor'] == 'ES')
								 {
									echo " selected ";
								 }
							?>>
						ES
					</option>
					<option value="GO"  
							<?php if($_GET['valor'] == 'GO')
								 {
									echo " selected ";
								 }
							?>>
						GO
					</option>
					<option value="MA"  
							<?php if($_GET['valor'] == 'MA')
								 {
									echo " selected ";
								 }
							?>>
						MA
					</option>
					<option value="MT"  
							<?php if($_GET['valor'] == 'MT')
								 {
									echo " selected ";
								 }
							?>>
						MT
					</option>
					<option value="MS"  
							<?php if($_GET['valor'] == 'MS')
								 {
									echo " selected ";
								 }
							?>>
						MS
					</option>
					<option value="MG"  
							<?php if($_GET['valor'] == 'MG')
								 {
									echo " selected ";
								 }
							?>>
						MG
					</option>
					<option value="PA"  
							<?php if($_GET['valor'] == 'PA')
								 {
									echo " selected ";
								 }
							?>>
						PA
					</option>
					<option value="PB"  
							<?php if($_GET['valor'] == 'PB')
								 {
									echo " selected ";
								 }
							?>>
						PB
					</option>
					<option value="PR"  
							<?php if($_GET['valor'] == 'PR')
								 {
									echo " selected ";
								 }
							?>>
						PR
					</option>
					<option value="PE"  
							<?php if($_GET['valor'] == 'PE')
								 {
									echo " selected ";
								 }
							?>>
						PE
					</option>
					<option value="PI"  
							<?php if($_GET['valor'] == 'PI')
								 {
									echo " selected ";
								 }
							?>>
						PI
					</option>
					<option value="RJ"  
							<?php if($_GET['valor'] == 'RJ"')
								 {
									echo " selected ";
								 }
							?>>
						RJ
					</option>
					<option value="RN"  
							<?php if($_GET['valor'] == 'RN')
								 {
									echo " selected ";
								 }
							?>>
						RN
					</option>
					<option value="RS"  
							<?php if($_GET['valor'] == 'RS')
								 {
									echo " selected ";
								 }
							?>>
						RS
					</option>
					<option value="RO"  
							<?php if($_GET['valor'] == 'RO')
								 {
									echo " selected ";
								 }
							?>>
						RO
					</option>
					<option value="RR"  
							<?php if($_GET['valor'] == 'RR')
								 {
									echo " selected ";
								 }
							?>>
						RR
					</option>
					<option value="SC"  
							<?php if($_GET['valor'] == 'SC')
								 {
									echo " selected ";
								 }
							?>>
						SC
					</option>
					<option value="SP"  
							<?php if($_GET['valor'] == 'SP')
								 {
									echo " selected ";
								 }
							?>>
						SP
					</option>
					<option value="SE"  
							<?php if($_GET['valor'] == 'SE')
								 {
									echo " selected ";
								 }
							?>>
						SE
					</option>
					<option value="TO"  
							<?php if($_GET['valor'] == 'TO')
								 {
									echo " selected ";
								 }
							?>>
						TO
					</option>
				</select>	
			<?php
			?>
					<input type="text"
						   id="iptComponentUf<? echo $_GET['componentId']; ?>"
						   style="width: 50px;
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
						   value="<?php echo $_GET['valor']; ?>"
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
				</nobr>
			<?
			break;
		}
		case 'tipoFone':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							label="tipo de telefone"
							componentType='tipoFone'
							style="display: none;">
							<option value="">
							</option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT s_tipo_telefone as label
											   FROM tb_tipo_telefone
											  ORDER BY s_tipo_telefone
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo urlencode($linhaComponent['label']); ?>">
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
			<?php
			?>
					<input type="text"
						   id="iptComponentFone<? echo $_GET['componentId']; ?>"
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
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo tipo de telefone', 'tipo_telefone_add.php', 'tipo_telefone_add', 'noresize');">
				</nobr>
			<?
			break;
		}
		/*case 'filialAdd':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType='filialAdd'>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT s_tipo_telefone as label
											   FROM tb_tipo_telefone
											  ORDER BY s_tipo_telefone
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['label']); ?>"
												onmouseover="showtip(this, event, '<? echo htmlentities($linhaComponent['label']); ?>')">
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo tipo de telefone', 'tipo_telefone_add.php', 'tipo_telefone_add', 'noresize');">
				</nobr>
			<?php
			break;
		}*/
		
		case 'filiais':
		{
			if(!$db_connection)
			{
				@include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}
			clearstatcache();
			$qr_selectCliente= "   SELECT pk_dados_pessoais,
										  s_usuario
									 FROM tb_dados_pessoais,
										  tb_pess_juridica j
									WHERE vfk_usuario isnull
									  AND j.fk_dados_pessoais = pk_dados_pessoais
									ORDER BY s_usuario";
			$dataCli= pg_query($db_connection, $qr_selectCliente);
			?>
			<table>
				<tr>
					<td>
						<nobr>
						<select name="<? echo $_GET['componentId']; ?>[]"
								id="<? echo $_GET['componentId']; ?>"
								componentType='componentFiliais'
								multiple
								size='4'
								style="width: 180px;">
						<?php
						while($linhaCli= @pg_fetch_array($dataCli))
						{
							?>
								<option value="<?php echo $linhaCli['pk_dados_pessoais']; ?>"
										onmouseover="showtip(this, event, '<? echo htmlentities($linhaComponent['s_usuario']); ?>')">
									<?php echo htmlentities($linhaCli['s_usuario']); ?>
								</option>
							<?php
						}
						?>
						</select>
						</nobr>
					</td>
					<td style="vertical-align: center;
							   width: 17px;">
						<img src="img/add.gif"
							 style="cursor: pointer;"
							 onclick="creatBlock('Nova filial', 'agenda_contato_filial.php', 'agenda_contato_filial');"
							 valign="middle">
						<img src="img/help.gif"
										 style="cursor: pointer;"
										 onclick="showHelp('filiais')"
										 valign="middle">
					</td>
				</tr>
			</table>
		<?php
		break;
		}
		case 'componentFiliais':
		{
			if(!$db_connection)
			{
				@include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}
			clearstatcache();
			$qr_selectCliente= "   SELECT pk_dados_pessoais,
										  s_usuario
									 FROM tb_dados_pessoais,
										  tb_pess_juridica j
									WHERE vfk_usuario isnull
									  AND j.fk_dados_pessoais = pk_dados_pessoais
									ORDER BY s_usuario";
			$dataCli= pg_query($db_connection, $qr_selectCliente);
			?>
						<select name="<? echo $_GET['componentId']; ?>[]"
								id="<? echo $_GET['componentId']; ?>"
								componentType='componentFiliais'
								multiple
								size='4'
								style="width: 180px;">
						<?php
						while($linhaCli= @pg_fetch_array($dataCli))
						{
							?>
								<option value="<?php echo $linhaCli['pk_dados_pessoais']; ?>">
									<?php echo htmlentities($linhaCli['s_usuario']); ?>
								</option>
							<?php
						}
						?>
						</select>
		<?php
		break;
		}
		case 'contatoDaEmpresa':
		{
			if(!$db_connection)
			{
				@include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectCliente= "   SELECT pk_dados_pessoais,
										  s_usuario
									 FROM tb_dados_pessoais,
										  tb_pess_fisica f
									WHERE vfk_usuario isnull
									  AND f.fk_dados_pessoais = pk_dados_pessoais
									ORDER BY s_usuario";
			$dataCli= pg_query($db_connection, $qr_selectCliente);
			?>
			<table>
				<tr>
					<td>
						<nobr>
							<select name="<? echo $_GET['componentId']; ?>[]"
									id="<? echo $_GET['componentId']; ?>"
									componentType='componentContatoDaEmpresa'
									multiple
									size='4'
									style="width: 180px;">
							<?php
							while($linhaCli= @pg_fetch_array($dataCli))
							{
								?>
									<option value="<?php echo $linhaCli['pk_dados_pessoais']; ?>">
										<?php echo htmlentities($linhaCli['s_usuario']); ?>
									</option>
								<?php
							}
							?>
							</select>
						</nobr>
					</td>
					<td style="vertical-align: center;
							   width: 17px;">
						<img src="img/add.gif"
							 style="cursor: pointer;"
							 onclick="creatBlock('Novo contato para empresa', 'agenda_contato_empresa.php', 'agenda_contato_empresa');"
							 valign="middle">
						<img src="img/help.gif"
										 style="cursor: pointer;"
										 onclick="showHelp('contatoDaEmpresa')"
										 valign="middle">
					</td>
				</tr>
			</table>
		<?php
			break;
		}
		case 'componentContatoDaEmpresa':
		{
			if(!$db_connection)
			{
				@include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectCliente= "   SELECT pk_dados_pessoais,
										  s_usuario
									 FROM tb_dados_pessoais,
										  tb_pess_fisica f
									WHERE vfk_usuario isnull
									  AND f.fk_dados_pessoais = pk_dados_pessoais
									ORDER BY s_usuario";
			$dataCli= pg_query($db_connection, $qr_selectCliente);
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType='componentContatoDaEmpresa'
							multiple
							size='4'
							style="width: 180px;">
					<?php
					while($linhaCli= @pg_fetch_array($dataCli))
					{
						?>
							<option value="<?php echo $linhaCli['pk_dados_pessoais']; ?>">
								<?php echo htmlentities($linhaCli['s_usuario']); ?>
							</option>
						<?php
					}
					?>
					</select>
				</nobr>
			<?php
			break;
		}
		
		case 'escolaridade':
		{
			
			if(!$db_connection)
			{
				include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectEscolaridade= "SELECT pk_grau_instrucao,
										  s_grau_instrucao
									 FROM tb_grau_instrucao
									ORDER BY s_grau_instrucao";
			$dataEscolaridade= pg_query($db_connection, $qr_selectEscolaridade);
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="escolaridade"
							style="width: 170px;
								   font-size:10px;
								   display: none;">
					<option value="">
						&nbsp;
					</option>
					<?php
					// $countTmp= 0;
					while($linhaEscolaridade= @pg_fetch_array($dataEscolaridade))
					{
						// if($countTmp == 0)
						//	 $value= htmlentities($linhaEscolaridade['s_grau_instrucao']);;
						?>
							<option value="<?php echo $linhaEscolaridade['pk_grau_instrucao']; ?>">
								<?php echo htmlentities($linhaEscolaridade['s_grau_instrucao']); ?>
							</option>
						<?php
						// $countTmp++;
					}
					?>
					</select>
			<?php
			?>
					<input type="text"
						   id="iptEscolaridade<? echo $_GET['componentId']; ?>"
						   readonly
						   class="selectIpt"
						   onfocus="//this.click();"
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<img src="img/add.gif"
							 style="cursor: pointer;"
							 onmouseover="showtip(this, event, 'Adicionar Nova Escolaridade')"
							 onclick="creatBlock('Nova Escolaridade ', 'rh/escolaridade_add.php', 'escolaridade_add', 'nomaximize, noresize');">
				</nobr>
			<?
			break;
		}
		
		case 'banco':
		{
			if(!$db_connection)
			{
				include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}
			$qr_selectBanco= "SELECT pk_banco,
										    s_banco
									FROM    tb_banco
									ORDER BY s_banco";
			$dataBanco= pg_query($db_connection, $qr_selectBanco);
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="banco"
							style="width: 180px;
								   font-size:10px;
								   display: none;">
					<option value=""></option>
					<?php
					while($linhaBanco= @pg_fetch_array($dataBanco))
					{
						?>
							<option value="<?php echo $linhaBanco['pk_banco']; ?>">
								<?php echo htmlentities($linhaBanco['s_banco']); ?>
							</option>
						<?php
					}
					?>
					</select>
					<input type="text"
						   id="iptBanco<? echo $_GET['componentId']; ?>"
						   readonly
						   class="selectIpt"
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Adicionar Novo Banco')"
						 onclick="creatBlock('Novo Banco ', 'rh/banco_add.php', 'banco_add', 'nomaximize, noresize');">
				</nobr>
		<?php
			break;
		}
		case 'operacao':
		{
			if(!$db_connection)
			{
				include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectBanco= "	  SELECT pk_operacao,
									     s_operacao
									FROM tb_banco_operacao
								   ORDER BY s_operacao";
			$dataBanco= pg_query($db_connection, $qr_selectBanco);
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="operacao"
							style="width: 180px;
								   font-size:10px;
								   display: none;">
						<option value=""></option>
					<?php
					while($linhaBanco= @pg_fetch_array($dataBanco))
					{
						?>
							<option value="<?php echo $linhaBanco['pk_operacao']; ?>">
								<?php echo htmlentities($linhaBanco['s_operacao']); ?>
							</option>
						<?php
					}
					?>
					</select>
					<input type="text"
						   id="iptOperacao<? echo $_GET['componentId']; ?>"
						   readonly
						   class="selectIpt"
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Adicionar Nova opera&ccedil;&atilde;o')"
						 onclick="creatBlock('Nova opera&ccedil;&atilde;o ', 'rh/operacao_add.php', 'operacao_add', 'nomaximize, noresize');">
				</nobr>
		<?php
			break;
		}
		case 'dependencia':
		{
			if(!$db_connection)
			{
				include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectBanco= "	   SELECT pk_dependencia,
										  s_nome_tipo
									 FROM tb_dependencia
									ORDER BY s_nome_tipo";
			$dataBanco= pg_query($db_connection, $qr_selectBanco);
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="dependencia"
							style="width: 180px;
								   font-size:10px;
								   display: none;">
						<option value="">
							
						</option>
						<?php
						while($linhaBanco= @pg_fetch_array($dataBanco))
						{
							?>
								<option value="<?php echo $linhaBanco['pk_dependencia']; ?>">
									<?php echo htmlentities($linhaBanco['s_nome_tipo']); ?>
								</option>
							<?php
						}
						?>
					</select>
					<input type="text"
						   id="iptComponentDependencia<? echo $_GET['componentId']; ?>"
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
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Adicionar Novo grau de pend&ecirc;ncia')"
						 onclick="creatBlock('Novo Grau de Depend&ecirc;ncia ', 'rh/dependencia_grau_add.php', 'dependencia_add', 'nomaximize, noresize');">
				</nobr>
			<?
		
		break;
		}
		case 'departamento':
		{
			if(!$db_connection)
			{
				include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectBanco= "	   SELECT pk_departamento,
										  s_departamento
									 FROM tb_departamento
									ORDER BY s_departamento";
			$dataBanco= pg_query($db_connection, $qr_selectBanco);
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="departamento"
							style="width: 180px;
								   font-size:10px;
								   display: none;">
						<option value=""></option>
					<?php
					while($linhaBanco= @pg_fetch_array($dataBanco))
					{
						?>
							<option value="<?php echo $linhaBanco['pk_departamento']; ?>">
								<?php echo htmlentities($linhaBanco['s_departamento']); ?>
							</option>
						<?php
					}
					?>
					</select>
					<input type="text"
						   id="iptDepartamento<? echo $_GET['componentId']; ?>"
						   readonly
						   class="selectIpt"
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Adicionar Novo departamento')"
						 onclick="creatBlock('Novo departamento ', 'rh/departamento_add.php', 'departamento_add', 'nomaximize, noresize');">
				</nobr>
		<?php
		break;
		}
		case 'cargo':
		{
			if(!$db_connection)
			{
				include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectBanco= "	   SELECT pk_cargo,
										  s_cargo
									 FROM tb_cargo
									ORDER BY s_cargo";
			$dataBanco= pg_query($db_connection, $qr_selectBanco);
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="cargo"
							style="width: 180px;
								   font-size:10px;
								   display: none;">
						<option value=""></option>
					<?php
					while($linhaBanco= @pg_fetch_array($dataBanco))
					{
						?>
							<option value="<?php echo $linhaBanco['pk_cargo']; ?>">
								<?php echo htmlentities($linhaBanco['s_cargo']); ?>
							</option>
						<?php
					}
					?>
					</select>
					<input type="text"
						   id="iptCargo<? echo $_GET['componentId']; ?>"
						   readonly
						   class="selectIpt"
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Adicionar Novo cargo')"
						 onclick="creatBlock('Novo cargo ', 'rh/cargo_add.php', 'cargo_add', 'nomaximize, noresize');">
				</nobr>
		<?php
		break;
		}
		case 'beneficio':
		{
			if(!$db_connection)
			{
				include("../connections/flp_db_connection.php");
				$db_connection= @connectTo();
			}

			$qr_selectBanco= "	   SELECT pk_beneficio,
										  s_nome
									 FROM tb_beneficio
									ORDER BY s_nome";
			$dataBanco= pg_query($db_connection, $qr_selectBanco);
			?>
				<nobr>
					<input type="text"
						   id="iptBeneficio<? echo $_GET['componentId']; ?>"
						   readonly
						   class="selectIpt"
						   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
						   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
						   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							componentType="beneficio"
							style="width: 180px;
								   font-size:10px;
								   display: none;">
						<option value=""></option>
					<?php
					while($linhaBanco= @pg_fetch_array($dataBanco))
					{
						?>
							<option value="<?php echo $linhaBanco['pk_beneficio']; ?>">
								<?php echo htmlentities($linhaBanco['s_nome']); ?>
							</option>
						<?php
					}
					?>
					</select>
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Adicionar Benefício')"
						 onclick="creatBlock('Novo benef&iacute;cio ', 'rh/beneficio_add.php', 'beneficio_add', 'nomaximize, noresize');">
				</nobr>
		<?php
		break;
		}
		// STATUS DO PROCESSO 
		// JAYDSON GOMES
		//22-10-2007  _  01:00 AM
		case 'statusProcesso':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							style="width:120px; display:none;"
							label="status processo"
							componentType='statusProcesso'>
							<option value=""></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_status_processo,
												    s_nome as label
											   FROM tb_status_processo
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['pk_status_processo']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['pk_status_processo'] == $_GET['code'])
															echo " selected ";
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   value="<?php echo $_GET['valor']; ?>"
					   class="selectIpt"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
						
					<img src="img/add.gif"
						 onmouseover="showtip(this, event, 'Adicionar Novo Status de Processo')"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo Status de Processo', 'processo/status_processo_add.php', 'novo_status_processo_add', 'nomaximize,noresize',false,'200/140');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		// NOME INTERNO DO PROCESSO 
		// JAYDSON GOMES
		//22-10-2007  _  01:00 AM
		case 'processoNomeInterno':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="nome interno do processo"
							style="width:120px;display:none"
							componentType='processoNomeInterno'>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_processo_nome_interno,
													s_nome_interno as label
											   FROM tb_processo_nome_interno
											  ORDER BY s_nome_interno
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['pk_processo_nome_interno']); ?>">
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo nome Interno de Processo', 'processo_nome_interno_add.php', 'proc_nome_interno_add', 'noresize');">
				</nobr>
			<?php
			break;
		}
		
		// ESCRITORIO ASSOCIADO
		// JAYDSON GOMES
		//23-10-2007  _  01:00 AM
		
		### USAR COMO MODELO
		case 'escritorioAssociado':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="escritorio associado"
							style="width:120px;display:none"
							componentType='escritorioAssociado'>
							<option value=""></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_escritorio_associado,
													s_nome as label
											   FROM tb_escritorio_associado
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['pk_escritorio_associado']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['pk_escritorio_associado'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   style="width: 110px;"
					   value="<? echo htmlentities($_GET['valor']); ?>"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 onmouseover="showtip(this, event, 'Adicionar Novo Escrit&oacute;rio Associado')"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo Escrit&oacute;rio Associado', 'processo/escritorio_associado_add.php', 'novo_escritorio_associado_add', 'noresize');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		// INSTANCIA DO PROCESSO
		// JAYDSON GOMES
		//23-10-2007  _  01:00 AM
		case 'instanciaProcesso':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="instancia do processo"
							style="width:170px;display:none"
							componentType='instanciaProcesso'>
							<option value=""></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_instancia_processo as code,
													s_nome as label
											   FROM tb_instancia_processo
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   readonly
					   value="<?=$_GET['valor']?>"
					   class="selectIpt"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>')">
					   
					<img src="img/add.gif"
						 onmouseover="showtip(this, event, 'Adicionar Nova Inst&acirc;ncia do Processo')"
						 style="cursor: pointer;"
						 onclick="creatBlock('Nova Inst&acirc;ncia do Processo', 'processo/instancia_processo_add.php', 'nova_instancia_processo_add', 'nomaximize,noresize',false,'200/140');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		case 'posicaoProcessual':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							style="width:170px;display:none"
							componentType='posicaoProcessual'>
							<option value=""></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_posicao_processual as code,
													s_nome as label
											   FROM tb_posicao_processual
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   style="width: 110px;"
					   value="<?=$_GET['valor']?>"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 onmouseover="showtip(this, event, 'Adicionar Nova Inst&acirc;ncia do Processo')"
						 style="cursor: pointer;"
						 onclick="creatBlock('Nova Posi&ccedil;&atilde;o Processual', 'processo/posicao_processual_add.php', 'nova_posicao_processual_add', 'nomaximize,noresize');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		// TIPO DA AÇÃO
		// JAYDSON GOMES
		//27-10-2007  _  22:00 AM
		case 'tipoAcao':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="tipo da acao"
							style="width:120px;display:none"
							componentType='tipoAcao'>
							<option value=""></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_tipo_acao as code,
													s_nome as label
											   FROM tb_tipo_acao
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   style="width: 110px;"
					   value="<?=$_GET['valor']?>"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo Tipo de A&ccedil;&atilde;o', 'processo/tipo_acao_add.php', 'novo_tipo_de_acao_add', 'noresize');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		// NATUREZA DA AÇÃO
		// JAYDSON GOMES
		//28-10-2007  _  16:00 PM
		case 'naturezaAcao':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="natureza da acao"
							style="width:120px;display:none"
							componentType='naturezaAcao'>
							<option value=""></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_natureza_acao as code,
													s_nome as label
											   FROM tb_natureza_acao
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   style="width: 110px;"
					   value="<?=$_GET['valor']?>"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Nova Natureza da A&ccedil;&atilde;o', 'processo/natureza_acao_add.php', 'nova_natureza_da_acao_add', 'noresize',false,'200/140');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		case 'orgaoJudicial':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="orgao judicial"
							style="width:120px;display:none"
							componentType='orgaoJudicial'>
							<option value=""></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_orgao_judicial as code,
													s_nome as label
											   FROM tb_orgao_judicial
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   style="width: 110px;"
					   value="<?=$_GET['valor']?>"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo Org&atilde;o Judicial', 'processo/orgao_judicial_add.php', 'novo_orgao_judicial_add', 'noresize',false,'100/100');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		// RITO
		// JAYDSON GOMES
		//28-10-2007  _  16:00 PM
		case 'rito':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="label_rito"
							style="width:170px;display:none;"
							componentType='rito'>
							<option value=''></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_rito as code,
													s_nome as label
											   FROM tb_rito
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   value="<?=$_GET['valor']?>"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Novo Rito', 'processo/rito_add.php', 'novo_rito_add', 'noresize',false,'200/140');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		case 'pos_cliente':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="label_pos_cliente"
							style="width:170px;display:none;"
							componentType='pos_cliente'>
							<option value=''></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_pos_cliente as code,
													s_nome as label
											   FROM tb_pos_cliente
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   value="<?=$_GET['valor']?>"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Nova Posi&ccedil;&atilde;o Cliente', 'processo/pos_cliente_add.php', 'nova_pos_cliente_add', 'noresize',false,'100/100');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		case 'fase':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="label_fase"
							style="width:170px;display:none;"
							componentType='fase'>
							<option value=''></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_fase as code,
													s_nome as label
											   FROM tb_fase
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   value="<?=$_GET['valor']?>"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Nova Fase', 'processo/fase_add.php', 'nova_fase_add', 'noresize',false,'100/100');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		case 'prob_exito':
		{
			?>
				<nobr>
					<select name="<? echo $_GET['componentId']; ?>"
							id="<? echo $_GET['componentId']; ?>"
							required="true"
							label="label_prob_exito"
							style="width:300px;display:none;"
							componentType='prob_exito'>
							<option value=''></option>
							<?
								if(!$db_connection)
								{
									include("../connections/flp_db_connection.php");
									$db_connection= @connectTo();
								}
								$qr_select= "SELECT pk_probabilidade as code,
													s_nome as label
											   FROM tb_probabilidade_exito
											  ORDER BY s_nome
											";
								$data= @pg_query($db_connection, $qr_select);
								while($linhaComponent= pg_fetch_array($data))
								{
									?>
										<option value="<? echo htmlentities($linhaComponent['code']); ?>"
												<?php
													if(trim($_GET['code']) != '')
														if($linhaComponent['code'] == $_GET['code'])
														{
															echo " selected ";
															$_GET['valor']= $linhaComponent['label'];
														}
													if(trim($_GET['valor']) != '')
														if($linhaComponent['label'] == $_GET['valor'])
															echo " selected ";
												?>>
											<?
												echo htmlentities($linhaComponent['label']);
											?>
										</option>
									<?
								}
							?>
					</select> 
					<input type="text"
					   id="iptEstadoCivil<? echo $_GET['componentId']; ?>"
					   clickVal="<?
									if ($_GET['referencia'])
									{
										echo "if(gebi('".$_GET['componentId']."').value=='2' || gebi('".$_GET['componentId']."').value=='6') document.getElementById('".$_GET['referencia']."').style.display=''; else document.getElementById('".$_GET['referencia']."').style.display='none';";
									}
								?>"
					   readonly
					   class="selectIpt"
					   value="<?=$_GET['valor']?>"
					   style="width: 110px;"
					   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
					   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
					   onclick="showSelectOptions(this, '<? echo $_GET['componentId']; ?>', this.clickVal)">
					   
					<img src="img/add.gif"
						 style="cursor: pointer;"
						 onclick="creatBlock('Nova Probabilidade', 'processo/prob_exito_add.php', 'novo_prob_exito_add', 'noresize',false,'100/100');">
				</nobr>
			<?php
			$_GET['valor']= null;
			$_GET['code'] = null;
			break;
		}
		
		/*
			COMPONENTE DO EXPLORADOR (explorer)
		*/
		case 'explorer':
		{
			$id   = $_GET['componentId'];
			if(!$_GET['componentValue'])
			{
				$valor= 'Selecione...';
			}else{
					$valor= $_GET['componentValue'];
			     }
			
			$name = (trim($_GET['componentName']) == '')? $_GET['componentId']: $_GET['componentName'];
			$tipo = $_GET['componentTipo'];
			$codeValue= trim($_GET['codeValue']);
			//$add  = $_GET['componentShowAdd'];
			?>
				<span style="white-space: nowrap;">
					<input type="hidden"
						   name="<? echo $name; ?>"
						   id="<? echo $id; ?>_target"
						   value="<? echo $codeValue; ?>"
						   readonly>
					<input id="<? echo $id; ?>"
						   style="letter-spacing:1px;"
						   type="text"
						   value="<? echo $valor; ?>"
						   style="cursor: pointer;
								   background-image:url('../img/lupa.png');
								   background-repeat:no-repeat;
								   background-position:right"
						   onclick="hideSelects(); explore(this, '<?php echo $tipo; ?>')"
						   alt="Abre o Explorador para sele&ccedil;&atilde;o"
						   target="<? echo $id; ?>_target"
						   onmouseover="showtip(this, event, this.getAttribute('alt'))"
						   readonly> 
					<img src="img/clear.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Limpar')"
						 onclick="this.parentNode.getElementsByTagName('input')[0].value= '';
								  this.parentNode.getElementsByTagName('input')[1].value= '';">
					<?php
						if($tipo== 'contato')
						{
						$ATHENA_HELP = ' Clique no campo ao lado com a imagem de uma Lupa e selecione o contato desejeado.\n Para selecionar um contato clique na pasta com o nome de Listar, ela expandir&aacute; \n  e mostrar&aacute; todos os contatos. Clique em cima de um para selecionar e em seguida clique em OK.';
						?>
							<img src="img/add.gif"
								 style="cursor: pointer;"
								 onmouseover="showtip(this,event,'Cadastrar Novo Contato')"
								 onclick="creatBlock('Novo contato', 'agenda_contato_empresa.php', 'agenda_contato_empresa',false,false,'739/536');"
								 valign="middle">
						<?php
						}elseif($tipo== 'filial')
							{
							$ATHENA_HELP = ' Clique no campo ao lado com a imagem de uma Lupa e selecione a filial desejeada.\n Para selecionar uma fiflial clique na pasta com o nome de Listar, ela expandir&aacute; \n  e mostrar&aacute; todas as filiais. Clique em cima de uma para selecionar e em seguida clique em OK.';
								?>
									<img src="img/filial_add_component.gif"
										 style="cursor: pointer;"
										 onmouseover="showtip(this,event,'Cadastrar Nova Filial')"
										 onclick="creatBlock('Nova filial', 'agenda_contato_filial.php', 'agenda_contato_filial',false,false,'739/536');"
										 valign="middle">
								<?php
							}else{
									if($_GET['componentCliente'] == 'cliente')
									{
										$ATHENA_HELP = ' Clique no campo ao lado com a imagem de uma Lupa e selecione o Cliente desejeado.\n Para selecionar um cliente clique na pasta com o nome de Listar, ela expandir&aacute; \n  e mostrar&aacute; todos os clientes. Clique em cima de um para selecionar e em seguida clique em OK.';
										?>
											<img src="img/add.gif"
												 style="cursor: pointer;"
												 onmouseover="showtip(this,event,'Cadastrar Novo Cliente')"
												 onclick="creatBlock('Novo Cliente', 'cliente_add.php', 'novo_cliente',false,false,'739/536');"
												 valign="middle">
										<?php	
									}
								 }
							$_GET['componentCliente'] = null;
					?>
					<img src="img/help.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Ajuda')"
						 onclick="top.showHelp('<?php echo $ATHENA_HELP;?>')">
				</span>
			<?php
			break;
		}
		case 'explorerFunc':
		{
			$id   = $_GET['componentId'];
			$valor= $_GET['componentValue'];
			$name = (trim($_GET['componentName']) == '')? $_GET['componentId']: $_GET['componentName'];
			//$add  = $_GET['componentShowAdd'];
			?>
				<span style="white-space: nowrap;">
					<input type="hidden"
						   name="<? echo $name; ?>"
						   id="<? echo $id; ?>_target"
						   readonly>
					<input id="<? echo $id; ?>"
						   type="text"
						   value="<? echo $valor; ?>"
						   style="cursor: pointer;
								  background-image:url('../img/lupa.png');
								  background-repeat:no-repeat;
								  background-position:right"
						   onclick="hideSelects(); exploreFunc(this, 'cliente')"
						   alt="Abre o Explorador para sele&ccedil;&atilde;o"
						   target="<? echo $id; ?>_target"
						   onmouseover="showtip(this, event, this.getAttribute('alt'))"
						   readonly> 
					<img src="img/clear.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Limpar')"
						 onclick="this.parentNode.getElementsByTagName('input')[0].value= '';
								  this.parentNode.getElementsByTagName('input')[1].value= '';">
					<img src="img/help.gif"
						 style="cursor: pointer;
								display: none;"
						 onmouseover="showtip(this, event, 'Ajuda')"
						 onclick="top.showHelp('ajuda')">
				</span>
			<?php
			break;
		}
		
		// Explorador Clientes
		case 'explorador':
		{
			//	containerId (obrigatorio) = id de onde será posto a árvore
			//	dpl_click			 = 
			//	apenasClientes		= para exibir apenas clientes
			//	on_click			= para executar ao clicar
			
			$PREID= date('ymdhis').microtime();
			$PREID= str_replace('.', '', str_replace(' ', '', $PREID));
			$_GET['dpl_click']= (trim($_GET['dpl_click']) == '')? 'false': $_GET['dpl_click'];
			$_GET['on_click']= (trim($_GET['on_click']) == '')? 'false': $_GET['on_click'];
			?>
			<flp_script>
			var v<?php echo $PREID; ?>arv= new tree('<?php echo $_GET['containerId']; ?>'); 
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>explorerToolFisica', 'Pessoa F&iacute;sica', false, false, false, false, false); 
			<?php
				# it acepts
				# clienteRaiz
				#
				#
				#	addNode(id, label, parentElement, code, tipo, cliente, sexo)
				// fisica
				/*if(trim($_GET['dpl_click']) != '')
					$_GET['dpl_click']= ', '.$_GET['dpl_click'];
				if(trim($_GET['on_click']) != '')
					$_GET['on_click']= ', '.$_GET['on_click'];*/
					
				$qr_selectCliente= " SELECT U.pk_usuario,
											DP.s_usuario,
											U.bl_cliente,
											DP.bl_status,
											DP.c_sexo
									   FROM tb_usuario U
									   INNER JOIN
											tb_dados_pessoais DP
										ON (U.pk_usuario = DP.vfk_usuario)
									  WHERE bl_cliente = 1
									  AND DP.bl_status = 1
									  AND upper(U.bl_tipo_pessoa) = 'F'";
				if(trim($_GET['clienteRaiz']) != '' && $_GET['clienteRaiz'] != false)
					$qr_selectCliente.= " AND U.pk_usuario= ".$_GET['clienteRaiz'];
				$qr_selectCliente.= " ORDER BY s_usuario";
				$dataCli= pg_query($db_connection, $qr_selectCliente);
				
				while($linhaCli= @pg_fetch_array($dataCli))
				{
					echo ' v'.$PREID."arv.addNode('".$PREID.$linhaCli['pk_usuario'].'_cliente'."',
									  '".htmlentities($linhaCli['s_usuario'])."',
									  '".$PREID."explorerToolFisica',
									  '".$linhaCli['pk_usuario']."',
									  'cliente',
									  '".$linhaCli['pk_usuario']."',
									  '".$linhaCli['c_sexo']."',
									  ".$_GET['dpl_click'].",
									  false,
									  ".$_GET['on_click']."
									  ); ";
				}
				// juridica
				echo ' v'.$PREID."arv.addNode('".$PREID."explorerToolJuridica', 'Pessoa Jur&iacute;dica'); ";
				$qr_selectCliente= " SELECT U.pk_usuario,
											DP.s_usuario,
											U.bl_cliente,
											DP.bl_status,
											DP.c_sexo
									   FROM tb_usuario U
									   INNER JOIN
											tb_dados_pessoais DP
										ON (U.pk_usuario = DP.vfk_usuario)
									  WHERE bl_cliente = 1
									  AND DP.bl_status = 1
									  AND upper(U.bl_tipo_pessoa) = 'J'";
				if(trim($_GET['clienteRaiz']) != '' && $_GET['clienteRaiz'] != false)
					$qr_selectCliente.= " AND U.pk_usuario= ".$_GET['clienteRaiz'];
				$qr_selectCliente.= " ORDER BY s_usuario";
				$dataCli= pg_query($db_connection, $qr_selectCliente);
				while($linhaCli= @pg_fetch_array($dataCli))
				{
					echo ' v'.$PREID."arv.addNode('".$PREID.$linhaCli['pk_usuario'].'_cliente'."',
									  '".htmlentities($linhaCli['s_usuario'])."',
									  '".$PREID."explorerToolJuridica',
									  '".$linhaCli['pk_usuario']."',
									  'cliente',
									  '".$linhaCli['pk_usuario']."',
									  '".$linhaCli['c_sexo']."',
									  ".$_GET['dpl_click'].",
									  false,
									  '".$_GET['on_click']."'
									  ); ";
				}
			if(!$_GET['apenasClientes'])
			{
				// pastas
				$qr_select= "SELECT pk_pasta,
									fk_usuario,
									s_nome,
									vfk_pasta_pai
							   FROM tb_pasta p,
									tb_usuario u,
									tb_dados_pessoais dp
							  WHERE dp.vfk_usuario = u.pk_usuario
								AND p.fk_usuario = u.pk_usuario
								AND dp.bl_status > 0
							";
				$qr_select.=" ORDER BY pk_pasta
								";
				$data= @pg_query($db_connection, $qr_select);
				//echo " alert('".pg_num_rows($data)."'); ";
				$processos_linha =  Array();
				while($linhaComponent= @pg_fetch_array($data))
				{
					$processos_linha[] = $linhaComponent;
					//echo " alert('".$linhaComponent['pk_pasta']     .' - '.$linhaComponent['fk_usuario']   .' - '.htmlentities($linhaComponent['s_nome']).' - '. $linhaComponent['vfk_pasta_pai']."'); ";
					//echo " alert('".$PREID.$linhaComponent['pk_pasta']."_pasta: ".$PREID.((trim(htmlentities($linhaComponent['vfk_pasta_pai']))=='')? ($linhaComponent['fk_usuario'].'_cliente'): htmlentities($linhaComponent['vfk_pasta_pai']).'_pasta')."'); ";
					$str= ' v'.$PREID."arv.addNode('".$PREID.$linhaComponent['pk_pasta']."_pasta',
										'".
										htmlentities($linhaComponent['s_nome'])
										."',
										'".$PREID.((trim(htmlentities($linhaComponent['vfk_pasta_pai']))=='')? ($linhaComponent['fk_usuario'].'_cliente'): htmlentities($linhaComponent['vfk_pasta_pai']).'_pasta')."',
										'".$linhaComponent['pk_pasta']."',
										'pasta',
										'".$linhaComponent['fk_usuario']."',
										false,
									    ".$_GET['dpl_click'].",
									    false,
									    ".$_GET['on_click']."
										); ";
					echo $str;
				};
				$qr_select= "SELECT pk_processo,
									pk_pasta,
									pr.s_nome,
									ps.fk_usuario
							   FROM tb_processo_pasta prs,
									tb_pasta ps,
									tb_processo pr
							  WHERE prs.fk_processo = pr.pk_processo
								    AND prs.fk_pasta    = ps.pk_pasta
							  ORDER BY pr.s_nome
							";
				$dataProcesso= pg_query($db_connection, $qr_select);
				//echo " alert('".pg_num_rows($data)."'); ";
//		echo " /* ";
//				echo " alert('".pg_num_rows($data)."'); ";
				reset($processos_linha);
				
				echo ' v'.$PREID."arv.addNode('".$PREID."explorerToolProcessos', 'Processos'); ";
				while($linhaComponent= pg_fetch_array($dataProcesso))
				{
					//echo " alert('pk_processo: ".$linhaComponent['pk_processo']." \\n s_nome: ".$linhaComponent['s_nome']." \\n pk_pasta: ". $linhaComponent['pk_pasta'] ."'); ";
						echo ' v'.$PREID."arv.addNode('".$PREID.$linhaComponent['pk_processo']."_processo',
										  '".htmlentities($linhaComponent['s_nome'])."',
										  '".$PREID.$linhaComponent['pk_pasta']."_pasta',
										  '".$linhaComponent['pk_processo']."',
										  'processo',
										  '".$linhaComponent['fk_usuario']."',
										  false,
									      ".$_GET['dpl_click'].",
									      false,
									      ".$_GET['on_click']."
										  ); ";
						//echo " alert('pk_processo: ".$linhaComponent['pk_processo']." \\n s_nome: ".$linhaComponent['s_nome']." \\n pk_pasta: ". $linhaComponent['pk_pasta'] ."'); ";
						echo ' v'.$PREID."arv.addNode('".$PREID.$linhaComponent['pk_processo']."_processo',
										  '".htmlentities($linhaComponent['s_nome'])."',
										  '".$PREID."explorerToolProcessos',
										  '".$linhaComponent['pk_processo']."',
										  'processo',
										  '".$linhaComponent['fk_usuario']."',
										  false,
										  ".$_GET['dpl_click'].",
										  false,
										  ".$_GET['on_click']."
										  ); ";
									 
				}
			}
			?>
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisar', 'Pesquisar', false, false, 'busca', false, false, false, false, false); 
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisarInput', '<input type="text" style="width: 80%; height: 20px; font-size: 11px;" oldvalue="" onkeyup="this.setAttribute(\'oldvalue\', this.value); if(event.keyCode == 13){ searchProcessolist(this.value, document.getElementById(\'<?php echo $_GET['containerId']; ?>\'), \'<?php echo $PREID; ?>pesquisarInput\'); }">', '<?php echo $PREID; ?>pesquisar', false, false, false, false, false, false, false, true); 
			
			
			
			document.getElementById('<?php echo $_GET['containerId']; ?>').objList= v<?php echo $PREID; ?>arv;
			<?php
			break;
		}
		
		
		////////////
		
		case 'exploradorFunc':
		{
			$PREID= date('ymdhis').microtime();
			$PREID= str_replace('.', '', str_replace(' ', '', $PREID));
			?>
			<flp_script>
				var v<?php echo $PREID; ?>arv= new tree('<?php echo $_GET['containerId']; ?>');
				<?php
				$qr_select= "SELECT pk_grupo,
									s_label
							   FROM tb_grupo
							  WHERE fk_agencia = ".$_SESSION['pk_agencia']."
							  ORDER BY pk_grupo
							";
				$data= @pg_query($db_connection, $qr_select);
					
				while($linhaComponent= @pg_fetch_array($data))
				{
					echo ' v'.$PREID."arv.addNode('".$PREID.$linhaComponent['pk_grupo'].'_grupo'."',
												  '".htmlentities($linhaComponent['s_label'])."',
												  false,
												  false,
												  'grupo'
												  ); ";
					
					
					$qr_selectU= "SELECT DISTINCT ON(dp.s_usuario)
										 u.pk_usuario,
										 dp.s_usuario
								    FROM tb_usuario u,
									 	 tb_dados_pessoais dp,
										 tb_usuario_grupo ug
								   WHERE bl_cliente =0
								     AND ug.fk_usuario = u.pk_usuario
									 AND ug.fk_usuario = dp.vfk_usuario
									 AND ug.fk_grupo= ".$linhaComponent['pk_grupo']."
									";
					$dataU= @pg_query($db_connection, $qr_selectU);
					while($linhaU= @pg_fetch_array($dataU))
					{
						//echo " alert('".htmlentities($linhaU['s_usuario'])."'); ";
						echo ' v'.$PREID."arv.addNode('".$PREID.$linhaU['pk_usuario'].'_func'."',
													  '".htmlentities($linhaU['s_usuario'])."',
													  '".$PREID.$linhaComponent['pk_grupo'].'_grupo'."',
													  ".$linhaU['pk_usuario'].",
													  'cliente'
													  ); ";
					}
				}
			?>
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisar', 'Pesquisar', false, false, 'busca', false, false, false, false, false); 
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisarInput', '<input type="text" style="width: 80%; height: 20px; font-size: 11px;" oldvalue="" onkeyup="this.setAttribute(\'oldvalue\', this.value); if(event.keyCode == 13){ searchProcessolist(this.value, document.getElementById(\'<?php echo $_GET['containerId']; ?>\'), \'<?php echo $PREID; ?>pesquisarInput\'); }">', '<?php echo $PREID; ?>pesquisar', false, false, false, false, false, false, false, true); 
			
			
			
			document.getElementById('<?php echo $_GET['containerId']; ?>').objList= v<?php echo $PREID; ?>arv;
			<?php
			break;
		}
		case 'exploradorContatos':
		{
			$PREID= date('ymdhis').microtime();
			$PREID= str_replace('.', '', str_replace(' ', '', $PREID));
			$_GET['dpl_click']= (trim($_GET['dpl_click']) == '')? 'false': $_GET['dpl_click'];
			$_GET['on_click']= (trim($_GET['on_click']) == '')? 'false': $_GET['on_click'];
			?>
			<flp_script>
				var v<?php echo $PREID; ?>arv= new tree('<?php echo $_GET['containerId']; ?>');
				v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>todos_contatos', 'Listar', false, false, false, false, false, false, false, false); 
				<?php
				$qr_selectCliente= "   SELECT pk_dados_pessoais,
											  s_usuario,
											  c_sexo
										 FROM tb_dados_pessoais,
											  tb_pess_fisica f
										WHERE vfk_usuario isnull
										  AND f.fk_dados_pessoais = pk_dados_pessoais
										  AND bl_status = 1
										ORDER BY s_usuario";
				$dataCli= pg_query($db_connection, $qr_selectCliente);
				while($linhaCli= @pg_fetch_array($dataCli))
				{
					echo "v".$PREID."arv.addNode('".$PREID.$linhaCli['pk_dados_pessoais'].'_filial_contato'."',
									  '".htmlentities($linhaCli['s_usuario'])."',
									  '".$PREID."todos_contatos',
									  '".$linhaCli['pk_dados_pessoais']."',
									  'contato',
									  '".$linhaCli['pk_dados_pessoais']."',
									  '".$linhaCli['c_sexo']."',
									  ".$_GET['dpl_click'].",
									  false,
									  ".$_GET['on_click']."
									  );";
				}
			?>
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisar', 'Pesquisar', false, false, 'busca', false, false, false, false, false); 
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisarInput', '<input type="text" style="width: 80%; height: 20px; font-size: 11px;" oldvalue="" onkeyup="this.setAttribute(\'oldvalue\', this.value); if(event.keyCode == 13){ searchProcessolist(this.value, document.getElementById(\'<?php echo $_GET['containerId']; ?>\'), \'<?php echo $PREID; ?>pesquisarInput\'); }">', '<?php echo $PREID; ?>pesquisar', false, false, false, false, false, false, false, true); 
			
			
			
			document.getElementById('<?php echo $_GET['containerId']; ?>').objList= v<?php echo $PREID; ?>arv;
			<?php
			break;
		}
		case 'exploradorFilial':
		{
			$PREID= date('ymdhis').microtime();
			$PREID= str_replace('.', '', str_replace(' ', '', $PREID));
			$_GET['dpl_click']= (trim($_GET['dpl_click']) == '')? 'false': $_GET['dpl_click'];
			$_GET['on_click']= (trim($_GET['on_click']) == '')? 'false': $_GET['on_click'];
			?>
			<flp_script>
				var v<?php echo $PREID; ?>arv= new tree('<?php echo $_GET['containerId']; ?>');
				<?php
				$qr_selectCliente= "   SELECT pk_dados_pessoais,
											  s_usuario
										 FROM tb_dados_pessoais,
											  tb_pess_juridica j
										WHERE vfk_usuario isnull
										  AND j.fk_dados_pessoais = pk_dados_pessoais
										  AND bl_status = 1
										ORDER BY s_usuario";
				$dataCli= pg_query($db_connection, $qr_selectCliente);
				while($linhaCli= @pg_fetch_array($dataCli))
				{
					echo "v".$PREID."arv.addNode('".$PREID.$linhaCli['pk_dados_pessoais'].'_filial_contato'."',
									  '".htmlentities($linhaCli['s_usuario'])."',
									  false,
									  '".$linhaCli['pk_dados_pessoais']."',
									  'filial',
									  '".$PREID.$linhaCli['pk_dados_pessoais']."',
									  '".$linhaCli['c_sexo']."',
									  ".$_GET['dpl_click'].",
									  false,
									  ".$_GET['on_click']."
									  );";
				}
			?>
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisar', 'Pesquisar', false, false, 'busca', false, false, false, false, false); 
			v<?php echo $PREID; ?>arv.addNode('<?php echo $PREID; ?>pesquisarInput', '<input type="text" style="width: 80%; height: 20px; font-size: 11px;" oldvalue="" onkeyup="this.setAttribute(\'oldvalue\', this.value); if(event.keyCode == 13){ searchProcessolist(this.value, document.getElementById(\'<?php echo $_GET['containerId']; ?>\'), \'<?php echo $PREID; ?>pesquisarInput\'); }">', '<?php echo $PREID; ?>pesquisar', false, false, false, false, false, false, false, true); 
			
			
			
			document.getElementById('<?php echo $_GET['containerId']; ?>').objList= v<?php echo $PREID; ?>arv;
			<?php
			break;
		}
		default: "";
	}
?>