
function funcAdd(pre)
{
	cliente_endereco_residencial= document.getElementById(pre+'func_endereco_values');
	iptEmails= document.getElementById(pre+'func_email_values');
	iptFone= document.getElementById(pre+'func_telefone_values');
	iptContato= document.getElementById(pre+'func_contato_values');
	iptDependentes= document.getElementById(pre+'dependenteList');
	ar_residenc= document.getElementById(pre+'cliente_endereco_tbody_pai').getElementsByTagName('table');
		cliente_endereco_residencial.value = '';
		for (i=0; i<ar_residenc.length; i++)
		{
			inputs = ar_residenc[i].getElementsByTagName('INPUT');
			for (j=0;j<inputs.length;j++)
			{
				if(inputs[j].getAttribute('type') != 'button' && inputs[j].getAttribute('type') != 'submit' && inputs[j].getAttribute('type') != 'reset')
					if(inputs[j].getAttribute('type')=='checkbox')
					{
						if(inputs[j].checked == 1)
							cliente_endereco_residencial.value += 'on'+'||';
						else
							cliente_endereco_residencial.value += 'off'+'||';
					}else
						cliente_endereco_residencial.value += inputs[j].value.replace(/\|/g, '')+'||';
			}
			inputs = ar_residenc[i].getElementsByTagName('SELECT');
			for (j=0;j<inputs.length;j++)
			{
				cliente_endereco_residencial.value += inputs[j].value.replace(/\|/g, '')+'||';
			}
			cliente_endereco_residencial.value +='|+|';
		}
	// iptEnd.value= valuesToString(pre+'cliente_endereco_tbody_pai');
	iptEmails.value= valuesToString(pre+'clienteEmailList');
	iptFone.value= valuesToString(pre+'clienteFoneList');
	iptDependentes.value= valuesToString(pre+'dependente');
	//iptContato.value = valuesToString(pre+'clienteContatoList');
	document.getElementById('func_add_form').submit();
}

function showFuncionarioTipoDoc()
{
	if(document.getElementById('selectTipoPessoa').value == 'F')
	{
		document.getElementById('td_funcionario_cpf').style.display = '';
		document.getElementById('td_funcionario_cnpj').style.display = 'none';
		document.getElementById('funcionarioCNPJ').value='';
	}else
	     {
			document.getElementById('td_funcionario_cnpj').style.display = '';
			document.getElementById('td_funcionario_cpf').style.display = 'none';
			document.getElementById('funcionarioCPF').value='';
	     }
}

function setGrupoGerUsuarioGrupo(obj)
{
	obj.setAttribute('altColor', '#aaaaaa');
	if(settedGrupoGerUsuarioGrupo == obj)
		return false;
	objParent= obj.parentNode.parentNode;
	objParent= objParent.getElementsByTagName('tr');
	for(i=0; i<objParent.length; i++)
	{
		objParent[i].getElementsByTagName('td')[0].style.fontWeight= 'normal';
	}
	obj.style.fontWeight= 'bold';
}

function showUsersFromGroup(pk_grupo, s_grupo, userToAdd, mode)
{
	url= "usuarios_list.php?pk_grupo="+pk_grupo+'&s_grupo='+s_grupo;
	if(userToAdd)
		url+= '&userToAdd='+userToAdd;
	if(mode)
		url+= '&mode='+mode;
	onlyEvalAjax(url, '', "ajax= ajax.split('<flp_script>'); if(ajax[0]=='false'){ try{ eval(ajax[1]); }catch(error){}}else{ ajax= ajax[0]; document.getElementById('ger_usuario_user_list').innerHTML= ajax;}");
}

function showLogs(pk_usuario, dt_ini, dt_fin)
{
	url= "logs_list.php?logs_viewer_PkUsuario="+pk_usuario+"&logs_viewer_dtFin="+dt_fin+"&logs_viewer_dtIni="+dt_ini;
	onlyEvalAjax(url, '', "ajax= ajax.split('<flp_script>'); if(ajax[0]=='false'){ try{ eval(ajax[1]); }catch(error){}}else{ ajax= ajax[0]; document.getElementById('logs_viewer_contents').innerHTML= ajax;}");
}

function deleteUsersGroup(pk_grupo)
{
	url= "grupo_del.php?pk_grupo="+pk_grupo;
	top.setLoad(true);
	onlyEvalAjax(url, '', "eval(ajax);");
}
function showFieldDeficiencia()
{
	if(document.getElementById('bl_deficiencia').checked == true)
	{
		document.getElementById('td_deficiencia').style.display = '';
		document.getElementById('funcionarioDeficiencia').focus();
	}else{
			document.getElementById('td_deficiencia').style.display = 'none';
		 }
}

function choseSystemAccess(obj)
{
	// var pwd= obj.value;
	// var login= obj.value;
		////LOGIN
	// while(login.length < 10)
		// login+= login;
		////SENHA
	// var specialChars= Array['@', '!', '#', '$', '%', '&'];
	// pwd= pwd.replace(/ /g, '_');
	// pwd= pwd.replace(/e/gi, '3');
	// pwd= pwd.replace(/i/gi, '1');
	// pwd= pwd.replace(/l/gi, '7');
	// pwd= pwd.replace(/a/gi, '4');
	// pwd= pwd.replace(/o/gi, '0');
	// pwd= pwd.replace(/\./gi, '#');
	// pwd= pwd.replace(/s/gi, '2');
	// while(pwd.length < 10)
		// pwd+= pwd;
	
	// alert(pwd);
}









