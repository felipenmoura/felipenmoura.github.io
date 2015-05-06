<table id="sideBar"
	   style="position: absolute;
			  right: 0px;
			  top: 0px;
			  z-index: 9998;
			  height: 100%;"
		cellpadding="0"
		cellspacing="0"
		onmousedown="">
		<tr>
			<td style="background-image: url(img/sidebar_back_menu_left.gif);
					   background-repeat: repeat-y;
					   background-position: right;">
				<br>
			</td>
			<td style="background-color: #ebebeb;
					   padding-left: 8px;"
				rowspan="3">
				<div id="sideBarContent"
					 style="width: 200px;
							height: 100%;
							overflow: auto;">
					<span style="text-align: center;
								 width: 100%;
								 padding-top: 4px;">
						Barra lateral
					</span>
					<br>
					<center>
						<select onchange="document.getElementById('divRelogios').innerHTML=this.value">
							<option value='<embed style="" src="http://www.relojesflash.com/swf/6.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Padrão
							</option>
							<!--
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock2001.swf" wmode="transparent" type="application/x-shockwave-flash" height="150" width="150"><param name=wmode value=transparent></embed>'>
								Contador
							</option>
							-->
							<option value='<embed style="" src="http://www.relojesflash.com/swf/3.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Simples I
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock82.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Simples II
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock2009.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Simples III
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/8.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Robusto
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock40.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Clássico
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock38.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Neutro
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock17.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Esporte I
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock73.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Esporte II
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock76.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Esporte III
							</option>
							<option value='<embed style="" src="http://www.relojesflash.com/swf/clock102.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed>'>
								Antigo
							</option>
						</select>
						<br>
					</center>
					<div id="divRelogios"
						 style="width: 100%;
								text-align: center;">
						<embed style=""
							   src="http://www.relojesflash.com/swf/6.swf"
							   wmode="transparent"
							   type="application/x-shockwave-flash"
							   height="100"
							   width="100">
							<param name=wmode
								   value=transparent>
						</embed>
					</div>
					<!--
						CONTEUDOS
					-->
					<br>
					<table>
						<tbody id="sideBarMsg">
						</tbody>
					</table>
					<div id="autoBKP"
						 style="display: none;">
						<br>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td style="padding-top: 3px;
					   background-image: url(img/sidebar_back_menu.gif);
					   background-repeat: no-repeat;
					   background-position: right top;
					   height: 110px;
					   padding: 0px;
					   margin: 0px;
					   text-align: right;">
				<img id="btSideBar"
					 src="img/bt_contract_sidebar.gif"
					 style="cursor: pointer;
							padding: 0px;
							margin: 0px;
							height: 100%;
							width: 21px;"
					 titulo="Contrair barra lateral"
					 onmouseover="showtip(this, event, this.getAttribute('titulo'))"
					 onclick="showHiddeSideBar(this);">
			</td>
		</tr>
		<tr>
			<td style="background-image: url(img/sidebar_back_menu_left.gif);
					   background-repeat: repeat-y;
					   background-position: right;">
				<br>
			</td>
		</tr>
	</table>
	<script>
		function sideBarAdd(tt, msg)
		{
				tb= document.createElement('TABLE');
				tb.setAttribute('style', '');
				tb.style.width= '180px';
				tb.style.border= 'solid 1px #000000';
					tr= document.createElement('TR');
						td= document.createElement('TD');
							td.setAttribute('style', '');
							td.style.background= 'red';
							td.style.paddingLeft= '7px';
							td.style.paddingRight= '7px';
							td.style.color= 'white';
							td.style.height= '20px';
							conteudo= '<span style="float: left;">'+tt+'</span>';
							conteudo+='<span style="float: right; cursor: pointer;" ';
							conteudo+='onclick="this.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode);">';
							conteudo+='<b>X</b></span>';
							td.innerHTML= conteudo;
					tr.appendChild(td);
					tr2= document.createElement('TR');
						td2= document.createElement('TD');
							td2.setAttribute('style', '');
							td2.style.background= '#fffff0';
							td2.style.color= '#000000';
							td2.style.padding= '15px';
							td2.innerHTML= msg;
					tr2.appendChild(td2);
				tb.appendChild(tr);
				tb.appendChild(tr2);
			trPai= document.createElement('TR');
				tdPai= document.createElement('TD');
			tdPai.appendChild(tb);
			trPai.appendChild(tdPai);
			document.getElementById('sideBarMsg').parentNode.parentNode.innerHTML+= '<center>'+tb.outerHTML+'<center>';
			// document.getElementById('sideBarMsg').style.backgroundColor= 'red';
			// document.getElementById('sideBarMsg').appendChild(trPai);
			//document.getElementById('sideBarContent').innerHTML+='<br><br><br><br>teste<br>a<hr>';
		}
	</script>
	<script>
		function slideSideBar(param)
		{
			document.getElementById('sideBar').setAttribute('animating', 'true');
			if(param == '-')
			{
				document.getElementById('sideBar').style.right= parseInt(document.getElementById('sideBar').style.right)-10;
				if(parseInt(document.getElementById('sideBar').style.right) + document.getElementById('sideBarContent').offsetWidth >= 0)
					setTimeout("slideSideBar('"+param+"')", 1);
				else{
						document.getElementById('sideBar').setAttribute('animating', 'false');
					}
			}else{
					document.getElementById('sideBar').style.right= parseInt(document.getElementById('sideBar').style.right)+20;
					if(parseInt(document.getElementById('sideBar').style.right) < 0)
						setTimeout("slideSideBar('"+param+"')", 10);
					else{
							document.getElementById('sideBar').style.right= '0px';
							document.getElementById('sideBar').setAttribute('animating', 'false');
							document.getElementById('sideBarContent').style.visibility= 'visible';
						}
				 }
		}
		function showHiddeSideBar()
		{
			if(document.getElementById('sideBar').getAttribute('animating') == 'true')
				return false;
			if(document.getElementById('sideBar').getAttribute('hidde') == 'true')
			{
				//	aparece
				slideSideBar('+')
				document.getElementById('sideBar').setAttribute('hidde', 'false');
				//document.getElementById('sideBarContent').style.display= '';
				document.getElementById('btSideBar').src="img/bt_contract_sidebar.gif";
				document.getElementById('btSideBar').titulo='Contrair barra lateral';
			}else{
					// some
					slideSideBar('-')
					document.getElementById('sideBar').setAttribute('hidde', 'true');
					//document.getElementById('sideBarContent').style.display= 'none';
					document.getElementById('sideBarContent').style.visibility= 'hidden';
					document.getElementById('btSideBar').src="img/bt_expand_sidebar.gif";
					document.getElementById('btSideBar').titulo='Expandir barra lateral';
				 }
		}
		/*
			funcao que faz o botao da barra lateral piscar em vermelho
		*/
		function callSideBar(val)
		{
			if(document.getElementById('sideBar').style.right!= '0px')
			{
				if(val == 1)
				{
					document.getElementById('btSideBar').src='img/bt_expand_sidebar_call.gif';
					setTimeout("callSideBar(0);", 500);
				}else{
						document.getElementById('btSideBar').src='img/bt_expand_sidebar.gif';
						setTimeout("callSideBar(1);", 500);
					 }
			}
		}
		setOpacity('sideBar', 75);
		//setTimeout("callSideBar(0);", 5000);
	</script>