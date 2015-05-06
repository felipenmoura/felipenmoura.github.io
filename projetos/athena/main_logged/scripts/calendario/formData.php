<?
#########################################################################################################
#
#           BRASGEO MAPEAMENTO E CONSULTORIA
#
#           Desenvolvido por: Cristiano Jacobsen
#           Modificado por:
#
#########################################################################################################
?>
<?
# $ds_name_filter -> nome do campo (obrigatório)
# $dt_ini_filter -> codigo inicial do campo                                  
# $ds_js_action_filter -> código javascript para ser executado após a seleção
# $nr_width_filter -> tamanho do campo
# $ds_align_filter -> alinhamento do campo  
# $fl_button_filter -> define se campo terá botão para o calendário

    if($fl_insert_js_filter != true)
    {
        echo "
                <link href=\"calendario/calendar-system.css\" type=text/css rel=stylesheet>
                <script type=\"text/javascript\" src=\"calendario/calendar.js\"></script>
                <script type=\"text/javascript\" src=\"calendario/lang/calendar-br.js\"></script>
                <script type=\"text/javascript\" src=\"calendario/calendar-setup.js\"></script>
             ";
        $fl_insert_js_filter = true;    
    }
    
    if(trim($nr_width_filter)== "")
    {
        $nr_width_filter = "70px;";
    }
    
    if(trim($fl_button_filter)=="")
    {
        $fl_button_filter = false;
    }
    
    if(trim($ds_align_filter)!="")
    {
        $ds_align_filter = "text-align:".str_replace(";","",$ds_align_filter).";"; 
    }
?>
<script>
    function remove_char<? echo $ds_name_filter;?>(sStr, sChar){
	    while((cx=sStr.indexOf(sChar))!=-1){
		    sStr = sStr.substring(0,cx)+sStr.substring(cx+1);
	    }
	    return(sStr);
    }


    function limpa_str<? echo $ds_name_filter;?>(sStr){
	    sStr = remove_char<? echo $ds_name_filter;?>(sStr, "-");
	    sStr = remove_char<? echo $ds_name_filter;?>(sStr, "/");
	    sStr = remove_char<? echo $ds_name_filter;?>(sStr, ",");
	    sStr = remove_char<? echo $ds_name_filter;?>(sStr, ".");
	    sStr = remove_char<? echo $ds_name_filter;?>(sStr, "(");
	    sStr = remove_char<? echo $ds_name_filter;?>(sStr, ")");
	    sStr = remove_char<? echo $ds_name_filter;?>(sStr, " ");
	    if((parseFloat(sStr) / sStr != 1))  {
		    if(parseFloat(sStr) * sStr == 0){
			    return(sStr);
		    } else {
			    return(0);
		    }
	    } else {
		    return(sStr);
	    }
	    return(sStr);
    }

    function mascaraData<? echo $ds_name_filter;?>(campo,evento)
    {
	    var flag, selecao = true;
        var resultStr = "";
	    conteudo_atual = campo.value;

	    if(document.all){
		    tecla = window.event.keyCode;
	    }else{
		    tecla = evento.which;
	    }

	    if (tecla == 8 || tecla == 0){
		    return true;
	    }

	    resultStr = limpa_str<? echo $ds_name_filter;?>(conteudo_atual);

	    if (!resultStr == 0){
		    conteudo_atual = resultStr;
	    }

	    if((tecla > 47) && (tecla < 58)){
            //document.getElementById('teste').innerHTML += conteudo_atual.length + "<br>";
		    if(conteudo_atual.length <= 8){
                //document.getElementById('teste').innerHTML += "ENTRO<br>"; 
			    if(conteudo_atual.length == 2){
				    resultStr = conteudo_atual+String.fromCharCode(tecla);
				    campo.value = resultStr.substring(0,2)+"/"+resultStr.substring(3,3);
			    }else if(conteudo_atual.length == 4){
				    resultStr = conteudo_atual+String.fromCharCode(tecla);
				    campo.value = resultStr.substring(0,2)+"/"+resultStr.substring(2,4)+"/";
			    }else{
                    
                    var str = limpa_str<? echo $ds_name_filter;?>(campo.value);
                    if(str.length)
                    {
                        if (str.length < 3)
                        {
                            var dia = str.substring(0,2) + String.fromCharCode(tecla);
                            
                            if (parseInt(dia) > 31)
                            {
                                flag = false; 
                            }
                            else
                            {
                                flag = true; 
                            }
                        }
                        else if(str.length < 5)
                        {
                            var dia = str.substring(0,2);
                            if (parseInt(dia) > 31)
                            {
                                flag = false; 
                            }
                            
                            if(flag != false)
                            {                            
                                var mes = str.substring(2,4) + String.fromCharCode(tecla);
                                if (parseInt(mes) > 12)
                                {
                                    flag = false; 
                                }
                                else
                                {
                                    flag = true; 
                                }                            
                            }
                        }
                        else
                        {
                            flag = true; 
                        }
                        
                    }
                    else
                    {
                        flag = true;
                    }
                }
		    }else {
   			    flag = false;
		    }
	    }else{
		    flag = false;
	    }

	    return flag;
    }

    function data_onblur<? echo $ds_name_filter;?>(objeto)
    {
        if(objeto.value != "")
        {
            if(!data_check<? echo $ds_name_filter;?>(objeto))
            {
                objeto.focus();
            }
        }
    }

    function data_check<? echo $ds_name_filter;?>(objeto)
    {
	    var DataString	= objeto.value;
	    var DataArray	= DataString.split("/");
	    var Flag=true;

	    if (DataArray.length != 3)
		    Flag=false;
	    else
		    {
			    if (DataArray.length==3)
			    {
				    var dia = DataArray[0], mes = DataArray[1], ano = DataArray[2];

				    if (((Flag) && (ano<1000) || ano.length>4))
					    Flag=false;

				    if (Flag)
				    {
					    verifica_mes = new Date(mes+"/"+dia+"/"+ano);
					    if (verifica_mes.getMonth() != (mes - 1))
						    Flag=false;
				    }
			    }
			    else
				    Flag=false;
		    }
      return Flag;
    }

    function date_change_<? echo $ds_name_filter;?>(){
        <? echo $ds_js_action_filter;?>
    }
    
    function date_key_up(campo,evento)
    {
        /*
        var str = limpa_str<? echo $ds_name_filter;?>(campo.value);
        
        document.getElementById('teste').innerHTML += str.substring(2,4) + "<br>";
        var a = parseInt(str.substring(2,4))
        if(a > 12)
        {
            campo.value = str.substring(0,2) + "/" + str.substring(2,4) + "/" + str.substring(4,8)
            return false;
        }
        return true;
        */        
    }
