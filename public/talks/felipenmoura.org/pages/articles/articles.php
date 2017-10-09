<div class="ppw-clonable-container">
    <?php addMenu(); ?>
</div>

<div id="articles-list-container">
    <img id="article-loading" src="<?php echo root(); ?>pages/articles/loading.gif" /><br/>
    <section id="articles-list">
        <div id="close-reading-mode-btn"></div>
        <?php
            for($i= 0; $i< 3; $i++){
                ?>
                    <article title="ARTICLE TITLE 1" class="articles-item">
                        <h3><a href="#!articles/article+name-<?php echo $i; ?>">Article title</a></h3>
                        <div class="decoration">
                            <div class="short-url" title="Get shortned link"></div>
                            <date>05/11/2013</date>
                            <div class="social-button fb-like" data-href="http://ARTICLE.com" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
                            <div class="social-button gp"><div class="g-plusone" data-size="medium" data-href="http://felipenmoura.org"></div></div>
                        </div>
                        <div class="article-content">
                            Mussum ipsum cacilds, vidis litro abertis. Consetis <span class="sarcasm">adipiscings elitis</span>. Pra lá , depois divoltis <strong>porris</strong>, paradis. <em>Paisis, filhis, espiritis santis.</em><br/> Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo.
                            <blockquote class="green">
                                Uma ctacildis aqui, que é pra mencionális o pessoal!
                                <cite>
                                    <a href="http://fonte.com/artigo">Quem falou isso</a>
                                </cite>
                            </blockquote>
                            <p>Manduma pindureta quium dia nois paga.</p> Sapien in monti palavris qui num significa nadis i pareci latim.
                            <blockquote class="yellow">
                                Uma ctacildis aqui, que é pra mencionális o pessoal!
                                <cite>
                                    <a href="http://fonte.com/artigo">Quem falou isso</a>
                                </cite>
                            </blockquote>
                            Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.<br/>
                            
                            <pre class="code">$('#readingMode').click(function(){
    if(_settings.readingMode){
        _exitReadingMode();
    }else{
        _enterReadingMode();
    }
});</pre>
                            
                            Suco de cevadiss, é um leite divinis, qui tem lupuliz, matis, aguis e fermentis.
                            <blockquote class="red">
                                Uma ctacildis aqui, que é pra mencionális o pessoal!
                                <cite>
                                    <a href="http://fonte.com/artigo">Quem falou isso</a>
                                </cite>
                            </blockquote>
                            Interagi no mé, cursus quis, vehicula ac nisi. Aenean vel dui dui. Nullam leo erat, aliquet quis tempus a, posuere ut mi.
                            <blockquote>
                                Uma ctacildis aqui, que é pra mencionális o pessoal!
                                <cite>
                                    <a href="http://fonte.com/artigo">Quem falou isso</a>
                                </cite>
                            </blockquote>
                            <img alt="uma imagem empolgante aqui!" src="http://www.rainbowlandscaping.com/wp-content/uploads/2012/01/landscaping-slide2.png" class="<?php echo ($i==0? 'right': ($i==1? 'left': 'center')); ?>" width="300px"/> Ut scelerisque neque et turpis posuere pulvinar pellentesque nibh ullamcorper. Pharetra in mattis molestie, volutpat elementum justo. Aenean ut ante turpis. Pellentesque laoreet mé vel lectus scelerisque interdum cursus velit auctor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac mauris lectus, non scelerisque augue. Aenean justo massa.<br/>Casamentiss faiz malandris se pirulitá, Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat <a href="#">facer possim assum</a>. Lorem ipsum dolor sit amet, consectetuer Ispecialista im mé intende tudis nuam golada, vinho, uiski, carirí, rum da jamaikis, só num pode ser mijis. Adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                        </div>
                    </article>
                <?php
            }
        ?>
    </section>

</div>

<div id="article-page-tools">
    <a href="" class="older active">older</a>
    <a href="" class="newer">newer</a>
</div>
<script>
    /*PPW.onSlideEnter(function(slides){
        //PPW.animate('#tags, #article-tools', 'fadeIn', {delay: '1s'});
        console.log("ENTERING", slides)
    });
    PPW.onSlideExit(function(slides){
        //PPW.animate('#tags, #article-tools', 'fadeOut', {delay: '0s'});
        console.log("EXITING", slides)
    });*/
</script>