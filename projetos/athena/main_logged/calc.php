<?php
//session_start();
$acessoWeb= 8; // calculadora
require_once("inc/valida_sessao.php");
?>
<center>
<form name="frmCalc"
	  style="margin: 0px;
			 padding: 0px;
			 padding-top: 7px;">
	<fieldset style="width: 175px;
					 text-align: center;
					 margin-top: 7px;
					 padding-bottom: 7px;
					 padding-top: 7px;">
<table style="background-color : #f0f0f0;" width="100" align="center">
	<tr>
		<td>
		<table border="0" cellpadding="0" align="center">
			<tr>
				<td style="text-align: center;">
				<table border="0" cellpadding="0" align="center">
					<tr>
						<td style="text-align: center;">
						<table width="100%" border="0">
							<tr>
								<td colspan="6" style="text-align: center;">
									<input type="text"
										   name="edDisplay"
										   value="0"
										   oldValue="0"
										   maxlength="32"
										   onChange="DoNumber(this.value);"
										   style="width: 160px; text-align: right;"
										   onFocus="this.blur();"></td>
							</tr>
							<tr>
								<td colspan="5">
								<table border="0" cellpadding="0" width="100%">
									<tr>
										<td style="display: none;"><input type="text" name="edMem" size="3" maxlength="3" onFocus="this.blur();"></td>
										<td style="text-align: left;"><input type="button" style='width: 90px;' name="btnBksp" value="Backspace" onClick="Backspace(document.frmCalc.edDisplay.value); return false;"></td>
										<td style="text-align: right;"><input type="reset" style='width: 30px;' name="btnC" value="  C     " onClick="C(); return false;"></td>
										<td style="text-align: center;"><input type="button" style='width: 40px;' name="btnCE" value=" CE   " onClick="CE(); return false;"></td>
									</tr>
								</table>
							</tr>
							<tr>
								<!--<td><input type="button" name="btnMC" style="width: 40px; margin-right: 4px;" value=" MC " onClick="MemClear(); return false;"></td>-->
								<td><input type="button" name="btnN7" style="width: 30px;" value="  7   " onClick="DoNumber('7'); return false;"></td>
								<td><input type="button" name="btnN8" style="width: 30px;" value="  8   " onClick="DoNumber('8'); return false;"></td>
								<td><input type="button" name="btnN9" style="width: 30px;" value="  9   " onClick="DoNumber('9'); return false;"></td>
								<td><input type="button" name="btnDivide" style="width: 30px;" value="   /   " onClick="Operation('/'); return false;"></td>
								<td><input type="button" name="btnSqrt" style="width: 40px;" value="sqrt" onClick="DoSqrt(); return false;"></td>
							</tr>
							<tr>
								<!--<td><input type="button" name="btnMR" style="width: 40px;" value=" MR " onClick="MemRecall(); return false;"></td>-->
								<td><input type="button" name="btnN4" style="width: 30px;" value="  4   " onClick="DoNumber('4'); return false;"></td>
								<td><input type="button" name="btnN5" style="width: 30px;" value="  5   " onClick="DoNumber('5'); return false;"></td>
								<td><input type="button" name="btnN6" style="width: 30px;" value="  6   " onClick="DoNumber('6'); return false;"></td>
								<td><input type="button" name="btnMultiply" style="width: 30px;" value="   *   " onClick="Operation('*'); return false;"></td>
								<td><input type="button" name="btnPercent" style="width: 40px;" value=" %  " onClick="DoPercent(); return false;"></td>
							</tr>
							<tr>
								<!--<td><input type="button" name="btnMS" style="width: 40px;" value=" MS " onClick="MemStore(document.frmCalc.edDisplay.value); return false;"></td>-->
								<td><input type="button" name="btnN1" style="width: 30px;" value="  1   " onClick="DoNumber('1'); return false;"></td>
								<td><input type="button" name="btnN2" style="width: 30px;" value="  2   " onClick="DoNumber('2'); return false;"></td>
								<td><input type="button" name="btnN3" style="width: 30px;" value="  3   " onClick="DoNumber('3'); return false;"></td>
								<td><input type="button" name="btnMinus" style="width: 30px;" value="   -   " onClick="Operation('-'); return false;"></td>
								<td><input type="button" name="btnRecip" style="width: 40px;" value="1/x " onClick="DoRecip(); return false;"></td>
							</tr>
							<tr>
								<!--<td><input type="button" name="btnMPlus" style="width: 40px;" value=" M+  " onClick="MemAdd(document.frmCalc.edDisplay.value); return false;"></td>-->
								<td><input type="button" name="btnNegate" style="width: 30px;" value=" +/-  " onClick="DoNegate(); return false;"></td>
								<td><input type="button" name="btnN0" style="width: 30px;" value="  0   " onClick="DoNumber('0'); return false;"></td>
								<td><input type="button" name="btnDecimal" style="width: 30px;" value="   .   " onClick="DoDecimal(); return false;"></td>
								<td><input type="button" name="btnPlus" style="width: 30px;" value="   +  " onClick="Operation('+'); return false;"></td>
								<td><input type="button" name="btnEqual" style="width: 40px;" value="  =   " onClick="DoEqual(); return false;"></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</fieldset>
</form>
</center>