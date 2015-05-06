function showOpCadastro(pre)
{
	if(!pre)
		pre= '';
	if (document.getElementById(pre+'op_fisica').checked == true)
	{
		document.getElementById(pre+'clienteAdd_tb_visivel').appendChild(document.getElementById(pre+'tbodyClienteFisica'));
		document.getElementById(pre+'clienteAddInvisibleDiv').appendChild(document.getElementById(pre+'tbodyClienteJuridico'));
	}else{
			document.getElementById(pre+'clienteAddInvisibleDiv').appendChild(document.getElementById(pre+'tbodyClienteFisica'));
			document.getElementById(pre+'clienteAdd_tb_visivel').appendChild(document.getElementById(pre+'tbodyClienteJuridico'));
		 }
}
function gerClienteClick()
{
	if(this.getAttribute('tipo') == 'cliente')
	{
		top.setLoad(true);
		onlyEvalAjax('ger_cliente_edit.php?pk_cliente='+this.getAttribute('code'), '', 'document.getElementById(\'corpo_ger_cliente_add\').innerHTML=ajax')
	}
}