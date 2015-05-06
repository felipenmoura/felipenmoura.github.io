function setLoad(stat)
{
	if(stat == true)
	{
		try
		{
			document.getElementById('loader').style.visibility= 'visible';
		}catch(e)
			{}
	}else{
			try
			{
				document.getElementById('loader').style.visibility= 'hidden';
			}catch(e)
			{}
		 }
}
function logInRestrictArea(userName, urlSrc, hr)
{	
	onlyEvalAjax("requests/_direita.php", "", "document.getElementById('td_form_login').innerHTML= ajax");

	t= 0;
	l= 0;
	w= screen.width;
	h= screen.height - 40;
	
	window_open= window.open(urlSrc, 'logado', 'width='+w+',height='+h+',left='+l+',top='+t+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=yes,titlebar=no,toolbar=no');

	try
	{
		window_open.focus();
		setLoad(false);
	}catch(exception)
	{
		self.location.href= urlSrc;
	}
}

/******************************************************************************************************/

	/*function checkKey(event)
	{
		//alert(event.keyCode);
		kCode= event.keyCode;
		if(kCode==27)	// ESC
		{
				closeBlock(blockInFocus);
			}catch(error)
			{}
		}
		if (kCode==116)	//	F5
		{
			return
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
		
		if (kCode==36)	//	HOME
		{
			//event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
		
		if (kCode==37)	//	esquerda
		{
			if (event.ctrlKey)
			{
				try
				{
					blockInFocus.style.left= parseInt(blockInFocus.style.left)-3;
				}catch(error)
				{}
				event.cancelBubble= true;
				event.returnValue = false;
				return false;
			}
		}
		if (kCode==38)	//	cima
		{
			if (event.ctrlKey)
			{
				try
				{
					blockInFocus.style.top= parseInt(blockInFocus.style.top)-3;
				}catch(error)
				{}
				event.cancelBubble= true;
				event.returnValue = false;
				return false;
			}
		}
		if (kCode==39)	//	direita
		{
			if (event.ctrlKey)
			{
				try
				{
					blockInFocus.style.left= parseInt(blockInFocus.style.left)+3;
				}catch(error)
				{}
				event.cancelBubble= true;
				event.returnValue = false;
				return false;
			}
		}
		if (kCode==40)	//	baixo
		{
			if (event.ctrlKey)
			{
				try
				{
					blockInFocus.style.top= parseInt(blockInFocus.style.top)+3;
				}catch(error)
				{}
				event.cancelBubble= true;
				event.returnValue = false;
				return false;
			}
		}
				
		if (kCode==35)	//	END
		{
			//event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
		if (kCode==91)
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
		if (kCode == 82)	// ctrl-R
		{
			if (event.ctrlKey)
			{
				event.keyCode= 0;
				event.cancelBubble= true;
				event.returnValue = false;
				return false;
			}
		}
		if (kCode == 65)	// ctrl-A
		{
			if (event.ctrlKey)
			{
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
		if (kCode == 66)	// ctrl-B
		{
			if (event.ctrlKey)
			{
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
	}

	try
	{
		document.attachEvent("onkeydown", checkKey);
	}catch(e)
	{
		window.addEventListener("keydown", checkKey, true);
	}
	*/
	
	function RorC(event)
	{
		var top=self.screenTop;
		if (top>9000)
		{
			//alert('window was closed')
		}
		else
		{
			//self.location.href= "restrita/sair.php";
		}
	}
	
	