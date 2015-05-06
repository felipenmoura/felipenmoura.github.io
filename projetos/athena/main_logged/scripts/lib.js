function gebi(id, parentEl)
{
	if(parentEl)
		if(parentEl.tagName)
			return parentEl.getElementById(id);
		else
			return document.getElementById(tagName).getElementById(id);
	return document.getElementById(id);
}
function gebt(tag, parentEl)
{
	if(parentEl)
		if(parentEl.tagName)
			return parentEl.getElementsByTagName(tag.toUpperCase());
		else
			return document.getElementById(parentEl).getElementsByTagName(tag.toUpperCase());
	return document.getElementsByTagName(tag.toUpperCase());
}
function newObj(element)
{
	element= document.createElement(element);
	element.setAttribute('style', '');
	return element;
}
function getBody()
{
	return document.getElementsByTagName('BODY')[0];
}
function setEvent(obj, evento, func, param)
{
	try
	{
		obj.attachEvent(evento, func);
	}catch(error)
	{
		if(!param)
			param= true;
		obj.addEventListener(evento, func, param);
	}
}
function unsetEvent(obj, evento, func)
{
	try
	{
		obj.detachEvent(evento, func);
	}catch(error)
	{
		obj.removeEventListener(evento, func, param);
	}
}
function newId(pre, pos)
{
	var letras= new Array();
	letras[0]= 'A';
	letras[1]= 'B';
	letras[2]= 'C';
	letras[3]= 'D';
	letras[4]= 'E';
	letras[5]= 'F';
	letras[6]= 'G';
	letras[7]= 'H';
	letras[8]= 'I';
	letras[9]= 'J';
	letras[10]= 'K';
	letras[11]= 'L';
	letras[12]= 'M';
	letras[13]= 'N';
	letras[14]= 'O';
	letras[15]= 'P';
	letras[16]= 'Q';
	letras[17]= 'R';
	letras[18]= 'S';
	letras[19]= 'T';
	letras[20]= 'U';
	letras[21]= 'V';
	letras[22]= 'X';
	letras[23]= 'Y';
	letras[24]= 'Z';
	if(pre)
		var id= pre;
	else
		var id= letras[parseInt((Math.random() * 100)/4)];
	var dt= new Date();
	id+= '_'+dt.getFullYear();
	id+= ''+dt.getMonth();
	id+= ''+dt.getDate();
	id+= ''+dt.getHours();
	id+= ''+dt.getMinutes();
	id+= ''+dt.getSeconds();
	id+= ''+dt.getMilliseconds();
	if(pos)
		id+= pos;
	return id;
}