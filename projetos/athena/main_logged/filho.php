<?php
	//session_start();
	require_once("inc/valida_sessao.php");

	include("../connections/flp_db_connection.php");
	$db_connection= @connectTo();
	if(!$db_connection)
	{
		?>
			<flp_script>
				alert("Ocorreu um problema ao tentar verificar o login !");
		<?
		exit;
	}
	echo "<?xml version='1.0' encoding='iso-8859-1'?>";
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="imagetoolbar" content="no">
	<!-- ESTILOS -->
	<link href="styles/estilos.css" rel="stylesheet" type="text/css">
	<link href="styles/calendar-system.css" type="text/css" rel="stylesheet">
	<link href="styles/estilos_impressao.css" rel="stylesheet" type="text/css" media="print">
	<link href="../styles/estilos.css" rel="stylesheet" type="text/css">
	<!-- SCRIPTS -->
	<script src="inc/f2j_elo.php"></script>
	<script src="scripts/globais.js"></script>
	<script src="scripts/tooltip.js"></script>
	<script src="scripts/lib.js"></script>
	<script src="scripts/editor_de_textos.js"></script>
	<script src="scripts/flp_home_functions.js"></script>
	<script src="scripts/flp_dragndrop.js"></script>
	<script src="scripts/flp_ajax.js"></script>
	<script src="scripts/flp_tree.js"></script>
	<script src="scripts/rht_bt.js"></script>
	<script src="scripts/calendar.js"></script>			
	<script src="scripts/calendario/calendar.js"></script>
	<script src="scripts/calendario/lang/calendar-br.js"></script>
	<script src="scripts/funcionario.js"></script>
	<script src="scripts/calendario/calendar-setup.js"></script>
	<script src="scripts/processo.js"></script>
	<script src="scripts/explorer.js"></script>
	<script src="scripts/animations.js"></script>
	<script src="scripts/f2j_select_list.js"></script>
	<script src="scripts/coockies.js"></script>
	<script src="scripts/errors.js"></script>
	<script src="scripts/events.js"></script>
	<script src="scripts/math.js"></script>
	<script src="scripts/blocks.js"></script>
	<script src="scripts/menus.js"></script>
	<script src="scripts/values_to_string.js"></script>
	<script src="scripts/agenda.js"></script>
	<script src="scripts/forms.js"></script>
	<script src="scripts/save.js"></script>
	<script src="scripts/images.js"></script>
	<script src="scripts/components.js"></script>
	<script src="scripts/keyboard.js"></script>
	<script src="scripts/mascaras.js"></script>
	<script src="scripts/calc.js"></script>
	<script src="scripts/contatos.js"></script>
	<script src="scripts/clientes.js"></script>
	<script src="scripts/icons.js"></script>
	<script src="scripts/cep.js"></script>
	<script src="scripts/refresh.js"></script>
	<script src="scripts/messages.js"></script>
	<script src="scripts/onload.js"></script>
	<?
		include('inc/abas_pack.php');
	?>
	<script>
		//		COMISSÕES
		
		// function searchFilterProduct(id)
		// {
			// cod= document.getElementById('cod_filter_'+id).value.replace(/ /g, '');
			// desc= document.getElementById('desc_filter_'+id).value.replace(/ /g, '');
			// linhas= document.getElementById('tbody_'+id).childNodes;
			// if(cod != "")
			// {
				// for(i=0; i<linhas.length; i++)
				// {
					// colunas= linhas[i].getElementsByTagName('TD');
					// if(colunas[0].innerHTML.indexOf(cod) != '-1')
					// {
						// linhas[i].style.display= '';
					// }else{
							// linhas[i].style.display= 'none';
						 // }
				// }
			// }else{
					// if(desc == "")
					// {
						// for(i=0; i<linhas.length; i++)
						// {
							// linhas[i].style.display= '';
						// }
					// }
				 // }
			
			// if(desc != "")
			// {
				// desc= desc.toUpperCase();
				// for(i=0; i<linhas.length; i++)
				// {
					// colunas= linhas[i].getElementsByTagName('TD');
					// if(colunas[1].innerHTML.toUpperCase().replace(/ /g, '').indexOf(desc) != '-1')
					// {
						// if(cod == '')
							// linhas[i].style.display= '';
					// }else{
							// linhas[i].style.display= 'none';
						 // }
				// }
			// }else{
					// if(cod == "")
						// for(i=0; i<linhas.length; i++)
						// {
							// linhas[i].style.display= '';
						// }
				 // }
		// }
	</script>
	<script>
		// function atualizaLista(id,url)
		// {
			// document.getElementById(id).innerHTML= "<img src='img/loader.gif' width='100%'>";
			// onlyEvalAjax(url, 'top.setLoad(true)', 'ajax=ajax.replace(/<flp_script>/g,"");top.setLoad(false);document.getElementById("'+id+'").innerHTML="Clientes"; try{ eval(ajax); }catch(error){}');
		// }
		
		// function atualizaListaContato(id,url)
		// {
			// onlyEvalAjax(url, 'top.setLoad(true)', 'top.setLoad(false); try{ eval(ajax); }catch(error){} document.getElementById("'+id+'").innerHTML= ajax');
		// }
	</script>
	<script>
		// function excluiEventos()
		// {
			// alert('Excluir');
		// }
	</script>
