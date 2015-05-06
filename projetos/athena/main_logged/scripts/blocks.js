/*
#	validBlocks= todas as janelas abertas atualmente
*/
validBlocks= Array();
function setSizeAtt(obj)
{
	obj.setAttribute('size', obj.offsetWidth+","+obj.offsetHeight);
}
function setPositionAtt(obj)
{
	obj.setAttribute('position', parseInt(obj.style.left)+","+parseInt(obj.style.top));
}

function getBlock(obj)
{
	while(!(obj.tagName == 'TABLE' && obj.getAttribute('bloco')))
	{
		if(obj.tagName == "BODY")
			return false;
		obj= obj.parentNode;
	}
	return obj
}

function minimiza(obj)
{
	obj= getBlock(obj);
	try
	{
		if(obj.getAttribute('drag_hability') == 'false')
		{
			//return false;
		}
	}catch(e)
	{}
	minimizeAnim(obj);
	obj.style.display= 'none';
	top.blockToBar(obj)
}

function atualiza(obj)
{
	obj= getBlock(obj);
	obj.reload();
}

function maximiza(obj)
{
	bt= obj;
	obj= getBlock(obj);
	if(parseInt(obj.style.left) == -1)
	{
		obj.setAttribute('drag_hability', 'true');
		size= obj.getAttribute('size').split(',');
		obj.style.width = size[0];
		obj.style.height= size[1];
		position= obj.getAttribute('position').split(',');
		obj.style.top	= position[1]+"px";
		obj.style.left	= position[0]+"px";
		bt.src= 'img/max_block.gif';
	}else{
			setPositionAtt(obj);
			setSizeAtt(obj);
			obj.setAttribute('drag_hability', 'false');
			obj.style.width = document.body.clientWidth - 15;
			obj.style.height= document.body.clientHeight - (maxiPadding + 22);
			obj.style.top= maxiPadding;
			obj.style.left= -1;
			bt.src= 'img/restore_block.gif';
		 }
	objTr= obj.getElementsByTagName('TR');
	objTr[2].style.display= '';
	objTr[3].style.display= '';
}
function changesVerify(obj)
{
	if(typeof obj == 'string')
		try
		{
			obj= document.getElementById(obj);
		}catch(error)
		{}
	while(!(obj.tagName == 'TABLE' && obj.getAttribute('bloco')))
	{
		if(obj.tagName == "BODY")
			return false;
		obj= obj.parentNode;
	}
	formsTypes= obj.getElementsByTagName('INPUT');
	for(i=0; i<formsTypes.length; i++)
	{
		if(formsTypes[i].getAttribute('readonly'))
		{
			return true;
		}
		if(formsTypes[i].type == 'text')
		{
			//alert(formsTypes[i].value+'\n'+formsTypes[i].getAttribute('oldValue'));
			if(formsTypes[i].getAttribute('oldValue') != null)
			{
				if(formsTypes[i].value!= formsTypes[i].getAttribute('oldValue'))
				{
					if(!confirm('Há campos alterados no formulário\nProsseguir mesmo assim?'))
					{
						return false;
					}
					break;
				}
			}else{
					if(formsTypes[i].value!= '')
					{
						if(!confirm('Há campos alterados no formulário\nProsseguir mesmo assim?'))
						{
							return false;
						}
						break;
					}
				 }
		}else{
				if(formsTypes[i].type == 'checkbox')
				{
					if(formsTypes[i].getAttribute('oldValue') != null)
					{
						if(formsTypes[i].getAttribute('oldValue') != formsTypes[i].checked)
						{
							if(!confirm('Há campos alterados no formulário\nProsseguir mesmo assim?'))
								{
									return false;
								}
								break;
						}
					}
				}else{
						if(formsTypes[i].getAttribute('oldValue') != null)
						{
							if(formsTypes[i].value!= formsTypes[i].getAttribute('oldValue'))
							{
								if(!confirm('Há campos alterados no formulário\nProsseguir mesmo assim?'))
								{
									return false;
								}
								break;
							}
						}
					 }
			 }
	}
	//alert(formsTypes[i].id);
	return true;
}
function closeBlock(obj, conf)
{
	if(typeof obj == 'string')
		try
		{
			obj= document.getElementById(obj);
		}catch(error)
		{}
	while(!(obj.tagName == 'TABLE' && obj.getAttribute('bloco')))
	{
		if(obj.tagName == "BODY")
			return false;
		obj= obj.parentNode;
	}
	// verifica alterações
	if(!conf)
		if(!changesVerify(obj))
			return false;
	if(top.document.getElementById(obj.id))
	{
		top.document.body.removeChild(document.getElementById(obj.id));
	}
	try
	{
		obj.onunload();
	}catch(error)
	{
	}
	//	fadeOut(obj.id);
	closeAnim(obj.id);
	top.removeApp(obj.id);
	if(parent)
	{
		ar_opened_blocks=document.getElementsByTagName('TABLE');
	}else{
			c.ar_opened_blocks=document.getElementsByTagName('TABLE');
		 }
	zM= -1;
	zMO= null;
	top.status= '';
	delete validBlocks[obj.id];
	return true;
}		

