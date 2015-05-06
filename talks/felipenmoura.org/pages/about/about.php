<div id="about-slide-container">
    <div id="theMoon"></div>
    <div id="theCloud"></div>
    <div class="decoration">
        <div class="ppw-clonable-container">
            <?php addMenu(); ?>
        </div>
        <?php echoIf(<<<EOD
        <div class="short-description">
            Here you will find some information about me, both professionally and personally.<br/>
        </div>
EOD
, "<img src='".root()."slides/about/felipe-moura-felipenmoura-no-bg.png' title='Felipe N Moura' description='Felipe N Moura - Web developer and speaker' />"); ?>
    </div>
    <div class="content-dark">

        <h2>JavaScript and Front End developer and enthusiast.</h2>

        <div class="about-content">

            <strong>Open Source</strong> projects taught me a lot, and inspired me to start projects from my own.<br/>
            <br/>
            <?php echoIf(<<<EOD
            I am graduated at <a href="http://portal.senacrs.com.br/site/index.asp">Senac/RS</a>, a technician from <a href="http://www.cttmaxwell.com.br/">CTT Maxwell</a>, Project Manager by <a href="http://www.pmtech.com.br/">PMTech</a> and have some different specialization courses.<br/>
            Actually, I have worked on McDonalds, was an alxiliar of a baker, worked on a super market, on a warehouse...but it doesn't really matter now :p<br/>
            <br/>
            An advice?<br/>
            <blockquote>Do it because you love it, use, contribute and create Open Source projects and be passionate to learning!</blockquote>
EOD
            ); ?>
            I work with web development for almost a decade, and nowadays I work at <a href="http://www.terra.com.br">Terra</a> as a Senior Development Analyst.<br/>
            <br/>
            Also, I love giving talks in conferences and enjoy giving trainings(I enjoy being an attendee, too!).<br/>
            <br/>
            Among my projects, you can find <a href="http://github.com/braziljs/power-polygon">Power-polygon</a>,
            <a href="http://thewebmind.org">theWebMind</a>,
            <a href="http://botaoteca.com.br">Botaoteca</a>,
            <a href="http://phpdevbar.org">PHPDevBar</a>
            and of course, I am an organizer of the <a href="http://rsjs.org/">RSJS</a> and <a href="http://braziljs.com.br">BrazilJS Conference</a>, the first Brazilian JavaScript Conference, also, the biggest one in Latin America, and one of the biggest in the world!<br/>
            With the same name, the <a href="http://braziljs.org">BrazilJS Foundation</a>.<br/>
            <br/>


            <q>Changing the world is the least I expect from myself</q>
            <br/><br/>

            <div>
                <strong>Short bio</strong><br/>
                Felipe works with web development for almost a decade, also giving talks and trainings.
                Works nowadays at Terra as a Senior Development Analyst.<br/>
                He is an organiser of BrazilJS Conference, the Brazilian JavaScript Conference, and the RSJS, a regional conference.<br/>
                Also, a co-founder of the BrazilJS Foundation.<br/>
                Felipe has contributed to some Open Source projects as well as started some others, like Power-polygon, theWebMind and PHPDevBar.<br/>
            </div>

        </div>
<?php
    if(!isMobile()){
        ?>
        <div class="right-panel">
            <img src="<?php echo root(); ?>pages/about/felipe-moura-felipenmoura.png"
                 alt="Felipe Nascimento de Moura - felipenmoura" /><br/>

            <div class="see-more-about-me">

                <!--
                    before you start crying because it is a table...
                    these ARE table data, and tables are there for this :)
                -->
                <table class="table-data">
                    <tr>
                        <td rowspan="2">
                            <div class="spin-left">Get in touch</div>
                        </td>
                        <td>
                            <a href="http://www.linkedin.com/profile/view?id=60746087&trk=tab_pro" class="social-icon linkedin"></a>
                        </td>
                        <td>
                            <a href="http://github.com/felipenmoura" class="social-icon github"></a>
                        </td>
                        <td>
                            <a href="https://plus.google.com/u/0/100273419330331113912/?rel=author" rel=author class="social-icon gp"></a>
                        </td>
                        <td>
                            <a href="http://facebook.com/felipenmoura" class="social-icon fb"></a>
                        </td>
                        <td rowspan="2">
                            <div class="spin-right">Follow</div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="http://www.youtube.com/user/flpnm" class="social-icon youtube"></a>
                        </td>
                        <td>
                            <a href="http://braziljs.org/" class="social-icon braziljs"></a>
                        </td>
                        <td>
                            <a href="http://twitter.com/felipenmoura" class="social-icon twitter"></a>
                        </td>
                        <td>
                            <a href="mailto:felipenmoura@gmail.com" class="social-icon gmail"></a>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="redehost-container">
                My page is generously hosted by
                <a href="http://www.redehost.com.br/" title="Hospedado na RedeHost" target="_quot"><img src="http://felipenmoura.org/wp-content/uploads/2012/01/site-hospedado-aqui1.jpg" alt="Este site está generosamente hospedado na RedeHost"></a>
            </div>
        </div>
        <br/>
    </div>
    <?php
    }else{
        ?>
        <div class="about-social-btns">
            <a href="http://www.linkedin.com/profile/view?id=60746087&trk=tab_pro" class="social-icon linkedin"></a>
            <a href="http://github.com/felipenmoura" class="social-icon github"></a>
            <a href="https://plus.google.com/u/0/100273419330331113912/?rel=author" rel="author" class="social-icon gp"></a>
            <a href="http://facebook.com/felipenmoura" class="social-icon fb"></a>
            <a href="http://www.youtube.com/user/flpnm" class="social-icon youtube"></a>
            <a href="http://braziljs.org/" class="social-icon braziljs"></a>
            <a href="http://twitter.com/felipenmoura" class="social-icon twitter"></a>
            <a href="mailto:felipenmoura@gmail.com" class="social-icon gmail"></a>
        </div>
        <br/><br/><br/><br/>
        <?php
    }
    ?>
    <?php echoIf('<div id="about-roots"></div>'); ?>
</div>