function showOpContato()
{
	if (document.getElementById('op_contatoFisica').checked == true)
	{
		document.getElementById('contatoAdd_tb_visivel').appendChild(document.getElementById('tbodyContatoFisica'));
		document.getElementById('contatoAddInvisibleDiv').appendChild(document.getElementById('tbodyContatoJuridico'));
	}else{
			document.getElementById('contatoAddInvisibleDiv').appendChild(document.getElementById('tbodyContatoFisica'));
			document.getElementById('contatoAdd_tb_visivel').appendChild(document.getElementById('tbodyContatoJuridico'));
		 }
}
function expandContactGroup(id)
{
	if(document.getElementById('left_group_contact_'+id).innerHTML == '+')
	{
		document.getElementById('group_contact_'+id).style.display= '';
		document.getElementById('left_group_contact_'+id).innerHTML= '-';
	}else{
			document.getElementById('group_contact_'+id).style.display= 'none';
			document.getElementById('left_group_contact_'+id).innerHTML= '+';
		 }
}

function gerContatoClick()
{
	if(this.getAttribute('tipo') == 'contato')
	{
		top.setLoad(true);
		onlyEvalAjax('ger_contato_edit.php?pk_contato='+this.getAttribute('code'), '', 'document.getElementById(\'corpo_ger_contato_add\').innerHTML=ajax')
	}
}
function gerFiliaisClick()
{
	if(this.getAttribute('tipo') == 'filial')
	{
		top.setLoad(true);
		onlyEvalAjax('ger_filiais_edit.php?pk_contato='+this.getAttribute('code'), '', 'document.getElementById(\'corpo_ger_filial_add\').innerHTML=ajax')
	}
}