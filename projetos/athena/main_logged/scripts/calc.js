//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
//																																		\\
// eCalc 1.0 beta 																										\\
// ------------------------------------------------------------------	\\
// Author: Emil Malinov                		 Last modified: 2001-02-22	\\
// Bug reports, suggestions, source related questions please send to:	\\
// emets@paradise.net.nz																							\\
//																																		\\
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\

//constants
var MAXBIN = "11111111111111111111111111111111";
var MAXOCT = "37777777777";
var MAXDEC = "4294967295";
var MAXHEX = "ffffffff";

//global variables
var fCalc = document.frmCalc;								//just a shortcut
//var document.frmCalc.edDisplay = document.frmCalc.edDisplay;	//just a shortcut
var Accum = 0;															//the first operand
var Num = 0;																//the second operand
var Mem = 0; 																//number stored in memory
var Op = "";																//operation
var OpPending = false;											//flag to indicate pending operation
var ClrOnEntry = false;											//flag to indicate if number display is to be cleared
var Base = 10;															//current number base

//show a number in the display edit box
function Show(aNum)
{
	if (aNum == "NaN")
	{
		ErrMsg(1003);
		C();
		return;
	}
	if (aNum == "Infinity")
	{
		ErrMsg(1004);
		C();
		return;
	}
	document.frmCalc.edDisplay.value = aNum;
}

//handle number buttons
function DoNumber(aNum)
{
	var curNum = document.frmCalc.edDisplay.value;
	switch (Base)
	{
		case 2 :
			if ((aNum != "0") && (aNum != "1")) return;
			if ((ClrOnEntry == false) && (curNum.length >= 32))
			{
				ErrMsg(1005, "32", "2");
				return;
			}
			break;
		case 8 :
			if ((aNum == "8") || (aNum == "9")) return;
			if ((ClrOnEntry == false) && (curNum.length >= 10))
			{
				ErrMsg(1005, "10", "8");
				return;
			}
			break;
		case 10 :
			if ((ClrOnEntry == false) && (curNum.length >= 32))
			{
				ErrMsg(1005, "32", "10");
				return;
			}
			break;
		case 16 :
			if ((ClrOnEntry == false) && (curNum.length >= 8))
			{
				ErrMsg(1005, "8", "16");
				return;
			}
		 	break;
	}

	if (curNum == "0" || ClrOnEntry == true)
	{
		Num = aNum;
		Show(Num);
		ClrOnEntry = false;
	}
	else
	{
		curNum += aNum;
		Num = curNum;
		Show(Num);
	}
}

//handle letter buttons
function DoLetter(aChar)
{
	var curNum = document.frmCalc.edDisplay.value;
	if (Base != 16) return;
	if ((ClrOnEntry == false) && (curNum.length >= 8))
	{
		ErrMsg(1005, "8", "16");
	 	return;
	}
	if (curNum == "0" || ClrOnEntry == true)
	{
		Num = aChar;
		Show(Num);
		ClrOnEntry = false;
	}
	else
	{
		curNum += aChar;
		Num = curNum;
		Show(Num);
	}
}

//handle the decimal button
function DoDecimal()
{
	var curNum = document.frmCalc.edDisplay.value;
	if (Base != 10) return;
	if (curNum.indexOf(".") == -1) curNum += ".";
	Num = curNum;
	Show(Num);
}

//set the operation
function Operation(aOp)
{
	Op = aOp;
	OpPending = true;
	ClrOnEntry = true;
	if (Base == 10)
	{
		Accum = parseFloat(document.frmCalc.edDisplay.value);
	}
	else
	{
		Accum = parseFloat(BaseToDec(document.frmCalc.edDisplay.value, Base));
	}
}

//perform the calculation
function DoEqual()
{
	var aNum = 0;
	if (OpPending)
	{
		if (Base == 10)
		{
			switch (Op)
			{
  			case "+" :
    			Accum += parseFloat(Num);
      		break;
   			case "-" :
	 				Accum -= parseFloat(Num);
      		break;
				case "*" :
					Accum *= parseFloat(Num);
					break;
				case "/" :
					if (parseFloat(Num) == 0)
						ErrMsg(1002);
					else
						Accum /= parseFloat(Num);
					break;
			}
			Show(Accum);
		}
		else
		{
			switch (Op)
			{
  			case "+" :
    			Accum += BaseToDec(document.frmCalc.edDisplay.value, Base);
      		break;
   			case "-" :
	 				Accum -= BaseToDec(document.frmCalc.edDisplay.value, Base);
      		break;
				case "*" :
					Accum *= BaseToDec(document.frmCalc.edDisplay.value, Base);
					break;
				case "/" :
					if (parseFloat(document.frmCalc.edDisplay.value) == 0)
						ErrMsg(1002);
					else
						Accum /= BaseToDec(document.frmCalc.edDisplay.value, Base);
					break;
			}
			aNum = Accum;
			Show(DecToBase(aNum, Base));
		}
  }
	ClrOnEntry = true;
}

function DoSqrt()
{
	if (Base != 10) return;
	if (parseFloat(document.frmCalc.edDisplay.value) < 0)
		ErrMsg(1002);
	else
	{
		Num = Math.sqrt(parseFloat(document.frmCalc.edDisplay.value));
		Show(Num);
	}
}

function DoPercent()
{
	if (Base != 10) return;
	Num = (parseFloat(document.frmCalc.edDisplay.value) / 100) * parseFloat(Accum);
	Show(Num);
}

function DoRecip()
{
	if (Base != 10) return;
	Num = 1 / parseFloat(document.frmCalc.edDisplay.value);
	Show(Num);
}

