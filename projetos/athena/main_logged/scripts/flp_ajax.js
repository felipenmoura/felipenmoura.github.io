/*
	***	***	***	***	***	***	***	****	

	autor:	Felipe Nascimento de Moura
	ano:	11/2006

	***	***	***	***	***	***	***	****
*/


function openAjax()
{
	var ajaxObj;
	try
	{
		ajaxObj= new XMLHttpRequest();		//	Para brawser que nao sejam o IE
		ajaxObj.overrideMimeType("index.html");		//	Nome do documento a ser carregado
	}
	catch (eee)
	{
		try
		{
			ajaxObj= new ActiveXObject("Msxm12.XMLHTTP");		//	Para Ie
		}
		catch (ee)
		{
			try
			{
				ajaxObj=new ActiveXObject("Microsoft.XMLHTTP");	//	Para Ie de outra versão
			}
			catch (e)
			{
				ajaxObj=false;
			}
		}
	}
	return ajaxObj;
}

function flp_getFromAjax(paraOnde)
{
	ajax=openAjax();	//	Inicia o Ajax
	ajax.open("GET", paraOnde, true);	//	abre o Ajax 
	ajax.onreadystatechange = passoApasso;		// executa mudando a cada evolução do status do ajax
	ajax.send(null);	//	Submete
	//return paraOnde;
}

function passoApasso()
{
	if(ajax.readyState == 1)
	{
		//alert('passo 1')
		setLoad(true, "");
	}
	if(ajax.readyState == 4)
	{
		//alert('passo 4');
		srcPageLoaded= ajax.responseText;
		srcPageLoaded= srcPageLoaded.split("<flp_script>")
		try
		{
			eval(srcPageLoaded[1]);
		}
		catch (error)
		{
		}
		setLoad(false, srcPageLoaded[0]);
	}
}

/**//**/

function flp_getAjaxReturn(paraOnde)
{
	ajax=openAjax();	//	Inicia o Ajax
	ajax.open("GET", paraOnde, true);	//	abre o Ajax 
	ajax.onreadystatechange = passoApasso_ii;		// executa mudando a cada evolução do status do ajax
	ajax.send(null);	//	Submete
}

function passoApasso_ii()
{
	if(ajax.readyState == 1)
	{
		//alert('passo 1')
		setLoadNormal(true, "");
	}
	if(ajax.readyState == 4)
	{
		//alert('passo 4');
		srcPageLoaded= ajax.responseText;
		setLoadNormal(false, srcPageLoaded);
	}
}




function getInfoFromAjax(paraOnde, target)
{
	targetElement= document.getElementById(target);
	ajaxInfo=openAjax();	//	Inicia o Ajax
	ajaxInfo.open("GET", paraOnde, true);	//	abre o Ajax 
	ajaxInfo.onreadystatechange = showHiddenInfo;		// executa mudando a cada evolução do status do ajax
	ajaxInfo.send(null);	//	Submete
}

	function showHiddenInfo()
	{
		if(ajaxInfo.readyState == 1)
		{
			targetElement.innerHTML= "<img src='../../img/loader.gif'>";
			//document.getElementById('td_info_box').style.display= '';
			//document.getElementById('info_title').innerHTML= "Carregando Informa&ccedil;&otilde;es";
		}
		if(ajaxInfo.readyState == 4)
		{
			srcPageLoaded= ajaxInfo.responseText;
			//document.getElementById('td_info_box').innerHTML= srcPageLoaded;
			//alert('passo 4');
			
			targetElement.innerHTML= srcPageLoaded;
			//	[0] => titulo da informação
			//	[1] => informação
			//document.getElementById('info_title').innerHTML= "<b><nobr>"+srcPageLoaded[0]+"</nobr></b>";
			//document.getElementById('td_info_box').innerHTML= srcPageLoaded[1];
		}
	}


	function evalAjax(url, loader, func)
	{
		ajaxToEval=openAjax();	//	Inicia o Ajax
		ajaxToEval.open("GET", url, true);	//	abre o Ajax 
		ajaxToEval.onreadystatechange =   function evalAjaxStateChange()
										  {
												if(ajaxToEval.readyState == 1)
												{
													try
													{
														document.getElementById(loader).style.display= "";
													}
													catch (error)
													{
													}

													try
													{
														setLoadNormal(true);
													}
													catch (error)
													{
													}
												}else{
														if(ajaxToEval.readyState == 4)
														{
															try
															{
																document.getElementById(loader).style.display= "none";
															}
															catch (error)
															{
															}

															//alert(func.replace('ajax', ajaxToEval.responseText));

															try
															{
																setLoadNormal(false);
															}
															catch (error)
															{
															}

															try
															{
																ajax= unescape(ajaxToEval.responseText);
																eval(func);
															}
															catch (error)
															{
															}
														}
													 }
										  }
		ajaxToEval.send(null);	//	Submete
	}

/**/

/*

	FIM DE "INVOCANDO O AJAX"

*/
	function onlyEvalAjax(url, loader, func, id, methodToSend, dados)
	{
		if(!id)
		{
			dt= new Date();
			id= dt.getTime();
		}
		if(loading == true)
		{
			stayLoading= setTimeout("onlyEvalAjax(\""+url+"\", \""+loader+"\", \""+func+"\", \""+id+"\")", 500);
			return true;
		}else{
				stayLoading= false;
				delete stayLoading;
			 }
		loading= true;
		oAjaxToEval= new openAjax();	//	Inicia o Ajax
		oAjaxToEval.open("POST", url, true);	//	abre o Ajax 
		oAjaxToEval.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
		oAjaxToEval.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		oAjaxToEval.onreadystatechange =  function oAjaxToEvalStateChange()
										  {
												if(oAjaxToEval.readyState == 1)
												{
													try
													{
														document.getElementById(loader).style.display= "";
													}
													catch (error)
													{
													}
												}else{
														if(oAjaxToEval.readyState == 4)
														{
															try
															{
																document.getElementById(loader).style.display= "none";
															}
															catch (error)
															{
															}

															try
															{
																ajax= unescape(oAjaxToEval.responseText);
																eval(func);
															}
															catch (error)
															{
															}
															
															setTimeout("try{ top.setLoad(false); }catch(error) { }", 550);
															loading= false;
														}
													 }
										  }
		if(methodToSend=='POST')
		{
			oAjaxToEval.send(dados + '&method=post');
		}else
			oAjaxToEval.send(null);	//	Submete
	}



	// function messagesVerify()
	// {
		//setTimeout("messagesVerify()", 20000);
	// }

	//messagesVerify()

/*
	Retorna o conteudo da pagina quando terminar o load
*/