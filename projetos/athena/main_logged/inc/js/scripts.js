function ovr(cor,cel) {
	cel.bgColor = cor;
}

function recibos_ver_old(id) {
	window.open('recibos_print.php?id='+id,'recibos','width=600,height=310,scrollbars=yes,resizable=yes');
}

function recibos_ver(cod, tipo, data) {
	window.open('recibos_print.php?codpro='+cod+'&datainicial='+data+'&tipo='+tipo,'recibos','width=600,height=310,scrollbars=yes,resizable=yes');
}

function imprimei() {
  document.i_recibos.focus();
  print();
}

function senha(id,senha) {
  val = id.innerHTML;
  if (val==senha) id.innerHTML = '<font color=red>mostrar</font>'; else id.innerHTML = senha;
}

			function checkKey()
			{
				//alert(event.keyCode);
				kCode= event.keyCode;
				if (kCode==116)
				{
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
			{}