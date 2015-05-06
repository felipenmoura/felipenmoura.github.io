<?php

// PERMISSÃO
$acessoWeb= 26;

require_once("inc/valida_sessao.php");
?>
<?php
	if($_GET)
	{
		echo $_GET['user'];
		if(!unlink('logados/'.$_GET['user']))
		{
			echo "<script>alert('Ocorreu um erro ao tentar deslogar este usuário')</script>";
		}
		exit;
	}
	function sessionUsuariosAtivos()
    {
        $ds_dir = session_save_path();
        $ob_dir = opendir($ds_dir);
        $ar_tmp = "";
        $nr_count = 0;
        while (false !== ($ds_filename = readdir($ob_dir)))
        {
            if (ereg("^sess", $ds_filename))
            {
                sessionConvertArray(session_save_path()."/".$ds_filename);
                if(trim(sessionGetVarValue('ds_usuario')) != "")
                {
                   $ar_tmp[$nr_count]['ds_usuario'] = sessionGetVarValue('ds_usuario');
                   $ar_tmp[$nr_count]['ds_session'] = $ds_filename;
                   $ar_tmp[$nr_count]['dt_session'] = sessionGetVarValue('dt_session');
                   $ar_tmp[$nr_count]['dt_logon'] = sessionGetVarValue('dt_logon');
                   $ar_tmp[$nr_count]['ds_pg_dbname'] = sessionGetVarValue('ds_pg_dbname');
                   $ar_tmp[$nr_count]['nr_ip'] = sessionGetVarValue('nr_ip'); 

                   $nr_count++;
                }
            }
        }
        return $ar_tmp;
    }

    function sessionCheckUser($ds_usuario,$ds_pg_dbname)
    {
        $fl_check = true;
        $ds_dir = session_save_path();
        $ob_dir = opendir($ds_dir);

        while (false !== ($ds_filename = readdir($ob_dir)))
        {
            if (ereg("^sess", $ds_filename))
            {
                sessionConvertArray(session_save_path()."/".$ds_filename);
                if(sessionGetVarValue('ds_usuario') == $ds_usuario and trim($ds_usuario) != "" and sessionGetVarValue('ds_pg_dbname') == $ds_pg_dbname)
                {
                   $fl_check = false;
                }
            }
        }
        return  $fl_check;
    }
    
    function sessionUser($ds_usuario)
    {
        $ds_dir = session_save_path();
        $ob_dir = opendir($ds_dir);

        while (false !== ($ds_filename = readdir($ob_dir)))
        {
            if (ereg("^sess", $ds_filename))
            {
                sessionConvertArray(session_save_path()."/".$ds_filename);
                if(sessionGetVarValue('ds_usuario') == $ds_usuario and trim($ds_usuario) != "")
                {
                   return $ds_filename;
                }
            }
        }
        return "";
    }
                       
    function sessionGetVarValue($ds_key)
    {
        global $_GL_AR_SESSION_;
        return $_GL_AR_SESSION_[$ds_key];
    }

   	function sessionConvertArray($ds_arq)
    {
        global $_GL_AR_SESSION_;
        $_GL_AR_SESSION_ = "";
        $ob_arq = fopen($ds_arq, "r+");
        $ds_conteudo = @fread($ob_arq, filesize($ds_arq));
        $ar_tmp = explode(";",$ds_conteudo);
        $nr_end = count($ar_tmp);
        $nr_count = 0;
        while ($nr_count < $nr_end-1)
        {
            $ar_tmp_pipe = explode("|",$ar_tmp[$nr_count]);
            $_GL_AR_SESSION_[$ar_tmp_pipe[0]] =  unserialize($ar_tmp_pipe[1].";");
            $nr_count++;
        }
        fclose($ob_arq);
        return $_GL_AR_SESSION_;
	}
    
    function sessionDelete($ds_session)
    {
        if (ereg("^sess", $ds_session))
        {
            @unlink(session_save_path()."/".$ds_session);
        }
        else
        {
            @unlink(session_save_path()."/sess_".$ds_session);
        }
        
        return "";
    }

	?>
	<div style="width: 100%;
				height: 100%;
				overflow: auto;">
	<?php
	$dir= opendir(session_save_path());
	echo "<table width='100%'
				 class='gridCell'>
			<tr>
				<td class='gridTitle'>
					Usu&aacute;rio logado
				</td>
				<td class='gridTitle'>
					Hor&aacute;rio
				</td>
				<td class='gridTitle'>
					<br>
				</td>
			</tr>";
	while(false !== ($ds_filename = readdir($dir)))
	{
		
		if($ds_filename != '.' && $ds_filename!= '..')
		{
			echo "<tr>";
			$t= file_get_contents(session_save_path()."/".$ds_filename, 'r+');
			$t= explode(';', $t);
			$ar_temp= Array();
			$ar_dados= Array();
			for($i=0; $i<count($t); $i++)
			{
				$ar_temp= explode('|', $t[$i]);
				//echo $ar_temp[0].'<br>';
				$ar_dados[str_replace('}', '', $ar_temp[0])]= str_replace('"', '', substr($ar_temp[1], strpos($ar_temp[1], '"')+1, strrpos($ar_temp[1], '"')), $ar_temp[1]);
			}
			echo "<td style='text-align: left;'>";
			echo htmlentities($ar_dados['s_usuario']);
			echo "</td>";
			echo "<td align='center'>";
			echo $ar_dados['time'];
			echo "</td>";
			echo "<td align='center'>";
				?>
					<img src='img/erro.gif'
					     style='width: 15px;
							    cursor: pointer;'
						 onmouseover="showtip(this, event, 'deslogar este usu&aacute;rio')"
						 onclick="if(confirm('Tem certeza que deseja deslogar este usu&aacute;rio do sistema?\nAo deslogar um usu&aacute;rio do sistema, aguarde alguns segundos para que a altera&ccedil;&atilde;o tenha efeito')) document.getElementById('usuarios_logados_iframe').src='usuarios_logados.php?user=<?php echo $ds_filename; ?>'">
				<?php
			echo "</td>";
		}
	}
?>


</div>
<iframe id="usuarios_logados_iframe"
		style="display: none;">
</iframe>
<flp_script>
	setTimeout("try{top.c.document.getElementById('usuarios_logados').reload();}catch(error){}", 10000);