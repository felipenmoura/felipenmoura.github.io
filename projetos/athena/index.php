<?
	//echo "http://".$_SERVER['HTTP_HOST']."/".'/index.php';
	/*
		$acessoWeb precisa ser um destes :
		'Logar'
		'Alterar dados de cadastro pessoal';
		'Listar clientes';
		'Cadastrar clientes'
		'Alterar dados de clientes'
		'Excluir cliente'
		'Salvar personalizacoes'
		'Listar circulares';
		'Inserir circulares'
		'Visualizar dados de cadastro pessoal'
		'Alterar dados pessoais'
		'Listar funcionarios'
		'Gerenciar funcionarios'
		'Gerrenciar agenda'
		'Cadastrar novo cliente'
		'Editar dados de contato'
	*/
	if($_POST)
	{
		include('connections/flp_db_connection.php');
		$connection= connectTo();
		if(!$connection)
		{
			?>
				<script>
					alert('Falha ao tentar estabelecer uma conexão com o banco de dados');
				</script>
			<?
			exit;
		}
		//mkdir('main_logged/logados');
		/*
			selecionou os dados do usuário validando a SENHA
		*/
		$qr_select= "SELECT u.pk_usuario,
							u.s_login,
							u.s_senha,
							dp.s_usuario,
							u.bl_cliente,
							dp.bl_status,
							bl_senha
					   FROM tb_usuario u,
						    tb_dados_pessoais dp
					  WHERE s_senha= '".$_POST['senha']."'
					    AND s_login= '".$_POST['login']."'
						AND dp.bl_status = 1
						AND u.bl_cliente = 0
						AND dp.vfk_usuario = u.pk_usuario
					";
		$data= pg_query($connection, $qr_select);
		
		$dados= @pg_fetch_array($data);
		clearstatcache();
		session_save_path('main_logged/logados');
		session_name('athenas');
		if(@pg_num_rows($data) != 1)
		{
			?>
				<script>
					alert('Usuário ou senha inválido !');
					top.document.getElementById('btLogar').value= 'Logar';
				</script>
			<?php
			exit;
		}else{
				$dir= opendir(session_save_path());
				while(false !== ($ds_filename = readdir($dir)))
				{
					if($ds_filename != '.' && $ds_filename!= '..')
					{
						//$time= date ("His.", fileatime(session_save_path().'/'.$ds_filename));
						$t= file_get_contents(session_save_path()."/".$ds_filename, 'r+');
						$t= explode(';', $t);
						$ar_temp= Array();
						$ar_dados= Array();
						for($i=0; $i<count($t); $i++)
						{
							$ar_temp= explode('|', $t[$i]);
							$ar_dados[str_replace('}', '', $ar_temp[0])]= str_replace('"', '', substr($ar_temp[1], strpos($ar_temp[1], '"')+1, strrpos($ar_temp[1], '"')), $ar_temp[1]);
						}
						$ar_dados['lastAccess']= str_replace(':', '', $ar_dados['lastAccess']);
						$time= date('YmdHis')-$ar_dados['lastAccess'];
						$tmp_logado= $ar_dados['pk_usuario'];
						/*echo "<script>";
						echo " 	alert('".$time." -> ".$ar_dados['lastAccess']."'); ";// --- ".$ar_dados['lastAccess']."'); ";
						echo " 	top.document.getElementById('btLogar').value= 'Logar'; ";
						echo "</script>";*/
						if($dados['pk_usuario'] == $tmp_logado)
						{
							if($time < 300)
							{
								if($time > 15)
									$msg= "Este usuário já está logado no sistema\\nCaso estivesse logado, e tenha enfrentado problemas com sua conexão\\naguarde alguns minutos para que o sistema recupere este erro, e tente logar novamente\\nse passados 6 minutos e o problema persistir, entre em contato\\n com algum administrador do sistema";
								else
									$msg= "Este usuário já está logado no sistema\\nEntre em contato com o administrador";
								echo "<script>";
								echo " 	alert('".$msg."'); ";// --- ".$ar_dados['lastAccess']."'); ";
								echo " 	top.document.getElementById('btLogar').value= 'Logar'; ";
								echo "</script>";
								exit;
							}else{
									$timeToInsert= substr($ar_dados['lastAccess'], 0,2).':'.substr($ar_dados['lastAccess'], 2,2).':'.substr($ar_dados['lastAccess'], 4,2);
									$obs= 'Falha na conexão';
									$qr_insert= "INSERT INTO tb_logs
													(
														fk_usuario,
														s_obs,
														s_ip,
														bl_movimento,
														dt_login,
														tmp_hora
													)
												 VALUES
													(
														".$ar_dados['pk_usuario'].",
														'".$obs."',
														'".$_SERVER[REMOTE_ADDR]."',
														'out',
														TO_DATE('".date('d/m/Y')."', 'DD/MM/YYYY'),
														to_timestamp('".$timeToInsert."', 'FF:MI:SS')
													)";
									$dataINS= @pg_query($connection, $qr_insert);
									@unlink(session_save_path().'/'.$ds_filename);
									@session_destroy();
									@session_unset();
								 }
						}
					}
				}
				clearstatcache();
				session_save_path('main_logged/logados');
				session_name('athenas');
				session_start();
				session_cache_expire(1);
				$_SESSION['lastAccess']= date('YmdHis');
				$_SESSION['pk_usuario']	= $dados['pk_usuario'];
				$_SESSION['s_usuario']	= $dados['s_usuario'];
				$_SESSION['s_login']	= $dados['s_login'];
				$_SESSION['fk_grupo']	= $dados['fk_grupo'];
				$_SESSION['bl_cliente']	= $dados['bl_cliente'];
				$_SESSION['time']		= date('h:i:s');
				$_SESSION['bl_senha']	= $dados['bl_senha'];
				setcookie('pk_usuario', $dados['pk_usuario']);
				setcookie('s_usuario', $dados['s_usuario']);
				$qr_select= "SELECT g.pk_grupo,
									g.s_label,
									g.fk_agencia
							   FROM tb_grupo g,
									tb_usuario_grupo ug,
									tb_usuario u
							  WHERE u.pk_usuario = ug.fk_usuario
								AND g.pk_grupo = ug.fk_grupo
								AND u.pk_usuario = ".$dados['pk_usuario']."
							";
				$data_grupo= @pg_query($connection, $qr_select);
				$ar_webAccess= Array();
				$cweb= 0;
				$_SESSION['grupos']= Array();
				while ($ar_linha_grupo = pg_fetch_array($data_grupo))	//	para cada grupo
				{
					if(trim($_SESSION['pk_agencia'])=='')
					{
						$_SESSION['pk_agencia']= $ar_linha_grupo['fk_agencia'];
					}elseif($_SESSION['pk_agencia'] != $ar_linha_grupo['fk_agencia'])
						{
							exit;
						}
					array_push($_SESSION['grupos'], $ar_linha_grupo['pk_grupo']);
					$qr_select_permissao= "  SELECT p.pk_permissao,
													p.s_titulo
											   FROM tb_permissao p,
													tb_grupo g,
													tb_grupo_permissao gp
											  WHERE gp.fk_grupo = g.pk_grupo
												AND gp.fk_permissao = p.pk_permissao
												AND g.pk_grupo = ". $ar_linha_grupo['pk_grupo'];
					$data_permissao= pg_query($connection, $qr_select_permissao);
					while ($ar_linhapermissao = pg_fetch_array($data_permissao))
					{
						$ar_webAccess[$cweb]= $ar_linhapermissao['pk_permissao'];
						$cweb++;
					}
				}
				$_SESSION['acesso_web']= $ar_webAccess;
				
				if(!$data || trim($_SESSION['pk_usuario'])=="")
				{
					?>
						<script>
							alert('Erro ao tentar o login !');
							top.document.getElementById('btLogar').value= 'Logar';
						</script>
					<?
					exit;
				}else{
						?>
								<script>
									//alert("<?php echo count($_SESSION['grupos']); ?>")
								</script>
								<script>
									l= 0//((screen.width/2)-((screen.width-10)/2));
									t= 0;//((screen.height/2)-((screen.height - 40)/2));
									w= screen.width -15;
									h= screen.height - 60;
									if(top.document.getElementById('saveCoockie').checked == true)
									{
										top.gravaCookie('athenasLogin', top.document.getElementById('login').value+'|"+"|'+top.document.getElementById('senha').value, new Date(new Date().getTime() + (12*30*24*60*1000)));
									}
									top.window_open= window.open('main_logged/index.php', 'window_open', 'width='+w+',height='+h+',left='+l+',top='+t+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
									texto = "<table width='100%' style='margin-top: 50px'><tr><td>";
									texto+= '<center>Logado como <b>'+top.document.getElementById('login').value+'</b><br><span class="botao" style="padding-top: 3px; font-size: 13px;"><input type="button" value="Deslogar" class="subBotao"';
									texto+= " onclick='if(confirm(\"Tem certeza que deseja fazer Logoff?\")){self.location.href= \"main_logged/logoff.php\"; try{window_open.close();}catch(error){}}'></span></center>";
									texto+= "</td></tr></table>";
									top.document.getElementById('div_login').innerHTML= texto;
									//top.logIn();
								</script>
								<?
								$obs= '';
								$qr_insert= "INSERT INTO tb_logs
												(
													fk_usuario,
													s_obs,
													s_ip
												)
											 VALUES
												(
													".$_SESSION['pk_usuario'].",
													'".$obs."',
													'".$_SERVER[REMOTE_ADDR]."'
												)";
								$data= @pg_query($connection, $qr_insert);
								exit;
							 //}
					 }
			}
		exit;
	}else{
			if(trim($_COOKIE['pk_usuario']) != '' && trim($_COOKIE['pk_usuario']) != false)
			{
				session_save_path('main_logged/logados');
				session_name('athenas');
				session_start();
				if(!$_SESSION['pk_usuario'])
				{
					setcookie('pk_usuario', '');
					setcookie('pk_usuario', false);
					unset($_COOKIE['pk_usuario']);
					session_destroy();
					session_unset();
				}
			}
		 }
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<meta name="Author" content="Felipe Nascimento de Moura">
		<meta name="Keywords" content="">
		<meta name="Description" content="">
		<meta http-equiv="imagetoolbar" content="no">

		<link rel="shortcut icon" href=""/>

		<link href="styles/estilos.css" type="text/css" rel="stylesheet">

		<title>
			Athena
		</title>

		<script src="scripts/coockies.js"></script>
		<script>
			var browser= (navigator.appName == "Microsoft Internet Explorer")? 'ie' : 'ff';

			function setOpacity(obj, opacityLevel)
			{
				if (browser == "ie")
				{
					document.getElementById(obj).style.filter="alpha(opacity="+opacityLevel+")";
				}else{
						var opacidade = parseFloat(opacityLevel/100);
						if (opacityLevel == 1)
						{
							opacidade = 1.0;
						}
						document.getElementById(obj).style.MozOpacity= opacidade;
					 }
			}
		</script>
		<script>
			function loginVerify(bt)
			{
				if(bt.value== 'Carregando...')
					return false;
				bt.value= 'Carregando...';
				vLogin= document.getElementById('login').value.replace(/ /g, '');
				vSenha= document.getElementById('senha').value.replace(/ /g, '');
				if(vLogin.length <3 || vSenha.length <3)
				{
					alert('Os campos senha e login devem ter ao menos 3 caracteres');
					return false;
				}else{
						document.getElementById('form_login').submit();
					 }
			}
			
			/* function logIn()
			{
				l= 0//((screen.width/2)-((screen.width-10)/2));
				t= 0;//((screen.height/2)-((screen.height - 40)/2));
				w= screen.width -15;
				h= screen.height - 60;
				if(document.getElementById('saveCoockie').checked == true)
				{
					gravaCookie('athenasLogin', document.getElementById('login').value+'|"+"|'+document.getElementById('senha').value, new Date(new Date().getTime() + (12*30*24*60*1000)));
				}
				window_open= window.open('main_logged/index.php', 'window_open', 'width='+w+',height='+h+',left='+l+',top='+t+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
				texto = "<table width='100%' style='margin-top: 50px'><tr><td>";
				texto+= '<center>Logado como <b>'+document.getElementById('login').value+'</b><br><span class="botao" style="padding-top: 3px; font-size: 13px;"><input type="button" value="Deslogar" class="subBotao"';
				texto+= " onclick='if(confirm(\"Tem certeza que deseja fazer Logoff?\")){self.location.href= \"main_logged/logoff.php\"; try{window_open.close();}catch(error){}}'></span></center>";
				texto+= "</td></tr></table>";
				document.getElementById('div_login').innerHTML= texto;
			} */
		</script>
		<script>
			function PNGTransparent()
			{
				var arVersion = navigator.appVersion.split("MSIE");
				var version = parseFloat(arVersion[1]);
				if ((version >= 5.5)) {
					if (!document.getElementsByTagName) return;
					var imgs = document.getElementsByTagName('img');
					for(var i=0; i < imgs.length; i++)
					{
					   var img = imgs[i];
					   var imgName = img.src.toUpperCase();
					   if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
					   {
							 var imgID = (img.id) ? "id='" + img.id + "' " : "";
							 var imgClass = (img.className) ? "class='" + img.className + "' " : "";
							 var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' ";
							 var imgStyle = "display:inline-block;" + img.style.cssText;
							 if (img.align == "left") imgStyle = "float:left;" + imgStyle;
							 if (img.align == "right") imgStyle = "float:right;" + imgStyle;
							 if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle;
							 var strNewHTML = "<span " + imgID + imgClass + imgTitle
							 + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
							 + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
							 + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
							 img.outerHTML = strNewHTML;
							 i = i-1;
					  }
				   }
				}
			}
		</script>
	</head>
	<body topmargin="0"
		  leftmargin="0"
		  onselectstart="return false"
		  oncontextmenu="return false"
		  bgcolor="#ffffff"
		  onload="PNGTransparent()">
		<img src="main_logged/img/loader.gif"
			 style="margin-left: 40px;
					display: none;">
		<img src="img/back_2.jpg"
			 style="position: absolute;
					left: 0px;
					top: 0px;
					width: 100%;
					height: 100%;
					z-index: 0;">
		<img src="img/athena.png"
			 style="position: absolute;
					left: 0px;
					top: 20px;"
					>
		<table width='100%'
			   height='100%'
			   style="position: absolute;
					  left: 0px;
					  top: 0px;"
			   align="center">
			<tr>
				<td style="text-align: center">
					<!--<img src="img/login_image.gif">
					<br>-->
					<form action="index.php"
						  method="POST"
						  name="form_login"
						  id="form_login"
						  target="hidden_frame_login"
						  style="padding: 0px;
								 margin: 0px;">
						<table id="tableLogin" align="center">
							<tr>
								<td>
									<img src="img/top_left_load.gif"><br>
								</td>
								<td style="background-color: #ffffff;
										   height: 4px;">
								</td>
								<td>
									<img src="img/top_right_load.gif"><br>
								</td>
							</tr>
							<tr style="background-color: #ffffff;">
								<td style="background-color: #ffffff;
										   height: 4px;">
									<br>
								</td>
								<td>
									<table width="100%"
										   cellpadding="0"
										   cellspacing="0">
										<tr>
											<td>	
												<span style="font-size: 15px;
															 font-weight: bold;
															 padding-left: 7px;
															 cursor: default;">
													Athena - Efetuar o Login
												</span>
											</td>
											<td style="text-align: right;">
												<img src="img/down.gif"
													 id="btDownMenu"
													 onmouseover="if(document.getElementById('downMenu').style.display == 'none')
																	this.src='img/down_over.gif'"
													 onmouseout="if(document.getElementById('downMenu').style.display == 'none')
																	this.src='img/down.gif'"
													 onclick="downOptions(event, this);"><br>
											</td>
										</tr>
									</table>
										<div style="background-image: url(img/back.jpg);
													background-position: center;
													width: 440px;
													height: 135px;
													padding-top: 0px;--190
													padding-left: 0px;--260
													border: outset 0px;
													padding: bottom: 0px;
													vertical-align: top;"
											 id="div_login">
											<table align="right"
												   cellpadding="2"
											       cellspacing="0"
											       valign="top"
												   id="downMenu"
												   style="background-color: #ffffff;
														  border-right: solid 2px #000000;
														  border-top: solid 1px #aaaaaa;
														  border-left: solid 1px #aaaaaa;
														  border-bottom: solid 2px #000000;
														  display: none;">
												<tr onmouseover="this.style.backgroundColor= '#dedeee';"
													onmouseout="this.style.backgroundColor= '';"
													style="cursor: pointer;">
													<td>
														&nbsp;Problemas para logar&nbsp;
													</td>
												</tr>
												<tr onmouseover="this.style.backgroundColor= '#dedeee';"
													onmouseout="this.style.backgroundColor= '';"
													style="cursor: pointer;">
													<td>
														&nbsp;Esqueci minha senha&nbsp;
													</td>
												</tr>
												<tr onmouseover="this.style.backgroundColor= '#dedeee';"
													onmouseout="this.style.backgroundColor= '';"
													style="cursor: pointer;">
													<td>
														&nbsp;Dicas de performance&nbsp;
													</td>
												</tr>
												<tr onmouseover="this.style.backgroundColor= '#dedeee';"
													onmouseout="this.style.backgroundColor= '';"
													style="cursor: pointer;"
													onmousedown="window.open('');">
													<td>
														&nbsp;Dicas de seguran&ccedil;a&nbsp;
													</td>
												</tr>
												<tr onmouseover="this.style.backgroundColor= '#dedeee';"
													onmouseout="this.style.backgroundColor= '';"
													style="cursor: pointer;"
													onmousedown="window.open('home/index.php');">
													<td>
														&nbsp;FAQ&nbsp;
													</td>
												</tr>
												<tr onmouseover="this.style.backgroundColor= '#dedeee';"
													onmouseout="this.style.backgroundColor= '';"
													style="cursor: pointer;"
													onmousedown="window.open('http://www.f2jweb.com');">
													<td>
														&nbsp;F2J web&nbsp;
													</td>
												</tr>
											</table>
											<br>
											<?php
												//echo $_SESSION['pk_usuario'].'<br>';
												if(!$_SESSION['pk_usuario'])
												{
											?>
											<table align="left"
												   style="margin-left: 15px;">
												<tr>
													<td style="text-align: left;
															   font-size: 15px;
															   font-weight: bold;
															   color: black;
															   cursor: default;">
														Login<br>
														<input type="text"
															   name="login"
															   style="width: 150px;
																	  height: 22px;
																	  font-style: italic;
																	  border: none;
																	  cursor: default;"
															   id="login"
															   value=""
															   onkeydown="if(event.keyCode==13) loginVerify(document.getElementById('btLogar'));">
													</td>
												</tr>
												<tr>
													<td style="text-align: left;
															   font-size: 15px;
															   font-weight: bold;
															   color: black;
															   cursor: default;">
														Senha<br>
														<input type="password"
															   name="senha"
															   style="width: 150px;
																	  height: 22px;
																	  border: none;
																	  background-color: #ffffff;
																	  cursor: default;"
															   id="senha"
															   onkeypress="if(event.keyCode==13) loginVerify(document.getElementById('btLogar'));">
													</td>
												</tr>
												<tr>
													<td style="text-align: center;">
														<span class="botao"
															  style="padding-top: 3px;
																	 font-size: 13px;">
															<input type="button"
																   id="btLogar"
																   onclick="loginVerify(this);"
																   value="Logar"
																   class="subBotao">
														</span>
													</td>
												</tr>
											</table>
											<?php
												}else{
														?>
														
														<!--
														Logado como <br>
														<b>
															<?php
																echo $_SESSION['s_login'];
															?>
														</b>
														<br>
														<span class="botao"
															  style="padding-top: 6px;
																	 font-size: 13px;
																	 text-align: center;"
															  onclick="if(confirm('Tem certeza que deseja fazer Logoff?'))
																	   {
																			self.location.href= 'main_logged/logoff.php';
																			try{window_open.close();}catch(error){}
																	   }">
															Deslogar
														</span>
														-->
														<?php
															$texto = "<table width='100%' style='margin-top: 50px'><tr><td>";
															$texto.= '<center>Logado como <b>'.$_SESSION['s_login'].'</b><br><span class="botao" style="padding-top: 3px; font-size: 13px;"><input type="button" value="Deslogar" class="subBotao"';
															$texto.= " onclick='if(confirm(\"Tem certeza que deseja fazer Logoff?\\n(A janela não será fechada)\")){self.location.href= \"main_logged/logoff.php\"; try{window_open.close();}catch(error){}}'></span></center>";
															$texto.= "</td></tr></table>";
															echo $texto;
													 }
											?>
										</form>
									</div>
								</td>
									<td style="background-color: #ffffff;
										   height: 4px;">
									<br>
								</td>
							<tr>
								<td>
									<img src="img/bottom_left_load.gif"><br>
								</td>
								<td style="background-color: #ffffff;
										   height: 4px;">
								</td>
								<td>
									<img src="img/bottom_right_load.gif"><br>
								</td>
							</tr>
						</table>
					<center>
						<span style="font-size: 13px; font-weight: bold; cursor: default;">
						<input type="checkbox"
							   name="saveCoockie"
							   id="saveCoockie"> Lembrar-me || 
						<span style="cursor: pointer;"
							  onclick="apagaCookie('athenasLogin'); document.getElementById('form_login').reset(); document.getElementById('saveCoockie').checked= false;"
							  onmouseover="this.style.textDecoration= 'underline';"
							  onmouseout="this.style.textDecoration= 'none';">
							Esquecer-me
						</span>
					</center>
					<iframe name="hidden_frame_login"
							id="hidden_frame_login"
							style="display: none;
								   width: 600px;
								   height: 500px;"
							frameborder="1">
					</iframe>
				</td>
			</tr>
		</table>
		<div style="position: absolute;
					right: 40px;
					bottom: 35px;
					font-size: 15px;
					text-align: right;">
			<a href="http://www.f2jweb.com"
			   style="color: #ffffff;
					  text-decoration: none;"
			   onmouseover="this.style.color= '#000000';"
			   onmouseout="this.style.color= '#ffffff';">
				Desenvolvido por F2J web&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
				Sites e aplica&ccedil;&otilde;es web
			</a>
		</div>
		
	</body>
	<script>
		function downOptions(evt, obj)
		{
			menu= document.getElementById('downMenu')
			if(menu.style.display == 'none')
			{
				if(obj)
				{
					document.getElementById('btDownMenu').src="img/down_clicked.gif";
					//menu.parentNode.appendChild(menu);
					menu.style.display= '';
				}
			}else{
					document.getElementById('btDownMenu').src="img/down.gif";
					menu.style.display= 'none';
				 }
		}
		try
		{
			document.attachEvent('onmousedown', downOptions);
		}catch(error)
		{
			window.addEventListener('mousedown', downOptions, true);
		}
	</script>
	<script>
	
		setOpacity('login', 75);
		setOpacity('senha', 75);
		setOpacity('tableLogin', 75);
	
		logInSavedValue= leCookie('athenasLogin');
		if(logInSavedValue != '' && logInSavedValue!= false && logInSavedValue!= null && document.getElementById('login'))
		{
			logInSavedValue= logInSavedValue.split('|"+"|');
			document.getElementById('login').value= logInSavedValue[0];
			if(logInSavedValue.length >1)
				document.getElementById('senha').value= logInSavedValue[1];
			document.getElementById('saveCoockie').checked= true;
			setTimeout("document.getElementById('btLogar').focus();", 150);
		}
	</script>
</html>