</head>
<body id="corpo"
	  leftmargin="0"
	  topmargin="0"
	  onerror="return handleErr"
	  bottommargin="0"
	  rightmargin="0"
	  onselectstart="return selectStartVerify()"
	  oncontextmenu="rightBtMenu(event); return false;"
	  ondragstart="return false"
	  onhelp="return top.showHelp()"
	  style="background-image: url(img/back_body.gif);
			 background-repeat: repeat-x;
			 background-position: top;
			 background-color: #204a69;--#B4CFE5;">
	<br>
	<br>
	<div onclick="//setBlur()"
		 style="width: 100%;
				height: 100%;
				position: absolute;
				background-repeat: no-repeat;
				background-color: #204a69;
				background-position: top left;
				left: 0px;
				top: 0px;"
		 rhtmenuclass="rhtMenuBackDiv">
		<img src="img/back_body_image.jpg"
			 style="width: 100%;"><br>
	</div>
	<span style="display: none;"
		 id="hiddenDivBotoes">
		<nobr>
			<table>
				<tr>
					<!--
					<td>
						<img src="img/context_menu_block.gif"
							 onmouseover="this.src='img/context_menu_block_over.gif';
										  top.showtip(this, event, 'Menu');"
							 onmouseout="this.src='img/context_menu_block.gif'"
							 onclick="rightBtMenu(event);">
					</td>
					-->
					<td>
						<img src="img/refresh_block.gif"
							 onmouseover="this.src='img/refresh_block_over.gif';
										  top.showtip(this, event, 'Atualizar');"
							 onmouseout="this.src='img/refresh_block.gif'"
							 onclick="atualiza(this);"
							 type="reload">
					</td>
					<td>
						<img src="img/min_block.gif"
							 onmouseover="this.src='img/min_block_over.gif'
										  top.showtip(this, event, 'Minimizar');"
							 onmouseout="this.src='img/min_block.gif'"
							 onclick="minimiza(this)"
							 style="margin: 0px;
									padding: 0px;">
					</td>
					<td>
						<img src="img/max_block.gif"
							 onmouseover="this.src= this.src.replace(/.gif/, '_over.gif');
										  top.showtip(this, event, 'Maximizar');"
							 onmouseout="this.src = this.src.replace(/_over.gif/, '.gif')"
							 onclick="maximiza(this)"
							 type="max"
							 id="max_bloco"
							 style="margin: 0px;
									padding: 0px;">
					</td>
					<td>
						<img src="img/close_block.gif"
							 onmouseover="this.src='img/close_block_over.gif';
										  top.showtip(this, event, 'Fechar');"
							 onmouseout="this.src='img/close_block.gif'"
							 onclick="closeBlock(this)"
							 style="margin: 0px;
									padding: 0px;">
					</td>
				</tr>
			</table>
		</nobr>
	</span>
	<span style="display: none;"
		 id="hiddenDivBotoes_onlyClose">
		<nobr>
			<table>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<img src="img/close_alert.gif"
							 onmouseover="//this.src='img/close_block_over.gif';
										  //top.showtip(this, event, 'Fechar');"
							 onmouseout="//this.src='img/close_block.gif'"
							 onclick="closeBlock(this)"
							 style="margin: 0px;
									padding: 0px;">
					</td>
				</tr>
			</table>
		</nobr>
	</span>
	<span style="display: none;"
		 id="hiddenDivBotoes_nominimize">
		<nobr>
			<table>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						<img src="img/refresh_block.gif"
							 onmouseover="this.src='img/refresh_block_over.gif';
										  top.showtip(this, event, 'Atualizar');"
							 onmouseout="this.src='img/refresh_block.gif'"
							 onclick="atualiza(this);"
							 type="reload">
					</td>
					<td>
						<img src="img/max_block.gif"
							 onmouseover="this.src= this.src.replace(/.gif/, '_over.gif');
										  top.showtip(this, event, 'Maximizar');"
							 onmouseout="this.src = this.src.replace(/_over.gif/, '.gif')"
							 onclick="maximiza(this)"
							 type="max"
							 id="max_bloco"
							 style="margin: 0px;
									padding: 0px;">
					</td>
					<td>
						<img src="img/close_block.gif"
							 onmouseover="this.src='img/close_block_over.gif';
										  top.showtip(this, event, 'Fechar');"
							 onmouseout="this.src='img/close_block.gif'"
							 onclick="closeBlock(this)"
							 style="margin: 0px;
									padding: 0px;">
					</td>
				</tr>
			</table>
		</nobr>
	</span>
	<span style="display: none;"
		 id="hiddenDivBotoes_nomaximize">
		<nobr>
			<table>
				<tr>
					<td>
					</td>
					<td>
						<img src="img/refresh_block.gif"
							 onmouseover="this.src='img/refresh_block_over.gif';
										  top.showtip(this, event, 'Atualizar');"
							 onmouseout="this.src='img/refresh_block.gif'"
							 onclick="atualiza(this);"
							 type="reload">
					</td>
					<td>
						<img src="img/min_block.gif"
							 onmouseover="this.src='img/min_block_over.gif'
										  top.showtip(this, event, 'Minimizar');"
							 onmouseout="this.src='img/min_block.gif'"
							 onclick="minimiza(this)"
							 style="margin: 0px;
									padding: 0px;">
					</td>
					<td>
						<img src="img/close_block.gif"
							 onmouseover="this.src='img/close_block_over.gif';
										  top.showtip(this, event, 'Fechar');"
							 onmouseout="this.src='img/close_block.gif'"
							 onclick="closeBlock(this)"
							 style="margin: 0px;
									padding: 0px;">
					</td>
				</tr>
			</table>
		</nobr>
	</span>
	<div style="position: absolute;
				left: 0px;
				top: 0px;
				z-index: zMax;
				background-color: white;
				display: non;
				cursor: default;
				border: solid 1px #000000;
				font-family: Arial;
				padding: 2px;"
		 id="select_options">
		<br>
	</div>
	<span id="toolInfo"
		  style="position: absolute;
				 z-index=9;
				 display: none;
				 width: 0px;
				 white-space: nowrap;
				 background-color: #ffff99;
				 color: #333366;
				 font-size: 10px;
				 padding-right: 3px;
				 padding-left: 3px;
				 border: solid 1px #333366;
				 height: 0px;">
	</span>
	<div id="td_info_box">
	</div>
	<div id="div_lixeira"
		 style="display: none;">
		<br>
	</div>
	<iframe id="hiddenFrame"
			name="hiddenFrame"
			style="display: block;"
			frameborder="0">
	</iframe>
