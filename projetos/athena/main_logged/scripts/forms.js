function selectStartVerify(event)
{
	if((window.event.srcElement.tagName== 'INPUT' && window.event.srcElement.type== 'text') || window.event.srcElement.tagName=='TEXTAREA')
	{
		return true;
	}else{
			return false;
		 }
}
function changePassword()
{
	pass= document.getElementById('nova_senha').value;
	passConfirm= document.getElementById('senha_confirm').value;
	if(pass.length <4)
	{
		alert("A senha deve ter pelo menos 6 caracteres");
		return false;
	}
	if(pass.length > 20)
	{
		alert("A senha deve ter no maximo 20 caracteres");
		return false;
	}
	if(pass != passConfirm)
	{
		alert("A senha não confere com a confirmação");
		return false;
	}
	if(document.getElementById('senha_atual').value.replace(/ /g, '') == '')
	{
		alert('Digite a senha atual');
		return false;
	}
	document.getElementById('form_change_pass').submit();
	top.setLoad(true);
}
function charCount(textObj, charLimit, innerObj)
{
	if(textObj.value.length > charLimit)
	{
		textObj.value= textObj.value.substring(0, charLimit);
	}
	if(innerObj)
	{
		document.getElementById(innerObj).innerHTML= textObj.value.length
	}
}

//	funcao que cria nova linha na tabela - bombando valendo 2
function addLine(parentObj, lineModel, limit)
{
	parentObj= document.getElementById(parentObj);
	lineModel= document.getElementById(lineModel);
	linhaTds= lineModel.getElementsByTagName('TD');
	if(limit)
		if(parentObj.getElementsByTagName('TR').length >= limit)
			return false;
	/*
	for(x in linhaTds[0])
		alert(x);
	return false;
	*/
	tr= document.createElement('TR');
	for(i=0; i<linhaTds.length; i++)
	{
		td= document.createElement('TD');
		for(x in linhaTds[i])
		{
			if(x != 'innerHTML' && linhaTds[i][x] != '' && linhaTds[i][x]!= null)
			{
				//alert(x + ' -> '+linhaTds[i][x])
				try
				{
					td.setAttribute(x, linhaTds[i][x])
				}catch(somenteLeitura){}
			}
		}
		td.setAttribute('style', '');
		for(x in linhaTds[i].style)
			if(linhaTds[i].style[x] != '')
				try
				{
					td.style[x]= linhaTds[i].style[x];
				}catch(e){}
		td.innerHTML= linhaTds[i].outerText;
			inputs= linhaTds[i].getElementsByTagName('input');
			for(ii=0; ii<inputs.length; ii++)
			{
				newInput= document.createElement('INPUT');
				newInput.setAttribute('style', '');
				for(x in inputs[ii])
				{
					if(x != 'id' && inputs[ii][x] != '' && inputs[ii][x] != null && inputs[ii][x] < 1000)
					{
						try
						{
							newInput.setAttribute(x, inputs[ii][x])
						}catch(somenteLeitura){}
					}
				}
				for(x in inputs[ii].style)
					if(inputs[ii].style[x] != '')
						try
						{
							newInput.style[x]= inputs[ii].style[x];
						}catch(e){}
				newInput.value= inputs[ii].value;
				newInput.type= inputs[ii].type;
				if(newInput.type == 'text')
				{
					newInput.style.backgroundImage = '';
					newInput.style.cursor = 'default';
				}
				
				if(inputs[ii].type == 'radio')
				{
					newInput.name= inputs[ii].name;
					newInput.id= inputs[ii].id+'_'+parentObj.getElementsByTagName('TR').length;	
				}else{
						newInput.name= inputs[ii].name+'_'+(parentObj.getElementsByTagName('TR').length -1);	
						newInput.id= inputs[ii].id+'_'+(parentObj.getElementsByTagName('TR').length -1);	
						newInput.onkeyup= inputs[ii].onkeyup;
						if(inputs[ii].type == 'button' && inputs[ii].value.replace(/ /g,'') == '+')
						{
							newInput.value = '-';
							newInput.className = inputs[ii].className;
							newInput.onclick = function()
							{
								//aqui
								if(confirm('Deseja realmente excluir esta linha?'))
								{
									var tBody = this.parentNode.parentNode.parentNode;
									this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
									var trs = tBody.getElementsByTagName('TR');
									for(var i=1;i<trs.length;i++)
									{
										var ipts = trs[i].getElementsByTagName('INPUT');
										for(var j=0;j<ipts.length;j++)
										{
											if(ipts[j].type == 'text' || ipts[j].type == 'hidden')
											{
												//alert(trs[i].innerHTML);
												//alert('Antes Porra : '+ipts[j].name+'\n'+ipts[j].value + '\n'+ i + '\n' + ipts[j].name.substring(0,ipts[j].name.lastIndexOf('_'))+'_'+i + '\n' + ipts.length);
												ipts[j].name = ipts[j].name.substring(0,ipts[j].name.lastIndexOf('_'))+'_'+(i-1);
												//alert(ipts[j].name.substring(0,ipts[j].name.lastIndexOf('_'))+'_'+(i-1));
												ipts[j].id = ipts[j].id.substring(0,ipts[j].id.lastIndexOf('_'))+'_'+i;
												//alert('Depois Caralho : ' + ipts[j].name);
											}
										}
										//this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
										//this.parentNode.parentNode.style.display = 'none';
									}
								}
							}
						}
					 }
				td.appendChild(newInput);
				if(inputs[ii].type != 'button')
					inputs[ii].value = '';
				
				if(inputs[ii].type == 'file')
				{
					inputs[ii].value = '';
					newInput.className = inputs[ii].className;
				}
			}
		if(td.innerHTML== '')
			td.innerHTML= linhaTds[i].innerHTML; // para quando NAO HOUVER NEM TEXTO NEM INPUT, joga todo o conteúdo da td modelo, na nova td
		tr.appendChild(td);
		try
		{
			tr.style.display= '';
		}catch(error){}
	}
	parentObj.appendChild(tr);
}

