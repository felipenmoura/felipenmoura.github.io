iconToDrag= null;
function setIconeProperties(obj, objId)
{
	try
	{
		if(objIcoSelected != null)
		{
			objIcoSelected .style.backgroundColor= '';
			objIcoSelected = null;
		}
		obj.style.backgroundColor= '#dedede';
		objIcoSelected= obj;
		document.getElementById('nome_arquivo_'+objId).value = obj.getAttribute('filename');
		document.getElementById('size_arquivos_'+objId).value= obj.getAttribute('filesize')/1024 + ' Kb';
		document.getElementById('tipo_arquivo_'+objId).value = obj.getAttribute('filetype');
		document.getElementById('data_arquivo_'+objId).value = obj.getAttribute('filedate');
		
		document.getElementById('opcoes_arquivo_'+objId).style.display= '';
		document.getElementById('opcoes_arquivo_'+objId).setAttribute('fileurl', obj.getAttribute('fileurl'));
		
	}catch(error){}
}

function addShortCut(obj, arDados)
{
	if(obj)
	{
		var iconUrl= obj.getAttribute('url');
		var iconTT= obj.getAttribute('tt');
		var iconId= obj.getAttribute('id');
		var iconEspc= obj.getAttribute('especific');
		var iconTamToOpen= obj.offsetWidth+'/'+obj.offsetHeight;
		var icoImgUrl= obj.getAttribute('ico');
		var left = makeRandom(400);
		var top = makeRandom(300);
	}else{
			var iconUrl= arDados['s_url'];
			var iconTT= arDados['s_titulo'];
			var iconId= arDados['s_table_id'];
			var iconEspc= arDados['s_conf'];
			var iconTamToOpen= arDados['s_tam'];
			var icoImgUrl= arDados['s_img_src'];
			var left = arDados['i_left'];
			var top = arDados['i_top'];
		 }
	var tmpDiv= newObj('DIV');
	tmpDiv.style.cursor= 'default';
	tmpDiv.style.position= "absolute";
	tmpDiv.style.left= left;
	tmpDiv.style.top= top;
	tmpDiv.style.padding= '3px';
	tmpDiv.style.width= '75px';
	// atalho
	tmpDiv.setAttribute('type', 'ico');
	tmpDiv.setAttribute('url', iconUrl);
	tmpDiv.setAttribute('url', iconUrl);
	tmpDiv.setAttribute('tt', iconTT);
	tmpDiv.setAttribute('pos', iconUrl);
	// janela a abrir
	tmpDiv.setAttribute('urlToOpen', iconUrl);
	tmpDiv.setAttribute('ttToOpen', iconTT);
	tmpDiv.setAttribute('idToOpen', iconId);
	tmpDiv.setAttribute('especificToOpen', iconEspc);
	tmpDiv.setAttribute('tamToOpen', iconTamToOpen);
	
	tmpDiv.onmouseover= function ()
	{
		this.style.border= 'solid 1px black';
		this.style.left= this.offsetLeft-1;
		this.style.top= this.offsetTop-1;
	}
	tmpDiv.onmouseout= function ()
	{
		this.style.border= 'none';
		this.style.left= this.offsetLeft+1;
		this.style.top= this.offsetTop+1;
	}
	tmpDiv.onmousedown= function ()
	{
		iconToDrag= this;
		try
		{
			document.attachEvent("onmousemove", iconStartToDrag);
			document.attachEvent("onmouseup", iconFinishToDrag);
		}catch(error)
		{
			window.addEventListener("mousemove", iconStartToDrag, true);
			window.addEventListener("mouseup", iconFinishToDrag, true);
		}
	}
	tmpDiv.call= function ()
	{
		creatBlock(
								this.getAttribute('ttToOpen'),
								this.getAttribute('urlToOpen'),
								this.getAttribute('idToOpen'),
								this.getAttribute('especificToOpen'),
								false,
								this.getAttribute('tamToOpen')
							);
	}
	tmpDiv.ondblclick= function ()
	{
		this.call();
	}
	var divId= newId('ico');
	tmpDiv.setAttribute('id', divId);
	
	nTable= newObj('TABLE');
	nTbody= newObj('TBODY');
	nTable.id= newId('ico_table');
	nTr= newObj('TR');
	nTd= newObj('TD');
	if(!icoImgUrl)
		icoImgUrl= "little_star.gif";
	nTd.innerHTML= "<center><img src='img/"+icoImgUrl+"'><br>"+iconTT+'</center>';
	
	nTr.appendChild(nTd);
	nTbody.appendChild(nTr);
	nTable.appendChild(nTbody);
	tmpDiv.appendChild(nTable);
	tmpDiv.setAttribute("rhtmenuclass", 'rhtMenuIco');
	//tmpDiv.oncontextmenu= function (){ return false;};
	getBody().appendChild(tmpDiv);
	if(obj)
	{
		var icoToSend= new f2j_elo(tmpDiv, 'icone');
		icoToSend.sendNode('save_ico.php', callBackFunc);
	}
}

function callBackFunc(retorno)
{
	if(retorno != 'true')
		top.showAlert('alerta', 'Ocorreu um erro ao tentar salvar o &iacute;cone! Possivelmente, ele n&atilde;o aparecer&aacute; na pr&oacute;xima vez que for feito o login');
}

function deleteIco(obj)
{
	icoToSend= new f2j_elo(obj, 'icone');
	icoToSend.sendNode('del_ico.php', delIcoCallBackFunc);
	getBody().removeChild(obj);
}

function delIcoCallBackFunc(retorno)
{
	if(retorno != 'true')
		top.showAlert('alerta', 'Ocorreu um erro ao tentar excluir o &iacute;cone! Possivelmente, ele continuar&aacute; aparecendo na pr&oacute;xima vez que for feito o login');
}

function iconStartToDrag(event)
{
	iconToDrag.style.left= event.clientX - (iconToDrag.offsetWidth/2);
	iconToDrag.style.zIndex= zMax+1;
	iconToDrag.style.top= event.clientY - (iconToDrag.offsetHeight/2);
}

function iconFinishToDrag(event)
{
	var icoToSend= new f2j_elo(iconToDrag, 'icone');
	icoToSend.sendNode('save_ico.php?move=true', callBackFunc);
	iconToDrag.style.zIndex= 1;
	try
	{
		document.detachEvent("onmousemove", iconStartToDrag);
		document.detachEvent("onmouseup", iconFinishToDrag);
	}catch(error)
	{
		window.removeEventListener("mousemove", iconStartToDrag, true);
		window.removeEventListener("mouseup", iconFinishToDrag, true);
	}
	iconToDrag= null;
}






