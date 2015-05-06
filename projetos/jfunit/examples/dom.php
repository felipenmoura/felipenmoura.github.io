<?php
	$src= '../';
	include '../includes/header.php';
	include '../includes/menu.php';

	$tests= <<<HereDoc
jfUnit.config({
		placeHolder: document.getElementById('placeHolder')
	});
	jfUnit.assert({
		call:function(){
			document.getElementById('menuToBeClickedAt').onclick();
			return true;
		},
		expected: true
	});
	jfUnit.assert({
		call:function(){
			document.getElementById('subMenuToBeHovered').onmouseover();
			return true;
		},
		expected: true,
		delay:1000
	});
	jfUnit.assert({
		call:function(){
			document.getElementById('secondSubMenuToBeHOvered').onmouseover();
			return true;
		},
		expected: true,
		delay:1000
	});
	jfUnit.assert({
		call:function(){
			document.getElementById('subMenuToBeClicked').onclick();
			return true;
		},
		expected: true,
		delay:1000
	});
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
				The <i>Menu 2</i> has a submenu, which, at the fourth item, has another submenu. This second submenu has a third submenu on its second item.<br/>
				The last submenu has a clicable item, the second one, which will increase the number of clicks the item has received.
				<br/><br/>
				<div style="margin-left:100px;" id="placeHolder">
					<div>
						<div id="menuExamples">
							<span>Menu 1</span>
							<span style="cursor:pointer;"
								  onclick="toggleFirstMenu();"
								  id="menuToBeClickedAt">Menu 2 ></span>
							<span>Menu 3</span>
							Menu Item clicked <b id="counter">0</b> times
							<ul id="example-FirstMenu" style="display:none;">
								<li>SubMenu 1</li>
								<li>SubMenu 2</li>
								<li>SubMenu 3</li>
								<li id="subMenuToBeHovered"
									onmouseover="toggleMenu(this)"
									onmouseout="toggleMenu(this)">
									SubMenu 4 >
									<ul id="example-SecondMenu"
										style="display:none;">
										<li>SubSubMenu 1</li>
										<li id="secondSubMenuToBeHOvered"
											onmouseover="toggleMenu(this)"
											onmouseout="toggleMenu(this)">
											SubSubMenu 2 >
											<ul id="example-ThirdMenu"
												style="display:none;">
												<li>SubSubSubMenu_1</li>
												<li id="subMenuToBeClicked"
													onclick="clicked()"
													style="cursor:pointer;">Menu to be clicked</li>
												<li>SubSubSubMenu_3</li>
											</ul>
										</li>
										<li>SubSubMenu 3</li>
									</ul>
								</li>
								<li>SubMenu 5</li>
								<li>SubMenu 6</li>
							</ul>
						</div>
						<div id='testPlaceHolder'></div>
						<br/>
						Click the "Run Tests" button to see the jfUnit interacting with this menu, going until the clicable menu item and clicking it, increasing the number of clicks.
						<br/>
						You will see it step by step because we set a delay for each action.
						<br/><br/>
						<input type="button" id="buttonToRun" value="Run Tests" onclick="startTests(this);">
					</div>
				</div>
				<br/>
				<a href="javascript:showCode()" style="margin-left:100px;">Source Code</a>
				<div id="codeHere" style="display:none;">
<b>TESTS</b>
	<?php echo $tests; ?>
				</div>
				<br/><br/><br/><br/>
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

	function setTests()
	{
		<?php echo $tests; ?>
	}

</script>
<script>

	function toggleFirstMenu()
	{
		if(document.getElementById('example-FirstMenu').style.display == 'none')
		{
			clearMenus();
			document.getElementById('example-FirstMenu').style.display= '';
		}else
			clearMenus();
	}

	function toggleMenu(el)
	{
		el= el.getElementsByTagName('ul')[0];
		el.style.display= (el.style.display=='none')? '': 'none';
	}
	function clearMenus()
	{
		document.getElementById('example-ThirdMenu').style.display= 'none';
		document.getElementById('example-SecondMenu').style.display= 'none';
		document.getElementById('example-FirstMenu').style.display= 'none';
	}
	var counterVar= 0;
	function clicked()
	{
		clearMenus();
		document.getElementById('counter').innerHTML= ++counterVar;
		return true;
	}
	function startTests(el)
	{
		setTests();
		clearMenus();
		//document.getElementById('buttonToRun').style.display= 'none';
		jfUnit.run();
	}
</script>