
function setOpacity(obj, opacityLevel)
{
	if (browser == "ie")
	{
		document.getElementById(obj).style.filter="alpha(opacity="+opacityLevel+")";
	}else{
			var opacidade = parseFloat(opacityLevel/100);
			if (opacityLevel == 1)
			{
				opacidade = 1.0;
			}
			document.getElementById(obj).style.MozOpacity= opacidade;
		 }
}

function flp_dd_doDrag(event)
{
	if (browser == 'ie')
	{ // 1
		if (event.button != '1')
		{
			return false;
		}
	}else{	// 0
			if (event.button != '0')
			{
				return false;
			}
		 }
	try
	{
		try
		{
			flp_objToDrag = document.getElementById(this.getAttribute('flp_anchorFor'));
		}
		catch (error)
		{
			flp_objToDrag = document.getElementById(event.srcElement.flp_anchorFor);
		}
		flp_dd_GLOBAL_objToDrag = flp_objToDrag;
		flp_dd_GLOBAL_left = event.clientX - parseInt(flp_dd_GLOBAL_objToDrag.style.left);
		flp_dd_GLOBAL_top  = event.clientY - parseInt(flp_dd_GLOBAL_objToDrag.style.top);
		try
		{
			if(flp_dd_GLOBAL_objToDrag.getAttribute('drag_hability') == 'false')
			{
				return false;
			}
		}catch(e)
		{}

		if(dragOpacity == true)
		{
			setOpacity(flp_dd_GLOBAL_objToDrag.id, 75);
		}

		flp_dd_GLOBAL_objToDrag.style.zIndex= zMax + 2;
		zMax++;
		
		try
		{
			document.attachEvent("onmousemove", flp_dd_doAnd);
		}
		catch (error)
		{
			window.addEventListener("mousemove", flp_dd_doAnd, false);
		}
		return;
	}
	catch (error)
	{
	}
}

function flp_dd_doAnd(event)
{
	if (browser == 'ie')
	{ // 1
		if (event.button != '1')
		{
			return false;
		}
	}else{	// 0
			if (event.button != '0')
			{
				return false;
			}
		 }
	flp_dd_GLOBAL_objToDrag.style.left= event.clientX-flp_dd_GLOBAL_left;
	flp_dd_GLOBAL_objToDrag.style.top= event.clientY-flp_dd_GLOBAL_top;
}

function flp_dd_doDrop(event)
{
	if (browser == 'ie')
	{ // 1
		if (event.button != '1')
		{
			return false;
		}
	}else{	// 0
			if (event.button != '0')
			{
				return false;
			}
		 }
	if(dragOpacity == true)
	{
		try 
		{
			setOpacity(flp_dd_GLOBAL_objToDrag.id, 100);
		}
		catch(error)
		{}
	}
	flp_dd_GLOBAL_objToDrag = false;
	/**************************/
	try
	{
		setPositionAtt(flp_dd_GLOBAL_objToDrag)
	}catch(error)
	{}
	/**************************/
	
	try
	{
		document.detachEvent("onmousemove", flp_dd_doAnd);
	}
	catch (error)
	{
		window.removeEventListener("mousemove", flp_dd_doAnd, false);
	}
	return;
}

function flp_makeItDragable(obj, objAnchor)
{
	obj = obj.replace(/ /g, "");
	if(objAnchor)
	{
		objAnchor = objAnchor.replace(/ /g, "");
	}else{
			objAnchor = "";
			objAnchor = obj;
		 } 
	obj = obj.split(",");
	objAnchor = objAnchor.split(",");
	for (i=0; i<obj.length; i++)
	{
		objName= obj[i];
		obj[i] = Array();
		obj[i]['obj']= document.getElementById(objName);
		obj[i]['ancora']= objAnchor;

		for (ii=0; ii<obj[i]['ancora'].length; ii++)
		{
			obj[i]['ancora'][ii] = document.getElementById(obj[i]['ancora'][ii]);
			obj[i]['ancora'][ii].setAttribute("flp_anchorFor", obj[i]['obj'].id);
			try
			{
				obj[i]['ancora'][ii].attachEvent("onmousedown", flp_dd_doDrag);
				obj[i]['ancora'][ii].attachEvent("onmouseup", flp_dd_doDrop);
			}
			catch (error)
			{
				obj[i]['ancora'][ii].addEventListener("mousedown", flp_dd_doDrag, false);
				obj[i]['ancora'][ii].addEventListener("mouseup", flp_dd_doDrop, false);
			}
		}
	}
}