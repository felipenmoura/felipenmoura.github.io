<?php

	foreach($_GET as &$get)
	{
		$get= trim(strtolower(strip_tags(addslashes($get))));
		while(strpos($get, "..") !== false)
		{
			$get= str_replace('..', '.', $get);
		}
	}
	
	function createLogFile($what)
	{
		/*if(!isset($_GET['in']))
		{
			$_GET['in']= '';
		}else{
				$_GET['in']= $_GET['in'].'/';
				if(!file_exists('statistics/'.$_GET['in']))
					mkdir('statistics/'.$_GET['in']);
			 }
		
		$file= 'statistics/'.$_GET['in'].$what;
		if(!file_exists($file))
		{
			$f= fopen($file, 'w+');
			fclose($f);
		}
		$nro= @file_get_contents($file);
		if($nro == '')
			$nro= 0;
		$nro++;
		@file_put_contents($file, $nro);*/
	}

	if(isset($_GET['func']))
	{
		$phpDevBarSep= '||||--phpDevBarSeparator--||||';
		$xml= simplexml_load_file('function_list.xml');
		
		if(!$xml)
		{
			echo -1;
			exit;
		}
		$_GET['func']= strtolower($_GET['func']);
		@createLogFile($_GET['func']);
		$funcs= $xml->xpath("//function[@name='".$_GET['func']."']|//function[@name='*::".$_GET['func']."']");
		
		$funcs= $funcs[0];
		//$funcName= $funcs[0]['name'];
		
		$function= Array();
		$function['name']= (string)$funcs['name'];
		
		if(trim($function['name']) == '')
		{
			echo '0';
			exit;
		}
		
		$function['retVal']= (string)$funcs->overload['retval'];
		
		if(isset($funcs->overload) && isset($funcs->overload->param))
		{
			$parms= $funcs->overload->param;
			foreach($parms as $p)
			{
				$function['parms'][]= (string)$p['name'];
			}
			$function['parms']= preg_replace('/\, \[/', ' [, ', implode(', ', $function['parms']));
		}else{
				$function['parms']= 'No parameters';
			 }
		
		$function['description']= 'No Description yet';
		

		echo $function['name'].$phpDevBarSep;
		echo $function['retVal'].' function '.$function['name'].'('.$function['parms'].'):'.$phpDevBarSep;
		echo $function['retVal'].$phpDevBarSep;
		echo $function['parms'].$phpDevBarSep;
		echo $function['description'].$phpDevBarSep;
		
		exit;
	}
	if(isset($_GET['searchFor']) && isset($_GET['in']))
	{
		// armazenar logs
		
		switch($_GET['in'])
		{
			case 'php_dev_bar_php.net':
			{
				$url= 'http://php.net/'.$_GET['searchFor'];
				break;
			}
			case 'php_dev_bar_phpclassses':
			{
				$url= 'http://www.phpclasses.org/search.html?words='.$_GET['searchFor'].'&x=0&y=0&go_search=1';
				break;
			}
			case 'php_dev_bar_pecl':
			{
				$url= 'http://pecl.php.net/package-search.php?pkg_name='.$_GET['searchFor'].'&bool=AND&submit=Search';
				break;
			}
			case 'php_dev_bar_pear':
			{
				$url= 'http://pear.php.net/search.php?q='.$_GET['searchFor'].'&in=packages&x=0&y=0';
				break;
			}
			case 'php_dev_bar_bugs':
			{
				$url= 'https://bugs.php.net/search.php?cmd=display&search_for='.$_GET['searchFor'].'';
				break;
			}
			default:{
				$url= 'http://php.net/'.$_GET['searchFor'];
			}
		}
		@createLogFile($_GET['searchFor']);
		header('Location: '.$url);
		exit;
	}
	if(isset($_GET['kyewords']))
	{
		/*
		$arr= Array('a'=>'',
					'b'=>'',
					'c'=>'',
					'd'=>'',
					'e'=>'',
					'f'=>'',
					'g'=>'',
					'h'=>'',
					'i'=>'',
					'j'=>'',
					'k'=>'',
					'l'=>'',
					'm'=>'',
					'n'=>'',
					'o'=>'',
					'p'=>'',
					'q'=>'',
					'r'=>'',
					's'=>'',
					't'=>'',
					'u'=>'',
					'v'=>'',
					'x'=>'',
					'y'=>'',
					'w'=>'',
					'z'=>'',
					'_'=>'',
					);
		*/
		$xml= simplexml_load_file('function_list.xml');
		$funcList= $xml->xpath("//function");
		for($i=0, $j=sizeof($funcList); $i<$j; $i++)
		{
			echo (string)$funcList[$i]['name'].',';
			//$curName= (string)$funcList[$i]['name'];
			//$arr[strtolower(substr($curName, 0, 1))].= $curName.',';
		}
		//echo '<pre>';
		//print_r($arr);
		//echo '<pre>'.implode($arr, '');
		exit;
	}
?>
<?php
    include('phpdevbar-page.php');

/*


$db= new SQLite3('sources/php_manual_en.sqlite');

//$sql = "select * from sqlite_master"; 
$sql = "select * from functions
    left join params
      on functions.name=params.function_name
    left join notes
     on functions.name=notes.function_name
/*    left join seealso
     on functions.name=seealso.function_name * /
where functions.name= 'explode'"; 

$result = $db->query($sql);//->fetchArray(SQLITE3_ASSOC); 

$row = array();

$i = 0;
echo "<pre>";
while($res = $result->fetchArray(SQLITE3_ASSOC)){

     print_r($res);
     /*
      if(!isset($res['user_id'])) continue; 

      $row[$i]['user_id'] = $res['user_id']; 
      $row[$i]['username'] = $res['username']; 
      $row[$i]['opt_status'] = $res['opt_status']; 

      $i++; 
    * /
  } 

//print_r($row);
*/