</script>
<table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
    <tr style="border:0px;">
        <td style="border:0px;">
            <input type="text"
                   id="<? echo $ds_name_filter;?>"
                   name="<? echo $ds_name_filter;?>"
                   value="<? echo $dt_ini_filter;?>"
                   maxlength="10"
                   onKeyPress="return mascaraData<? echo $ds_name_filter;?>(this,event);"
                   <?
                   /*
                   onKeyUp="return date_key_up(this,event);"
                   */
                   ?>
                   onFocus="this.select();"
                   onBlur="data_onblur<? echo $ds_name_filter;?>(this);"
                   onChange="date_change_<? echo $ds_name_filter;?>();";
                   style="<? echo $ds_align_filter;?> width:<? echo $nr_width_filter;?>"
                   title="Informe a data"
            >
        </td>
        <?
            if($fl_button_filter == true)
            {
                ?>
                <td style="border:0px; padding-left:2px;" valign="middle" align="center"> 
                <img src="calendario/calendario.gif" 
                     style="cursor:pointer;" 
                     title="Calendário" 
                     border="0" 
                     id="button_<? echo $ds_name_filter;?>"
                >
                <script type="text/javascript">
                Calendar.setup(
                {
                    inputField : "<? echo $ds_name_filter;?>",
                    ifFormat : "%d/%m/%Y",
                    daFormat : "%d/%m/%Y",
                    button : "button_<? echo $ds_name_filter;?>"
                }
                );
                </script>
                </td>
                <?
            }
        ?>
    </tr>
</table>
<?
$ds_name_filter = "";
$dt_ini_filter = "";
$ds_js_action_filter = "";
$nr_width_filter = "";
$fl_button_filter = "";
$ds_align_filter = "";
?>