<?php
    /*$requested = empty($_SERVER['REQUEST_URI']) ? false : $_SERVER['REQUEST_URI'];
    if(substr($requested, -4) == '.css')
    {
        include('styles/'.basename($requested));
        exit;
    }*/
    /*if(substr($requested, -3) == '.js')
    {
        include('scripts/'.basename($requested));
        exit;
    }*/
?><!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <title>felipeNMoura.org(true)</title>
        
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="styles/default.css" />
        <link rel="alternate" type="application/atom+xml" title="feed" href="/feed/" />
        <link rel="icon" href="favicon.gif" size="32x32"/>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <script src="scripts/router.js"></script>
        <script src="scripts/default.js"></script>
        <style type="text/css">
            /**********
            Sorry for this scrollbar thing! but google chrome has a
            bug with normal scrollbars for rotated elements!
            Bug which I reported here http://code.google.com/p/chromium/issues/detail?id=98142&thanks=98142&ts=1317079936
            **********/
            #universe{
                -webkit-transform: rotate(0deg) translate(16px, 0px) !IMPORTANT;
            }
        </style>
    </head>
    <body>
        <noscript>
            !!!
        </noscript>
        <div id="globalDiv">
            <header id="topHeader">
                <div class="contentLeft">welcome</div>
                <div class="contentRight">
                    <div id="alignUniverseButton">
                        Line up
                    </div>
                </div>
            </header>
            <div id="universe">
                <div id="west">
                    <div id="west-north">
                        <nav id="viewers">
                            <nav id="home" style="display: none;">
                                <div class="subMenu"><a href="#">About me</a></div>
                                <div class="subMenu"><a href="#">Projects o' mine</a></div>
                                <div class="subMenu"><a href="#">Experiments</a></div>
                                <div class="subMenu"><a href="#">Contact me</a></div>
                                <div class="subMenu"><a href="#">Buy me a beer</a></div>
                            </nav>
                            <nav id="articles" style="display: none;">
                                <!-- CATEGORIES -->
                                <div class="subMenu"><a href="#">PHP</a></div>
                                <div class="subMenu"><a href="#">Javascript/HTML/CSS</a></div>
                                <div class="subMenu"><a href="#">Client Technologies</a></div>
                                <div class="subMenu"><a href="#">Server Technologies</a></div>
                                <!-- <div class="history">
                                    HISTORY/ARCHIVE
                                </div> -->
                            </nav>
                            <nav id="projects" style="display: none;">
                                <div class="subMenu"><a href="#">Projects o' mine</a></div>
                                    <div class="subMenu2"><a href="#">theWebMind</a></div>
                                    <div class="subMenu2"><a href="#">PHPDevBar</a></div>
                                    <div class="subMenu2"><a href="#">FoxTale</a></div>
                                    <div class="subMenu2"><a href="#">Botaoteca</a></div>
                                    <div class="subMenu2"><a href="#">Desconferencia</a></div>
                                    <div class="subMenu2"><a href="#">jfUnit</a></div>
                                <div class="subMenu"><a href="#">Experiments</a></div>
                                    <div class="subMenu2"><a href="#">Video Exp. 1</a></div>
                                    <div class="subMenu2"><a href="#">CSS animation 1</a></div>
                                <div class="subMenu"><a href="#">Buy me a beer</a></div>
                            </nav>
                            <nav id="about" style="display: none;">
                                <div class="subMenu"><a href="#">About me</a></div>
                                <div class="subMenu"><a href="#">Contact me</a></div>
                                    <div class="subMenu2"><a href="#">E-mail me</a></div>
                                    <div class="subMenu2"><a href="#">Me, on twitter</a></div>
                                    <div class="subMenu2"><a href="#">Google+ me</a></div>
                                <div class="subMenu"><a href="#">Buy me a beer</a></div>
                            </nav>
                        </nav>
                        
                        <div id="arrowOlder">
                            Older
                            <img src="images/arrow-older.png" />
                        </div>
                    </div>
                    <div id="west-south">
                        <div id="arrowNewer">
                            <img src="images/arrow-newer.png"/>
                            Newer
                        </div>
                        <div class="zLineLeft"></div>
                        <div class="zLineLeftShadow"></div>
                    </div>
                </div>
                <div id="east">
                    <div id="east-north">
                        <div id="arrowOlderRightPannel" class="arrowOlder" >
                            <img src="images/arrow-older.png"/>
                        </div>
                        <div class="zLineRight"></div>
                        
                        <div class="articleDate articleDateFront">
                            <a href="post_files/post1.php">Aug. 22/2011</a>
                        </div>
                        <div class="articleDate articleDateMiddle">
                            <a href="post_files/post2.php">July. 15/2011</a>
                        </div>
                        <div class="articleDate articleDateBehind">
                            <a href="post_files/post3.php">July. 03/2011</a>
                        </div>
                        
                        <div class="content front">
                            <article>
                                <h1>First Title here!</h1>
                                <h2>See here, a small description for this article</h2>
                                <div style="width: 450px;">
                                    
                                <img src="images/globe.png" width="150" align="right"/>
                                Lorem ipsum <b>dolor</b> sit <strong>amet</strong>, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor.<br/>
                                Nam <a href="">sed pharetra</a> orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean <i>rhoncus</i>, augue <em>vitae tempor</em> sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante. Nullam ut sapien orci, vitae blandit lorem.
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.
                                </div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                            </article>
                        </div>
                            
                        <div class="content middle">
                            <article>
                                <h1>Second Title here!</h1>
                                <h2>Here, another article description!</h2>
                                <div style="width: 450px;">
                                    
                                <img src="images/globe.png" width="150" align="right"/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante. Nullam ut sapien orci, vitae blandit lorem.
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.
                                </div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                            </article>
                        </div>
                        
                        <div class="content behind">
                            <article>
                                <h1>Tird Title!</h1>
                                <h2>wohoow! This is the tird title we've got...</h2>
                                <div style="width: 450px;">
                                    
                                <img src="images/globe.png" width="150" align="right"/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante. Nullam ut sapien orci, vitae blandit lorem.
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.
                                </div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                                Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                                Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                                Morbi commodo pellentesque ante.<br/>
                            </article>
                        </div>
                    </div>
                    
                    <div id="east-south">
                        <nav>
                            <ul class="menu" id="controlers">
                                <li><a href="home">Home</a></li>
                                <li><a href="articles">Articles/Lectures</a></li>
                                <li><a href="projects">Projects</a></li>
                                <li><a href="about">About/Contact</a></li>
                            </ul>
                        </nav>
                        <div id="pagDescription">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis nulla id antecursus porttitor id sed elit.<br/>
                            Sed condimentum mattis auctor. Nam sed pharetra orci. Nullam ut sapien orci, vitae blandit lorem.<br/>
                            Aenean rhoncus, augue vitae tempor sagittis, elit sapien tristique mi, eget tempor nulla neque sed leo.<br/>
                            Morbi commodo pellentesque ante.
                        </div>
                    </div>
                </div>
            </div>
            <div  id="footer">
                <div id="footerPannel">
                    Website created by FelipeNMoura -- <a href="feed" target='_quot'>RSS</a> -- <a href="http://twitter.com/felipenmoura" target='_quot'>twitter</a>
                    <a style="float:left;" rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Licença Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png" /></a>
                    <footer>
                        @copyright 2011
                    </footer>
                </div>
            </div>
            
        </div>
    </body>
</html>
