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
		
	function rhtBtMenu(event)
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
		obj= getBlockRhtBt(obj);
		top.rhtBtMenu(obj)
		cancelEvent(event);
		return false;
	}