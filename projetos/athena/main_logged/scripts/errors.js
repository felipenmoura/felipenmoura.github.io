function handleErr(msg,url,l)
{
	// funcao para controle e personalisacao de erros
	top.showAlert('erro', 'Ocorreu um erro durante a execu��o de algum script inernamente no Sistema Web, tente efetuar logoff e logar-se novamente, caso o problema persista, entre em contato com o suporte.<br>-----------------<br><b>Descricao t�cnica do erro:</b> '+ msg+'<br><b>arquivo:</b> '+url+'<br><b>linha:</b> '+l);
	return false;
}
window.onerror= handleErr;