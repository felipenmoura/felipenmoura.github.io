<?php
	$src= '../';
	include '../includes/header.php';
	include '../includes/menu.php';

	$funcs= <<<HereDoc
	function sum(value1, value2)
	{
		return value1+value2;
	}

	function getBool()
	{
		return true;
	}

	function getEmail(login, domain)
	{
		return login+"@"+domain;
	}
HereDoc;
	$tests= <<<HereDoc
// testing the sum
	jfUnit.assert(sum, 4, 3, 7);
	jfUnit.assert(sum, 4, 4, 7); // forcing an error
	jfUnit.assert(sum, 4, 2, 6);

	// testing the getStr
	jfUnit.assert(getEmail, 'felipenmoura', 'gmail.com', 'felipenmoura@gmail.com');
	jfUnit.assert(getEmail, 'forcingerror', 'gmail.com', 'felipemoura@gmail.com'); // forcing an error

	// testing booleans
	jfUnit.assert(getBool, true);
	jfUnit.assert(getBool, 'true'); // forcing other error
	jfUnit.assert(getBool, 1); // 1 will be treated as true
	jfUnit.assert(getBool, 2); // forcing other error

	// using an object as conf
	jfUnit.assert({
		call:sum,
		value1:2,
		value2:5,
		expected:7,
		description: "Testing the sum of 2+5"
	});

	jfUnit.run(); // simply comment it to not perform the tests
HereDoc;

?>
<div id="body">
	<div id="body-top">
		<div id="body-bot">
			<div style="background-color: #D7B8AA;text-align:center;">
				All the source code may be in the same file. Everything you gotta do is to import the library<br/>
				something like <i>&lt;scrip src='jfUnit/jfUnit.js'>&lt;/scrip></i> and write your tests
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div id="foot" style="background-image: url(../images/foot_bg2.gif);">
	<div id="foot-top" style="background-image:url(../images/foot_to2.jpg)">
		<div id="foot-bot" >
			<div style="margin-bottom:10px;">
				<img src="../images/run.png" width="86" height="77" alt="User interaction" class="left" />
				<div style="margin-left:100px;" id="placeHolder">
				</div>
				<br/>
				<a href="javascript:showCode()" style="margin-left:100px;">Source Code</a>
				<div id="codeHere" style="display:none;">
<b>FUNCTIONS TO BE TESTED</b>
<?php echo $funcs; ?>
	

<b>TESTS</b>
	<?php echo $tests; ?>
				</div>
			</div>
			For more details, please visit our <a href="../docs/index.php">documentation area</a>.<br/>
			For more examples, go to our <a href="../examples/index.php">example's area</a>.<br/>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php
	include '../includes/footer.php';
?>
<script src="../jfUnit/jfUnit.js"></script>
<script>
	function showCode()
	{
		var el= document.getElementById('codeHere');
		el.style.display= el.style.display=='none'? '': 'none';
	}



	<?php echo $funcs; ?>

	jfUnit.config({placeHolder:document.getElementById('placeHolder')})

	<?php echo $tests; ?>
	
	
</script>