function setToolInfo(obj)
{
	document.getElementById('toolInfo').style.top= window.event.clientY + 20;
	document.getElementById('toolInfo').style.left= window.event.clientX - 10;
	document.getElementById('toolInfo').style.zIndex= zMax+1;
	document.getElementById('toolInfo').style.display= '';
	document.getElementById('toolInfo').innerHTML= obj.offsetWidth + " / "+ obj.offsetHeight;
}

function resize(direction, obj, event)
{
	obj= getBlock(obj);
	try
	{
		if(obj.getAttribute('drag_hability') == 'false')
		{
			return false;
		}
	}catch(e)
	{}
	ob_block_to_resize= obj;
	s_block_to_resize_direction= direction;
	setToolInfo(obj);
	try
	{
		document.attachEvent('onmousemove', blockResize);
		document.attachEvent('onmouseup', setBlockSize);
	}
	catch(error)
	{
		document.addEventListener('mousemove', blockResize, true);
		document.addEventListener('mouseup', setBlockSize, true);
	}
	//document.body.style.cursor= 'nw-resize';
	cancelEvent(event);
}
		
function setBlockSize()
{
	document.getElementById('toolInfo').style.top= event.clientY;
	document.getElementById('toolInfo').style.left= event.clientX;
	document.getElementById('toolInfo').style.display= 'none';
	try
	{
		document.detachEvent('onmousemove', blockResize);
		document.detachEvent('onmouseup', setBlockSize);
	}
	catch(error)
	{
		document.removeEventListener('mousemove', blockResize, true);
		document.removeEventListener('mouseup', setBlockSize, true);
	}
	start_position_l	= null;
	start_size_w		= null;
	document.body.style.cursor= '';
}

function blockResize(event)
{
	setToolInfo(ob_block_to_resize);
	if(s_block_to_resize_direction == 'nw')
	{
		//alert("  "+event.clientX + "\n- "+parseInt(ob_block_to_resize.style.left)+"\n" + (event.clientX - parseInt(ob_block_to_resize.style.left)))
		try
		{
			w= (event.clientX - parseInt(ob_block_to_resize.style.left)) + 4;
			h= (event.clientY - parseInt(ob_block_to_resize.style.top)) + 4;
			ob_block_to_resize.style.width= w;
			ob_block_to_resize.style.height= h;
		}
		catch(error)
		{}
		return false;
	}
	if(s_block_to_resize_direction == 'wR')
	{
		//alert("  "+event.clientX + "\n- "+parseInt(ob_block_to_resize.style.left)+"\n" + (event.clientX - parseInt(ob_block_to_resize.style.left)))
		try
		{
			w= (event.clientX - parseInt(ob_block_to_resize.style.left)) + 4;
			//h= (event.clientY - parseInt(ob_block_to_resize.style.top)) + 4;
			ob_block_to_resize.style.width= w;
			//ob_block_to_resize.style.height= h;
		}
		catch(error)
		{}
		return false;
	}
	if(s_block_to_resize_direction == 's')
	{
		//alert("  "+event.clientX + "\n- "+parseInt(ob_block_to_resize.style.left)+"\n" + (event.clientX - parseInt(ob_block_to_resize.style.left)))
		try
		{
			//w= (event.clientX - parseInt(ob_block_to_resize.style.left)) + 4;
			h= (event.clientY - parseInt(ob_block_to_resize.style.top)) + 4;
			//ob_block_to_resize.style.width= w;
			ob_block_to_resize.style.height= h;
		}
		catch(error)
		{}
		return false;
	}
}