function everyChecked()
{
	if(this.checked == true)
		this.checked= false
	else this.checked= true;
}

// adiciona dados a lista, adicionando uma nova linha
function addToList(tbodyId, elementId)
{
	tbody= document.getElementById(tbodyId);
	elementId= elementId.replace(/ /g, '');
	elementId= elementId.split(',');
	
	tr= document.createElement('TR');
	for(i=0; i<elementId.length; i++)
	{
		element= document.getElementById(elementId[i]);
		//alert(element.value.replace(/ /g, '')=='');
		if(element.getAttribute('required') == 'true')
		{
			if(element.value.replace(/ /g, '')=='')
			{
				top.showAlert('alerta', (element.getAttribute('label'))? element.getAttribute('label')+' é obrigatório': 'Um dos campos é obrigatório')
				return false
			}
		}
			if(element.style.display != 'none' || !td)	// se houver uma variavel td já criada, ele joga na td antiga o mesmo input, se este anterior estiver invisivel
			{
				td= document.createElement('TD');
				td.className= 'gridCell';
				td.style.textAlign= 'left';
			}
			newContent= element.cloneNode(true);
			
			newContent.setAttribute('style', '');
			
			if(newContent.getAttribute('type') == 'select-one')
			{
				/*
				newAlterContent= document.createElement('input');
				newAlterContent.type= "text";
				newAlterContent.value= element.value;
				newContent.style.width= element.offsetWidth;
				newContent= newAlterContent;
				*/
				newContent.value= document.getElementById(elementId[i]).value;
			}
			newContent.classname= document.getElementById(elementId[i]).classname;
			if(newContent.getAttribute('type') == 'checkbox')
			{
				newContent.onclick= everyChecked;
				if(element.checked == true)
				{
					setTimeout("document.getElementById('"+newContent.getAttribute('id')+'_'+tbody.getElementsByTagName('TR').length+"').checked= true;", 1);
				}
			}
			
			//newContent.style.backgroundColor= '#dedede';
			newContent.setAttribute('id', newContent.getAttribute('id')+'_'+tbody.getElementsByTagName('TR').length)
			newContent.setAttribute('name', newContent.getAttribute('name')+'_'+tbody.getElementsByTagName('TR').length)
			//newContent.style.border= 'none';
			//newContent.setAttribute('readOnly', true);
			td.appendChild(newContent);
		tr.appendChild(td);
	}
		td= document.createElement('TD');
		td.className= 'gridCell';
		td.style.textAlign= 'center';
			// altere aqui, caso queria colocar uma imagem, botao, ou algo do genero
			td.innerHTML= "<input type='button' value='-' class='botao_caract' onclick='if(confirm(\"Tem certeza que deseja remover este ítem da lista ?\")){this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);}'>";
	tr.appendChild(td);
	tbody.appendChild(tr);
	for(i=0; i<elementId.length; i++)
	{
		document.getElementById(elementId[i]).value= document.getElementById(elementId[i]).getAttribute('defaultValue');
	}
}

