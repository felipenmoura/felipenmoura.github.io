function setCEPCliente(str)
{
	top.setLoad(false);
	if(str == 'false')
		return false;
	alert('a')
	try
	{
		cepRetornado= '';
		eval(str);
		document.getElementById('clienteLogradouro').value= unescape(cepRetornado['tipoLogradouro']+' '+cepRetornado['logradouro'].replace(/\+/g, ' '));
		document.getElementById('clienteBairro').value= unescape(cepRetornado['bairro'].replace(/\+/g, ' '));
		document.getElementById('clienteCidade').value= unescape(cepRetornado['cidade'].replace(/\+/g, ' '));
		//document.getElementById('clienteEstado').value= unescape(cepRetornado['cidade'].replace(/\+/g, ' '));
		document.getElementById('clienteEstado').value= cepRetornado['UF'];
		document.getElementById('iptComponentUfclienteEstado').value= cepRetornado['UF'];
	}catch(error){}
}

function setCEPcontatoFilial(str)
{
	top.setLoad(false);
	if(str == 'false')
		return false;
	try
	{
		cepRetornado= '';
		eval(str);
		document.getElementById('acf_clienteLogradouro').value= unescape(cepRetornado['tipoLogradouro']+' '+cepRetornado['logradouro'].replace(/\+/g, ' '));
		document.getElementById('acf_clienteBairro').value= unescape(cepRetornado['bairro'].replace(/\+/g, ' '));
		document.getElementById('acf_clienteCidade').value= unescape(cepRetornado['cidade'].replace(/\+/g, ' '));
		document.getElementById('acf_clienteEstado').value= cepRetornado['UF'];
		document.getElementById('iptComponentUfacf_clienteEstado').value= cepRetornado['UF'];
	}catch(error){}
}

function setCEPContatoEmpresa(str)
{
	top.setLoad(false);
	if(str == 'false')
		return false;
	try
	{
		cepRetornado= '';
		eval(str);
		document.getElementById('ace_clienteLogradouro').value= unescape(cepRetornado['tipoLogradouro']+' '+cepRetornado['logradouro'].replace(/\+/g, ' '));
		document.getElementById('ace_clienteBairro').value= unescape(cepRetornado['bairro'].replace(/\+/g, ' '));
		document.getElementById('ace_clienteCidade').value= unescape(cepRetornado['cidade'].replace(/\+/g, ' '));
		document.getElementById('ace_clienteEstado').value= cepRetornado['UF'];
		document.getElementById('iptComponentUface_clienteEstado').value= cepRetornado['UF'];
	}catch(error){}
}

function setCEP(str, pre)
{
	top.setLoad(false);
	if(str == 'false')
		return false;
	try
	{
		cepRetornado= '';
		eval(str);
		document.getElementById(pre+'clienteLogradouro').value= unescape(cepRetornado['tipoLogradouro']+' '+cepRetornado['logradouro'].replace(/\+/g, ' '));
		document.getElementById(pre+'clienteBairro').value= unescape(cepRetornado['bairro'].replace(/\+/g, ' '));
		document.getElementById(pre+'clienteCidade').value= unescape(cepRetornado['cidade'].replace(/\+/g, ' '));
		document.getElementById(pre+'clienteEstado').value= cepRetornado['UF'];
		document.getElementById('iptComponentUf'+pre+'clienteEstado').value= cepRetornado['UF'];
	}catch(error){}
}

function setCEPFunc(str)
{
	top.setLoad(false);
	if(str == 'false')
		return false;
	try
	{
		cepRetornado= '';
		eval(str);
		document.getElementById('func_clienteLogradouro').value= unescape(cepRetornado['tipoLogradouro']+' '+cepRetornado['logradouro'].replace(/\+/g, ' '));
		document.getElementById('func_clienteBairro').value= unescape(cepRetornado['bairro'].replace(/\+/g, ' '));
		document.getElementById('func_clienteCidade').value= unescape(cepRetornado['cidade'].replace(/\+/g, ' '));
		document.getElementById('func_clienteEstado').value= cepRetornado['UF'];
		document.getElementById('iptComponentUffunc_clienteEstado').value= cepRetornado['UF'];
	}catch(error){}
}

function setCEPContato(str)
{
	top.setLoad(false);
	if(str == 'false')
		return false;
	try
	{
		cepRetornado= '';
		eval(str);
		document.getElementById('ger_contato_add_contatoLogradouro').value= unescape(cepRetornado['tipoLogradouro']+' '+cepRetornado['logradouro'].replace(/\+/g, ' '));
		document.getElementById('ger_contato_add_contatoBairro').value= unescape(cepRetornado['bairro'].replace(/\+/g, ' '));
		document.getElementById('ger_contato_add_contatoCidade').value= unescape(cepRetornado['cidade'].replace(/\+/g, ' '));
		document.getElementById('ger_contato_add_contatoEstado').value= cepRetornado['UF'];
		document.getElementById('iptComponentUfger_contato_add_contatoEstado').value= cepRetornado['UF'];
	}catch(error){}
}