function DoNegate()
{
	if (Base == 10)
	{
		Num = parseFloat(document.frmCalc.edDisplay.value) * -1;
	}
	else
	{
		Num = BaseToDec(document.frmCalc.edDisplay.value, Base) * -1;
		Show(Num);
		Num = DecToBase(document.frmCalc.edDisplay.value, Base);
	}
	Show(Num);
}

//delete the last digit of the displayed number
function Backspace(aNum)
{
	var length = aNum.length;
	aNum = aNum.substring(0, length - 1);
	if (document.frmCalc.edDisplay.value != "")
	{
		Num = aNum.toString();
		if (Num == "") Num = 0;
		Show(Num);
	}
}

//clear the displayed number
function CE()
{
	Num = 0;
	Show(Num);
}

//clear the current calculation
function C()
{
	OpPending = false;
	ClrOnEntry = false;
	Accum = 0;
	Num = 0;
	Show(Num);
}

//clear the number storred in memory
function MemClear()
{
	Mem = 0;
	fCalc.edMem.value = "";
}

//recall the storred number from memory
function MemRecall()
{
	if (fCalc.edMem.value == " M ")
	{
		if (Base != 10)
			Accum = DecToBase(Mem, Base);
		else
			Accum = Mem;
		Show(Accum);
	}
}

//store the displayed number in memory
function MemStore(aNum)
{
	if (aNum != "0")
	{
		if (Base != 10)
			Mem = eval(BaseToDec(aNum, Base));
		else
			Mem = eval(aNum);
		fCalc.edMem.value = " M ";
	}
	ClrOnEntry = true;
}

//add the displayed number to any number already in memory
function MemAdd(aNum)
{
	if (Base != 10)
		Mem += eval(BaseToDec(aNum, Base));
	else
		Mem += eval(aNum);
	if (Mem.length > 32) Mem = Mem.substr(0,32);

	fCalc.edMem.value = " M ";
	ClrOnEntry = true;
}

function rgSelectedIndex(RadioGroup)
{
	var i = 0;
	var idx = -1;
	for (i = 0; i < RadioGroup.length; i++)
	{
		if (RadioGroup[i].checked == true)
		{
			idx = i;
			break;
		}
	}
	return idx;
}

function DoBase()
{
	var idx = rgSelectedIndex(fCalc.base);
	switch (idx)
	{
		case 0 :
    	Convert(Base, 16);
      break;
		case 1 :
			Convert(Base, 10);
			break;
		case 2 :
			Convert(Base, 8);
			break;
		case 3 :
			Convert(Base, 2);
			break ;
	}
}

function Convert(fromBase, toBase)
{
	var aNum = 0;
	if (fromBase != toBase)
	{
		Base = toBase;
		if (fromBase == 10)
		{
			aNum = DecToBase(document.frmCalc.edDisplay.value, toBase);
			Show(aNum);
		}
		else
		{
			if (toBase == 10)
			{
				aNum = BaseToDec(document.frmCalc.edDisplay.value, fromBase);
				Show(aNum);
			}
			else
			{
				aNum = BaseToDec(document.frmCalc.edDisplay.value, fromBase);
				Show(aNum);
				aNum = DecToBase(document.frmCalc.edDisplay.value, toBase);
				Show(aNum);
			}
		}
	}
}

function DecToBase(aValue, toBase)
{
	var rExp = /[(\+\)]/;
	var aNum = 0;
	if (rExp.test(aValue) == true)
	{
		ErrMsg(1006, aValue, MAXDEC);
		aNum = parseInt(MAXDEC);
	}
	else
		aNum = parseInt(aValue);
	if (aNum < 0)
	{
		aNum = aNum * -1;
		aNum = aNum.toString(toBase);
		aNum = "-" + aNum;
	}
	else
		aNum = aNum.toString(toBase);
	if (rExp.test(aNum) == true)
	{
		switch (toBase)
		{
			case 2 :
				ErrMsg(1006, aNum, MAXBIN);
				aNum = MAXBIN;
				break;
			case 8 :
				ErrMsg(1006, aNum, MAXOCT);
				aNum = MAXOCT;
				break;
			case 16 :
				ErrMsg(1006, aNum, MAXHEX);
				aNum = MAXHEX;
				break;
		}
	}
	return aNum;
}

function BaseToDec(aValue, fromBase)
{
	var aNum = 0;
	var curNum = 0;
	var i = 0;
	var s = aValue;
	var c = aValue.substr(0,1);
	var SignChanged = false;
	if (c == "-")
	{
		s = aValue.substr(1, aValue.length -1);
		SignChanged = true;
	}
	for (i = 0; i < s.length; i++)
	{
		c = s.substr(i,1);
		switch (c)
		{
			case "a" :
				curNum = 10;
      	break;
			case "b" :
				curNum = 11;
				break;
			case "c" :
				curNum = 12;
				break;
			case "d" :
				curNum = 13;
				break;
			case "e" :
				curNum = 14;
				break;
			case "f" :
				curNum = 15;
				break;
			default :
				curNum = eval(s.substr(i,1));
		}
		aNum = aNum * fromBase + curNum;
	}
	if (SignChanged == true) aNum = aNum * -1;
	return aNum;
}

function ErrMsg(errCode, param1, param2)
{
	switch (errCode)
	{
		case 1001 :
			alert("Informação! Não é permitida edição direta deste campo, utilize os botões.");
			fCalc.btnN0.focus();
      break;
		case 1002 :
			alert("Erro! Entrada inválida para função.");
			break;
		case 1003 :
			alert("Erro! Não é um número.");
			break;
		case 1004 :
			alert("Erro! Número muito grante.");
			break;
		case 1005 :
			alert("Informação! Número máximo de dígitos: " + param1 + " para base " + param2 + "");
			break;
		case 1006 :
			alert("Erro! Número " + param1 + " muito grande para converter, o valor será truncado em " + param2 + ".");
			break;
	}
}