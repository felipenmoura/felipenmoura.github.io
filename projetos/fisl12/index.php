<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
	<head>
		<script src='jquery.js'></script>
		<style type='text/css'>
			@charset "iso-9985-1";
		</style>
		<title>CSS3, HTML5 e JS...reconquistando a web</title>
	</head>
	<body leftmargin='0' topmargin='0' rightmargin='0' bottommargin='0' bgcolor='#000000' oncontextmenu="return false;" >
	   <table style='width:100%; height:100%;'>
	   	<tr>
	   		<td>
	   			<center>
		   			<div class='mainBody'
		   				 style='border:solid 1px red; width:800px;
		   				 		margin-top:4px;
								box-shadow: 0px 0px 12px #fff;
								-webkit-box-shadow: 0px 0px 12px #fff;
								-moz-box-shadow: 0px 0px 12px #fff;
								border:solid 1px #000;'>
			   			<iframe src='press.php'
			   					class='main'
			   					style='width:800px; height:600px;' frameborder='0'></iframe>
			   		</div>
			   		<div id='goToFields' style='display:none;'>
		   				<input type='text' id='goToSlide' />
		   				<input type='button' value='Go' onclick="Slides.goTo(document.getElementById('goToSlide').value);" />
		   			</div>
		   		</center>
	   		</td>
	   	</tr>
	   </table>
	</body>
	<script>
		$(window).bind('keydown mousedown', function(event){
			slides.capture(event);
		});
		var toGoTo= location.search;
		if(location.hash)
			toGoTo= location.hash;
		if(toGoTo && !isNaN(toGoTo.replace(/^\?|\#/, '')))
		{
			funcToGoOn= function(){
				slides.Slides.next(function(){
					Slides.goTo(toGoTo.replace(/^\?|\#/, ''));
				});
				//alert(toGoTo);
			};
		}else{
			funcToGoOn= function(){};
		}
		//for(var x in location) alert(x+': '+location[x]);
	</script>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1270869-17']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>