function enderecoNewLine(obj, objPai, listToClear)
{
	obj= document.getElementById(obj);
	objPai= document.getElementById(objPai);
	
	clone= obj.cloneNode(true);

	inputs= clone.getElementsByTagName('INPUT');
	selects= clone.getElementsByTagName('SELECT');
	
	inputsPai= obj.getElementsByTagName('INPUT');
	selectsPai= obj.getElementsByTagName('SELECT');
	
	enderecoCount++;
	for(i=0; i<selects.length; i++)
	{
		selects[i].id= selects[i].id+'_'+enderecoCount;
		selects[i].name= selects[i].name+'_'+enderecoCount;
		selects[i].value= selectsPai[i].value;
	}
	for(i=0; i<inputs.length; i++)
	{
		if(inputs[i].type != 'button')
		{
			inputs[i].id= inputs[i].id+'_'+enderecoCount;
			inputs[i].name= inputs[i].name+'_'+enderecoCount;
			inputs[i].onkeyup= "return false";
			inputs[i].onblur= "return false";
			if(inputs[i].tagName == 'select')
			{
				inputs[i].value= inputsPai[i].value;
			}
			if(inputs[i].type == 'checkbox')
			{
				if(inputsPai[i].checked == true)
					setTimeout("document.getElementById('"+inputs[i].id+"').checked = 'true';", 10);
			}
		}else{
				if(inputs[i].value == '+')
				{
					inputs[i].value= '-';
					inputs[i].onclick= function ()
											{
												if(confirm("Tem certeza que deseja remover este ítem da lista ?"))
												{
													this.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode.parentNode);
												}
											}
				}
			 }
	}
	listToClear= listToClear.replace(/ /g, '');
	listToClear= listToClear.split(',');
	for(i=0; i<listToClear.length; i++)
	{
		listToClear[i]= document.getElementById(listToClear[i]);
		listToClear[i].value= "";
	}
	objPai.appendChild(clone);
}