</body>
<script>
	// function setShadow(obj)
	// {
		/*shadowImg= document.createElement('IMG');
		shadowImg.setAttribute('style', '');
		shadowImg.setAttribute('src', 'img/right_bottom.gif');
		shadowImg.style.position= 'absolute';
		shadowImg.style.left= obj.offsetLeft + 5;
		shadowImg.style.top= obj.offsetTop + 5;
		shadowImg.style.width= obj.offsetWidth;
		shadowImg.style.height= obj.offsetHeight;
		document.getElementById('corpo').appendChild(shadowImg);
		shadowImg.style.filter= "dropshadow(color=#000000, offx=0, offy=0, positive=false)";*/
	// }
</script>
<script>
	//top.setLoad(true, 'Carregando configura&ccedil;&otilde;es pessoais...');
</script>
<?php
	include('inc/load.php')
?>
<script>
	<?php
		if($_SESSION['bl_senha'] != 1)
		{
			echo " creatBlock('Alterar Senha', 'senha_edit.php', 'dados_de_cadastro'); ";
		}
	?>
</script>
<script>
	/* function unloadding()
	{
		//alert('descarregando');
		try
		{
			top.location.href= "logoff.php";
			opener.focus();
		}catch(error){}
		top.close();
	} */
	//window.onbeforeunload= unloadding;
</script>
<script>
		function viewClientData()
		{
			//top.creatBlock('Renomear grupo de contatos ', 'renomear_grupo_agenda_contato.php?','renomear_grupo_agenda_contato', 'noresize, nomaximize'); document.getElementById('rhtGrupoAgendaContato').style.display= 'none';
		}
<?php
		$qr_select=" SELECT s_obs
					   FROM tb_logs
					  WHERE pk_logs= (
					 SELECT MAX(pk_logs)
					   FROM tb_logs
					  WHERE bl_movimento = 'out'
						AND fk_usuario = '".$_SESSION['pk_usuario']."')";
		// $data= @pg_query($db_connection, $qr_select);
		// $lastLogoff= @pg_fetch_array($data);
		// if(trim($lastLogoff['s_obs']) != '')
		// {
			//echo " top.callSideBar(1); ";
			//echo " top.showAlert('informativo', 'Detectamos que seu &uacute;ltimo logoff foi inesperado<br>Caso estivesse com alguma tarefa semi-conclu&iacute;da, verifique os <i>backups autom&aacute;ticos</i> na barra lateral'); ";
			?>
				//top.document.getElementById('autoBKP').style.display= '';
			<?php
		// }
?>
</script>