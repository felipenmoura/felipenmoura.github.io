
//var vLocker= null;

function addLocker()
{
	//	bloqueia as acoes do usuario, com o mouse
	vLocker= document.createElement('DIV');
	vLocker.setAttribute('id', 'locker');
	vLocker.setAttribute('style', '');
	vLocker.innerHTML= "<br>";
	vLocker.style.position= 'absolute';
	vLocker.style.left= '0px';
	vLocker.style.top= '0px';
	vLocker.oncontextmenu= function (){ return false; };
	vLocker.onclick= function (){ return false; };
	vLocker.style.backgroundColor= '#000000';
	vLocker.style.width= '100%';
	vLocker.style.height= '100%';
	vLocker.style.zIndex= zMax+99;
	document.body.appendChild(vLocker);
	setOpacity('locker', '50');
	vLocker.style.display= 'none';
}

function explore(obj, tipo)
{
	objSelectLists= obj.getElementsByTagName('SELECT');
	for(i=0; i< objSelectLists.length; i++)
	{
		objSelectLists[i].style.display= 'none';
	}
	vLocker.style.display= '';
	vLocker.style.zIndex= zMax+50;
	if(tipo == 'contato')
		url= 'explorerContato_tool';
	else if(tipo == 'filial')
			url= 'explorerFilial_tool';
		 else
			url= 'explorer_tool';
	expl= creatBlock('Explorador', url+'.php?explorerReturn='+tipo, 'explorer_tool', 'noresize, nominimize, nomaximize, nodragable', ((((document.body.clientWidth/2)-(350/2))+'/'+((document.body.clientHeight/2)-(450/2)))), '350/450');
	expl.style.zIndex= zMax+51;
	expl.onunload= function ()
	{
		vLocker.style.display= 'none';
		setFocus(expl.opener);
	}
	expl.returnType= tipo;
	expl.opener= getBlock(obj);
	expl.openerInput= obj;
}

function exploreFunc(obj)
{
	objSelectLists= obj.getElementsByTagName('SELECT');
	for(i=0; i< objSelectLists.length; i++)
	{
		objSelectLists[i].style.display= 'none';
	}
	vLocker.style.display= '';
	vLocker.style.zIndex= zMax+50;
	expl= creatBlock('Explorador', 'explorerFunc_tool.php?explorerReturn=funcionario,cliente', 'explorer_tool', 'noresize, nominimize, nomaximize, nodragable', ((((document.body.clientWidth/2)-(350/2))+'/'+((document.body.clientHeight/2)-(450/2)))), '350/450');
	expl.style.zIndex= zMax+51;
	expl.onunload= function ()
	{
		vLocker.style.display= 'none';
		setFocus(expl.opener);
	}
	expl.returnType= 'funcionario, cliente';
	expl.opener= getBlock(obj);
	expl.openerInput= obj;
}

function retornaSelecao(obj)
{
	// (id, label, parentElement, code, tipo, cliente)
	obj= getBlock(obj);
	obj.returnType= obj.returnType.replace(/ /g, '')
	ar_tiposPermitidos= obj.returnType;
	//ar_tiposPermitidos= ar_tiposPermitidos.replace(/ /g, '');
	ar_tiposPermitidos= obj.returnType.split(',');
	retorna= false;
	if(!selectedNode)
		return false;
	for(i=0; i<ar_tiposPermitidos.length; i++)
	{
		//alert(ar_tiposPermitidos[i] + '\n' + selectedNode.getAttribute('tipo'))
		if(ar_tiposPermitidos[i] == selectedNode.getAttribute('tipo'))
			retorna= true;
	}
	if(retorna!= true)
	{
		top.showAlert('alerta', 'Selecione um(a) '+ obj.returnType.replace(/,/g, ' ou ') + ' para retornar')
		return false;
	}
	targetCode= document.getElementById(obj.openerInput.getAttribute('target'));
	targetReturn= obj.openerInput;
	
	targetCode.value  = selectedNode.getAttribute('code')+'|+|'+selectedNode.getAttribute('tipo')+'|+|'+selectedNode.getAttribute('cliente');
	valueReturn= selectedNode.innerHTML;
	valueReturn= (valueReturn.length > 17)? valueReturn.substring(0,14)+'...' : valueReturn;
	targetReturn.value= valueReturn;
	targetReturn.setAttribute('code', selectedNode.getAttribute('code'));
	targetReturn.setAttribute('tipo', selectedNode.getAttribute('tipo'));
	targetReturn.setAttribute('cliente', selectedNode.getAttribute('cliente'));
	targetReturn.setAttribute('alt', selectedNode.innerHTML);
	
	closeBlock(obj);
	
	setFocus(getBlock(targetReturn));
}

