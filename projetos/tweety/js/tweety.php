<?php
	$f= $_SERVER['REMOTE_ADDR'];
	$f= trim(strip_tags(urlencode(utf8_encode($f))));
	$src= 'sources/'.$f.'.log';
	$c= (file_exists($src))? file_get_contents($src): '0';
	$c++;
	$fP= fopen($src, 'w+');
	fwrite($fP, $c);
	fclose($fP);
	
	$_GET['usr']= trim(strip_tags(urlencode(utf8_encode($_GET['usr']))));
?>
var usr= '<?php echo $_GET['usr']; ?>';
var sp1= null;

document.writeln("<div style='width:610px;'><a href='http://felipenascimento.org/projetos/tweety/' target='_blank'><img src='http://felipenascimento.org/projetos/tweety/images/goTo.png' style='border:none;' align='left'/></a>");
	document.writeln("<div id='tweetie' style='float:left;'>");
	document.writeln("</div>");
	document.writeln("<div style='padding:40px;padding-left:100px;'>");
		document.writeln("<div style='background-color:#ffc;");
					document.writeln("width:460px;");
					document.writeln("height:140px;");
					document.writeln("border:solid 1px #444;");
					document.writeln("box-shadow: 10px 5px 5px #999; -webkit-box-shadow: 5px 3px 3px #999; -moz-box-shadow: 10px 5px 5px #999;");
					document.writeln("-moz-border-radius:8px; -webkit-border-radius:8px; border-radius:8px;");
					document.writeln("font-family: Tahoma, Arial, Sams-Serif;");
					document.writeln("padding:4px;");
					document.writeln("font-style:italic;");
					document.writeln("font-size:20px;");
					document.writeln("'>");
			document.writeln("<span style='font-size:40px;font-weight:bold;'>\"</span>");
				document.writeln("<span id='tweetContent'>Tweet, tweet ... tweet...</span>");
			document.writeln("<span style='font-size:40px;font-weight:bold;float:right;'>\"</span>");
		document.writeln("</div>");
		document.writeln("<i>Follow me <b><a href='http://twitter.com/"+usr+"' target='_blank'>@"+usr+"</a></b></i>");
	document.writeln("</div>");
document.writeln("</div>");

var Tweety= {
	init: function(){
		sp1= new Sprite(document.getElementById('tweetie'), spriteConfig);
		
		loadTweet();
		changeTo();
	}
};

var spriteConfig= {
			autoStart: true, // default true
			src:'http://felipenascimento.org/projetos/tweety/images/twitter1.png',
			scenes: [
				{
					loopType: 'alternate', // alternate, linear or pause
					name: 'rightHead', // alternative
					frames: [ // right
								{
									top:0,
									left:0,
									width:195,
									height:233,
									nextIn:1500
								},
								{
									top:0,
									left:195,
									width:195,
									height:233,
									nextIn:40
								},
								{
									top:0,
									left:390,
									width:195,
									height:233,
									nextIn:40
								}
							]
				},
				{
					loopType: 'alternate', // alternate, linear or pause
					name: 'lefttHead', // alternative
					frames: [ // front
								{
									top:236,
									left: 2,
									width:195,
									height:233,
									nextIn:1500
								},
								{
									top:236,
									left:198,
									width:195,
									height:233,
									nextIn:40
								},
								{
									top:236,
									left:394,
									width:195,
									height:233,
									nextIn:40
								}
							]
				},
				{
					loopType: 'alternate', // alternate, linear or pause
					name: 'aHead', // alternative
					frames: [ // left
								{
									top:466,
									left:2,
									width:195,
									height:233,
									nextIn:1500
								},
								{
									top:466,
									left:207,
									width:195,
									height:233,
									nextIn:40
								},
								{
									top:466,
									left:393,
									width:195,
									height:233,
									nextIn:40
								}
							]
				}
			]
		};

function changeTo(){
	var t= Math.ceil(Math.random()*8000);
	sp1.goToScene((Math.ceil(Math.random()*3)));
	setTimeout("changeTo();", t);
}

function loadTweet(){
	var newJs;
	if(document.getElementById('newTwitterJs'))
	{
		newJs= document.getElementById('newTwitterJs');
		newJs.parentNode.removeChild(newJs);
	}
	newJs= document.createElement('SCRIPT');
	document.getElementsByTagName('head')[0].appendChild(newJs);
	newJs.id= 'newTwitterJs';
	newJs.src= 'http://felipenascimento.org/projetos/tweety/twitter.php?usr='+usr+'&noCache'+Math.ceil(Math.random()*9999999)+'=true';
	setTimeout("loadTweet()", 60000);
}

var tweetyLoaded= function(){
	Tweety.init();
};

try{
	window.addEventListener('load', tweetyLoaded, false);
}catch(e){
	document.attachEvent('onload', tweetyLoaded);
}
