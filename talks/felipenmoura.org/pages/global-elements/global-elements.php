<a id="accessibility-welcome" href="javascript:void(0);" tabindex="1" accesskey="m" onclick="focusOnMenu()" keypress="if(event.keyCode == 13) focusOnMenu();" >Hi, thanks for visiting my page! Hit enter to go to the menu.</a>

<div id="fb-root"></div>

<h1 class="h-tt">Felipe N Moura - Web developer, speaker, trainer and addicted</h1>

<?php
    if(isMobile()){
        ?>
            <div id="mobile-menu">
                <nav>
                    <a href="./home" class="mm-home" tabindex="2" id="menu-home">Home</a>
                    <a href="./about" class="mm-about" tabindex="3" id="menu-about">About me</a>
                    <a href="./projects" class="mm-projects" tabindex="4" id="menu-projects">Projects/Demos</a>
                    <a href="./trainings" class="mm-trainings" tabindex="5" id="menu-trainings">Trainings/Talks</a>
                    <a href="./articles" class="mm-articles" tabindex="6" id="menu-articles">Articles</a>
                    <a  id="toggle-mmenu-btn" tabindex="-1" href="javascript: $('#mobile-menu').toggleClass('mmenu-open'); void(0);">

                    </a>
                </nav>
            </div>
        <?php
    }
?>

<div id="bg-coloured" class=""></div>
<div id="projects-bg" class="fulfill"></div>
<div id="articles-bg" class="fulfill">
    
    <nav>
        <?php
            if(!isMobile()){
        ?>
        <div id="tags" class="postit">
            <strong>Tags</strong>
            <ul>
                <li><a href="">php</a></li>
                <li><a href="">javascript</a></li>
                <li><a href="">CSS3</a></li>
                <li><a href="">HTML5</a></li>
                <li><a href="">SQL</a></li>
            </ul>
        </div>
        <?php
            }
        ?>
    </nav>
    <div id="article-tools" class="postit type-2">
        <?php echoIf('<strong>Tools</strong><br/>'); ?>
        <form id="form-search" target="hiddenFrame">
            <input type="search" role="search" name="search" id="search-ipt" spellcheck="false" autocomplete="false" placeholder="search..." /><br/>
            <input type="submit" class="hiddenInput" />
            <iframe id="hiddenFrame" name="hiddenFrame"></iframe>
        </form>
        <input type="button" id="smallerFont" title="Decrease the font size" />
        <input type="button" id="biggerFont" title="Increase the font size" />
        <a href="http://felipenmoura.org/rss"><input type="button" id="rssBtn" title="RSS Feed" /></a>
        <input type="button" id="readingMode" title="Toggle Reading mode" />
        <?php
            if(!isMobile()){
        ?>
        <div id="scroll-tools">
            <a href="" id="scrollTop-trigger">Scroll to top</a>
            <a href="" id="scrollBottom-trigger">Scroll to bottom</a>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<div id="trainings-bg" class="fulfill">
    <?php //echoIf('<div class="decoration"></div><div class="decoration-marker"></div>'); ?>
    <?php echoIf('<div class="decoration"></div>'); ?>
</div>

<?php echoIf('<div id="shaddow-effect"></div>'); ?>

<footer role="contentinfo" class="footer-element global">
    <div class="info">
        Developed by <a href="<?php echo root(); ?>about">FelipeNMoura</a> - 2013
    </div>
    <div class="social-buttons">

        <a href="" id="brasilian-flag" title="Mudar para Português" ></a>
        <a href="" id="usa-flag" title="Change to english" ></a>

        <div class="social-button">You like it?</div>
        <div class="social-button fb-like" data-href="http://felipenmoura.org" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
        <div class="social-button gp"><div class="g-plusone" data-size="medium" data-href="http://felipenmoura.org"></div></div>
    </div>
</footer>

<div id="full-page-decoration"></div>