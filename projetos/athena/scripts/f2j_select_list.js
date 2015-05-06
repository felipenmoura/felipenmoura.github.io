var f2j_selectedOptions= null;
function offsetLeft(el)
{
	x = el.offsetLeft
	for (e = el.offsetParent; e; e = e.offsetParent)
		x += e.offsetLeft;
	return x
}
function offsetTop(el)
{
	y = el.offsetTop
	for (e = el.offsetParent; e; e = e.offsetParent)
		y += e.offsetTop;
	return y
}

function hideOptions(event)
{
	if(f2j_selectedOptions!= null)
		f2j_selectedOptions.style.display= 'none';
	f2j_selectedOptions= null;
	
	try
	{
		document.detachEvent('onclick', hideOptions);
	}catch(error)
	{
		document.removeEventListener('click', hideOptions, true);
	}
}

function showSelectOptions(obj, objRef)
{
	alert('a')
	if(!obj.tagName)
		obj= document.getElementById(obj);
	if(!objRef.tagName)
		objRef= document.getElementById(objRef);
	alert('b')
	div= document.getElementById(objRef.id+'_options');
	
	div.style.width= obj.offsetWidth;
	div.style.height= obj.offsetHeight;
	div.style.position= 'absolute';
	div.style.left= offsetLeft(obj);
	div.style.top= offsetTop(obj) + obj.offsetHeight + 2;
	
	op= objRef.getElementsByTagName('OPTION');
	div.innerHTML= "";
	for(i=0; i<op.length; i++)
	{
		dvTmp= document.createElement('DIV');
		dvTmp.setAttribute('style', '');
		dvTmp.style.width= '100%';
		dvTmp.onmouseover= "this.style.backgroundColor= '#dedede';"
		dvTmp.onmouseout= "this.style.backgroundColor= '';";
		
		dvTmp.innerHTML= op[i].outerText;
		
		dvTmp.onclick= "document.getElementById('"+objRef.id+"').value= '"+op[i].value+"'; document.getElementById('"+obj.id+"').value= '"+dvTmp.outerText+"'";
		
		div.innerHTML+= dvTmp.outerHTML;
	}
	setTimeout("try{document.attachEvent('onclick', hideOptions);}catch(error){document.addEventListener('click', hideOptions, true);}", 100);
	f2j_selectedOptions= div;
	div.style.display= '';
}