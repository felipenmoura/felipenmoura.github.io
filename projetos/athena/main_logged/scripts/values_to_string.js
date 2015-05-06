function valuesToString(parentObj, line, field)
{
	line= (!line)? '|+|': line;
	field= (!field)? ';;;': field;
	if(!parentObj.tagName)
		parentObj= document.getElementById(parentObj);
	// pega todas as linhas (de taeblas ou listas)
	lines= parentObj.getElementsByTagName('TR');
	if(lines.length == 0)
		lines= parentObj.getElementsByTagName('LI');
	str= "";
	for(i=0; i<lines.length; i++)
	{
		// pega os inputs das linhas
		inputs= lines[i].getElementsByTagName('INPUT');
		for(ii=0; ii<inputs.length; ii++)
		{
			if(inputs[ii].type != 'button' && inputs[ii].type != 'submit' && inputs[ii].type != 'reset')
			{
				if( /* inputs[ii].type == 'radio' || */ inputs[ii].type == 'checkbox')
				{
					if(inputs[ii].checked == true)
						str+= "1";
					else
						str+= "0";
				}else{
						inputs[ii].value= inputs[ii].value.replace(/line/g, ';');
						if(inputs[ii].value.replace(/field/g, '| + |') != 'Selecione...')
						{
							if(inputs[ii].getAttribute('code'))
							{
								var strTmp= inputs[ii].getAttribute('code')+'';
								str+= strTmp.replace(/field/g, '| + |');
							}else{
									str+= inputs[ii].value.replace(/field/g, '| + |');
								 }
						}
					 }
			}
			str+= field;
		}
		str+= line;
	}
	return str;
}