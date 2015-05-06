function cancelEvent(event)
{
	if (event && event.preventDefault)
		event.preventDefault(); // DOM style
	return false; // IE style
}