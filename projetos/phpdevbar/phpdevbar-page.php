<!DOCTYPE HTML>
<html>
    <head>
        <title>
            PHPDevBar, the PHP Developer's toolbar for Firefox
        </title>
        <link rel="shortcut icon" href="images/paletteico.png"></link>
        <style type="text/css">
            body{
                margin:0px;
                background: white url(images/bg-header.png) repeat-x;
                font-family: Verdana, Tahoma, Arial;
            }
            #content{
                width: 960px;
                margin:auto;
            }
            .header{
                position:relative;
                background: url(images/darkBlue.png) no-repeat;
                height:90px;
                z-index:2;
                border-top: solid 1px black;
                color:white;
                text-shadow: 0px 0px 4px black;
            }
            .body{
                position:relative;
                z-index:1;
                min-height:600px;
                background-color:white;
                box-shadow: 0px -100px 100px rgba(40, 40, 40, 0.5);
            }
            h1{
                margin:3px;
            }
            .header h1{
                margin-left: 40px;
            }
            .header h2{
                margin:0px;
                margin-left: 200px;
                font-weight:normal;
                /*-moz-transform: skew(40deg) rotate(-6deg) translate(10px, -30px);*/
                font-size:16px;
            }
            #downloadableButtons{
                padding-top:30px;
                float:left;
            }
            a{
                color: #00a;
                text-decoration:none;
                cursor:pointer;
            }
            a:hover{
                text-decoration:underline;
            }
            a img{
                border:none;
            }
            #downloadableButtons div{
                border:solid 1px #fff;
            }
            #downloadableButtons div:hover{
            }
            #downloadButton{
            }
            #bodyContent{
                color: #777;
                padding: 20px;
                padding-top: 10px;
            }
			.tip
			{
				margin:8px;
				padding:8px;
				background-image: -moz-linear-gradient(top, white, #E1E1EE);
				background-image: -webkit-linear-gradient(top, white, #E1E1EE);
				border: solid 1px #99c;
			}
            h4
            {
                font-size:16px;
                margin:0px;
            }
            #creditsEContribute{
                height:110px;
                border:solid 1px white;
            }
            #creditsDiv{
                float:left;
                margin-right:40px;
            }
            #donateDiv{
            }
            #donateDiv>div{
                text-align:center;
            }
        </style>
    </head>
    <body>
        <div id="content">
            <div class="header">
                <h1>PHPDevBar</h1>
                <h2>The PHP Developer Toolbar</h2>
            </div>
            <div class="body">
                <div id="downloadableButtons">
                    <br/>
                    <div id="downloadButton">
                        <a href="https://addons.mozilla.org/pt-BR/firefox/addon/php-developer-toolbar/" target="_quot" >
                            <img src="images/download-btn.png" />
                        </a>
                    </div><br/>
                    <div id="downloadFFButton">
                        <a href="http://getfirefox.com" target="_quot" >
                            <img src="images/download-ff-btn.png" />
                        </a>
                    </div>
                </div>
                <div id="bodyContent">
                    <div>
                        <h3>What is PHPDevBar</h3>
                        PHPDevBar is an addon for firefox.<br/>
                        <p>This toolbar uses the official documentation from PHd to quickly retrieve method and function definitions showing you their structure straightly in your browser. You can also use it to search in PHP Web sites.</p>
                        <p>Besides that, PHP Developer Toolbar has a huge list of user groups and server and client tools/links.</p>
                        <p>This addon also has a different feature, the PHPClassGen, which allows you to easily generate a class and its HTML Form just by filling a form in. <a href="https://addons.mozilla.org/pt-BR/firefox/addon/php-developer-toolbar/">See more details here.</a></p>
                        <div id="creditsEContribute">
                            <div id="creditsDiv">
                                <h3>Credits</h3>
                                <a href="http://felipenmoura.org" target="_quot">Felipe Nascimento de Moura</a><br/>
                                <a href="http://jaydson.org" target="_quot">Jaydson Nascimento Gomes</a><br/>
                            </div>
                            <div id="donateDiv">
                                <h3>Donate</h3>
                                <div>
                                    <!--<a href="https://addons.mozilla.org/pt-BR/firefox/addon/php-developer-toolbar/contribute/?src=addon-detail">contribute</a>-->
                                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                        <input type="hidden" name="cmd" value="_s-xclick">
                                        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
                                        ">
                                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                        <img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div id="helpContent">
                        <h3>Help content</h3>
                        <div class='tip'>
                            <h4>Accessibility</h4>
                            You can show the PHPDevBar by pressing <i>F4</i> in your keyboard, of thecombination <i>Ctrl+shiftF</i>. When visible and with the search input focused, <i>ESC</i> will hide it.<br/>
                            If your PHPDevBar is visible but the search input is not focused, calling it by its shortcut will focus the search field.<br/>
                            You can also use te small icon in yout extensions bar in the bottom part of your browser, to show the PHP Developer Toolbar.<br/>
                                            <br/>
                            While typing into the PHPDevBar input, it will show you some of the PHP functions that match with your text, and verify if you are not forgetting any "_", also, ignoring captialised letters.<br/>
                            You can navigate through the options with the <i>down</i> and <i>up</i> arrows on your keyboard. Then, press enter to search for results.<br/>
                        </div>
                        <div class='tip'>
                            <h4>Options</h4>
                            The first botton on the PHPDevBar tells where your search will run.<br>
                            The first option will bring to you a resume of the searched function while the other options will open a new tab with the documentation about the searched term into the choosen target.<br/>
                            The third button gives you a list of continents, then countries and all their registered PHP User groups.
                        </div>
                        <div class='tip'>
                            <h4>Class and Form Generator</h4>
                            You also have a generator, built to help you to write classes or forms that may be annoying to code, some times.<br/>
                            With this tool, you can see the code changing on the fly as you change any detail of your class.<br/>
                            To toggle between form and classe visualization, simply click on the buttons below the panel.<br/>
                            To add new fields to your form or class, simply fill the data about this field and click on the button with the "+" symbol.<br/>
                            The new field will be shown in the right panel, in which you can remove each field by clicking on the red "X".<br/>
                        </div>
                        <div class='tip'>
                            <h4>License</h4>
                            This addon is under <a href="license.txt" target="_quot">MIT license</a>.<br/>
                            Function list was updated using the PHD engine (thanks to the <a href="http://doc.php.net/phd/" target="_quot">PHd Project)</a><br/>
                            Feel free to contribute to this project by sending your ideas or PHPUG and reporting bugs.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1270869-18']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>