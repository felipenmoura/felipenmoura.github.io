<?
	//session_start();
	require_once("inc/valida_sessao.php");
	
	function permissionVerifyMenu($acessoWebMenu)
	{
		$return= false;
		for($i=0; $i<count($_SESSION['acesso_web']); $i++)
		{
			if($_SESSION['acesso_web'][$i] == $acessoWebMenu)
			{
				$return= true;
			}
		}
		return $return;
	}
?>
<html>
	<head>
		<title>
			.:: Athena Novo 1.0 - <? echo strtoupper($_SESSION['s_usuario']); ?> ::.
		</title>
		
		<link href="styles/estilos.css" rel="stylesheet" type="text/css">
		<script src="inc/f2j_elo.php"></script>
		<script src="scripts/tooltip.js"></script>
		<script src="scripts/rht_bt.js"></script>
		<script src="scripts/lib.js"></script>
		<script>
			function mousedownVerify()
			{
				return;
				if(filho.vLocker)
					if(filho.vLocker.style.display != 'none')
					{
						alert('Tarefa bloqueada\nAguardando o retorno de alguma outra tarefa do sistema');
						event.returnValue=false;
						
						event.cancelBubble= true;
						
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						
						event.button= 9;
						
						return false;
					}
			}
		</script>
		<script>
			document.attachEvent("onmousedown", mousedownVerify);
			document.attachEvent("onclick", mousedownVerify);
			document.attachEvent("onmouseup", mousedownVerify);
		</script>
		<script>
			var rhtBtSubMenu= null;
			var settedMenu= null;
			
			var image_back_menu				= new Image();
				image_back_menu.src			= 'img/back_menu.gif';
			var image_back_menu_over		= new Image();
				image_back_menu_over.src	= 'img/back_menu_over.gif';
			var image_back_menu_top			= new Image();
				image_back_menu_top.src		= 'img/back_menu_top.gif';
			var image_back_menu_top_ovr		= new Image();
				image_back_menu_top_ovr.src = 'img/back_menu_top_over.gif';
			var rhtBtSubMenu= null;
			var settedMenu= null;
			
			onerror= handleErr;
			
			function handleErr(msg,url,l)
			{
				alert('Ocorreu um erro durante a execução de algum script inernamente no Sistema Web, tente efetuar logoff e logar-se novamente, caso o problema persista, entre em contato com o suporte.\n-----------------\nDescricao técnica do erro: '+ msg+'\narquivo: '+url+'\nlinha: '+l);
				return false;
			}
			
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
			
			function getChilds(obj)
			{
				try
				{
					childs= obj.getAttribute('child_element');
				}catch(error)
				{
				}
				if(!childs)
					return false;
				if(typeof childs != 'string')
					return false;
				childs= childs.replace(/ /g, '');
				childs= childs.split(',');
				for(i=0; i<childs.length; i++)
				{
					childs[i]= top.document.getElementById(childs[i]);
				}
				return childs;
			}

			function changeMenu(obj, evento)
			{
				if(settedMenu != null)
				{
					menuUnset(settedMenu);
					setMenu(obj);
					return false;
				}
				if(obj.className != 'menuTopAbaDown')
				{
					if(evento == 'over')
					{
						obj.className='menuTopAbaOver';
					}else{
							obj.className='menuTopAba';
						 }
				}
			}

			
			function hiddeSelectLists(obj)
			{
				if(!obj)
					objSelectLists= c.document.getElementsByTagName('select');
				else
					objSelectLists= obj.getElementsByTagName('select');
				for(i=0; i< objSelectLists.length; i++)
				{
					objSelectLists[i].style.visibility= 'hidden';
				}
			}
			
			function setMenu(obj)
			{
				if(settedMenu != null)
				{
					menuUnset();
					return false
				}
				obj.className='menuTopAbaDown';
				ar_menu_childs= getChilds(obj);
				for(i=0; i<ar_menu_childs.length; i++)
				{
					ar_menu_childs[i].style.display= '';
					ar_menu_childs[i].style.left= obj.offsetLeft;
					objSelectLists= c.document.getElementsByTagName('select');
					for(i=0; i< objSelectLists.length; i++)
					{
						objSelectLists[i].style.visibility= 'hidden';
					}
				}
				settedMenu= obj;
				if(rhtBtSubMenu != null)
				{
					rhtBtSubMenu.style.display= 'none';
					rhtBtSubMenu= null;
				}
			}
			
			function menuUnset(obj)
			{
				if(!obj)
				{
					if(settedMenu != null)
						obj= settedMenu;
					else
						return false;
				}
				if(typeof obj != 'object')
					return false;
				obj.className='menuTopAba';
				ar_menu_childs= getChilds(obj);
				for(i=0; i<ar_menu_childs.length; i++)
				{
					ar_menu_childs[i].style.display= 'none';
				}
				settedMenu= null;
				if(rhtBtSubMenu != null)
				{
					rhtBtSubMenu.style.display= 'none';
					rhtBtSubMenu= null;
				}
				objSelectLists= obj.getElementsByTagName('select');
				for(i=0; i< objSelectLists.length; i++)
				{
					objSelectLists[i].style.visibility= 'visible';
				}
				//c.focus();
			}
			window.onblur= menuUnset;
			document.onblur= menuUnset;
			
			function centerObject(obj)
			{
				if(typeof obj == 'string')
					obj= document.getElementById(obj);
				try
				{
					obj.style.left= (document.body.clientWidth/2)-(obj.offsetWidth/2);
					obj.style.top= (document.body.clientHeight/2)-(obj.offsetHeight/2);
				}catch(error)
				{}
			}
			
			function setLoad(valor, legend)
			{
				if(valor == true || valor == 'true')
				{
					hiddeSelectLists();
					document.getElementById('loader').style.display= '';
					if(legend)
						document.getElementById('loaderLegend').innerHTML= legend;
					else
						document.getElementById('loaderLegend').innerHTML= 'Carregando dados ...';
				}else{
						if(c.stayLoading || c.loading)
						{
							document.getElementById('loader').style.display= '';
							setTimeout("setLoad(false)", 500);
							return false;
						}
						document.getElementById('loader').style.display= 'none';
					 }
				centerObject('loader');
			}
			
			function checkKey(event)
			{
				try
				{
					if(top.filho.document.getElementById('locker').style.display != 'none')
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}catch(error){}
				//alert(event.keyCode);
				if(document.getElementById('divLock').style.display == '')
					return false;
				kCode= event.keyCode;
				if(kCode==27)	// ESC
				{
					return false;
					try
					{
						c.document.body.removeChild(c.blockInFocus);
						blockInFocus= null;
					}catch(error)
					{}
				}
				if (kCode==116)	//	F5
				{
					/*event.keyCode= 0;
					event.cancelBubble= true;
					event.returnValue = false;
					return false;*/
					
					if(blockInFocus!= null)
						top.filho.blockInFocus.reload();
					event.keyCode= 0;
					event.cancelBubble= true;
					event.returnValue = false;
					return false;
				}
				if (kCode==36)	//	HOME
				{
					if(event.altKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if (kCode==35)	//	END
				{
					if(event.altKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if (kCode==91 || kCode==92) // windows
				{
					event.keyCode= 0;
					event.cancelBubble= true;
					event.returnValue = false;
					return false;
				}
				if (kCode==122)	//	F11
				{
					event.keyCode= 0;
					event.cancelBubble= true;
					event.returnValue = false;
					return false;
				}
				if (kCode==114)	//	F3
				{
					event.keyCode= 0;
					event.cancelBubble= true;
					event.returnValue = false;
					return false;
				}
				if (kCode==76)	//	ctrl-L
				{
					if (event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue= false;
						return false;
					}
				}
				/* if (kCode == 82)	// ctrl-R
				{
					if (event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				} */
				if (kCode == 65)	// ctrl-A
				{
					if (event.ctrlKey)
					{
						top.showShortcutList();
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if (kCode == 69)	// ctrl-E
				{
					if (event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if (kCode == 79)	// ctrl-O
				{
					if (event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if (kCode == 78)	// ctrl-N
				{
					if (event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				/*if (kCode == 66)	// ctrl-B
				{
					if (event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}*/
				if (kCode == 82)	// ctrl-R
				{
					if (event.ctrlKey)
					{
						if(blockInFocus!= null)
							top.filho.blockInFocus.reload();
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if (kCode == 72)	// ctrl-H
				{
					if (event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if(kCode==9)	// ctrl-TAB
				{
					hiddeSelectLists();
					if (event.ctrlKey)
					{
						if(event.shiftKey)
						{
							ctrlTab('-');
						}else{
								ctrlTab('+');
							 }
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if(kCode==80)	// ctrl-P
				{
					if(event.ctrlKey)
					{
						top.printPage();
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if(kCode==87)	// ctrl-W
				{
					if(event.ctrlKey)
					{
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if(kCode==77)	// ctrl-M
				{
					if(event.ctrlKey)
					{
						if(blockInFocus!= null)
							if(blockInFocus.style.display == '')
								if(blockInFocus.getAttribute('drag_hability') == 'false')
									filho.maximiza(blockInFocus);
								else
									filho.maximiza(blockInFocus);
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if(kCode==66)	// ctrl-B
				{
					if(event.ctrlKey)
					{
						top.showHiddeSideBar(document.getElementById('btSideBar'))
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if(kCode==73)	// ctrl-I
				{
					if(event.ctrlKey)
					{
						if(blockInFocus!= null)
							if(blockInFocus.style.display != 'none')
								filho.minimiza(blockInFocus);
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
				if(kCode==83)	// ctrl-S
				{
					if(event.ctrlKey)
					{
						filho.saveDataBlocks();
						event.keyCode= 0;
						event.cancelBubble= true;
						event.returnValue = false;
						return false;
					}
				}
			}

			try
			{
				document.attachEvent("onkeydown", checkKey);
			}catch(e)
			{
				window.addEventListener("keydown", checkKey, true);
			}
			
			function printPage()
			{
				blockInFocus= c.blockInFocus;
				if(blockInFocus)
				{
					titleToPrint= c.document.getElementById('title_'+blockInFocus.id).innerHTML;
					blockInFocus= c.document.getElementById('blockInner_'+blockInFocus.id)
					document.getElementById('abertura_back_div').style.display= '';
					setLoad(true, 'Imprimindo');
					urlSrc= "print_page.php";
					w= 450;
					h=300;
					t= (screen.height)/2 - 225;
					l= (screen.width)/2 - 200;
					window_open= window.open(urlSrc, 'imprimir', 'width='+w+',height='+h+',left='+l+',top='+t+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
					top.focus();
				}else{
						showAlert('informativo', 'Não há nada a ser impresso');
					 }
			}
			
			function showShortcutList()
			{
				document.getElementById('shortcutList').style.display= '';
				hiddeSelectLists();
			}
			
		</script>
		
		
		<div id="shortcutList"
			 style=" position: absolute;
					 left: 0px;
					 top: 0px;
					 height: 100%;
					 width: 100%;
					 z-index: 9999;
					 display: none;">
			<table cellpadding="0"
				   cellspacing="0"
				   style="height: 100%;
						  width: 100%;">
				<tr>
					<td style="text-align: center;">
						<table style="border: solid 1px #333366;">
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
									<fieldset>
										<legend>
											Atalhos do teclado
										</legend>
										<table>
											<tr>
												<td style="border-right: solid 2px black;
														   vertical-align: top;">
													<table cellspacing="7">
														<tr>
															<td>
																Ctrl+A
															</td>
															<td>
																Exibe esta caixa, com a lista de Atalhos do teclado
															</td>
														</tr>
														<tr>
															<td style="vertical-align: top;">
																Ctrl+TAB
															</td>
															<td>
																Exibe a lista de aplicações do sistema, abertas atualmente<br>permite a sua sele&ccedil;&atilde;o
															</td>
														</tr>
														<tr>
															<td style="vertical-align: top;">
																Ctrl+Shift+TAB
															</td>
															<td>
																Exibe a lista de aplicações do sistema, abertas atualmente<br>permite a sua sele&ccedil;&atilde;o em sentido oposto
															</td>
														</tr>
														<tr>
															<td>
																Ctrl+F4
															</td>
															<td>
																Fecha a aplica&ccedil;&atilde;o do sistema, aberta atualmente
															</td>
														</tr>
														<tr>
															<td>
																Ctrl+P
															</td>
															<td>
																Imprime a aplica&ccedil;&atilde;o atual
															</td>
														</tr>
														<tr>
															<td>
																Ctrl+S
															</td>
															<td>
																Salva a configura&ccedil;&atilde;o atual
															</td>
														</tr>
														<tr>
															<td>
																F1
															</td>
															<td>
																Abre a tela para ajuda, sobre o sistema
															</td>
														</tr>
													</table>
												</td>
												<td style="vertical-align: top;">
													<table cellspacing="7">
														<tr>
															<td>
																Ctrl+M
															</td>
															<td>
																Maximiza/Restaura a aplica&ccedil;&atilde;o atual
															</td>
														</tr>
														<tr>
															<td>
																Ctrl+I
															</td>
															<td>
																Minimiza a aplica&ccedil;&atilde;o atual
															</td>
														</tr>
														<tr>
															<td>
																Ctrl+B
															</td>
															<td>
																Expande ou contrai a Barra lateral
															</td>
														</tr>
														<tr>
															<td style="vertical-align: top;">
																Ctrl+R
															</td>
															<td>
																Atualiza a aplica&ccedil;&atilde;o atual<br>
																Retorna todos os campos ao padr&atilde;o
															</td>
														</tr>
														<tr>
															<td style="vertical-align: top;">
																F5
															</td>
															<td>
																Atualiza a aplica&ccedil;&atilde;o atual<br>
																Retorna todos os campos ao padr&atilde;o
															</td>
														</tr>
														<tr>
															<td>
																Ctrl+setas
															</td>
															<td>
																Move o bloco da aplica&ccedil;&atilde;o atual
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan="2"
													style="text-align: right;
														   padding-right: 7px;">
													<div style="border: solid 1px black;
																cursor: pointer;
																width: 75px;
																text-align: center;"
														 onclick="document.getElementById('shortcutList').style.display= 'none';">
														Fechar
													</div>
												</td>
											</tr>
										</table>
									</fieldset>
								</td>
								<td style="background-color: #ffffff;
										   height: 4px;">
									<br>
								</td>
							</tr>
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
					</td>
				</tr>
			</table>
		</div>
		
		<script>
			function ctrlTab(param)
			{
				blocks= document.getElementById('ctrlTabTable').getElementsByTagName('TR');
				if(blocks.length <= 1)
					return false;
				if(blockInFocus==null)
				{
					for(i=0; i< blocks.length; i++)
					{
						blocks[i].style.fontWeight= 'normal';
					}
					blocks[0].style.fontWeight= 'bold';
					blockInFocus= filho.document.getElementById(blocks[0].getAttribute('block'));
					top.document.getElementById('ctrlTabDiv').style.display= '';
					return false;
				}
				for(i=0; i< blocks.length; i++)
				{
					blocks[i].style.fontWeight= 'normal';
					if(blocks[i].getAttribute('block') == blockInFocus.id)
					{
						if(param == '+')
						{
							if(i== (blocks.length - 1))
							{
								blocks[0].style.fontWeight= 'bold';
								tmp_bloco= filho.document.getElementById(blocks[0].getAttribute('block'));
							}else{
									blocks[i+1].style.fontWeight= 'bold';
									tmp_bloco= filho.document.getElementById(blocks[i+1].getAttribute('block'));
								 }
						}else{
								if(i== 0)
								{
									blocks[blocks.length-1].style.fontWeight= 'bold';
									tmp_bloco= filho.document.getElementById(blocks[blocks.length-1].getAttribute('block'));
								}else{
										blocks[i-1].style.fontWeight= 'bold';
										tmp_bloco= filho.document.getElementById(blocks[i-1].getAttribute('block'));
									 }
							 }
						blockInFocus= tmp_bloco;
						break;
					}
				}
				top.document.getElementById('ctrlTabDiv').style.display= '';
			}
			
			function checkCtrlTab()
			{
				top.document.getElementById('ctrlTabDiv').style.display = 'none';
				if(top.document.getElementById(blockInFocus.id))
						top.document.getElementById(blockInFocus.id).click();
				blockInFocus.setFocus();
				if(top.document.getElementById(blockInFocus.id))
				{
					try
					{
					}catch(error){
									top.document.getElementById(blockInFocus.id).restaura();
								 }
				}
			}
			
			function checkKeyUp(event)
			{
				if(top.filho.document.getElementById('locker').style.display != 'none')
					return false;
				if(event.keyCode==115 && event.ctrlKey)	// CTRL F4
				{
					top.removeBlockKey();
					return false;
				}
				if( top.document.getElementById('ctrlTabDiv').style.display == ''
					&&
					event.ctrlKey == false
				  )
				{
					checkCtrlTab();
				}
			}
			
			try
			{
				document.attachEvent("onkeyup", checkKeyUp);
			}catch(e)
			{
				window.addEventListener("keyup", checkKeyUp, true);
			}
			
			function removeBlockKey()
			{
				if(blockInFocus!= null)
					filho.closeBlock(blockInFocus, true);
			}
		</script>
		<script>
			function selectStartVerify(event)
			{
				if((window.event.srcElement.tagName== 'INPUT' && window.event.srcElement.type== 'text') || window.event.srcElement.tagName=='TEXTAREA')
				{
					return true;
				}else{
						return false;
					 }
			}
		</script>
		<script>
			function showHelp(str)
			{
				var header = '| ATHENA 1.0 | HELP |';
				alert(header+'\n \n' + str + '\n');
				return false;
			}
		</script>
		
		<script>
			//  Loader antes de abrir o Sistema
			counter = -50;
			function moveLoader()
			{
				if(counter<150)
				{
					//alert(document.getElementById('tablePaiLoad').style.left);
					counter= counter + 10;
					document.getElementById('tablePaiLoad').style.left = counter;
					setTimeout("moveLoader()", 100);
				}
				
				if(counter == 150)
				{
					counter = -50;
				}
			}
		</script>
	</head>
	<body id="bodyFather"
		  leftmargin="0"
		  topmargin="0"
		  bgcolor="#333366"
		  style="margin: 0px;
				 padding: 0px;"
		  scroll="no"
		  rightmargin="0"
		  onselectstart="return selectStartVerify()"
		  TESTEonselectstart="return false"
		  ondragstart="return false"
		  onhelp="return top.showHelp()"
		  oncontextmenu="rightBtMenu(event); return false;"
		  bottommargin="0">
		  
	<?php
		include("inc/class_menu.php");
		$menu= new menu;
	?>
	
		<div class="menuTopDiv">
			<table cellpadding="0"
				   cellspacing="0">
				<tr>
					<?php
						if(hasPermission(1) || hasPermission(2) || hasPermission(3))
						{
							?>
								<td class="menuTopAba"
									onmouseover="changeMenu(this, 'over');"
									onmouseout="changeMenu(this, 'out');"
									onclick="setMenu(this)"
									child_element="processos_subMenu"
									style="background-image: url('img/back_menu.gif');">
									Processos
								</td>
							<?php
						}	
					?>
					<?php
						if(hasPermission(7) || hasPermission(8) 
						|| hasPermission(9) || hasPermission(10) 
						|| hasPermission(11) || hasPermission(12)
						|| hasPermission(13) || hasPermission(14)
						|| hasPermission(15))
						{
							?>
								<td class="menuTopAba"
									onmouseover="changeMenu(this, 'over');"
									onmouseout="changeMenu(this, 'out');"
									onclick="setMenu(this)"
									child_element="clientes_subMenu"
									style="background-image: url('img/back_menu.gif');">
									Clientes
								</td>
							<?php
						}
					?>
					<?php
						if(hasPermission(16) || hasPermission(17) || hasPermission(18) || hasPermission(19))
						{
							?>
								<td class="menuTopAba"
									onmouseover="changeMenu(this, 'over');"
									onmouseout="changeMenu(this, 'out');"
									onclick="setMenu(this)"
									child_element="rh_subMenu"
									style="background-image: url('img/back_menu.gif');
										   text-align:center;
										   width:30px;">
									RH
								</td>
							<?php
						}
					?>
					<td class="menuTopAba"
						onmouseover="changeMenu(this, 'over');"
						onmouseout="changeMenu(this, 'out');"
						onclick="setMenu(this)"
						child_element="gerenciar_subMenu"
						style="background-image: url('img/back_menu.gif');">
						Gerenciar
					</td>
					<td class="menuTopAba"
						onmouseover="changeMenu(this, 'over');"
						onmouseout="changeMenu(this, 'out');"
						onclick="setMenu(this)"
						child_element="pesquisar_subMenu"
						style="background-image: url('img/back_menu.gif');">
						Pesquisar
					</td>
					<td class="menuTopAba"
						onmouseover="changeMenu(this, 'over');"
						onmouseout="changeMenu(this, 'out');"
						onclick="setMenu(this)"
						child_element="ferramentas_subMenu"
						style="background-image: url('img/back_menu.gif');">
						Ferramentas
					</td>
					<td class="menuTopAba"
						onmouseover="changeMenu(this, 'over');"
						onmouseout="changeMenu(this, 'out');"
						onclick="setMenu(this)"
						child_element="ajuda_subMenu"
						style="background-image: url('img/back_menu.gif');">
						Ajuda
					</td>
					<td class="menuTopAba"
						onmouseover="changeMenu(this, 'over');"
						onmouseout="changeMenu(this, 'out');"
						onclick="logoff()"
						style="background-image: url('img/back_menu.gif');">
						Logoff
					</td>
				</tr>
			</table>
		</div>
		
		<!-- submenus ARQUIVO -->
		<table id="arquivo_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 2px;
					  top: 20px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			 <?php
				//Importar
				// $menu->makeMenu('Importar', 'Importar', 'importar.php', '', 'Importar dados para meu computador');
				// $menu->setAttribute('unique', 'novo_usuario');
				// $menu->write();
			?>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="showtip(this, event, this.getAttribute('alt'));
								 this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= '';
								this.style.backgroundImage= 'url(img/back_menu.gif)';"
					alt="Exibe a lista de opções para impressão"
					onclick=" menuUnset(); printPage();">
					Imprimir	<!-- Exibe a lista de opções para imprimir  -->
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');">
					<hr>
				</td>
			</tr>
			<?php
				$menu->makeMenu('Alterar Senha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Alterar Senha', 'senha_edit.php', '', 'Alterar Senha');
				$menu->setAttribute('unique', 'dados_de_cadastro');
				$menu->write();
			?>
			
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="showtip(this, event, this.getAttribute('alt'));
								 this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= '';
								this.style.backgroundImage= 'url(img/back_menu.gif)';"
					alt="Salva a disposição atual dos objetos como padrão para este login"
					onclick="c.saveDataBlocks(); menuUnset();">
					Salvar <!-- salva as posições, especificações e tamanhos dos objetos visiveis  -->
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');">
					<hr>
				</td>
			</tr>
			<?php
				$menu->makeMenu('Propriedades', 'Propriedades', 'help_sobre_sistema.php', '', 'Exibe dados técnicos e especificações ou requisitos do sistema');
				$menu->setAttribute('unique', 'eventos_viewer');
				$menu->write();
			?>
			<!--
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="showtip(this, event, this.getAttribute('alt'));
								 this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= '';
								this.style.backgroundImage= 'url(img/back_menu.gif)';"
					alt="Propriedades do sistema"
					onclick="menuUnset();">
					Propriedades
				</td>
			</tr>
			-->
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="showtip(this, event, this.getAttribute('alt'));
								 this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= '';
								this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="logoff()"
					alt="Deslogar-se do Sistema">
					Logoff
				</td>
			</tr>
		</table>
		
		<!-- submenu PROCESSOS -->
		
		<table id="processos_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 50px;
					  top: 20px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			<?php
				if(hasPermission(1))
				{
					$menu->makeMenu('Novo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Novo Processo', 'processo/processo_add.php?PREID=processo_add_ger', '', 'Cadastrar um novo Processo no sistema');
					$menu->setAttribute('unique', 'novo_processo');
					$menu->write();
				}
			?>
			<?php
				if(hasPermission(2))
				{
					$menu->makeMenu('Gerenciar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Gerenciar Processos', 'processo/ger_processo.php?tab_mov_proc=true', '', 'Gerenciar Processos');
					$menu->setSize('500/300');
					$menu->write();
				}
			?>
			<?php
				if(hasPermission(2))
				{
					$menu->makeMenu('Adicionar Movimenta&ccedil;&atilde;o&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Adicionar Movimenta&ccedil;&atilde;o', 'processo/mov_proc_add_select.php', '', 'Adicionar Movimenta&ccedil;&atilde;o');
					$menu->setSize('500/300');
					$menu->write();
				}
			?>
			<?php
				if(hasPermission(3))
				{
					?>
						<tr>
							<td style="background-image: url('img/back_menu.gif');">
								<hr>
							</td>
						</tr>
					<?php
					$menu->makeMenu('Pesquisar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Pesquisar Processos', 'processo/processos_viewer.php', '', 'Filtros para pesquisa de Processos');
					$menu->setAttribute('unique', 'processos_search');
					$menu->write();
				}
			?>
		</table>
		
		<!-- submenu CLIENTES -->
		
		<table id="clientes_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 50px;
					  top: 20px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			<?php
				if(hasPermission(7))
				{
					$menu->makeMenu('Novo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Novo Cliente', 'cliente_add.php', '', 'Cadastrar um novo cliente no sistema');
					$menu->setAttribute('unique', 'novo_cliente');
					$menu->setPosition('0/30');
					$menu->setSize('840/560');
					$menu->setPosition('0/25');
					$menu->write();
				}
			?>
			<?php
				if(hasPermission(8))
				{
					$menu->makeMenu('Gerenciar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Gerenciar Clientes', 'ger_clientes.php', '', 'Gerenciar clientes');
					$menu->setAttribute('unique', 'ger_clientes');
					$menu->setSize('890/580');
					$menu->write();
				}
			?>
			<?php
				if(hasPermission(7) || hasPermission(8))
				{
					?>
						<tr>
							<td style="background-image: url('img/back_menu.gif');">
								<hr>
							</td>
						</tr>
					<?php
				}
			?>
			<!-- SubMenu Contatos-->
			<?php
				if(hasPermission(10) || hasPermission(11) || hasPermission(12))
				{
					$menu->makeParentMenu('Contatos');
					$blockMenuContatos = true;
				}else{
					$blockMenuContatos = false;
				}
				if(hasPermission(10))
				{
					$menu->makeSubMenu('Novo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Novo Contato', 'agenda_contato_empresa.php', '', 'Cadastrar um novo contato');
					$menu->setSubMenuAttribute('unique', 'agenda_contato_empresa');
				}
				if(hasPermission(11))
				{
					$menu->makeSubMenu('Gerenciar', 'Gerenciar Contatos', 'ger_contatos.php', '', 'Gerenciar Contatos');
					$menu->setSubMenuAttribute('unique', 'ger_contatos');
				}
				if(hasPermission(12))
				{
					$menu->makeSubMenu('Pesquisar', 'Pesquisar Contatos', 'viewer_contato.php', '', 'Pesquisar Contatos');
					//$menu->write();
				}
				if($blockMenuContatos)
					$menu->write();
					
			?>
			
			<!-- SubMenu Filiais-->
			<?php
				if(hasPermission(13) || hasPermission(14) || hasPermission(15))
				{
					$menu->makeParentMenu('Filiais&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
					$blockMenuFiliais = true;
				}else{
					$blockMenuFiliais = false;
				}
				if(hasPermission(13))
				{
					$menu->makeSubMenu('Nova&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Nova Filial', 'agenda_contato_filial.php', '', 'Cadastrar uma nova Filial');
					$menu->setSubMenuAttribute('unique', 'agenda_contato_filial');
				}
				if(hasPermission(14))
				{
					$menu->makeSubMenu('Gerenciar', 'Gerenciar Filiais', 'ger_filiais.php', '', 'Gerenciar Filiais');
					$menu->setSubMenuAttribute('unique', 'ger_filiais');
				}
				if(hasPermission(15))
				{
					$menu->makeSubMenu('Pesquisar', 'Pesquisar Filiais', 'viewer_filiais.php', '', 'Pesquisar Filiais');
				}
				if($blockMenuFiliais)
					$menu->write();
			?>
			<?php
				if(hasPermission(9))
				{
					?>
						<tr>
							<td style="background-image: url('img/back_menu.gif');">
								<hr>
							</td>
						</tr>
					<?php
					$menu->makeMenu('Pesquisar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Pesquisar Clientes', 'clientes_viewer.php', '', 'Explorar clientes e suas pastas, subpastas e processos');
					$menu->write();
				}
			?>
		</table>
		
		
		
		<!-- submenu RH -->
		
		<table id="rh_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 50px;
					  top: 20px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			<?php
				if (hasPermission(16) || hasPermission(17))
				{
					$menu->makeParentMenu('Funcion&aacute;rios');
					$blockMenuFuncionario = true;
				}else{
					$blockMenuFuncionario = false;
				}
				
				if (hasPermission(16))
				{
					$menu->makeSubMenu('Novo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Novo Funcion&aacute;rio', 'rh/funcionario_add.php', '', 'Cadastrar um novo Funcion&aacute;rio');
					$menu->setSubMenuAttribute('unique', 'novo_funcionario');
				}
				if (hasPermission(17))
				{
					$menu->makeSubMenu('Gerenciar', 'Gerenciar Funcion&aacute;rios', 'ger_usuario.php', '', 'Gerenciar Funcion&aacute;rios');
					$menu->setSubMenuAttribute('unique', 'ger_funcionario');
				}
				
				if($blockMenuFuncionario)
					$menu->write();
					
				if (hasPermission(19))
				{
					$menu->makeParentMenu('Grupo de Funcion&aacute;rios&nbsp;&nbsp;');
					$menu->makeSubMenu('Novo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Novo Grupo de Funcion&aacute;rios', 'usuario_grupo_add.php', '', 'Cadastrar um Novo Grupo de Funcion&aacute;rios');
					$menu->setSubMenuAttribute('unique', 'novo_grupo_funcionario');
					$menu->write();
				}
				
			?>
			<?php
				if (hasPermission(18))
				{
					?>
						<tr>
							<td style="background-image: url('img/back_menu.gif');">
								<hr>
							</td>
						</tr>
					<?php
					
					$menu->makeMenu('Pesquisar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Pesquisar Funcion&aacute;rios', 'rh/viewer_funcionarios.php', '', 'Pesquisar Funcion&aacute;rios');
					$menu->write();
				}
			?>
		</table>
		
		
		<!-- submenu GERENCIAR -->
		
		<table id="gerenciar_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 50px;
					  top: 20px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			
			<?php
				if (hasPermission(21))
				{
					$menu->makeMenu('Permiss&otilde;es&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Permiss&otilde;es', 'ger_permissoes_grupo.php', '', 'Gerenciar Permissões dos Grupos de Usuarios');
					$menu->setAttribute('unique', 'ger_permissoes_grupo');
					$menu->write();
				}
			?>
			<?php
				if(hasPermission(20) || hasPermission(21))
				{
					?>
						<tr>
							<td style="background-image: url('img/back_menu.gif');">
								<hr>
							</td>
						</tr>
					<?php
				}
			?>
			
			<?php
				//Usuários Logados
				if(hasPermission(26))
				{
					$menu->makeMenu('Usu&aacute;rios Logados&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Usu&aacute;rios Logados', 'usuarios_logados.php', '', 'Usu&aacute;rios logados');
					$menu->setAttribute('unique', 'usuarios_logados');
					$menu->write();
				}
			?>
			<?php
				//Logs
				if(hasPermission(25))
				{
					$menu->makeMenu('Logs', 'Logs', 'logs_viewer.php', '', 'Visualizar Logs');
					$menu->setAttribute('unique', 'logs_viewer');
					$menu->setSize('645/400');
					$menu->write();
				}
			?>
		</table>
		
			
		<!-- submenu PESQUISAR -->
		
		<table id="pesquisar_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 112px;
					  top: 20px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			<?php
				//Clientes
				$menu->makeMenu('Clientes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Pesquisar Clientes', 'clientes_viewer.php', '', 'Explorar clientes e suas pastas, subpastas e processos');
				$menu->setAttribute('unique', 'clientes_search');
				$menu->write();
			?>
				
			<?php
				//Processos
				$menu->makeMenu('Processos', 'Pesquisar Processos', 'processo/processos_viewer.php', '', 'Filtros para pesquisa de Processos');
				$menu->setAttribute('unique', 'processos_search');
				$menu->write();
			?>
		</table>
		
		<!---	submenu FERRAMENTAS     -->
		
		<table id="ferramentas_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 280px;
					  top: 20px;
					  width: 100px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			<?php
				if(hasPermission(28))
				{
					$menu->makeMenu('Calculadora', 'Calculadora', 'calc.php', '8', 'Abrir calculadora');
					$menu->setAttribute('unique', 'calc');
					$menu->setAttribute('translucent', '');
					$menu->setAttribute('nomaximize', '');
					$menu->write();
				}
			?>
			<?php
				if(hasPermission(29))
				{
					$menu->makeMenu('Calend&aacute;rio', 'Calend&aacute;rio', 'calendario.php', '9', 'Abrir calendário');
					$menu->setAttribute('unique', 'calendario');
					$menu->setSize('265/210');
					$menu->setAttribute('nomaximize', '');
					$menu->write();
				}
			?>
			
			<!--INFORMES-->
			<?php
				if(hasPermission(32) || hasPermission(33))
				{
					$menu->makeParentMenu('Informes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
					$blockMenuInformes = true;
				}else{
					$blockMenuInformes = false;
				}
				
				if(hasPermission(32))
				{
					$menu->makeSubMenu('Mensagens&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Mensagens', 'mensagens/ger_mensagem.php', '', 'Mensagens');
					$menu->setSubMenuAttribute('unique', 'ger_mensagens');
				}
				if(hasPermission(33))
				{
					$menu->makeSubMenu('Circulares&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Circulares', 'circulares/ger_circulares.php', '', 'Circulares');
					$menu->setSubMenuAttribute('unique', 'ger_circulares');
				}
				if($blockMenuInformes)
					$menu->write();
			?>
		
		</table>

		
		<!---	submenu AJUDA     -->
		
		<table id="ajuda_subMenu"
			   style="display: none;
					  position: absolute;
					  left: 280px;
					  top: 20px;"
			   class="subMenu"
			   cellpadding="0"
			   cellspacing="0">
			<?php
				$menu->makeMenu('Sobre o Sistema&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'Sobre o sistema', 'help_sobre_sistema.php', '', 'Exibe dados técnicos e especificações ou requisitos do sistema');
				$menu->setAttribute('unique', 'eventos_viewer');
				$menu->write();
			?>
		</table>
		
		
		<!-- LOADER-->
		<div id="loader"
			style=" position: absolute;
			 	    left: 90px;
					top: 140px;
					z-index: 9999;
					display: none;">
			<table cellpadding="0"
				   cellspacing="0">
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
					<td>
					</td>
					<td>
						<table style="border: solid 1px #dedede;">
							<tr>
								<td>
									<img src="img/loading.gif"> 
								</td>
								<td>
									<span id="loaderLegend"
										  style="font-family: Arial;
												 color: #333366;
												 font-weight:bold;
												 font-size: 13px;
												 font-style: italic;">
										Carregando dados ...
									</span>
								</td>
							</tr>
						</table>
					</td>
					<td>
					</td>
				</tr>
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
		</div>
		
		<div id="ctrlTabDiv"
			 style=" position: absolute;
					 left: 0px;
					 top: 0px;
					 height: 100%;
					 width: 100%;
					 z-index: 9999;
					 display: none;">
			<table cellpadding="0"
				   cellspacing="0"
				   style="height: 100%;
						  width: 100%;">
				<tr>
					<td style="text-align: center;">
						<table style="border: solid 1px #333366;">
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
									<fieldset>
										<legend>
											Selecione a aplica&ccedil;&atilde;o
										</legend>
										<table>
											<tbody id="ctrlTabTable">
											</tbody>
										</table>
									</fieldset>
								</td>
								<td style="background-color: #ffffff;
										   height: 4px;">
									<br>
								</td>
							</tr>
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
					</td>
				</tr>
			</table>
		</div>
		<script>
			function addApp(objId, tt)
			{
				cTabTR= document.createElement('TR');
					cTabTD= document.createElement('TD');
					cTabTD.innerHTML= tt;
				cTabTR.appendChild(cTabTD);
				cTabTR.setAttribute('block', objId);
				document.getElementById('ctrlTabTable').appendChild(cTabTR);
			}
			function removeApp(objId)
			{
				trs= document.getElementById('ctrlTabTable').getElementsByTagName('tr');
				for(i=0; i<trs.length; i++)
				{
					if(trs[i].getAttribute('block') == objId)
					{
						try
						{
							filho.blockInFocus= filho.document.getElementById(trs[i-1].getAttribute('block'));
							blockInFocus= filho.document.getElementById(trs[i-1].getAttribute('block'));
						}catch(error)
						{
							filho.blockInFocus= null;
							blockInFocus= null;
						}
						//filho.setBlur();
						try
						{
							if(i != 0)	// AQUI
							{
								filho.setFocus(filho.document.getElementById(trs[i-1].getAttribute('block')));
								//filho.document.getElementById(trs[i-1].getAttribute('block')).click();
							}else{
									filho.setFocus(filho.document.getElementById(trs[i+1].getAttribute('block')));
									//filho.document.getElementById(trs[i+1].getAttribute('block')).click();
								 }
						}catch(error){}
						document.getElementById('ctrlTabTable').removeChild(trs[i]);
						break;
					}
				}
			}
		</script>
		<div id="minimizeds"
			 style="position: absolute;
					bottom: 0px;
					left: 0px;
					width: 100%;
					z-index: 9999;
					height: 25px;
					font-size: 11px;
					font-family: Arial;
					font-weight: bold;
					color: #000000;
					overflow: auto;
					padding-top: 5px;
					padding-left: 7px;
					border-bottom: #383838;
					background-image: url(img/top_blue_focus.gif);
					background-attachment: fixed;
					background-color: #5985D2">
		</div>		
		
		<iframe src="filho.php"
				id="frame"
				width="100%"
				height="100%"
				scroll="no"
				scrolling="no"
				frameborder="0"
				onload="top.focus();">
		</iframe>
		
		<div id="td_info_box"
			 style="">
		</div>
	
	</body>
	<script>
		try
		{
			var c= window.frames;
			c= c[0];
			var filho= window.frames;
			filho= filho[0];

		}catch(error)
		{
			var c= document.getElementById('frame');
		}
		
		function blockToBar(obj)
		{
			bar= document.getElementById('minimizeds');
			objTt= obj.getAttribute('tt');
			minSpan= document.createElement('SPAN');
			minSpan.setAttribute("style", '');
			minSpan.setAttribute("id", obj.getAttribute('id'));
			minSpan.style.float= 'left';
			minSpan.align= 'left';
			minSpan.style.textAlign= 'left';
			minSpan.style.whiteSpace= 'nowrap';
			minSpan.style.width= '90px';
			minSpan.style.overflow= 'hidden';
			minSpan.setAttribute('obj', obj);
			minSpan.style.cursor= 'pointer';
			minSpan.style.paddingLeft= '7px';
			minSpan.style.borderRight= 'solid 1px #ffffff';
			objTt= (objTt.length > 10)? objTt.substring(0,10)+"...": objTt.substring(0,13);
			minSpan.innerHTML= objTt;
			//minSpan.setAttribute('rhtmenuclass', 'rhtMenuTitleTable');
			minSpan.onclick= function restaura()
									 {
										filho.minimizeReturnAnim(obj, this);
										return;
										// filho.document.getElementById(objs.id).style.display= '';
										// filho.document.getElementById(obj.id).style.zIndex= filho.zMax+1;
										// filho.zMax++;
										// filho.setFocus(filho.document.getElementById(obj.id));
										// bar.removeChild(this);
									 }
			bar.appendChild(minSpan);
		}
		
		
		//setLoad(true);
	</script>
	
	

	<!--RIGHT MENU (menu de botao direito)     -->
	<!---->
	<div id="rhtMenuIco"
		 style="position: absolute;
				left: 0px;
				top: 40px;
				border: solid 1px; #000000;
				display: none;
				z-index: 9999;">
		<table cellpadding="0"
			   cellspacing="0"
			   class="subMenu">
			<tr>
				<td style="background-image: url('img/back_menu.gif'); width: 120px;"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="document.getElementById('rhtMenuIco').getAttribute('blockReferences').call();
							 document.getElementById('rhtMenuIco').style.display= 'none';">
					Abrir
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="top.filho.deleteIco(document.getElementById('rhtMenuIco').getAttribute('blockReferences'));
							 document.getElementById('rhtMenuIco').style.display= 'none';">
					Excluir
				</td>
			</tr>
		</table>
	</div>
	<!-- AGENDA DE CONTATOS -->
	<div id="rhtGrupoAgendaContato"
		 style="position: absolute;
				left: 0px;
				top: 40px;
				border: solid 1px; #000000;
				display: none;
				z-index: 9999;">
		<table cellpadding="0"
			   cellspacing="0"
			   class="subMenu">
			<tr>
				<td style=""
					onmouseover="this.style.backgroundColor= '#777777';"
					onmouseout="this.style.backgroundColor= '';"
					onclick="c.creatBlock('Renomear grupo de contatos ', 'renomear_grupo_agenda_contato.php?pk_agenda_grupo='+document.getElementById('rhtGrupoAgendaContato').getAttribute('blockReferences').getAttribute('pk_agenda_grupo')+'&s_nome_agenda_grupo='+document.getElementById('rhtGrupoAgendaContato').getAttribute('blockReferences').innerHTML, 'renomear_grupo_agenda_contato', 'noresize, nomaximize'); document.getElementById('rhtGrupoAgendaContato').style.display= 'none';">
					Renomear
				</td>
			</tr>
			<tr>
				<td style=""
					onmouseover="this.style.backgroundColor= '#777777';"
					onmouseout="this.style.backgroundColor= '';"
					onclick="c.creatBlock('Excluir grupo de contatos ', 'excluir_grupo_agenda_contato.php?pk_agenda_grupo='+document.getElementById('rhtGrupoAgendaContato').getAttribute('blockReferences').getAttribute('pk_agenda_grupo')+'&s_nome_agenda_grupo='+document.getElementById('rhtGrupoAgendaContato').getAttribute('blockReferences').innerHTML, 'excluir_grupo_agenda_contato', 'noresize, nomaximize'); document.getElementById('rhtGrupoAgendaContato').style.display= 'none';">
					Excluir
				</td>
			</tr>
			<tr>
				<td style=""
					onmouseover="this.style.backgroundColor= '#777777';"
					onmouseout="this.style.backgroundColor= '';"
					onclick="document.getElementById('rhtGrupoAgendaContato').getAttribute('blockReferences').click(); document.getElementById('rhtGrupoAgendaContato').style.display= 'none';">
					Expandir / Contrair
				</td>
			</tr>
		</table>
	</div>
	
	<div id="rhtMenuTitleTable"
		 style="position: absolute;
				left: 0px;
				top: 40px;
				border: solid 1px; #000000;
				display: none;
				z-index: 9999;">
		<table cellpadding="0"
			   cellspacing="0"
			   class="subMenu">
			<tr style="display: none;">
				<td style="display: none;"
					onmouseover="this.style.backgroundColor= '#777777';"
					onmouseout="this.style.backgroundColor= '';"
					id="linkToOpen"
					onclick="window.open(this.getAttribute('urlSrc'), 'alterar_senha', 'width=600,height=400,left=150,top=150,scrollbars=no,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no'); document.getElementById('rhtMenuTitleTable').style.display= 'none';">
					<!--Abrir em outra janela-->
				</td>
			</tr> 
			<!--<tr>
				<td style=""
					onmouseover="this.style.backgroundColor= '#777777';"
					onmouseout="this.style.backgroundColor= '';"
					onclick="refresh('rhtMenuTitleTable')">
					Atualizar
				</td>
			</tr>-->
			
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="tryShortCut('rhtMenuTitleTable'); document.getElementById('rhtMenuTitleTable').style.display= 'none';">
					Criar Atalho
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="filho.saveTmp('rhtMenuTitleTable'); document.getElementById('rhtMenuTitleTable').style.display= 'none';">
					Salvar Rascunho
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="setTransparency('rhtMenuTitleTable')">
					Transparente
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#aaaaaa'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="printPage(); document.getElementById('rhtMenuTitleTable').style.display= 'none'">
					Imprimir
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');">
					<hr>
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="tryReload('rhtMenuTitleTable');">
					Atualizar
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="tryMin('rhtMenuTitleTable')">
					Minimizar
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="this.style.backgroundColor= '#777777'; this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= ''; this.style.backgroundImage= 'url(img/back_menu.gif)';"
					onclick="c.closeBlock(document.getElementById('rhtMenuTitleTable').getAttribute('blockReferences')); document.getElementById('rhtMenuTitleTable').style.display= 'none';">
					Fechar
				</td>
			</tr>
		</table>
	</div>
	<script>
		function refresh(objId)
		{
			obj= document.getElementById(objId).getAttribute('blockReferences');
			id= obj.getAttribute('id').replace('table_block_', '');
			//alert(c.document.getElementById('blockInner_'+id).innerHTML);
			c.onlyEvalAjax(obj.getAttribute('src'), '', "ajax= ajax.split('<flp_script>'); document.getElementById('blockInner_"+id+"').innerHTML= ajax[0]; try{ eval(ajax[1]); }catch(e){}; verify('table_"+id+"');");
			document.getElementById(objId).style.display= 'none';
		}		
		function setTransparency(objId)
		{
			obj= document.getElementById(objId).getAttribute('blockReferences');
			if(obj.getAttribute('translucent'))
			{
				obj.removeAttribute('translucent');
				c.setOpacity(obj.id, 100);
			}else{
					c.setOpacity(obj.id, 70);
					obj.setAttribute('translucent', 'true');
				 }
			document.getElementById(objId).style.display= 'none';
		}
		function tryMin(objId)
		{
			obj= document.getElementById(objId).getAttribute('blockReferences');
			c.minimiza(obj);
			document.getElementById(objId).style.display= 'none';
		}
		
		function tryReload(objId)
		{
			obj= document.getElementById(objId).getAttribute('blockReferences');
			obj.reload();
			document.getElementById(objId).style.display= 'none';
		}
		
		function tryShortCut(objId)
		{
			obj= document.getElementById(objId).getAttribute('blockReferences');
			//alert('url: ' + obj.getAttribute('url'));
			// alert('title: ' + obj.getAttribute('tt'));
			// alert('especific: ' + obj.getAttribute('especific'));
			// alert('w: ' + parseInt(obj.style.width)+' h:' + parseInt(obj.style.height) + ' l: ' + parseInt(obj.style.left) + ' t:' + parseInt(obj.style.top));
			filho.addShortCut(obj);
			//document.getElementById(objId).style.display= 'none';
		}
		
	</script>
	<div id="rhtMenuBackDiv"
		 style="position: absolute;
				left: 0px;
				top: 40px;
				display: none;
				border: solid 1px #000000;
				z-index: 9999;
				padding: 0px;">
		<table cellpadding="0"
			   cellspacing="0"
			   class="subMenu"
			   style="width: 120px;">
			<?php
				$menu->makeMenu('Calculadora', 'Calculadora', 'calc.php', '', 'Abrir calculadora');
				$menu->setAttribute('unique', 'calc');
				$menu->setAttribute('translucent', '');
				$menu->setAttribute('nomaximize', '');
				$menu->setEvent("onclick", "document.getElementById('rhtMenuBackDiv').style.display= 'none'; ");
				$menu->write();
			?>
			<?php
				$menu->makeMenu('Calend&aacute;rio', 'Calend&aacute;rio', 'calendario.php', '', 'Abrir calendário');
				$menu->setAttribute('unique', 'calendario');
				$menu->setAttribute('nomaximize', '');
				$menu->setSize('265/210');
				$menu->setEvent("onclick", "document.getElementById('rhtMenuBackDiv').style.display= 'none'; ");
				$menu->write();
			?>
			<?php
				$menu->makeParentMenu('Agenda');
				$menu->makeSubMenu('Agenda de Eventos', 'Agenda de Eventos', 'agenda_eventos.php', '', 'Abrir a agenda de eventos');
				$menu->setSubMenuAttribute('unique', 'agenda_de_eventos');
				$menu->setSubMenuAttribute('translucent', '');
				$menu->setSubMenuSize('300/');
				$menu->setSubMenuEvent("onclick", "document.getElementById('rhtMenuBackDiv').style.display= 'none'; ");
				$menu->makeSubMenu('Agenda de Contatos', 'Agenda de Contatos', 'agenda_contatos.php', '', 'Abrir a agenda de contatos');
				$menu->setSubMenuEvent("onclick", "document.getElementById('rhtMenuBackDiv').style.display= 'none'; ");
				$menu->write();
			?>
			<tr>
				<td style="background-image: url('img/back_menu.gif');">
					<hr>
				</td>
			</tr>
			<?
				$menu->makeMenu('A&ccedil;&otilde;es pendentes', 'A&ccedil;&otilde;es pendentes ', 'acoes_pendentes_viewer.php', '', 'Exibe as ações que aguardam confirmação');
				$menu->setAttribute('unique', 'acoes_pendentes');
				$menu->setEvent("onclick", "document.getElementById('rhtMenuBackDiv').style.display= 'none'; ");
				$menu->write();
			?>
			<?php
				$menu->makeMenu('Clientes', 'Pesquisar Clientes', 'clientes_viewer.php', '', 'Explorar clientes e suas pastas, subpastas e processos');
				$menu->setAttribute('unique', 'clientes_search');
				$menu->setEvent("onclick", "document.getElementById('rhtMenuBackDiv').style.display= 'none'; ");
				$menu->write();
			?>
			<?php
				$menu->makeMenu('Circulares ', 'Circulares ', 'circulares/ger_circulares.php', '', 'Permite trocar mensagens com outros usuários do sistems');
				$menu->setAttribute('unique', 'circulares');
				$menu->setEvent("onclick", "document.getElementById('rhtMenuBackDiv').style.display= 'none'; ");
				$menu->write();
			?>
			<tr>
				<td style="background-image: url('img/back_menu.gif');">
					<hr>
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="showtip(this, event, this.getAttribute('alt'));
								 this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= '';
								this.style.backgroundImage= 'url(img/back_menu.gif)';"
					alt="Salva a disposição atual dos objetos como padrão para este login"
					onclick="document.getElementById('rhtMenuBackDiv').style.display= 'none'; c.saveDataBlocks(); menuUnset();">
					Salvar <!-- salva as posições, especificações e tamanhos dos objetos visiveis  -->
				</td>
			</tr>
			<tr>
				<td style="background-image: url('img/back_menu.gif');"
					onmouseover="showtip(this, event, this.getAttribute('alt'));
								 this.style.backgroundImage= 'url(img/back_menu_over.gif)';"
					onmouseout="this.style.backgroundColor= '';
								this.style.backgroundImage= 'url(img/back_menu.gif)';"
					alt="Salva a disposição atual dos objetos como padrão para este login"
					onclick="document.getElementById('rhtMenuBackDiv').style.display= 'none'; logoff()">
					Logoff
				</td>
			</tr>
		</table>
	</div>
	<script>	
	
		function logoff()
		{
			if(!confirm('Tem certeza que deseja deslogar-se do sistema ?'))
				return false;
			window.close();
		}
	
		function cancelEvent(event)
		{
			if (event && event.preventDefault)
			{
				event.preventDefault(); // DOM style
			}
			event.returnValue= false;
			event.cancelBubble= true;
		  return false; // IE style
		}
	
		function rhtBtMenu(obj, objTarget)
	    {
			try
			{
				rhtMenuClass= obj.getAttribute('rhtmenuclass');
			}catch(error)
			{
				cancelEvent(event);
				return false;
			}
			rhtMenuClass= top.document.getElementById(rhtMenuClass);
			if(rhtMenuClass)
			{
				objSelectLists= c.document.getElementsByTagName('select');
				for(i=0; i< objSelectLists.length; i++)
				{
					objSelectLists[i].style.visibility= 'hidden';
				}
				
				rhtMenuClass.style.left= c.event.clientX;
				rhtMenuClass.style.top= c.event.clientY;
				//	ajustanto posição
				rhtMenuClass.style.display= '';
				if((rhtMenuClass.offsetLeft + rhtMenuClass.offsetWidth) > (document.body.clientWidth-5))
					rhtMenuClass.style.left= c.event.clientX - (rhtMenuClass.offsetWidth);
				
				if((rhtMenuClass.offsetTop + rhtMenuClass.offsetHeight) > (document.body.clientHeight-5))
					rhtMenuClass.style.top= c.event.clientY - (rhtMenuClass.offsetHeight);
				
				trs= rhtMenuClass.getElementsByTagName('TR');
				/*for(i=0; i<trs.length; i++)
				{
					//trs[i].getAttribute('typeOfElement') == '';
				}*/
				if(objTarget.getAttribute('linkToOpen'))
				{
					document.getElementById('linkToOpen').style.display= '';
					document.getElementById('linkToOpen').setAttribute('urlSrc', objTarget.getAttribute('linkToOpen'));
				}else{
						document.getElementById('linkToOpen').style.display= 'none';
					 }
				rhtBtSubMenu= rhtMenuClass;
				rhtBtSubMenu.setAttribute('blockReferences', obj);
			}
			//cancelEvent(event);
			return false;
		}
	</script>
	
	<!--   ABERTURA    -->
	<div id="abertura_back_div"
		 style="position: absolute;
				left: 0px;
				top: 0px;
				z-index: 999998;
				width: 100%;
				height: 100%;
				background-color: #4f4444;">
		
	</div>
	<div style="position: absolute;
				left: 0px;
				top: 0px;
				z-index: 999999;
				display: non;
				padding: 5px;"
		 id="div_abertura">
						<table>
							<tr>
								<td>
									<img src="../img/top_left_load.gif"><br>
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
									<span style="font-size: 15px;
												 font-weight: bold;
												 padding-left: 7px;">
										Athena - <span id="loadingSystem">Inicializando o Sistema</span>
									</span>
									<span style="margin-left:45px;">
										<div id="load"
											 style="width:150px;
													height:25px;
													position:absolute;
													clip:rect(0px, 150px, 145px, 0px);">
													
										<div id="blockLoad"
											 style="position:absolute;
													border:solid 2px #cccccc; 
													width:150px;
													height:14px;
													z-index:9999;">
											<table cellspacing="1"
												   cellpadding="0"
												   id="tablePaiLoad"
												   style="width:40px;
														  height:10px;
														  font-size:2px;
														  position:absolute;
														  left:0px;">
												<tr>
													<td style="background-color:#7EB9FC;
															   border:solid 1px #cccccc;
															   font-size:3px;
															   width:10px">
														&nbsp;
													</td>
													<td style="background-color:#2C88F2;
															   border:solid 1px #cccccc;
															   font-size:3px;
															   width:10px">
														&nbsp;
													</td>
													<td style="background-color:#0261FA;
													           border:solid 1px #cccccc;
															   font-size:3px;
															   width:10px">
														&nbsp;
													</td>
												</tr>
											</table>
										</div>
									</div>
									</span>
										<div style="background-image: url(img/back.jpg);
													background-position: center;
													width: 440px;
													height: 140px;
													padding-top: 0px;--190
													padding-left: 0px;--260
													border: outset 0px;
													padding: bottom: 0px;"><br>
											<table align="left"
												   style="margin-left: 15px;">
												<tr>
													<td style="text-align: left;
															   font-size: 15px;
															   font-weight: bold;
															   color: black">
														<br>
													</td>
												</tr>
												<tr>
													<td style="text-align: left;
															   font-size: 15px;
															   font-weight: bold;
															   color: black">
														<br>
													</td>
												</tr>
											</table>
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
</div>
	<!--    ALERT    -->
	<span style="display: none;"
		 id="hiddenDivBotoes_onlyClose">
		<nobr>
			<img src="img/close_alert.gif"
				 onclick="hiddeAlert()">
		</nobr>
	</span>
	<table style="position: absolute;
				  left: 0px;
				  top: 0px;
				  z-index: 999999;
				  display: none;"
		   width="100%"
		   height="100%"
		   cellpadding="0"
		   cellspacing="0"
		   id="table_alert">
		<tr>
			<td id="td_alert"
				style="text-align: center;
					   padding: 0px;
					   margin: 0px;"
				width="100%"
				height="100%">
				<script>
					/*	Criando a tabela externa	*/
					table= document.createElement('TABLE');
					table.setAttribute("style", '');
					table.setAttribute("bloco", 'true');
					
					tBody= document.createElement('TBODY');
						/*  Primeira linha   */
						tr= document.createElement('TR');
							tr.setAttribute("style", '');
							tr.style.cursor= 'default';
							tr.style.height= '20px';
							// celulas
							tdLt= document.createElement('TD');
								tdLt.setAttribute("style", '');
								tdLt.style.width= '7px';
								tdLt.innerHTML= "<img src='img/left_top_blue_focus.gif'><br>";
							
							tdCt= document.createElement('TD');
								tdCt.setAttribute("style", '');
								tdCt.style.backgroundImage="url(img/top_blue_focus.gif)";
								tdCt.style.backgroundRepeat= 'repeat-x';
								tdCt.style.whiteSpace= 'nowrap';
								container= "";
								container+= document.getElementById('hiddenDivBotoes_onlyClose').innerHTML;
								tdCt.innerHTML= "<table width='100%' bgclor='red' cellpadding='0' cellspacing='0'> <tr> <td style='width:320px;font-weight: bold; font-size: 14px; text-align: left;' id='alert_title'>titulo</td><td id='alert_botoes' style='padding-left: 8px; text-align: right;'>"+ container +"</td> </tr> </table>"
							tdRt= document.createElement('TD');
								tdRt.setAttribute("style", '');
								tdRt.style.width= '7px';
								tdRt.innerHTML= "<img src='img/right_top_blue_focus.gif'><br>";
								
						tr.appendChild(tdLt);
						tr.appendChild(tdCt);
						tr.appendChild(tdRt);
					
					tBody.appendChild(tr);
					
						/*  Segunda linha   */
						tr= document.createElement('TR');
							tr.setAttribute("style", '');
							tr.style.cursor= 'default';
							// celulas
							tdLt= document.createElement('TD');
								tdLt.setAttribute('style', '');
								tdLt.style.backgroundImage= 'url(img/left.gif)';
								tdLt.style.backgroundRepeat= 'repeat-y';
							
							tdCt= document.createElement('TD');
								tdCt.setAttribute("style", '');
								tdCt.style.backgroundColor= '#f0f0f0';
								tdCt.style.verticalAlign= 'top';
								tdCt.style.textAlign= 'center';
								tdCt.setAttribute('id', 'alert_inner');
								tdCt.innerHTML= "alerta";
								
							tdRt= document.createElement('TD');
								tdRt.setAttribute('style', '');
								tdRt.style.backgroundImage= 'url(img/right.gif)';
								tdRt.style.backgroundRepeat= 'repeat-y';
						tr.appendChild(tdLt);
						tr.appendChild(tdCt);
						tr.appendChild(tdRt);
						
					tBody.appendChild(tr);
				   
					/*  Terceira linha   */
						tr= document.createElement('TR');
							tr.setAttribute("style", '');
							tr.style.cursor= 'default';
							// celulas
							tdLt= document.createElement('TD');
								tdLt.setAttribute('style', '');
								tdLt.style.backgroundImage= 'url(img/left.gif)';
								tdLt.style.backgroundRepeat= 'repeat-y';
							
							tdCt= document.createElement('TD');
								tdCt.setAttribute("style", '');
								tdCt.style.backgroundColor= '#f0f0f0';
								tdCt.style.verticalAlign= 'top';
								tdCt.style.textAlign= 'center';
								tdCt.innerHTML= '<hr><input type="button" id="button_alert" class="botao" value="Ok" onclick="hiddeAlert()">';
								
							tdRt= document.createElement('TD');
								tdRt.setAttribute('style', '');
								tdRt.style.backgroundImage= 'url(img/right.gif)';
								tdRt.style.backgroundRepeat= 'repeat-y';
						tr.appendChild(tdLt);
						tr.appendChild(tdCt);
						tr.appendChild(tdRt);
						
					tBody.appendChild(tr);

							
					/*  Quarta linha   */
						tr= document.createElement('TR');
							tr.setAttribute("style", '');
							tr.style.cursor= 'default';
							tr.style.height='5px';
							// celulas
							tdLt= document.createElement('TD');
								tdLt.setAttribute('style', '');
								tdLt.style.width= '7px';
								tdLt.style.height= '5px';
								tdLt.innerHTML= "<img src='img/left_bottom.gif'><br>";
							
							tdCt= document.createElement('TD');
								tdCt.setAttribute("style", '');
								tdCt.style.backgroundImage= 'url(img/bottom.gif)';
								tdCt.style.backgroundRepeat= 'repeat-x';
								tdCt.style.height= '5px';
							
							tdRt= document.createElement('TD');
								tdRt.setAttribute('style', '');
								tdRt.style.backgroundImage= 'url(img/right_bottom.gif)';
								tdRt.style.backgroundRepeat= 'repeat-y';
								
						tr.appendChild(tdLt);
						tr.appendChild(tdCt);
						tr.appendChild(tdRt);
						
					tBody.appendChild(tr);

					table.appendChild(tBody);
					document.getElementById('td_alert').appendChild(table);
				</script>
			</td>
		</tr>
	</table>
	
	<?php
		/*
			barra lateral
		*/
		include('side_bar.php');
	?>
	
	<div style="width: 100%;
				height: 100%;
				position: absolute;
				left: 0px;
				top: 0px;
				z-index: 9999;
				display: none;
				background-color: #000000;"
		 id="divLock"
		 obj=""
		 onclick="try{ this.obj.focus(); }catch(e){}">
		<br>
	</div>
	<script>
		
		function lockUse(value, obj)
		{
			dv= document.getElementById('divLock');
			if(value == true)
			{
				dv.style.display= '';
				if(obj) dv.setAttribute('obj', obj);
			}else{
					dv.style.display= 'none';
					dv.setAttribute('obj', '');
				 }
		}
		
		setOpacity('divLock', 30);
	</script>
	<script>
		function fadeOut(objId)
		{
			obj= document.getElementById(objId);
			i=0;
			for(count=10; count>=0; count--)
			{
				i= i+100;
				try
				{
					setTimeout("setOpacity('"+objId+"', "+(10*count)+");", i);
				}catch(error)
				{alert(error.description)}
			}
			setTimeout("document.getElementById('abertura_back_div').style.display= 'none'; document.getElementById('div_abertura').style.display= 'none';", 1000);
		}

		setOpacity('abertura_back_div', 50);
		document.getElementById('div_abertura').style.left= (document.body.clientWidth/2) - 200;
		document.getElementById('div_abertura').style.top= (document.body.clientHeight/2) - 140;
		/*
		setTimeout('document.getElementById("loadingSystem").innerHTML= "Preparando interface gr&aacute;fica" ', 1000);
		setTimeout('document.getElementById("loadingSystem").innerHTML= "Carregando Configura&ccedil;&otilde;es pessoais" ', 2000);
		setTimeout('document.getElementById("loadingSystem").innerHTML= "Conex&atilde;o estabelecida" ', 3000);
		*/
		setTimeout('fadeOut("div_abertura"); ', 1000);
		
		//setTimeout("document.getElementById('abertura_back_div').style.display='none'; document.getElementById('div_abertura').style.display='none';", 1000);
		
		/*
		*/
		
		function unloadding()
		{
			//top.close();
			try
			{
				opener.location.href= "logoff.php";
				opener.focus();
			}catch(error){
							try{
									top.location.href= "logoff.php";
							   }catch(error){
												self.location.href= "logoff.php";
											}
						 }
		}
		function showAlert(tipo, msg)
		{
			hiddeSelectLists();
			document.getElementById('alert_title').innerHTML= tipo.substring(0,1).toUpperCase()+tipo.substring(1,tipo.length);
			document.getElementById('alert_inner').innerHTML= "<img src='img/"+tipo+".gif'><br>"+msg;
			document.getElementById('abertura_back_div').style.display= '';
			document.getElementById('table_alert').style.display= '';
			document.getElementById('button_alert').focus();
		}
		
		function hiddeAlert()
		{
			document.getElementById('table_alert').style.display= 'none';
			document.getElementById('abertura_back_div').style.display= 'none';
		}
		
		//setTimeout("showAlert('informativo', 'Mensagem de alerta a ser exibida');", 3000);	//	teste
		
		function handleErr(msg,url,l)
		{
			//('erro', 'Ocorreu um erro durante a execução de algum script, tente efetuar logoff e logar-se novamente, caso o problema persista, entre em contato com o suporte.<br>-----------------<br><b>Descricao técnica do erro:</b> '+ msg+'<br><b>arquivo:</b> '+url+'<br><b>linha:</b> '+l);
			return false;
		}
		
		window.onerror= handleErr;
		window.onunload= unloadding;
	</script>
	<script>
		window.attachEvent("onload", moveLoader);
	</script>
</html>