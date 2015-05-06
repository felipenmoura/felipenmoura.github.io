try
{
	window.attachEvent('onload', addLocker, true);
}catch(error)
{
	window.addEventListener('load', addLocker, true);
}

// /**/


hideSelects();

// /**/

try
{
	window.attachEvent("onunload", RorC);
}catch(exception)
{
	window.addEventListener("unload", RorC, true);
}

// /**/

top.setLoad(false);
self.focus();
// document.getElementById('corpo').focus();
// document.getElementById('corpo').click();

// /**/

try
{
	document.attachEvent("onkeydown", checkKey);
}catch(e)
{
	window.addEventListener("keydown", checkKey, true);
}

try
{
	document.attachEvent("onkeyup", checkKeyUp);
}catch(e)
{
	window.addEventListener("keyup", checkKeyUp, true);
}

/**/

try 
{
	document.attachEvent('onmousedown', menuUnset);
	document.attachEvent('onmousedown', rhtSubMenu);
}catch(e)
{
	document.addEventListener('mousedown', menuUnset, false);
	document.addEventListener('mousedown', rhtSubMenu, false);
}

/**/

setTimeout(newsVerify, 10000); // verifica as atualizações no servidor

/**/

