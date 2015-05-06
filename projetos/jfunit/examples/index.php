<?php
	$src= '../';
	include '../includes/header.php';
	include '../includes/menu.php';
?>
<div id="body">
	<div id="body-top">
		<div id="body-bot">
			<div style="background-color: #D7B8AA;text-align:center;">
				Here, you can find some interesting usages for this library to base your tests on
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div id="foot" style="background-image: url(../images/foot_bg2.gif);">
	<div id="foot-top" style="background-image:url(../images/foot_to2.jpg)">
		<div id="foot-bot" >
			<div style="margin-bottom:30px;">
				<img src="../images/matrix_folder_alt.png" width="86" height="77" alt="User interaction" class="left" />
				<div style="margin-left:100px;">
					<h2><b>Basic</b> usage</h2>
					See an example of how to implement and have it working on its basic form
					<br/><a href="basic.php" >Go to the example</a><br/><br/>
					<h2><b>Different</b> possibilities</h2>
					A good example with many different possibilities you may use to assert your results
					<br/><a href="different.php" >Go to the example</a><br/><br/>
					<h2><b>Advanced</b> usage</h2>
					An advanced example of use
					<br/><a href="advanced.php" >Go to the example</a><br/><br/>
					<h2><b>Succeed</b> tests</h2>
					How it looks like, when all your tests passed
					<br/><a href="ok.php" >Go to the example</a><br/><br/>
					<h2><b>Simulate</b> an user interaction</h2>
					Example showing a menu being opened, and then clicked
					<br/><a href="dom.php" >Go to the example</a><br/><br/>
				</div>
			</div>
			For more details, please visit our <a href="../docs/index.php">documentation area</a>.
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php
	include '../includes/footer.php';
?>