function exploreLineAdd(parentObj)
{
	parentObj= (parentObj.tagName)? parentObj: document.getElementById(parentObj);
	modelLine= parentObj.firstChild;
	newLine= modelLine.cloneNode(true);
	iptsTemp=  newLine.getElementsByTagName('INPUT');
	lengthTemp= modelLine.parentNode.getElementsByTagName('TR').length;
	for(i=0; i<iptsTemp.length; i++)
	{
		if(iptsTemp[i].id)
			iptsTemp[i].setAttribute('id', iptsTemp[i].id + lengthTemp);
		if(iptsTemp[i].getAttribute('target'))
			iptsTemp[i].setAttribute('target', iptsTemp[i].target+lengthTemp);
		
		if(iptsTemp[i].type == 'button' && iptsTemp[i].value.replace(/ /g, '') == '+')
		{
			iptsTemp[i].value= '-';
			iptsTemp[i].onclick= function (){ if(confirm('Tem certeza que deseja remover este ítem da lista ?')) this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); }
		}else if(iptsTemp[i].type == 'hidden' || iptsTemp[i].type == 'text')
					iptsTemp[i].value= 'Selecione...';
	}
	parentObj.appendChild(newLine);
}

//	metodos para o resize de objetos
var toResize= Array();
	toResize['element']= '';
	toResize['block']= '';
	toResize['startWidth']= '';
	toResize['startLeft']= '';
function resizeInnerObject(event)
{
	/*
	toResize.style.position= 'absolute';
	toResize.style.left= event.clientX;
	toResize.style.top= event.clientY;
	*/
	if((X= event.clientX- toResize['startLeft']) >10 && X < (toResize['block'].offsetWidth - 50))
		toResize['element'].style.width= X; //event.clientX- toResize['startLeft'];
}

function finishResizeInnerObject(event)
{
	toResize= Array();
	toResize['element']= '';
	toResize['block']= '';
	toResize['startWidth']= '';
	toResize['startLeft']= '';
	document.detachEvent('onmousemove', resizeInnerObject);
	document.detachEvent('onmouseup', finishResizeInnerObject);
}

function resizeDiv(divId)
{
	toResize['element']= document.getElementById(divId);
	toResize['block']= getBlock(toResize['element']);
	el= toResize['element'];
	x = el.offsetLeft
	while(el != toResize['block'])
	{
		el= el.parentNode;
		x= parseInt(x)+el.offsetLeft;
	}
	toResize['startLeft']= x;
	document.attachEvent('onmousemove', resizeInnerObject);
	document.attachEvent('onmouseup', finishResizeInnerObject);
}

function searchProcessolist(val, objeto, parentLi)
{
	todas= objeto.firstChild.getElementsByTagName('SPAN');
	liTmp= Array();
	if(val.replace(/ /g, '') != '')
		for(i=0; i<todas.length; i++)
		{
			if(todas[i].getAttribute('tipo') == 'busca')
			{
				break;
			}
			if(todas[i].outerText.toUpperCase().indexOf(val.toUpperCase()) != -1 && todas[i].getAttribute('tipo'))
				liTmp.push(todas[i]);
		}
	liAtual= document.getElementById(parentLi).parentNode.getElementsByTagName('LI')
	if(liAtual.length>1)
	{
		liToRemove= Array();
		for(i=1; i<liAtual.length; i++)
		{
			liToRemove.push(liAtual[i]);
		}
		for(i=0; i<liToRemove.length; i++)
		{
			document.getElementById('div_lixeira').appendChild(liToRemove[i]);
		}
	}
		document.getElementById('div_lixeira').innerHTML= '';
	for(i=0; i<liTmp.length; i++)
	{
		objeto.objList.addNode( liTmp[i].id+'_searched',
						liTmp[i].getAttribute('text'),
						parentLi,
						liTmp[i].getAttribute('code'),
						liTmp[i].getAttribute('tipo'),
						liTmp[i].getAttribute('cliente'),
						liTmp[i].getAttribute('sexo'),
						liTmp[i].noDblClick,
						true,
						liTmp[i].aoClicar,
						true);
	}
}