(function () {
    
    var _b= document.body,
        currentlyShowing= false,
        hashData = {};
    
    var UTILS= {};
    
    UTILS.XHR = {
        obj: new XMLHttpRequest(),
        askFor: function (url, cb) {
            var xhr = UTILS.XHR.obj;
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    cb(xhr.responseText, xhr.status == 200);
                }
            };
            xhr.open('GET', url, true);
            xhr.send(null);
        }
    };
    
//    UTILS.currentSocialData = {};
//    UTILS.setSocialData = function () {
//        
//    };
//    
//    UTILS.resetSocialData = function () {
//        
//    };
    
    UTILS.showContent = function (id, src, path) {
        hashData = {
            page: id,
            detail: src,
            extra: path
        }
        UTILS.updatePageStatus();
    }
    
    UTILS.clickManager = function(event){
        
        var target = event.target || event.srcElement,
            tag = target.tagName.toLowerCase(),
            tmp,
            cl = target.classList,
            src= '#';
        
        if(tag == 'a' && cl.contains('local')){
            
            if(cl.contains('inactive')){
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            // clicked on a link that must be retrieved via Ajax
            src= target.getAttribute('href');
            tmp = src.replace('/', '').split('/');
            UTILS.showContent(tmp[0], tmp[1], tmp[2]);
            
            event.preventDefault();
            event.stopPropagation();
        }else if((tmp = target.getAttribute('data-yt-ref')) || (tmp = target.parentNode.getAttribute('data-yt-ref'))){
            hashData.extra = tmp;
            UTILS.videoBg = target.getAttribute('src') || target.firstElementChild.getAttribute('src');
            UTILS.updatePageStatus();
        }else if(cl.contains('closeLayerBtn')){
            UTILS.closeModal();
        }else if(cl.contains('art-nav-tbn')){
            if(cl.contains('art-tools')){
                var el = document.getElementById('articles-nav');
                if(el.getAttribute('data-show') != 'tools'){
                    el.setAttribute('data-show', 'tools');
                    _b.classList.remove('see-all-articles');
                }else{
                    el.removeAttribute('data-show');
                }
            }else if(cl.contains('art-see-list')){
                _b.classList.toggle('see-all-articles');
            }else{
                var el = document.getElementById('the-article');
                var curTextSize = parseInt(el.getAttribute('data-text-size'));
                switch(target.id){
                    case 'article-tool-bigger':
                        if(curTextSize < 4){
                            curTextSize++;
                            el.setAttribute('data-text-size', curTextSize);
                        }
                    break;
                    case 'article-tool-smaller':
                        if(curTextSize > 1){
                            curTextSize--;
                            el.setAttribute('data-text-size', curTextSize);
                        }
                    break;
                    case 'article-tool-contrast':
                        if(el.getAttribute('data-contrast') == 'on'){
                           el.setAttribute('data-contrast', 'off');
                        }else{
                            el.setAttribute('data-contrast', 'on');
                        }
                    break;
                }
            }
        }
    };
    
    UTILS.showPlayer = function (data) {
        var bg = document.getElementById('playerLayer'),
            player = document.getElementById('playerElement');
        bg.style.backgroundImage = 'url('+ data.bg +')';
        player.style.backgroundImage = 'url('+ data.bg +')';
        player.setAttribute('src', "//www.youtube.com/embed/"+data.ytRef+"?showinfo=0");
    };
    
    UTILS.closePlayer = function () {
        document.getElementById('playerElement').removeAttribute('src');
    };
    
    UTILS.showModal = function (data) {
        switch(data.type){
            case 'player': {
                UTILS.showPlayer(data);
                break;
            }
        }
        _b.setAttribute('data-full-layer', data.type);
        UTILS.registerPageView();
    };
    
    UTILS.closeModalLayer = function () {
        var curModal = _b.getAttribute('data-full-layer');
        switch(curModal){
            case 'player': {
                UTILS.closePlayer();
                break;
            }
        }
        _b.removeAttribute('data-full-layer');
        UTILS.registerPageView();
    };
    
    UTILS.closeModal = function () {
        hashData.extra = false;
        UTILS.updatePageStatus();
    };
    
    UTILS.setArticlesLoadStatus = function (status) {
        if(status >= 100){
            UTILS.articlesloader.style.width= '120%';
            setTimeout(function(){
                UTILS.articlesContainer.innerHTML = UTILS.tmpContainer.querySelector('section').innerHTML;
                UTILS.tmpContainer.innerHTML = '';
                UTILS.applySH();
                UTILS.applyComments();
                UTILS.applySocialButtons();
                UTILS.registerPageView();
            }, 400);
        }else{
            UTILS.articlesloader.style.width= status + '%';
        }
    };
    
    UTILS.loadArticleAsync = function (articleURL) {
        
        var imgList,
            loadedImgs = 0,
            onImgLoad;
        
        UTILS.tmpContainer = UTILS.tmpContainer || document.getElementById('articleTmpElement');
        UTILS.articlesContainer = UTILS.articlesContainer || document.getElementById('articles-container');
        UTILS.articlesloader = document.getElementById('loading-bar');
        UTILS.setArticlesLoadStatus(30);
        _b.classList.remove('see-all-articles');
        
        UTILS.XHR.askFor('/articles/' + articleURL + '/index-ajax.html',
                         function (data, status) {
            UTILS.setArticlesLoadStatus(60);
            if(status){
                UTILS.tmpContainer.innerHTML = data;
                imgList = [].slice.call(UTILS.tmpContainer.querySelectorAll('img'));
                
                onImgLoad = function () {
                    loadedImgs++;
                    if(loadedImgs >= imgList.length - 1){
                        UTILS.setArticlesLoadStatus(100);
                    }
                };
                
                if(imgList.length){
                    imgList.forEach(function(cur){
                        cur.onload= cur.onerror = onImgLoad;
                    });
                }else{
                    onImgLoad();
                }
            }else{
                // TODO: do something to deal with not found articles
            }
        });
    };
    
    UTILS.applySH = function () {
        Prism.highlightAll();
    };
    
    UTILS.applyComments = function(){
        
        if(UTILS.disqusApplied){
            DISQUS.reset({
                reload: true,
//                config: function () {  
//                    this.page.identifier = '/'+hashData.page+'/'+hashData.detail+'/';
//                    this.page.url = location.href;
//                }
            });
        }else{
            UTILS.disqusApplied = true;
            var disqus_shortname = 'felipenmoura';

            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        }
    }
    
    UTILS.updatePageStatus = function () {
        if(hashData.page){
            _b.setAttribute('data-page', hashData.page);
        }else{
            _b.setAttribute('data-page', 'home');
        }
        
        if(hashData.page == 'articles' && hashData.detail) {
            if(UTILS.loaded){// && location.pathname != ('/' + hashData.page + '/' + hashData.detail + '/')){
                UTILS.loadArticleAsync(hashData.detail);
            }
        }else{
            _b.classList.remove('see-all-articles');
            document.getElementById('articles-nav').removeAttribute('data-show');
        }
        
        if(hashData.detail == 'videos' || hashData.detail == 'labs'){
            if(hashData.extra){
                UTILS.showModal({
                    type: "player",
                    bg: UTILS.videoBg || '',
                    ytRef: hashData.extra
                });
            }else{
                UTILS.closeModalLayer();
            }
        }else{
            UTILS.closeModalLayer();
        }
        
        if(hashData.detail){
            _b.setAttribute('hash-bang-detail', hashData.detail);
        }else{
            _b.removeAttribute('hash-bang-detail');
        }
        if(hashData.extra){
            _b.setAttribute('hash-bang-extra', hashData.extra);
        }else{
            _b.removeAttribute('hash-bang-extra');
        }
        
        var path = "/" + (hashData.page || '');
        if(hashData.detail){
            path += "/" + hashData.detail; // + location.hash;
        }
        
        if(hashData.extra){
            path += "/#" + hashData.extra; // + location.hash;
        //}else if(location.hash){
        //    path += "/" + location.hash;
        }else{
            if(!path.match(/\/$/)){
                path += '/';
            }
        }
        
        UTILS.registerPageView();
        
        //if(location.pathname != path) {
        if(location.pathname + (location.hash || '#' ) != path + (hashData.extra || '#')) {
            history.pushState({}, path, path);
            UTILS.setTitle();
        }
    };
    
    UTILS.setTitle = function () {
        var tt = 'felipenmoura: ' + (hashData.page || 'home');
        if(hashData.detail){
            tt+= ' | ' + hashData.detail
        }
        if(hashData.extra){
            tt+= ' | ' + hashData.extra
        }
        document.title = tt;
    };
    
    UTILS.registerPageView = function () {
        ga('send', 'pageview', {
            'page': location.pathname + location.search  + location.hash
        });
    };
    
    UTILS.goToPage = function  (url) {
        url = url || location;
        var path = url.pathname;
        
        path = path.split('/') ;
        
        if ( path.length ) {
            
            hashData.page = path[1];
            hashData.detail = path[2];
            hashData.extra = location.hash.replace('#', '');
            
            UTILS.updatePageStatus();
        } else {
            hashData = {};
            UTILS.updatePageStatus();
        }
    }
    
    UTILS.applpiedSocialButtons = false;
    UTILS.applySocialButtons = function () {
        
        if(!UTILS.applpiedSocialButtons){
            // load twitter
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            
            // load facebook
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3&appId=427975900560419";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        }else{
            // reload twitter
            twttr.widgets.load();
            // reload facebook
            FB.XFBML.parse(document.body);
        }
        
        // gp
        //window.___gcfg = {lang: 'pt-BR'};
        (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
        
        UTILS.applpiedSocialButtons = true;
    }

    
    function applyEvents () {
        
        _b.addEventListener('click', UTILS.clickManager);
        
        window.addEventListener('popstate', function onPopStateChange (event) {
            UTILS.goToPage(location);
        });

        window.addEventListener('hashchange', function(event){
            //getHash(event.newURL);
            //hashData.detail = location.hash.replace(/^#!/, ''); //event.newURL;
            hashData.extra = "";
            UTILS.updatePageStatus();
        });

        window.addEventListener('load', function onPageLoad (event) {
            window.scrollTo(0, 0);
            //UTILS.registerPageView();
            UTILS.goToPage(location);
            UTILS.applySH();
            UTILS.applyComments();
            UTILS.applySocialButtons();
            setTimeout(function(){
                UTILS.loaded = true;
            });
            UTILS.setTitle();
        });

        window.addEventListener('keyup', function onKeyUpEvent (event) {
            switch(event.keyCode){
                case 27: { // esc key
                    UTILS.closeModal();
                    _b.classList.remove('see-all-articles');
                    break;
                }
            }
        });
    }
    
    applyEvents();
    UTILS.goToPage(location);
    
})();