function setBlur()
{
	obj= blockInFocus;	//	blockInFocus é uma global
	if(obj == null)
		return false;
	//alert('setando blur de '+obj.id);
	try
	{
		objSelectLists= obj.getElementsByTagName('select');
		for(i=0; i< objSelectLists.length; i++)
		{
			objSelectLists[i].style.visibility= 'hidden';
		}
	}catch(error)
	{}
	
	titleObj= obj.getElementsByTagName('TR');
	titleObj= titleObj[0];
	titleCells= titleObj.getElementsByTagName('TD');
	titleCells[0].innerHTML="<img src='img/left_top_blue_blur.gif'><br>";
	titleCells[1].style.backgroundImage="url(img/top_blue_blur.gif)";
	titleCells[2].className='title_blur';
	titleCells[titleCells.length-1].innerHTML="<img src='img/right_top_blue_blur.gif'><br>";
	
	blockInFocus= null;
	return
}

function setFocus(obj)
{
	try
	{
		if(vLocker.style.display != 'none')	//	verifica se as acoes estao bloqueadas
			return false;
	}catch(error){}
	if (blockInFocus != null)
		setBlur();
	if(!obj)
		obj= this;
	obj.style.zIndex= zMax+1;
	top.status= obj.getAttribute('tt');
	//alert('setando focus de '+obj.id);
	try
	{
		objSelectLists= obj.getElementsByTagName('select');
		for(i=0; i< objSelectLists.length; i++)
		{
			objSelectLists[i].style.visibility= 'visible';
		}
	}catch(error)
	{}
	
	zMax++;
	
	titleTr= obj.getElementsByTagName('TR');
	titleTr= titleTr[0];
	titleCells= titleTr.getElementsByTagName('TD');
	titleCells[0].innerHTML="<img src='img/left_top_blue_focus.gif'><br>";
	titleCells[1].style.backgroundImage="url(img/top_blue_focus.gif)";
	titleCells[2].className='title';
	titleCells[titleCells.length-1].innerHTML="<img src='img/right_top_blue_focus.gif'><br>";
	
	blockInFocus= obj;
	top.blockInFocus= obj;
	cancelEvent();
}

function setBlockSubMenu(obj)
{
	objPai= getBlock(obj);
	document.getElementById(objPai.getAttribute('blockSubMenu')).style.left= obj.offsetLeft;
	document.getElementById(objPai.getAttribute('blockSubMenu')).style.left= obj.offsetTop + obj.offsetHeight;
	document.getElementById(objPai.getAttribute('blockSubMenu')).style.display= '';
}

function startResizing(event)
{
	resize(this.getAttribute('direction'), this)
}