// clientes
function validNewClient(pre)
{
	if(!pre)
		pre= '';
	cliente_endereco_residencial = document.getElementById(pre+'cliente_endereco_residencial');
	cliente_emails = document.getElementById(pre+'cliente_emails');
	cliente_telefones = document.getElementById(pre+'cliente_telefones');
	cliente_contatos = document.getElementById(pre+'cliente_contatos');
	cliente_filiais = document.getElementById(pre+'cliente_filiais');
	document.getElementById(pre+'clientLoginSub').value= '';
	document.getElementById(pre+'clientLoginSubPwd').value= '';
	document.getElementById(pre+'clientObservacao').value= '';
	formInputs= document.getElementById(pre+'form_cliente_add');
	for(i=0; i<formInputs.length; i++)
	{
		if(formInputs[i].getAttribute('required') == 'true')
		{
			if(formInputs[i].value.replace(/ /g, '')=='')
			{
				top.showAlert('alerta', (formInputs[i].getAttribute('label'))? formInputs[i].getAttribute('label')+' é obrigatório': 'Um dos campos é obrigatório')
				return false
			}
		}
	}
	ar_residenc= document.getElementById(pre+'clienteEndList').getElementsByTagName('table');
	cliente_endereco_residencial.value = '';
	for (i=0; i<ar_residenc.length; i++)
	{
		inputs = ar_residenc[i].getElementsByTagName('INPUT');
		for (j=0;j<inputs.length;j++)
		{
			if(inputs[j].getAttribute('type') != 'button' && inputs[j].getAttribute('type') != 'submit' && inputs[j].getAttribute('type') != 'reset')
				if(inputs[j].getAttribute('type')=='checkbox')
				{
					if(inputs[j].checked == 1)
						cliente_endereco_residencial.value += 'on'+'||';
					else
						cliente_endereco_residencial.value += 'off'+'||';
				}else
					cliente_endereco_residencial.value += inputs[j].value.replace(/\|/g, '')+'||';
		}
		inputs = ar_residenc[i].getElementsByTagName('SELECT');
		for (j=0;j<inputs.length;j++)
		{
			cliente_endereco_residencial.value += inputs[j].value.replace(/\|/g, '')+'||';
		}
		cliente_endereco_residencial.value +='|+|';
	}
	
	/*
	*/try
	{
			// CONTATOS DA EMPRESA
			ar_cliente_contatos= document.getElementById(pre+'contatoList');
			clientesContatosString = valuesToString(ar_cliente_contatos);
			cliente_contatos.value = clientesContatosString;
	}
	catch(error)
	{}
	try
	{
			//FILIAIS DA EMPRESA
			arr_filial_list = document.getElementById(pre+'filialList');
			filiaisString = valuesToString(arr_filial_list);
			alert(filiaisString);
			cliente_filiais.value = filiaisString;
	}catch(error)
	{}
	ar_cliente_emails= document.getElementById(pre+'clienteEmailList').getElementsByTagName('TR');
	cliente_emails.value = '';
	for (i=0; i<ar_cliente_emails.length; i++)
	{
		inputs = ar_cliente_emails[i].getElementsByTagName('INPUT');
		if (inputs.length > 0)
		{
			for (j=0;j<inputs.length;j++)
			{
				if(inputs[j].getAttribute('type') != 'button' && inputs[j].getAttribute('type') != 'submit' && inputs[j].getAttribute('type') != 'reset')
					cliente_emails.value += inputs[j].value.replace(/\|/g, '');
			}
			cliente_emails.value +='|+|';
		}
	}
	
	ar_cliente_telefones= document.getElementById(pre+'clienteFoneList').getElementsByTagName('TR');
	cliente_telefones.value = '';
	
	for (i=0; i<ar_cliente_telefones.length; i++)
	{
		try
		{
			inputs = ar_cliente_telefones[i].getElementsByTagName('INPUT');
			selects= ar_cliente_telefones[i].getElementsByTagName('SELECT');
			for (j=0; j<inputs.length; j++)
			{
				//alert(inputs[j].value);
				if(inputs[j].getAttribute('type') != 'button' && inputs[j].getAttribute('type') != 'submit' && inputs[j].getAttribute('type') != 'reset')
					cliente_telefones.value += inputs[j].value.replace(/\|/g, '')+'||';
			}
			
			cliente_telefones.value += selects[0].value;
			cliente_telefones.value +='|+|';
		}catch(error)
		{}
	}
	try
	{
		document.getElementById(pre+'clientLoginSub').value= document.getElementById(pre+'clientLogin').value;
		document.getElementById(pre+'clientLoginSubPwd').value= document.getElementById(pre+'clientLoginPwd').value;
	}catch(error){}
	document.getElementById(pre+'clientObservacao').value= document.getElementById(pre+'clienteObs').value;
	
	top.setLoad(true);
	document.getElementById(pre+'form_cliente_add').submit();
	//document.getElementById(pre+'form_cliente_add').reset();
	return true;
}

