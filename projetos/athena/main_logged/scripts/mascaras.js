function validaMascaraCPF()
{
	obj= this;
	var CPF = obj.value.replace(/ /g, '');
	CPF= CPF.replace(/\./g, '');
	CPF= CPF.replace(/-/g, '');

	// Verifica se o campo é nulo
	if (CPF == '')
	{
		//alert('Este campo é de preenchimento obrigatório!');
		return false;
	}

	// Aqui começa a checagem do CPF
	var POSICAO, I, SOMA, DV, DV_INFORMADO;
	var DIGITO = new Array(10);
	DV_INFORMADO = CPF.substr(9, 2); // Retira os dois últimos dígitos do número informado

	// Desemembra o número do CPF na array DIGITO
	for (I=0; I<=8; I++)
	{
		DIGITO[I] = CPF.substr( I, 1);
	}

	// Calcula o valor do 10º dígito da verificação
	POSICAO = 10;
	SOMA = 0;
	for (I=0; I<=8; I++)
	{
		SOMA = SOMA + DIGITO[I] * POSICAO;
		POSICAO = POSICAO - 1;
	}
	DIGITO[9] = SOMA % 11;
	if (DIGITO[9] < 2)
	{
		DIGITO[9] = 0;
	}else{
			DIGITO[9] = 11 - DIGITO[9];
		 }

	// Calcula o valor do 11º dígito da verificação
	POSICAO = 11;
	SOMA = 0;
	for (I=0; I<=9; I++)
	{
		SOMA = SOMA + DIGITO[I] * POSICAO;
		POSICAO = POSICAO - 1;
	}
	DIGITO[10] = SOMA % 11;
	if (DIGITO[10] < 2)
	{
		DIGITO[10] = 0;
	}else{
			DIGITO[10] = 11 - DIGITO[10];
		 }

	// Verifica se os valores dos dígitos verificadores conferem
	DV = DIGITO[9] * 10 + DIGITO[10];
	if (DV != DV_INFORMADO)
	{
		//alert('CPF inválido');
		obj.style.border= 'solid 1px red';
		//obj.value = '';
		//obj.focus();
		return false;
	}else{
			obj.style.border= 'solid 1px blue';
		 }
}

function mascaraCPF(obj, event)
{
	obj.setAttribute('maxLength', 14);
	obj.onblur= validaMascaraCPF;
	if(
		event.keyCode != 8
		&& event.keyCode != 46
		&& event.keyCode != 37
		&& event.keyCode != 38
		&& event.keyCode != 39
		&& event.keyCode != 40
	  )
	{
		conteudoI= returnNum(obj.value);
		conteudoF= conteudoI;
		if(conteudoI.length >2 && conteudoI.length<6)
		{
			conteudoF= conteudoI.substring(0,3)+'.'+conteudoI.substring(3,6);
		}else if(conteudoI.length >=6 && conteudoI.length<9)
			  {
				//alert(conteudoI);
				conteudoF= conteudoI.substring(0,3)+'.'+conteudoI.substring(3,6)+'.'+conteudoI.substring(6,10);
			  }else if(conteudoI.length >=9)
					{
						conteudoF= conteudoI.substring(0,3)+'.'+conteudoI.substring(3,6)+'.'+conteudoI.substring(6,9)+'-'+conteudoI.substring(9,15);
					}
		obj.value= conteudoF.substring(0,14);
	}else{
		 }
}

function validaEMail(formObj)
{
	/*
		VALIDADOR DE E-MAIL
	*/
	if (formObj.value.replace(/ /g, '') != "")
	{
		if ((ar_mail= formObj.value.split("@")).length == 2)
		{
			if (ar_mail[0] == "" || (ar_mail[1].split(".").length < 2 || ar_mail[1].split(".").length > 3))
			{
				formObj.style.border= 'solid 1px red';
				return false;
			}else{
					formObj.style.border= 'solid 1px blue';
					return true;
				 }
		}else{
				formObj.style.border= 'solid 1px red';
				return false;
			 }
	}else{
			if (formObj.getAttribute('required') == "true")
			{
				formObj.style.border= 'solid 1px red';
				return false;
			}else{
					formObj.style.border= 'solid 1px blue';
					return true;
				 }
		 }
}

function numOnly(obj)
{
	obj.value= returnNum(obj.value);
}

function returnNum(valor)
{
	valor= valor.replace(/[a-z]/gi, '');
	valor= valor.replace(/ /gi, '');
	valor= valor.replace(/[ç,!,@,#,$,%,¨,&,*,(,),\-,_,+.\§,\º,\,,\[,\],\/,~,^,?,\{,\},\\,\|,\',\,\.,<,>,\;,\:"]/gi, '');
	return valor;
}

function mascaraCEP(obj)
{
	obj.setAttribute('maxLength', 9);
	valor= obj.value.replace(/-/g, '');
	valor= parseInt(valor);
	valor= valor+'';
	//alert(valor.substring(2,9));
	if(valor.length >= 5)
	{
		valor= valor.substring(0,5)+'-'+valor.substring(5,9);
	}
	obj.value= valor.replace('NaN', '');
}

function formataData(obj, event)
{
	obj.setAttribute('maxLength', 10);
	obj.style.textAlign= 'center';
	if(
		event.keyCode != 8
		&& event.keyCode != 46
		&& event.keyCode != 37
		&& event.keyCode != 38
		&& event.keyCode != 39
		&& event.keyCode != 40
	  )
	{
		valor= returnNum(obj.value);
		dia= valor.substring(0,2);
		mes= valor.substring(2,4);
		ano= valor.substring(4,10);
		obj.value= dia;
		if(valor.length > 2)
			obj.value+= '/'+mes;
		if(valor.length > 4)
			obj.value+= '/'+ano;
	}
}