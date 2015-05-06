<?php
	$src= '../';
	include '../includes/header.php';
	include '../includes/menu.php';
?>
<div id="body">
	<div id="body-top">
		<div id="body-bot">
			<div class="content wikistyle gollum markdown" style="background-color: #D7B8AA;">
				  <p>Here, you'll see an overview of the possible methods you can call to perform your tests, and also to understand this library.
				This library does not require any other library, css or HTML structure, which allows you to simple call it as you wish, even from your console. As this library is small, you can set it to be download (and by this, cached) with the rest of your application, and then perform your tests straight from your main structure, just by calling the <em>jfUnit.run()</em> method.<br>
				Differently than other libraries, you don't need to keep your assertions in a different file, allowing you to write your tests right with your libraries. Of course, you can put your tests in a different file, although you will need to import their sources too, once you want to run your tests.<br>

				<p>The easiest way to perform your tests is by adding their assertions line by line, like this.

				<pre><code> jfUnit.assert(yourFunction, param1, param2, expected);</code></pre>

				<p>Another thing you can see here is that you are not calling yourFunction, but passing its reference. That's why you can add all your tests like this, and not to run them.<br>
				Once you decided to run them, simply call

				<pre><code>jfUnit.run();</code></pre>

				<p>You'll see the results of your tests in the end of your body element into the HTML. If your want to change it, you may use the config method.

				<pre><code>jfUnit.config({
	placeHolder : document.getElementById('someDiv')*
});</code></pre>

				<p>Before running your tests, you can add their assertions using any of the following methods:

				<p><h2>assert</h2><br>
				You will assert that, when calling the specific function/object method, sending specific parameters, the return should be the expected parameter. This method also accepts a callback.
				You can call it in two distinct ways:
				<em>by parameters</em>

				<pre><code> jfUnit.assert(yourFunction, param1, param2, paramN, expected [, callback]);</code></pre>

				<p>Where: <em>yourFunction</em> is the function to be called, and <em>expected</em> is the expected return. Any other parameters between these(you can send as many as you want) will be sent to the specified function/method when the tests run. You can send a callback, to be executed in the end of that test, as the last paramether.
				<em>by object</em>

				<pre><code>jfUnit.assert({
	call:yourFunction,
	param1: value1,
	param2: value2,
	paramN: value,
	expected: 'expectedValue'
	[
		callback: function(){},
		description: '',
		structureOnly: false,
		funcName: 'an alias to your function'
	]
})</code></pre>

				<p>Notice that, <em>callback, description, structureOnly and funcName</em> are optional, that's why there are those [ ] symbols.
				Again, you can send as many parameters as you want, but now, specifying a name to each one. The description will simply show a message next to the name of your test.<br><em>structureOnly</em> will verify only the structure of an object, and the return of your called function. What means that you may want as a return an object with <em>name, age and email</em> but the content of these data can be different. The default value of this property is <em>false</em>, so, when passing an object as expected, it will be deeply verified and to pass the test, must match each value.<br>

				<p><h2>assertNot</h2><br>
				The inverse of <em>assert</em> method. In other words, it will pass with the returned value is NOT EQUALS to the passed as expected.

				<p><h2>assertIn</h2><br>
				This method defines that the return of the called function must be one of the passed through an array. This method, like all the others, also accepts an object as parameter.

				<pre><code> jfUnit.assertIn(yourFunction, param1, param2, paramN, [option1, option2, optionN] [, callback]);</code></pre>

				<p>Example:

				<pre><code> jfUnit.assertIn(Math.min, 10, 4, [2, 3, 4, 5]); // the return will be 4, so, one of the valid options</code></pre>

				<p><h2>assertNotIn</h2><br>
				This method is the inverse of <em>assertIn</em>. It means your expected array will represent the values the return must NOT be. Anything else, will be accepted  as a valid option and the test will pass.

				<p><h2>assertBetween</h2><br>
				Asserts that the returned value must fit between two values passed as array, in your expected parameter. As the example shows:

				<pre><code> jfUnit.assertBetween(Math.min, 10, 4, [2, 5]); // the return will be 4, so, between 2 and 5</code></pre>

				<p><h2>assertNotBetween</h2><br>
				It is the inverse of <em>assertBetween</em>, passing the test when the return is NOT between those two values.

				<p><h2>assertGT</h2><br>
				ASserts that the returned value must be greater than the expected.

				<p><h2>assertLT</h2><br>
				ASserts that the returned value must be less than the expected.

				<p><h2>assertType</h2><br>
				Asserts that the type of the returned value, must be the specified.
				You send, as expected, the type you're waiting for.

				<pre><code> jfUnit.assertType(Math.min, 10, 2, 'integer');</code></pre>

				<p>As you must have noticed, jfUnit will treat it to be not simply <em>number</em>, allowing you to send a bunch of different specifications, such as:
				<em>integer, number, numeric, float, real or double</em><br>
				Any other type will be compared normally.
			</div>
		</div>
	</div>
</div>
<?php
	include '../includes/footer.php';
?>