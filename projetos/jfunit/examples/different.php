<?php
	$src= '../';
	include '../includes/header.php';
	include '../includes/menu.php';

	$funcs= <<<HereDoc

	function sum(value1, value2)
	{
		return value1+value2;
	}
	function division(value1, value2)
	{
		return value2>0? value1/value2: 0;
	}
HereDoc;
	$tests= <<<HereDoc
// assertIn
		// simple mode
	jfUnit.assertIn(sum, 10, 0, [9,10,11]); // ok
	jfUnit.assertIn(sum, 10, 0, [9,12,11]); // error
		// advanced mode
	jfUnit.assertIn({
		call:sum,
		v1:10,
		v2:2,
		expected:[10, 12]
	}); // ok
	jfUnit.assertIn({
		call:sum,
		v1:10,
		v2:2,
		expected:[10, 11, 13]
	}); // error

	// assertNotIn
		// simple mode
	jfUnit.assertNotIn(sum, 10, 0, [9,12,11]); // ok
	jfUnit.assertNotIn(sum, 10, 0, [9,10,11]); // error
		// advanced mode
	jfUnit.assertNotIn({
		call:sum,
		v1:10,
		v2:2,
		expected:[10, 11, 13]
	}); // ok
	jfUnit.assertNotIn({
		call:sum,
		v1:10,
		v2:2,
		expected:[10, 12]
	}); // error

	// assertNot
		// simple mode
	jfUnit.assertNot(sum, 10, 0, 0); // ok
	jfUnit.assertNot(sum, 10, 0, 10); // error
		// advanced mode
	jfUnit.assertNot({
		call:sum,
		v1:10,
		v2:2,
		expected: 10
	}); // ok
	jfUnit.assertNot({
		call:sum,
		v1:10,
		v2:2,
		expected: 12
	}); // error

	// assertBetween
		// simple mode
	jfUnit.assertBetween(sum, 10, 0, [9,11]); // ok
	jfUnit.assertBetween(sum, 10, 0, [7,9]); // error
		// advanced mode
	jfUnit.assertBetween({
		call:sum,
		v1:10,
		v2:2,
		expected: [5, 16]
	}); // ok
	jfUnit.assertBetween({
		call:sum,
		v1:10,
		v2:2,
		expected: [4,9]
	}); // error

	// assertNotBetween
		// simple mode
	jfUnit.assertNotBetween(sum, 10, 0, [7,9]); // ok
	jfUnit.assertNotBetween(sum, 10, 0, [9,11]); // error
		// advanced mode
	jfUnit.assertNotBetween({
		call:sum,
		v1:10,
		v2:2,
		expected: [4, 9]
	}); // ok
	jfUnit.assertNotBetween({
		call:sum,
		v1:10,
		v2:2,
		expected: [5,16]
	}); // error

	jfUnit.assertGT(sum, 10, 2, 3); // ok
	jfUnit.assertGT(sum, 10, 2, 16); // fail
	jfUnit.assertLT(sum, 10, 2, 16); // ok
	jfUnit.assertLT(sum, 10, 2, 3); // fail

	jfUnit.assertType(sum, 10, 2, 'integer'); // ok
	jfUnit.assertType(sum, 10, 'a', 'integer'); // fail

	jfUnit.assertType(division, 10, 3, 'real'); // ok
	jfUnit.assertType(division, 10, 3, 'integer'); // fail
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

	jfUnit.run();
</script>
