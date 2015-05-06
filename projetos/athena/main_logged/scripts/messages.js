function sendUserMessage(formId, parentObj, textAreaId)
{
	// concatenar com "Data" na id do objeto correspondente ao parentObj
	if(!parentObj)
		parentObj= 'funcMsgList';
	document.getElementById(parentObj+'Data').value= valuesToString(parentObj, '|@@@|', '@@@');
	if(gebi(textAreaId).value.replace(/ /g, '') != '')
	{
		top.setLoad(true, 'Enviando mensagem');
		document.getElementById(formId).submit();
	}
}
function sendCircular(form, list, msg)
{
	msg= document.getElementById(msg)
	list= document.getElementById(list);
	form= document.getElementById(form);
	if(msg.value.replace(/ /g, '') == '')
		return false;
	list= list.getElementsByTagName('INPUT');
	for(var i=0; i< list.length; i++)
	{
		if(list[i].checked == true)
		{
			i= -1;
			break
		}
	}
	if(i>=0)
	{
		top.showAlert('informativo', 'Selecione ao menos um grupo destinat&aacute;rio');
		return false;
	}
	form.submit();
}