function setMaximizeOnBar(event)
{
	imgM= this.getElementsByTagName('img');
	for(imgCounter=0; imgCounter< imgM.length; imgCounter++)
	{
		if(imgM[imgCounter].getAttribute('type') == 'max')
		{
			maximiza(imgM[imgCounter]);
			return;
		}
	}
}
function creatBlock(tt, src, id, especific, pos, tam, zInd)
{
	if(!id)
	{
		dt= new Date();
		id= dt.getTime();
		id= 'table_block_'+id;
		execContinue= true;
	}else{
			if(document.getElementById('table_block_'+id))
			{
				if(top.document.getElementById('table_block_'+id))
					top.document.getElementById('table_block_'+id).click();
				zMax++;
				document.getElementById('table_block_'+id).style.zIndex= zMax+1;
				document.getElementById('table_block_'+id).style.border= 'solid 3px #000000';
				document.getElementById('table_block_"+id+"').style.left= parseInt(document.getElementById('table_block_'+id).style.left)-2;
				document.getElementById('table_block_"+id+"').style.top= parseInt(document.getElementById('table_block_'+id).style.top)-2;
				setTimeout("document.getElementById('table_block_"+id+"').style.border= 'hidden'; document.getElementById('table_block_"+id+"').style.left= parseInt(document.getElementById('table_block_"+id+"').style.left)+2; document.getElementById('table_block_"+id+"').style.top= parseInt(document.getElementById('table_block_"+id+"').style.top)+2;", 100);
				setTimeout("document.getElementById('table_block_"+id+"').style.border= 'solid 3px #000000'; document.getElementById('table_block_"+id+"').style.left= parseInt(document.getElementById('table_block_"+id+"').style.left)-2; document.getElementById('table_block_"+id+"').style.top= parseInt(document.getElementById('table_block_"+id+"').style.top)-2;", 200);
				setTimeout("document.getElementById('table_block_"+id+"').style.border= 'hidden'; document.getElementById('table_block_"+id+"').style.left= parseInt(document.getElementById('table_block_"+id+"').style.left)+2; document.getElementById('table_block_"+id+"').style.top= parseInt(document.getElementById('table_block_"+id+"').style.top)+2;", 300);
				zMax++;
				execContinue= false;
				return false;
			}else{
					try
					{
						if(document.getElementById(id))
						{
							if(top.document.getElementById(id))
								top.document.getElementById(id).click();
							zMax++;
							document.getElementById(id).style.zIndex= zMax+1;
							document.getElementById(id).style.border= 'solid 2px #000000';
							document.getElementById(id).style.left= parseInt(document.getElementById(id).style.left)-2;
							document.getElementById(id).style.top= parseInt(document.getElementById(id).style.top)-2;
							setTimeout("document.getElementById('"+id+"').style.border= 'none'; document.getElementById('"+id+"').style.left= parseInt(document.getElementById('"+id+"').style.left)+2; document.getElementById('"+id+"').style.top= parseInt(document.getElementById('"+id+"').style.top)+2;", 100);
							setTimeout("document.getElementById('"+id+"').style.border= 'solid 2px #000000';document.getElementById('"+id+"').style.left= parseInt(document.getElementById('"+id+"').style.left)-2; document.getElementById('"+id+"').style.top= parseInt(document.getElementById('"+id+"').style.top)-2;", 200);
							setTimeout("document.getElementById('"+id+"').style.border= 'none'; document.getElementById('"+id+"').style.left= parseInt(document.getElementById('"+id+"').style.left)+2; document.getElementById('"+id+"').style.top= parseInt(document.getElementById('"+id+"').style.top)+2;", 300);
							//alert(getBlock(document.getElementById(id)));
							zMax++;
							execContinue= false;
							return false;
						}
					}catch(error)
					{}
					execContinue= true;
				 }
		 }
	if(!tam)
		tam= "350/280";
	if(execContinue == true)
	{
		/*	Criando a tabela externa	*/
		table= document.createElement('TABLE');
		table.setAttribute("tt", tt);
		table.setAttribute("style", '');
		table.style.position= 'absolute';
		
		if(!pos)
		{
			table.style.left= makeRandom(400)+'px';
			table.style.top= makeRandom(300)+'px';
		}else{
				pos= pos.split('/');
				table.style.left= pos[0]+'px';
				table.style.top= pos[1]+'px';
			 }
		zMax++;
		validBlocks[id]= table;;
		table.setAttribute("bloco", 'true');
		table.setAttribute("id", id);
		table.setAttribute("tt", tt);
		table.setAttribute("rhtmenuclass", 'rhtMenuTitleTable');
		table.setAttribute("url", src);
		table.onmousedown= setFocus;
		table.setFocus= setFocus;
		if(especific)
		{
			table.setAttribute('especific', especific);
			//	especific = noresize, nominimize, nomaximize, translucent, nodragable
			especific= especific.replace(/ /g, '');
			especific= especific.split(',')
			for(i=0; i<especific.length;i++)
			{
				switch(especific[i])
				{
					case 'noresize':
						{
							table.setAttribute("noresize", 'true');
							break;
						}
					case 'nominimize':
						{
							table.setAttribute("nominimize", 'true');
							break;
						}
					case 'nomaximize':
						{
							table.setAttribute("nomaximize", 'true');
							break;
						}
					case 'translucent':
						{
							table.setAttribute("translucent", 'true');
							break;
						}
					case 'nodragable':
						{
							table.setAttribute("nodragable", 'true');
							break;
						}
					default:
						{
							break;
						}
				}
			}
		}else{
				table.setAttribute('especific', 'false');
			 }
		tBody= document.createElement('TBODY');
			/*  Primeira linha   */
			tr= document.createElement('TR');
				tr.setAttribute("style", '');
				tr.style.cursor= 'default';
				tr.style.height= '20px';
				tr.ondblclick= setMaximizeOnBar;
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
					if(!table.getAttribute('nominimize') && !table.getAttribute('nomaximize'))
						container+= document.getElementById('hiddenDivBotoes').innerHTML;
					else if(table.getAttribute('nominimize') && table.getAttribute('nomaximize'))
							{
								container+= document.getElementById('hiddenDivBotoes_onlyClose').innerHTML;
							}else   if (table.getAttribute('nominimize'))
									{
										container+= document.getElementById('hiddenDivBotoes_nominimize').innerHTML;
									}else{
											container+= document.getElementById('hiddenDivBotoes_nomaximize').innerHTML;
										 }
					tdCt.innerHTML= "<table width='100%' bgclor='red' cellpadding='0' cellspacing='0'> <tr> <td style='font-weight: bold; font-size: 14px; text-align: left;' id='title_"+id+"'>"+(tt.substring(0,30)+((tt.length>40)? '...':''))+"</td><td id='botoes_"+id+"' style='padding-left: 8px; text-align: right;'>"+ container +"</td> </tr> </table>"
				tdRt= document.createElement('TD');
					tdRt.setAttribute("style", '');
					tdRt.style.width= '12px';
					tdRt.style.filter="progid:DXImageTransform.Microsoft.Alpha( Opacity=100, FinishOpacity=30, Style=1, StartX=35,  FinishX=80, StartY=50, FinishY=50)";
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
					// tdCt.style.backgroundImage= 'url(img/back_gray.jpg)';
					// tdCt.style.backgroundRepeat= 'no-repeat';
					// tdCt.style.backgroundPosition= 'center';
					// tdCt.style.verticalAlign= 'top';
					tdCt.setAttribute('id', 'blockInner_'+id);
					tdCt.innerHTML= "<center><br><img src='img/loader2.gif'><br></center>";
					
				tdRt= document.createElement('TD');
					tdRt.setAttribute('style', '');
					tdRt.style.backgroundImage= 'url(img/right.gif)';
					//tdRt.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader";
					tdRt.style.filter="progid:DXImageTransform.Microsoft.Alpha( Opacity=100, FinishOpacity=30, Style=1, StartX=35,  FinishX=80, StartY=50, FinishY=50)";
					tdRt.style.backgroundRepeat= 'repeat-y';
					if (!table.getAttribute('noresize'))
					{
						tdRt.style.cursor= 'w-resize';
						tdRt.setAttribute('direction', 'wR');
						tdRt.onmousedown= startResizing;
					}
			tr.appendChild(tdLt);
			tr.appendChild(tdCt);
			tr.appendChild(tdRt);
			
		tBody.appendChild(tr);
		
		
		/*  Terceira linha   */
			tr= document.createElement('TR');
				tr.setAttribute("style", '');
				tr.style.cursor= 'default';
				tr.style.height='5px';
				// celulas
				tdLt= document.createElement('TD');
					tdLt.setAttribute('style', '');
					tdLt.style.width= '7px';
					tdLt.style.height= '12px';
					tdLt.style.verticalAlign=" top";
					tdLt.innerHTML= "<img src='img/left_bottom.gif'><br>";
					tdLt.style.filter="progid:DXImageTransform.Microsoft.Alpha( Opacity=100, FinishOpacity=0, Style=1, StartX=50,  FinishX=50, StartY=30, FinishY=100)";
					
				tdCt= document.createElement('TD');
					tdCt.setAttribute("style", '');
					tdCt.style.backgroundImage= 'url(img/bottom.gif)';
					tdCt.style.backgroundRepeat= 'repeat-x';
					tdCt.style.height= '16px';
					tdCt.style.filter="progid:DXImageTransform.Microsoft.Alpha( Opacity=100, FinishOpacity=0, Style=1, StartX=50,  FinishX=50, StartY=30, FinishY=100)";
					if (!table.getAttribute('noresize'))
					{
						tdCt.style.cursor= 's-resize';
						tdCt.setAttribute('direction', 's')
						tdCt.onmousedown= startResizing;
					}
				
				tdRt= document.createElement('TD');
					tdRt.setAttribute('style', '');
					tdRt.style.backgroundImage= 'url(img/right_bottom.gif)';
					tdLt.style.width= '7px';
					tdLt.style.height= '16px';
					tdRt.style.backgroundRepeat= 'repeat-y';
					tdRt.style.filter="progid:DXImageTransform.Microsoft.Alpha( Opacity=100, FinishOpacity=0, Style=1, StartX=50,  FinishX=50, StartY=30, FinishY=100) progid:DXImageTransform.Microsoft.Alpha( Opacity=100, FinishOpacity=30, Style=1, StartX=35,  FinishX=80, StartY=50, FinishY=50)";
					
					if (!table.getAttribute('noresize'))
					{
						tdRt.style.cursor= 'nw-resize';
						tdRt.setAttribute('direction', 'nw');
						tdRt.onmousedown= startResizing;
					}
					
			tr.appendChild(tdLt);
			tr.appendChild(tdCt);
			tr.appendChild(tdRt);
			
		tBody.appendChild(tr);

		table.appendChild(tBody);
		top.addApp(table.id, tt);
		table.style.display= 'none';
		document.getElementById('corpo').appendChild(table);
		

		onlyEvalAjax(src, '', "ajax= ajax.split('<flp_script>'); document.getElementById('blockInner_"+id+"').innerHTML= ajax[0]; try{ eval(ajax[1]); }catch(e){}; verify('table_"+id+"');"); // , table.id);
		document.getElementById(id).reload= function ()
		{
			/* if(!changesVerify(obj))
				return false; */
			imgM= this.getElementsByTagName('img');
			imgCounter=0;
			for(imgCounter=0; imgCounter< imgM.length; imgCounter++)
			{
				if(imgM[imgCounter].getAttribute('type') == 'reload')
				{
					imgM[imgCounter].src= 'img/loader_little.gif';
					break;
				}
			}
			onlyEvalAjax(src,
						 '',
						 "ajax= ajax.split('<flp_script>'); document.getElementById('blockInner_"+id+"').innerHTML= ajax[0]; try{ eval(ajax[1]); }catch(e){}; verify('table_"+id+"'); getBlock(document.getElementById('blockInner_"+id+"')).getElementsByTagName('img')["+imgCounter+"].src= 'img/refresh_block.gif'; ");
		}
		if(tam)
		{
			tam= tam.split('/');
			table.style.width= tam[0];
			table.style.height= tam[1];
		}
		if(table.getAttribute('translucent'))
			setOpacity(table.id, '75');
		if(zInd)
		{
			table.style.zIndex= zInd;
			if(zInd >= zMax)
				zMax= zInd+1;
		}else{
				zMax++;
				table.style.zIndex= zMax;
			 }
		// if(blockShadow == true)
			// setShadow(table);
		if(!table.getAttribute('nodragable'))
		{
			// if(blockShadow == true)
			// {
				// dragavel= table.id;
			// }else
				dragavel= table.id;
			flp_makeItDragable(dragavel, 'title_'+id+', botoes_'+id);
			//flp_makeItDragable(dragavel, dragavel);
		}
	}
	//ar_opened_blocks.push(table);
	//table.setAttribute('arrayPosition', ar_opened_blocks.length-1);
	setBlur();
	openAnim(table);
	setFocus(table);
	table.onunload= '';
	//PNGTransparent();
	return table;
}

