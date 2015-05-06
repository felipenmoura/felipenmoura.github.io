function aplyVariations(val)
{
	//alert('aplicando variacoes: '+val);
	val= unescape(val);
	try
	{
		eval(val);
	}catch(error){}
	refresh= false;
	setTimeout(newsVerify, 10000);
}
function newsVerify()
{
	if(refresh == false)
	{
		//alert('chamando metodo para validacao');
		// chama metodo ajax para verificação de variações, e executa aplyVariations
		ajaxVerify=openAjax();	//	Inicia o Ajax
		ajaxVerify.open("GET", 'refresh.php', true);	//	abre o Ajax 
		ajaxVerify.onreadystatechange = function ()
		{
			if(ajaxVerify.readyState == 1)
			{
				refresh= true;
			}else if(ajaxVerify.readyState == 4)
				  {
					try
					{
						ajax= unescape(ajaxVerify.responseText);
						//arAjax[id]= unescape(oAjaxToEval.responseText);
						aplyVariations(ajax);
					}
					catch (error)
					{
					}
				  }
		};
		ajaxVerify.send(null);	//	Submete
	}
}
