<html>
	<style type="text/css">
		p { margin-top: 2px; margin-bottom: 2px; }
	</style>
	<body onmousemove="parent.mousemove;"
		  rightmargin="5"
		  leftmargin="5"
		  bottommargin="5"
		  topmargin="10"
		  background="img/agiplan_logo.jpg"
		  style="background-repeat: no-repeat;
				 font-family: Arial;
				 line-height: 15px;
				 ">
		  <?
			if(!@$fileContent= readfile($_GET['fileurl']))
				$fileContent= @readfile(substr_replace($_GET['fileurl'], '', 0,3));
			$fileContent= ($fileContent == '0')? '' : $fileContent;
			echo $fileContent;
		  ?>
	</body>
</html>