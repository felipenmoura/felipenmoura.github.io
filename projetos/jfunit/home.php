<?php
	include 'includes/header.php';
	include 'includes/menu.php';
?>
<div id="body">
	<div id="body-top">
		<div id="body-bot">
			<div id="about-box">
				<h2><b>What about</b> unit tests</h2>
				<img src="images/geotherms.png" style="margin-right:8px;" height="96" alt="Bug" align="left"/>
				<p>It is for sure, a tendency. You will still hear a lot about unit tests and TDD.<br/>
				You want to be sure your new changes have not broken down any other thing you knew was working? So, unit tests is your answer.<br/>
				Some advantages:
				<ul>
					<li>Find problems before releasing your code</li>
					<li>Run many test for each part of your project</li>
					<li>You don't need to remember each test to redo </li>
					<li>Find problems your new code may have caused anywhere else</li>
					<li>This project is open source, under MIT license</li>
				</ul>
			</div>
			<div id="express-box">
				<h2><b>Why</b> jfUnit?</h2>
				<img src="images/unit-tests.png" height="75" alt="jfUnit" class="left" />
				<p>Yes, you will find out there many others libraries to implement unit tests in your code, and some for your Javascript, too.<br/>
					Why, then, to use jfUnit?
				</p>
				<div class="clear">
					<ul>
						<li>It does NOT require any other library or CSS file</li>
						<li>You don't need to prepare any HTML, simply importing the library itself is enough</li>
						<li>You can run your tests whenever you want, even from your console, if you prefer</li>
						<li>You may add your tests straight in your libraries, or separate them in specific files, as you wish</li>
						<li>You can simulate the user interaction, such as navigating through menus or filling forms</li>
						<li>Writing your tests is REALLY easier</li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div id="foot">
	<div id="foot-top">
		<div id="foot-bot">
			<div id="what-box">
				<h2><b>Simulate</b> an user interaction</h2>
				<img src="images/user_interaction.png" width="86" height="77" alt="User interaction" class="left" />
				<p>
					You can simulate the use of your system, such as navigating through menus, filling forms or clicking on buttons.<br/>
					You can also apply a delay, to watch the steps being executed one by one.
			</div>
			<div id="news-box">
				<h2><b>Docs</b> &amp; examples</h2>
				<img src="images/DocuLibraryIcon.png" width="86" height="77" alt="Docs and examples" class="left" />
				Check our <a href="docs/index.php">documentation</a> area, or our <a href="examples/index.php">examples</a> area to see really interesting, useful examples and also to see the methods you can use.<br/>
				If you prefer, you may also get along our project on the <a href="contribute.php">contribute</a> area and send your ideas or doubts.
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php
	include 'includes/footer.php';
?>
