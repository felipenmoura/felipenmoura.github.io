function getBlockRhtBt(obj)
{
	while(!obj.getAttribute('rhtmenuclass'))
	{
		if(obj.tagName == "BODY")
			return false;
		if(!obj.getAttribute('rhtmenuclass'))
			obj= obj.parentNode;
	}
	return obj;
}

function rightBtMenu(event)
{
	try
	{
		obj= event.srcElement;
		if(!obj.tagName)
			return false;
	}catch(exception)
	{
		obj= event.target;
		if(!obj.tagName)
			return false;
	}
	try
	{
		rhtMenuClass= obj.getAttribute('rhtmenuclass');
	}catch(error)
	{
		cancelEvent(event);
		return false;
	}
	objTarget= obj;
	obj= getBlockRhtBt(obj);
	top.rhtBtMenu(obj, objTarget)
	cancelEvent(event);
	return false;
}