function menuUnset(event)
{
	if(top.settedMenu != null)
		top.menuUnset();
}

function rhtSubMenu()
{
	if(top.rhtBtSubMenu != null)
	{
		top.rhtBtSubMenu.style.display= 'none';
		top.rhtBtSubMenu= null;
	}
}

