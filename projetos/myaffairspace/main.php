<?php
	session_start();
	$_SESSION['mindcode']= 1;
	$usrCode= $_SESSION['mindcode'];
?><!-- doctype-->
<html>
	<head>
		<title>
			AffairSpace - for safe affairs
		</title>
		<link rel="shortcut icon" href="img/mini_logo1.jpg" type="image/x-icon" />
		<link href='styles/default1.css' type='text/css' rel='stylesheet'>
		<script type="text/javascript" src="scripts/async.js"></script>
		<script type="text/javascript" src="scripts/json.parser.js"></script>
		<script type="text/javascript" src="scripts/jquery.js"></script>
		<script type="text/javascript" src="scripts/jquery.history.js"></script>
		<script type="text/javascript" src="scripts/engine.js"></script>
		<script>
			var scroller =  {
							  init:   function()
								{
								    //collect the variables
								    scroller.docH = document.getElementById("content").offsetHeight;
								    scroller.contH = document.getElementById("container").offsetHeight;
								    scroller.scrollAreaH = document.getElementById("scrollArea").offsetHeight;
								      
								    //calculate height of scroller and resize the scroller div
								    //(however, we make sure that it isn't to small for long pages)
								    scroller.scrollH = (scroller.contH * scroller.scrollAreaH) / scroller.docH;
								    //if(scroller.scrollH < 15) scroller.scrollH = 15;
								    document.getElementById("scroller").style.height = Math.round(scroller.scrollH) + "px";
								    
								    //what is the effective scroll distance once the scoller's height has been taken into account
								    scroller.scrollDist = Math.round(scroller.scrollAreaH-scroller.scrollH);
								    
								    //make the scroller div draggable
								    Drag.init(document.getElementById("scroller"),null,0,0,-1,scroller.scrollDist);
								    
								    //add ondrag function
								    document.getElementById("scroller").onDrag = function (x,y)
									{
								      var scrollY = parseInt(document.getElementById("scroller").style.top);
								      var docY = 0 - (scrollY * (scroller.docH - scroller.contH) / scroller.scrollDist);
								      document.getElementById("content").style.top = docY + "px";
								    }
								}
							}

		</script>
	</head>
	<body leftmargin='0'
		  topmargin='0'
		  bottommargin='0'
		  rightmargin='0'>
		<img src='img/bg_image.jpg'
			 class='backgroundBody'/>
		<div class='header'>
			<div class='headerLinks'>
				<table width='100%'
					   cellpadding='0'
					   cellspacing='0'>
					<tr>
						<td style='text-align: left;
								   color: #fff;
								   padding-left: 7px;'>
							<img class='logoImg'
								 alt='AffairSpace'
								 src='img/logo_extenso.jpg'/> 
							<a href='#profile'
							   rel='dinamicAnchor'
							   <?php
								echo ' mindcode="'.$usrCode.'" ';
							   ?>>
								Profile</a>&nbsp;
							| 
							<a href='#messages' rel='dinamicAnchor'
							   <?php
								echo ' mindcode="'.$usrCode.'" ';
							   ?>>
								Messages</a>&nbsp;
							| 
							<a href='#contacts' rel='dinamicAnchor'
							   <?php
								echo ' mindcode="'.$usrCode.'" ';
							   ?>>
								Contacts</a>&nbsp;
							| 
							<a href='#invitations' rel='dinamicAnchor'
							   <?php
								echo ' mindcode="'.$usrCode.'" ';
							   ?>>
								Invitations</a>&nbsp;
							| 
							<a href='#events' rel='dinamicAnchor'
							   <?php
								echo ' mindcode="'.$usrCode.'" ';
							   ?>>
								Events</a>
						</td>
						<td style='text-align: right;
								   padding-right: 10px;'>
							<a href='#logoff' rel='dinamicAnchor'
							   <?php
								echo ' mindcode="'.$usrCode.'" ';
							   ?>>
								Logoff</a> 
							<input type='text'
								   class='iptSearch'>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<table cellpadding='0'
			   cellspacing='4'
			   class='bodyStructure'>
			<tr>
				<td style='width: 180px;'>	<!-- informacoes do usuario e menus -->
					<table cellpadding='0'
						   cellspacing='0'
						   width='100%'>
						<tr>
							<td class='tdLeft'>
							</td>
							<td class='tdCenter'
								rowspan='2'>
								<div id='info'>
									<?php
										include('info.php');
									?>
								</div>
							</td>
							<td class='tdRight'>
							</td>
						</tr>
						<tr>
							<td class='glass_center_left'>
								<br>
							</td>
							<td class='glass_center_right'>
								<br>
							</td>
						</tr>
						<tr>
							<td class='glass_bottom_left'>
							</td>
							<td class='glass_bottom_center'>
							</td>
							<td class='glass_bottom_right'>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table cellpadding='0'
						   cellspacing='0'
						   width='100%'
						   height='100%'>
						<tr>
							<td class='tdLeft'>
							</td>
							<td class='tdCenter'
								rowspan='2'>
								<div id='mainContent'>
									<?php
										include('home.php');
									?>
								</div>
							</td>
							<td class='tdRight'>
							</td>
						</tr>
						<tr>
							<td class='glass_center_left'>
								<br>
							</td>
							<td class='glass_center_right'>
								<br>
							</td>
						</tr>
						<tr>
							<td class='glass_bottom_left'>
							</td>
							<td class='glass_bottom_center'>
							</td>
							<td class='glass_bottom_right'>
							</td>
						</tr>
					</table>
				</td>
				<td style='width: 370px;'>
					<table cellpadding='0'
						   cellspacing='0'
						   width='100%'>
						<tr>
							<td class='tdLeft'>
							</td>
							<td class='tdCenter'
								rowspan='2'>
								<div id='contacts'>
								<?php
									include('contacts.php');
								?>
								</div>
								<div class='separator'>
								</div>
								<div id='groups'>
								<?php
									include('groups.php');
								?>
								</div>
								<div class='separator'>
								</div>
								<div id='historic'>
								<?php
									$_GET['historicLimit']= 3;
									include('historic.php');
								?>
								</div>
							</td>
							<td class='tdRight'>
							</td>
						</tr>
						<tr>
							<td class='glass_center_left'>
								<br>
							</td>
							<td class='glass_center_right'>
								<br>
							</td>
						</tr>
						<tr>
							<td class='glass_bottom_left'>
							</td>
							<td class='glass_bottom_center'>
							</td>
							<td class='glass_bottom_right'>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan='3'>
					<table cellpadding='0'
						   cellspacing='0'
						   class='rodape'
						   align='center'>
						<tr>
							<td style='text-align: left;'>
								Copyright  @2009
							</td>
							<td style='text-align: center;'>
								<a href=''
								   target='_quot'>
									About</a> | 
								<a href=''
								   target='_quot'>
									Privacy</a> | 
								<a href=''
								   target='_quot'>
									Terms</a> | 
								<a href=''
								   target='_quot'>
									Help</a>
							</td>
							<td style='text-align: right;'>
								Developed by ...
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php
			include('dialog.php');
		?>
	</body>
</html>