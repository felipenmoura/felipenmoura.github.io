<?php
	function connectTo($ob)
	{
		$connection = "host=".$ob['dbAddress']." dbname='".$ob['dbName']."' user='".$ob['rootUser']."' password='".$ob['rootUserPwd']."'";
		$connect = pg_connect($connection);
		return $connect;
	}
		
	$con= connectTo(Array('dbAddress'=>'localhost',
						  'dbName'=>'f2jweb_tasklist',
						  'rootUser'=>'f2jweb_mind',
						  'rootUserPwd'=>'mindorg2009'));

	if($con)
		echo 'CONECTOU O PRIMEIRO<br/>';
		
	$con= connectTo(Array('dbAddress'=>'localhost',
						  'dbName'=>'f2jweb_phpdevbar',
						  'rootUser'=>'f2jweb_devbar',
						  'rootUserPwd'=>'php@ffbar2.2'));
	if($con)
		echo 'CONECTOU O SEGUNDO';
?>
