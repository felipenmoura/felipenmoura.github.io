<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JumPenguin</title>
		<style type="text/css">
			*
			{
				margin:0px;
				overflow:hidden;
			}
			canvas
			{
				position:absolute;
				margin:auto;
				border:solid 1px black;
			}

			#sign
			{
				text-align: center;
				font-weight: bold;
				font-size:46px;
				position:absolute;
				left:0px;
				top:0px;
				width:800px;
				height:600px;
				padding-top:200px;
			}
			#sign span
			{
			}

			#startGameBtn
			{
				position:absolute;
				left:0px;
				top:0px;
				width:800px;
				padding-top:400px;
				text-align:center;
				color: black;
				z-index: 99999999;
			}
			#startGameBtn div
			{
				width:240px;
				border:outset 3px #ccccff;
				background-color: #9f84fe;
				padding:4px;
				margin-left: 280px;
				cursor: pointer;
			}
		</style>
    </head>
    <body>
		<div id="startGameBtn"
			 onclick="startGame();">
			<div>Start Game</div>
		</div>
		<div id="game" >
			<canvas width="800" height="600" id="scenary"></canvas>
			<canvas width="800" height="600" id="details"></canvas>
			<canvas width="800" height="600" id="elements"></canvas>
			<div style="position:absolute;
						left:10px;
						top:10px;
						color:white;
						font-weight:bold;
						font-size:24px;"
				id="pts">
				<div style="margin-bottom:6px;"><img src="images/banana.png" />&nbsp;&nbsp;<span>0</span></div>
				<div><img src="images/cereja.png" />&nbsp;&nbsp;<span>0</span></div>
			</div>
			<div id="sign">
				<span style="display:none; color:blue;">You WIN!<br/>\o/</span>
				<span style="display:none; color:red;">You LOOSE!<br/>:(</span>
				<span style="display:none; color:blue;">PAUSED</span>
			</div>
		</div>
		<div style="position:absolute;ldft:0px;top:0px;
					width:800px; height:600px;
					background-image:url(images/cover.jpg);
					background-position:center center;
					background-repeat: no-repeat;"
					id="cover">
			<img src="images/penguin.png" style="display:none;" />
			<img src="images/background.png" style="display:none;" />
			
			<div style="padding-top:190px;
						padding-left:460px;
						color:white;
						text-shadow:0px 0px 4px #009;
						font-weight: bold;">
				<h1>JumPenguin</h1>
				<br/>
				<div style="padding-left:20px;">
					Get the fruits to gain points<br/>
					Use the <- and -> keys to move<br/>
					the penguin down the hill<br/>
					Use [space] to jump<br/>
					Avoid rocks and holes.
				</div>
			</div>
		</div>
    </body>
	<script src="scripts/jumpenguin.js"></script>
	<script src="scripts/canvasext.js"></script>
	<script>
		var bt= null;
		startGame= function(){
			bt= document.getElementById('startGameBtn').
						 getElementsByTagName('DIV')[0];
			bt.innerHTML= 3;
			setTimeout(function(){
				bt.innerHTML= 2;
			}, 1000);
			setTimeout(function(){
				bt.innerHTML= 1;
			}, 2000);
			setTimeout(function(){
				bt.innerHTML= 'Start Game';
				JP.startGame();
			}, 3000);
		};
		
		window.addEventListener('load', function(){
		}, true)
	</script>
</html>
