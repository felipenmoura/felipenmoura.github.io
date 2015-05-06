<?php
	// let's clear it, just to be sure
	$_GET['func']= preg_replace('/^\//', '', $_GET['func']);
	while(strstr($_GET['fun'], '..'))
		strreplace('..', '.', $_GET['func']);

	
	function createLogFile($what)
	{
		$file= 'statistics/'.$what;
		if(!file_exists($file))
		{
			$f= fopen($file, 'w+');
			fclose($f);
		}
		$nro= @file_get_contents($file);
		if($nro == '')
			$nro= 0;
		$nro++;
		@file_put_contents($file, $nro);
	}
	//@createLogFile($_GET['func']);

	$_GET['func']= str_replace("'", "", strip_tags(str_replace('::', '.', $_GET['func'])));

	$err= false;
	if(strlen($_GET['func']) < 3)
		$err= true;
	else{
			$d= 'ide-json/'.$_GET['func'][0].'/'.$_GET['func'][1].'/';
		}
	if(file_exists($d.$_GET['func'].'.json'))
		echo file_get_contents($d.$_GET['func'].'.json');
	else
		$err= true;
		
	if($err)
	{
		$ret= Array('error'=>$_GET['func'].' not found!');
		$ret['didyoumean']= Array();
		$ar_order= Array();
		$ret['notfound']= $_GET['func'];
		include('func-list.php');
		
		$idx= &$funcList[$_GET['func'][0]];
		for($i=0, $j= sizeof($idx); $i<$j; $i++)
		{
			if(strstr($idx[$i], '::'))
			{
				$curIdx= explode('::', $idx[$i]);
				$curIdx= $curIdx[1];
			}else{
					$curIdx= $idx[$i];
				 }
			$lev= levenshtein($_GET['func'], $curIdx);
			if($lev < strlen($_GET['func'])/2)
			{
				$ret['didyoumean'][]= Array($idx[$i]);
				$ar_order[]= $lev;
			}
		}
		array_multisort($ar_order, $ret['didyoumean']);
		echo JSON_encode($ret);
	}
