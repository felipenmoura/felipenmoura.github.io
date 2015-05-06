<?php
	$src= '../';
	include '../includes/header.php';
	include '../includes/menu.php';

	$funcs= <<<HereDoc

	function getArray(v)
	{
		return [1, v, 3];
	}

	var getPerson= function(){
		var o = {
					age:25,
					name: 'felipe',
					jump: function(height){
						return true;
					}
				 }
		return o;
	};
HereDoc;
	$tests= <<<HereDoc
// testing the array
	jfUnit.assert(getArray, 2, [1,2,3]);
	jfUnit.assert(getArray, 3, [1,3,3]);
	jfUnit.assert(getArray, 3, [1,3,3,4]);
	jfUnit.assert(getArray, 2, [1,2]);
	jfUnit.assert(getArray, 5, [1,2,3]); // forcing another error

	// testing person
	jfUnit.assert(getPerson, {age:25, name:'felipe', jump:function x(height){return true;}});
	jfUnit.assert(getPerson, {age:25, name:'felipe', foo:'bar'});
	jfUnit.assert(getPerson, {age:25, name:'felipe', jump:function (height){return true;}, foo:'bar'});
	jfUnit.assert(getPerson, {age:25, name:'felipe', jump:function (height){return true;}});

	// using an object
	jfUnit.assert({
		call:getPerson,
		description: "Testing using an object",
		expected:{age:25, name:'foo', jump:function (height){return true;}}
	});

	jfUnit.assert({
		call:getPerson,
		expected:{age:25, name:'felipe', jump:function (height){return true;}}
	});

	// verifying only the class, or the structure, not verifying the values
	jfUnit.assert({
		call:getPerson,
		structureOnly:true,
		description: "this test is verifying ONLY the structure."+
		"It could be used to check for 'classes' instead of exact objects",
		expected:{age:0, name:'foo', jump:function(){}}
	});

	// forcing an error, even when verifying only the structure
	jfUnit.assert({
		call:getPerson,
		structureOnly:true,
		expected:{age:0, name:'foo', jump:'string'}
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
