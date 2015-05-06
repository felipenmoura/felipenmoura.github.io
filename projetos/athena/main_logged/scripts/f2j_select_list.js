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

function hideOptions(event, flag)
{
	if(!event.srcElement.getAttribute('thisIsAIEBugCorrector_Select') || flag)
	{
		if(f2j_selectedOptions!= null)
			f2j_selectedOptions.style.display= 'none';
		f2j_selectedOptions= null;
		
		try
		{
			document.detachEvent('onmousedown', hideOptions);
		}catch(error)
		{
			document.removeEventListener('mousedown', hideOptions, true);
		}
	}
}

function showSelectOptions(obj, objRef, func)
{
	if(!obj.tagName)
		obj= document.getElementById(obj);
	if(!objRef.tagName)
		objRef= document.getElementById(objRef);
	div= document.getElementById('select_options');
	div.style.width= obj.offsetWidth;
	div.style.height= obj.offsetHeight;
	div.style.position= 'absolute';
	div.style.display= '';
	bloco= getBlock(obj);
	el= obj;
	var x= 0;
	var y=0;
	while(el.tagName != 'BODY')
	{
		if(el.tagName != 'TR' && el.tagName != 'TBODY' && el.tagName != 'UL' && el.style.display != 'none' && el.tagName != 'NOBR' && el.tagName != 'SPAN')
		{
			x+= el.offsetLeft;
			x-= el.scrollLeft;
			y+= el.offsetTop;
			y-= el.scrollTop;
		}
		//el.style.border = 'solid 2px red';
		el= el.parentNode;
		//alert(x+'\n'+y+'\n'+el.tagName+'\n'+el.offsetLeft+'\n'+el.offsetTop);
		
	}
	el= obj;
	ySelectPos= 0;
	last= 0;
	div.style.zIndex= zMax + 51;
	div.style.width= obj.offsetWidth;
	op= objRef.getElementsByTagName('OPTION');
	div.innerHTML= "";
	for(i=0; i<op.length; i++)
	{
		dvTmp= document.createElement('DIV');
		dvTmp.setAttribute('style', '');
		dvTmp.style.width= '100%';
		dvTmp.style.backgroundColor= 'white';
		dvTmp.style.whiteSpace= 'nowrap';
		dvTmp.setAttribute('thisIsAIEBugCorrector_Select', 'true');
		dvTmp.onmouseover= "this.style.backgroundColor= '#dedede';"
		dvTmp.onmouseout= "this.style.backgroundColor= '';";
		dvTmp.innerHTML= (op[i].outerText.replace(/ /g, '') == '')? '<br>': op[i].outerText;
		//alert(objRef.id);
		clickSlt= "document.getElementById('"+objRef.id+"').value= '"+op[i].value+"'; document.getElementById('"+obj.id+"').setAttribute('code', document.getElementById('"+objRef.id+"').value); document.getElementById('"+obj.id+"').value= '"+((dvTmp.outerText.length > 20)? dvTmp.outerText.substring(0,20)+'...' : dvTmp.outerText)+"'; ";
		if(func)
			clickSlt+= func;
		dvTmp.onclick= clickSlt+"; hideOptions(event, true); ";
		
		div.innerHTML+= dvTmp.outerHTML;
	}
	div.style.overflow= '';
	
	div.style.left = x;//event.clientX - (div.offsetWidth/2);
	div.style.top = y + obj.offsetHeight;//event.clientY;// - (div.offsetHeight/2);
	
	div.setAttribute('hFinal', div.offsetHeight);
	div.setAttribute('wFinal', div.offsetWidth);
	div.animCutOpen= cutOpen;
	
	setTimeout("try{document.attachEvent('onmousedown', hideOptions);}catch(error){document.addEventListener('mousedown', hideOptions, true);}", 100);
	f2j_selectedOptions= div;
	//div.animCutOpen(div.id);
	if(div.offsetHeight > 250)
	{
		div.style.height= '250px';
		div.style.width= div.offsetWidth + 40;
		div.style.overflow= 'auto';
	}
	if(div.offsetTop+div.offsetHeight > document.body.clientHeight - 40)
	{
		div.style.top= div.offsetTop-div.offsetHeight - obj.offsetHeight;
	}
	div.style.display= '';
}

//	esconder selects
function hideSelects()
{
	objSelectLists= document.getElementsByTagName('SELECT');
	for(i=0; i< objSelectLists.length; i++)
	{
		objSelectLists[i].style.visibility= 'hidden';
	}
}
