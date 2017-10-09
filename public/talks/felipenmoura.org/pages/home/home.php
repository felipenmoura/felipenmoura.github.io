<div id="cloud-1" class="cloud"></div>
<div id="cloud-2" class="cloud"></div>
<div id="cloud-3" class="cloud"></div>
<?php echoIf('<div id="cloud-4" class="cloud"></div>'); ?>

<div id="felipenmoura"></div>
<div class="home-content-container">

    <?php echoIf('<div class="current-menu-description"></div>'); ?>
    <nav class="home-menus">
        <ul>
            <li>
                <a href="<?php echo root(); ?>home" tabindex="2" id="menu-home">Home</a>
                <?php echoIf(<<<EOD
                <label for="menu-home" class="menu-description">
                    Welcome to my personal home page!<br/>
                    Here you can find ways to contact me or see the projects I started.<br/>
                    There is also a bunch of tutorials/articles.<br/>

                    <div>
                        <div class="social-button">You like it?</div>
                        <div class="social-button fb-like" data-href="http://felipenmoura.org" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
                        <div class="social-button gp"><div class="g-plusone" data-size="medium" data-href="http://felipenmoura.org"></div></div>
                    </div>
                </label>
EOD
                ); ?>
            </li>
            <li>
                <a href="<?php echo root(); ?>about/" tabindex="3" id="menu-about">About me</a>
                <?php
                    $mrkp= <<<EOD
                <label for="menu-about" class="menu-description">
                    Here you can learn a bit more about me.<br/>
                    Professional information, and some personal stuff, too.<br/>
                    Going straight to point? You can see more at:<br/>

                    <div class="social-container">
                        <a href="http://www.linkedin.com/profile/view?id=60746087&trk=tab_pro"><img src="{ROOT}pages/about/linkedin.png" alt='Linkedin' /></a>
                        <a href="http://github.com/felipenmoura"><img src="{ROOT}pages/about/github.png" alt='Github' /></a>
                        <a href="https://plus.google.com/u/0/100273419330331113912/?rel=author"><img src="{ROOT}pages/about/gp.png" alt='Google+' /></a>
                        <a href="http://facebook.com/felipenmoura"><img src="{ROOT}pages/about/fb.png" alt='Facebook' /></a>
                        <a href="http://www.youtube.com/user/flpnm"><img src="{ROOT}pages/about/youtube.png" alt='Youtube' /></a>
                        <a href="http://braziljs.org/"><img src="{ROOT}pages/about/braziljs.png" alt='Brazil JS' /></a>
                        <a href="http://twitter.com/felipenmoura"><img src="{ROOT}pages/about/twitter.png" alt='Twitter' /></a>
                        <a href="mailto:felipenmoura@gmail.com"><img src="{ROOT}pages/about/gmail.png" alt='GMail' /></a>
                    </div>
                </label>
EOD;
                    echoIf(str_replace('{ROOT}', root(), $mrkp));
                ?>
            </li>
            <li>
                <a href="<?php echo root(); ?>projects" tabindex="4" id="menu-projects">Projects/Demos</a>
                <?php $mrkp= <<<EOD
                <label for="menu-projects" class="menu-description">
                    I like writing demos and Open Source projects.<br/>
                    I hope you can learn and help me as I could with other projects I helped and used to learn.<br/>
                    Follow me or fork my projects at <a href="http://github.com/felipenmoura/">github</a>
                </label>
EOD;
                echoIf(str_replace('{ROOT}', root(), $mrkp));
                ?>
            </li>
            <li>
                <a href="<?php echo root(); ?>trainings" tabindex="5" id="menu-trainings">Trainings/Talks</a>
                <?php $mrkp= <<<EOD
                <label for="menu-trainings" class="menu-description">
                    Interested in hiring me to teach/train a team?<br/>
                    Check the meanings we can set this up and get in touch!<br/>
                    I may also speak at your conference if you will.
                </label>
EOD;
                echoIf(str_replace('{ROOT}', root(), $mrkp));
                ?>
            </li>
            <li>
                <a href="<?php echo root(); ?>articles" tabindex="6" id="menu-articles">Articles</a>
                <?php $mrkp= <<<EOD
                <label for="menu-articles" class="menu-description">
                    Well, as every good nerd, I like wondering about things, and sometimes I write them down!<br/>
                    Also, check for some publications of mine, and some tips.
                </label>
EOD;
                echoIf(str_replace('{ROOT}', root(), $mrkp));
                ?>
            </li>
        </ul>
    </nav>
</div>