function verify(objId)
{
	obj= document.getElementById(objId);
	if(obj == null)
	{
		obj= document.getElementById(objId.replace(/table_/, ''));
	}
	h= obj.offsetHeight;
	w= obj.offsetWidth;
	t= obj.offsetTop;
	l= obj.offsetLeft;
	//alert(l+" + " + w + '= '+ (l+w)+'\n'+document.body.clientWidth)
	if((l + w) > document.body.clientWidth)
	{
		obj.style.width= w- (((w+l) - document.body.clientWidth)+10)// (document.body.clientHeight - 40) - l;
	}
	if((t + h) > document.body.clientHeight)
	{
		obj.style.height= (document.body.clientHeight - 80) - t;
	}
	filterSelectElements(obj);
	//obj.style.overflow= 'auto';
}

function getBlocks()
{
	blockArrayToSave= document.getElementsByTagName('table');
	blockArrayToSaveTmp= Array();
	for(i=0; i<blockArrayToSave.length; i++)
	{
		if( blockArrayToSave[i].getAttribute('bloco')
			||
			blockArrayToSave[i].id.indexOf('table_block_') != -1
		  )
		{
			blockArrayToSaveTmp.push(blockArrayToSave[i]);
		}
	}
	delete blockArrayToSave;
	blockArrayToSave= "";
	blockArrayToSave= Array();
	blockArrayToSave= blockArrayToSaveTmp;
	delete blockArrayToSaveTmp;
	return blockArrayToSave;
}