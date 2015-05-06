<?php
if(is_dir('logados'))
{
	$sessDir= 'logados';
}elseif(is_dir('../logados'))
	 {
		$sessDir= '../logados';
	 }else{
			$sessDir= 'endereco_invalido';
		  
		  }
	clearstatcache();
	session_save_path($sessDir);
	session_cache_expire(1);
	session_name('athenas');
	session_start();
if($acessoWeb)
{
	$validSession= false;
	for($i=0; $i<=count($_SESSION['acesso_web']); $i++)
	{
		//echo $_SESSION['acesso_web'][$i];
		if($_SESSION['acesso_web'][$i] == $acessoWeb)
		{
			$validSession= true;
		}
	}
	if($validSession != true)
	{
		//print "<html>";
		?>
			<script>
				top.showAlert('erro', 'Voc&ecirc; n&atilde;o tem permiss&atilde;o para executar esta tarefa !');
				//top.close();
			</script>
			<center>
				<img src="img/erro.gif">
				<br>
				<span style="color: red;
							 font-weight: bold;">
					Voc&ecirc; n&atilde;o tem permiss&atilde;o para executar esta tarefa !<br>
					Contate o Administrador.
				</span>
			</center>
			<flp_script>
				//top.showAlert('erro', 'Voc&ecirc; n&atilde;o tem permiss&atilde;o para executar esta tarefa !');
		<?
		exit();
	}
}
if(trim($_SESSION['pk_usuario'])=="")
{
  print "<html>";
  print "<script> alert('Sua sessão expirou!'); top.close(); </script>";
  echo "<!--<flp_script>alert('Sua sessão expirou!'); top.close(); try{opener.location.href= opener.location.href}catch(error){}";
  exit();
}
$_SESSION['lastAccess']= date('YmdHis');
function showPost()
{
	foreach($_POST as $aux)
	{
		$b= each($_POST);
		if($b[value] == '')
		{
			echo "<font style='color: red; font-weight: bold;'>".$b[key]." -> [ ".$b[value]." ]</font><br>";
		}else
		    {
			    echo "<font style='color: blue;'>".$b[key]." -> [ ".$b[value]." ]</font><br>";
			}
	}
}

function hasPermission($permission)
{
	// $permission é um valor numérico, Consulte a documentação de Permissoes
	return in_array($permission,$_SESSION['acesso_web'])? true : false;
}
?>
