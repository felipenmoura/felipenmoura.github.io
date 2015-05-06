function checkKey(event)
{
	try
	{
		if(vLocker.style.display != 'none')
		{
			if(event.srcElement.type != 'text' || event.srcElement.tagName !='INPUT')
			{
				event.keyCode= 0;
				event.cancelBubble= true;
				event.returnValue = false;
				return false;
			}
		}
	}catch(error){}
	//alert(event.keyCode);
	// if(top.document.getElementById('divLock').style.display == '')
		// return false;
	kCode= event.keyCode;
	if(kCode==27)	// ESC
	{
		event.keyCode= 0;
		event.cancelBubble= true;
		event.returnValue = false;
		return false;
		try
		{
			document.body.removeChild(blockInFocus);
			blockInFocus= null;
		}catch(error)
		{}
	}
	if (kCode==116)	//	F5
	{
		if(blockInFocus!= null)
			top.filho.blockInFocus.reload();
		event.keyCode= 0;
		event.cancelBubble= true;
		event.returnValue = false;
		return false;

	}
	if (kCode==36)	//	HOME
	{
		//alert('home '+event.ctrlKey+' '+event.altKey)
		if(event.altKey)
		{
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if (kCode==35)	//	END
	{
		if(event.altKey)
		{
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if (kCode==91 || kCode==92) // windows
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
	/* if (kCode == 82)	// ctrl-R
	{
		if (event.ctrlKey)
		{
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	} */
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
	if (kCode == 65)	// ctrl-A
	{
		if (event.ctrlKey)
		{
			top.showShortcutList();
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
	/* if (kCode == 66)	// ctrl-B
	{
		if (event.ctrlKey)
		{
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	} */
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
	if (kCode == 82)	// ctrl-R
	{
		if (event.ctrlKey)
		{
			if(blockInFocus!= null)
				top.filho.blockInFocus.reload();
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if(kCode==9)	// ctrl-TAB
	{
		if (event.ctrlKey)
		{
			if(event.shiftKey)
			{
				top.ctrlTab('-');
			}else{
					top.ctrlTab('+');
				 }
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if(kCode==80)	// ctrl-P
	{
		if(event.ctrlKey)
		{
			top.printPage();
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if(kCode==87)	// ctrl-W
	{
		if(event.ctrlKey)
		{
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if(kCode==77)	// ctrl-M
	{
		if(event.ctrlKey)
		{
			if(blockInFocus!= null)
				if(blockInFocus.style.display == '')
					if(blockInFocus.getAttribute('drag_hability') == 'false')
						maximiza(blockInFocus);
					else
						maximiza(blockInFocus);
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if(kCode==73)	// ctrl-I
	{
		if(event.ctrlKey)
		{
			if(blockInFocus!= null)
				if(blockInFocus.style.display != 'none')
					minimiza(blockInFocus);
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if(kCode==66)	// ctrl-I
	{
		if(event.ctrlKey)
		{
			top.document.getElementById('btSideBar').click();
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if(kCode==83)	// ctrl-S
	{
		if(event.ctrlKey)
		{
			saveDataBlocks();
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue = false;
			return false;
		}
	}
	if (kCode==76)	//	ctrl-L
	{
		if (event.ctrlKey)
		{
			event.keyCode= 0;
			event.cancelBubble= true;
			event.returnValue= false;
			return false;
		}
	}
	return true
}



function checkKeyUp(event)
{
	if(document.getElementById('locker').style.display != 'none')
		return false;
	if(event.keyCode==115 && event.ctrlKey)	// CTRL F4
	{
		top.removeBlockKey();
		return false;
	}
	if( top.document.getElementById('ctrlTabDiv').style.display == ''
		&&
		event.ctrlKey == false
	  )
	{
		top.checkCtrlTab();
		top.ctrlKey= true;
	}
}