// contatos
function validNewContact()
{
	contato_endereco_residencial = document.getElementById('contato_endereco_residencial');
	contato_emails = document.getElementById('contato_emails');
	contato_telefones = document.getElementById('contato_telefones');
	
	document.getElementById('clientLoginSub').value= '';
	document.getElementById('clientLoginSubPwd').value= '';
	document.getElementById('clientObservacao').value= '';
	
	formInputs= document.getElementById('form_contato_add');
	for(i=0; i<formInputs.length; i++)
	{
		if(formInputs[i].getAttribute('required') == 'true')
		{
			if(formInputs[i].value.replace(/ /g, '')=='')
			{
				top.showAlert('alerta', (formInputs[i].getAttribute('label'))? formInputs[i].getAttribute('label')+' é obrigatório': 'Um dos campos é obrigatório')
				return false
			}
		}
	}
	
	// if(document.getElementById('').value.replace(/ /g, '') == '')
	// {
		// document.getElementById('').focus();
	// }
	
	ar_residenc= document.getElementById('contatoEnderecoTbody').getElementsByTagName('TR');
	contato_endereco_residencial.value = '';
	for (i=0; i<ar_residenc.length; i++)
	{
		inputs = ar_residenc[i].getElementsByTagName('INPUT');
		for (j=0;j<inputs.length;j++)
		{
			if(inputs[j].getAttribute('type') != 'button' && inputs[j].getAttribute('type') != 'submit' && inputs[j].getAttribute('type') != 'reset')
				contato_endereco_residencial.value += inputs[j].value.replace(/\|/g, '')+'|| ';
		}
		contato_endereco_residencial.value +='|+|';
	}

	ar_contato_emails= document.getElementById('contatoEmailList').getElementsByTagName('TR');
	contato_emails.value = '';
	for (i=0; i<ar_contato_emails.length; i++)
	{
		inputs = ar_contato_emails[i].getElementsByTagName('INPUT');
		for (j=0;j<inputs.length;j++)
		{
			if(inputs[j].getAttribute('type') != 'button' && inputs[j].getAttribute('type') != 'submit' && inputs[j].getAttribute('type') != 'reset')
				contato_emails.value += inputs[j].value.replace(/\|/g, '');
		}
		contato_emails.value +='|+|';
	}
	
	ar_contato_telefones= document.getElementById('contatoFoneList').getElementsByTagName('TR');
	contato_telefones.value = '';
	for (i=0; i<ar_contato_telefones.length; i++)
	{
		inputs = ar_contato_telefones[i].getElementsByTagName('INPUT');
		for (j=0;j<inputs.length;j++)
		{
			if(inputs[j].getAttribute('type') != 'button' && inputs[j].getAttribute('type') != 'submit' && inputs[j].getAttribute('type') != 'reset')
				contato_telefones.value += inputs[j].value.replace(/\|/g, '')+'|| ';
		}
		contato_telefones.value +='|+|';
	}
	document.getElementById('clientLoginSub').value= document.getElementById('clientLogin').value;
	document.getElementById('clientLoginSubPwd').value= document.getElementById('clientLoginPwd').value;
	document.getElementById('clientObservacao').value= document.getElementById('contatoObs').value;
	document.getElementById('form_contato_add').submit();
	//document.getElementById('form_contato_add').reset();
	
	return true;
}

function filterSelectElements(obj)
{
	/*selectIEBUGlist= obj.getElementsByTagName('select');
	alert(selectIEBUGlist.length);
	for(var j=0; j<selectIEBUGlist.length; j++)
	{
		var sOpts = "<SELECT onmouseup='algo(this)'>";
		for (var i=0;i<100;i++)
		{
			sOpts += '<OPTION VALUE="' + i + '" onmousedown="alert('+i+')">' + i + '</OPTION>\n';
		}
		selectIEBUGlist[j].outerHTML = sOpts  + "</SELECT>";
	}*/
}

/*function algo(cu)
{
	porra= "";
	for(pica in cu)
	{
		porra+= pica+": "+cu[pica]+"\n";
	}
	alert(porra);
}*/




function saveTmp(objId)
{
	for(var i=0; i<validBlocks.length; i++)
	{
		
	}
	

	return;

	var blocks= document.getElementById('ctrlTabTable').getElementsByTagName('TR');
	for(i=0; i< blocks.length; i++)
	{
		var tmp_bloco= filho.document.getElementById(blocks[i].getAttribute('block'));
		alert(tmp_bloco.innerHTML)
	}
	
	objId= top.document.getElementById(objId).getAttribute('blockReferences');
	alert(objId.innerHTML.length+' : '+objId.getAttribute('tt'));
	var cToSave= objId.innerHTML;
	var cCookieCount= 0;
	var textToSave= "";
	while(cToSave.length > 3600)
	{
		cCookieCount++;
		textToSave= cToSave.substring(0,3600);
		gravaCookie('athenaRascunho_'+objId.getAttribute('tt')+cCookieCount,
						textToSave, new Date(new Date().getTime() + (12*30*24*60*1000)));
		cToSave= cToSave.substring(3601, cToSave.length);
	}
	if(cCookieCount == 0)
		gravaCookie('athenaRascunho_'+objId.getAttribute('tt')+cCookieCount,
						cToSave, new Date(new Date().getTime() + (12*30*24*60*1000)));
}

function buscaArquivosTemporarios()
{
	
	
	document.getElementById('corpo').innerHTML+= "";
}
//setTimeout("buscaArquivosTemporarios()", 1000);








