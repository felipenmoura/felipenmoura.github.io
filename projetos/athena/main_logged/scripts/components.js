function atualizaComponents(componentType)
{
	components= document.getElementsByTagName('select');
	for(i=0; i<components.length; i++)
	{
		if(components[i].getAttribute('componentType') == componentType)
		{
			//alert(components[i].parentNode.parentNode.innerHTML);
			url="components.php?component="+componentType+"&componentId="+components[i].id;
			onlyEvalAjax(url, '', "document.getElementById('"+components[i].id+"').parentNode.parentNode.innerHTML= ajax;");
		}
	}
}