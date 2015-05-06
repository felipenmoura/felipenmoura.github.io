/*
	Funçoes para Processos
*/
function insertDataProcesso(preId)	//	quebrar as linhas por ||| e os campos por |-|
{
	top.setLoad(true);
	document.getElementById(preId+'list_clientes').value = valuesToString(preId+'processoClienteList', '|-|', '|||');
	document.getElementById(preId+'processoAddForm').submit();
}
/*
function addLitisConsorcio()
{
	document.getElementById('td_litis_consorcio').style.display = '';
}
*/

function gerenciarProcessosEdit()
{
	if(this.tipo == 'processo')
	{
		//creatBlock('Alterar - '+this.text, 'processo/edit_processo.php?pk_processo='+this.code+'&nome='+this.text,'edit_processo',false,false,'750/500');
		top.setLoad(true);
		onlyEvalAjax('processo/edit_processo.php?pk_processo='+this.getAttribute('code'), '', 'document.getElementById(\'corpo_ger_processo_add\').innerHTML=ajax')
	}
}

function addClienteProcesso(){
	tr = document.createElement('TR');
	td = document.createElement('TD');
	td.innerHTML = "dasdasdasdasdas"; 
	alert(td.innerHTML);
	tr.appendChild(td);
	document.getElementById('clienteProcessoTbody').appendChild(tr);
}

function procAdd(formId){
	document.getElementById(formId).submit;
}