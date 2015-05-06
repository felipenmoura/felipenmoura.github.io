function agenda_contato_edit()
{
	if(document.getElementById('s_edit_nome').value.length >= 4)
	{
		//alert('a')
		a= document.forms;
		//alert('b')
		a['agenda_contato_edit_form'].submit();
		//alert('c')
		return true;
	}
	else{
			alert('Sera necessario um nome com ao menos 4 caracteres');
		}
}

function excluiContatoAgenda(pk)
{
	onlyEvalAjax('exclui_contato_agenda.php?pk_contato='+pk, 'top.setLoad(true)', 'top.setLoad(false); ajax=ajax.split("<flp_script>"); try{ eval(ajax[1]); }catch(error){} document.getElementById("agenda_contatos_grupos_lista").innerHTML= ajax[0]');
}