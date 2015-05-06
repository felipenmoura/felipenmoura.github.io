<html>
	<head>
		<title>Tweety</title>
		<style type='text/css'>
			*
			{
				font-family: Tahoma, Arial, Sans-Serif;
			}
			.ipt
			{
				-moz-border-radius:8px;
		  		-webkit-border-radius:8px;
		  		border-radius:8px;
		  		background-color:#fff;
		  		color:#444;
		  		font-style:italic;
		  		border:solid 1px #444px;
			}
			.rounded
			{
		  		 -moz-border-radius:8px;
		  		 -webkit-border-radius:8px;
		  		 border-radius:8px;
		  		 -moz-box-shadow: 0px 0px 8px #66f;
		  		 -webkit-box-shadow: 0px 0px 8px #66f;
		  		 box-shadow: 0px 0px 8px #66f;
			}
			h1
			{
				font-size:42px;
				color:#44f;
				font-weight:bold;
				font-style:italic;
				margin-top:0px;
				box-shadow: 0px 0px 8px #66f;
		  		-moz-box-shadow: 0px 0px 8px #66f;
		  		-webkit-box-shadow: 0px 0px 8px #66f;
			}
			h1 sub
			{
				margin-left:-14px;
				color:red;
				font-size:14px;
				font-style:italic;
				font-weight:normal;
			}
		</style>
	</head>
	<body style='background:transparent;margin:0px; padding:0px;' leftmargin='0' topmargin='0'>
		<center>
			<header>
				<h1>
					Tweety
					<sub>
						beta
					</sub>
				</h1>
			</header>
			<script src='http://felipenascimento.org/projetos/tweety/js/Sprites.js'></script>
			<script src='http://felipenascimento.org/projetos/tweety/js/tweety.php?usr=felipenmoura'></script>
			<div style='width:480px;
						border:solid 1px #66f;
						margin:40px;
						padding:12px;
						background-color:#f0f0ff;'
				 class='rounded'>
				Type your Twitter account:<br/>
				<input type='text' name='twitterId' id='twitterId' onkeyup='getCode(this)' class='ipt' /><br/>
				Then copy this, and paste in your website or blog to have this animated little tweety tweeting your last posts:<br/>
				<div id='code'
					 class='rounded'
						  style='background-color:#fff;
						  		 color:#444;
						  		 font-style:italic;
						  		 font-size:12px;
						  		 border:solid 1px #fff;
						  		 width:440px;
						  		 height:75px;
						  		 margin:12px;
						  		 border-radius:8px;
						  		 text-align:left;
						  		 padding:4px;
						  		 ' >
					&lt;script src='http://felipenascimento.org/projetos/tweety/js/Sprites.js'>&lt;/script> &lt;script src='http://felipenascimento.org/projetos/tweety/js/tweety.php?usr=yourTwitterId'>&lt;/script>
				</div>
			</div>
			<br/>
			Want to contribute? Send me an e-mail. You can help me drawing new skins or providing feedback<br/>
			<footer>
				<a href='http://felipenascimento.org' />http://felipenascimento.org</a> - felipenmoura@gmail.com - @felipenmoura
			</footer>
		</center>
	</body>
	<script>
		function getCode(el){
			document.getElementById('code').innerHTML= "&lt;script src='http://felipenascimento.org/projetos/tweety/js/Sprites.js'>&lt;/script> &lt;script src='http://felipenascimento.org/projetos/tweety/js/tweety.php?usr="+el.value+"'>&lt;/script>";
		}
	</script>
</html>
