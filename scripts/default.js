(function () {
    
    var _b= document.body,
        currentlyShowing= false,
        hashData = {};
    
    var UTILS= {};
    
    UTILS.showContent = function (id, src, path) {
        hashData = {
            page: id,
            detail: src,
            extra: path
        }
        UTILS.updatePageStatus();
//        if(currentlyShowing && currentlyShowing == id || id == 'home'){
//            src = id = 'home';
//        }
//        currentlyShowing= id;
//        hashData.page = id;
//        UTILS.updatePageStatus();
    }
    
    UTILS.clickManager = function(event){
        
        var target = event.target || event.srcElement,
            tag = target.tagName.toLowerCase(),
            tmp,
            cl = target.classList,
            src= '#';
        
        if(tag == 'a' && cl.contains('local')){
            // clicked on a link that must be retrieved via Ajax
            src= target.getAttribute('href');
            
            //UTILS.showContent(src.replace(/^(\.|\/)+/, '').replace(/\/.+/, ''), src);
            tmp = src.replace('/', '').split('/');
            UTILS.showContent(tmp[0], tmp[1], tmp[2]);
            
            event.preventDefault();
            event.stopPropagation();
        }else if((tmp = target.getAttribute('data-yt-ref')) || (tmp = target.parentNode.getAttribute('data-yt-ref'))){
            showModal({
                type: "player",
                bg: target.getAttribute('src'),
                ytRef: tmp
            });
        }else if(cl.contains('closeLayerBtn')){
            UTILS.closeModal();
        }else if(cl.contains('art-nav-tbn')){
            if(cl.contains('art-tools')){
                var el = document.getElementById('articles-nav');
                if(el.getAttribute('data-show') != 'tools'){
                    el.setAttribute('data-show', 'tools');
                }else{
                    el.removeAttribute('data-show');
                }
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
    
//    function getHash(url){
//        debugger;
//        if(url.indexOf('#!') > 0){
//            url = url.split('#!')[1];
//            url = url.split('/');
//            hashData = {
//                page: url[0] || '',
//                detail: url[1] || '',
//                extra: url[2] || ''
//            };
//            _b.setAttribute('data-page', hashData.page);
//            if(hashData.detail){
//                _b.setAttribute('hash-bang-detail', hashData.detail);
//            }else{
//                _b.removeAttribute('hash-bang-detail');
//            }
//            if(hashData.extra){
//                _b.setAttribute('hash-bang-extra', hashData.extra);
//            }else{
//                _b.removeAttribute('hash-bang-extra');
//            }
//        }else{
//            //_b.removeAttribute('data-page');
//            _b.setAttribute('data-page', 'home');
//            _b.removeAttribute('hash-bang-detail');
//            _b.removeAttribute('hash-bang-extra');
//            hashData = {};
//        }
//        if(!hashData.extra){
//            closeModal();
//        }
//    }
    
//    function setHash(data){
//        var newHash = '#!' + data.page;
//        if(data.detail){
//            newHash+= '/' + data.detail;
//            if(data.extra){
//                newHash+= '/' + data.extra;
//            }
//        }
//        location.hash = newHash;
//    }
    
    UTILS.showPlayer = function (data) {
        var bg = document.getElementById('playerLayer'),
            player = document.getElementById('playerElement');
        bg.style.backgroundImage = 'url('+ data.bg +')';
        player.style.backgroundImage = 'url('+ data.bg +')';
        player.setAttribute('src', "//www.youtube.com/embed/"+data.ytRef+"?showinfo=0");
        setHash({
            page: hashData.page,
            detail: hashData.detail,
            extra: data.ytRef
        });
    }
    
    UTILS.closePlayer = function () {
        document.getElementById('playerElement').removeAttribute('src');
        setHash({
            page: hashData.page,
            detail: hashData.detail,
            extra: ''
        });
    }
    
    UTILS.showModal = function (data) {
        switch(data.type){
            case 'player': {
                UTILS.showPlayer(data);
                break;
            }
        }
        _b.setAttribute('data-full-layer', data.type);
    }
    
    UTILS.closeModal = function () {
        var curModal = _b.getAttribute('data-full-layer');
        switch(curModal){
            case 'player': {
                closePlayer();
                break;
            }
        }
        _b.removeAttribute('data-full-layer');
    }
    
    UTILS.applySH = function () {
        sh_highlightDocument();
    }
    
    
    UTILS.updatePageStatus = function () {
        if(hashData.page){
            _b.setAttribute('data-page', hashData.page);
        }else{
            _b.setAttribute('data-page', 'home');
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
        
        var path = "/" + (hashData.page || 'home');
        if(hashData.detail){
            path += "/" + hashData.detail + location.hash;
        }
        history.pushState({}, path, path);
    }
    
    UTILS.goToPage = function  (url) {
        url = url || location;
        var path = url.pathname;
        
        path = path.split('/') ;
        
        if ( path.length ) {
            
            hashData.page = path[1];
            hashData.detail = (location.hash.replace(/^#/, '')) || path[2]; // path[2];
            hashData.extra = path[3];
            
            UTILS.updatePageStatus();
        } else {
            //_b.setAttribute('data-page', 'home');
            //_b.removeAttribute('hash-bang-detail');
            //_b.removeAttribute('hash-bang-extra');
            hashData = {};
            UTILS.updatePageStatus();
        }
    }

    
    function applyEvents () {
        
        _b.addEventListener('click', UTILS.clickManager);
        
        window.addEventListener('popstate', function onPopStateChange (event) {
            UTILS.goToPage(location);
            ga('send', 'pageview', {
                'page': location.pathname + location.search  + location.hash
            });
        });

//        window.addEventListener('hashchange', function(event){
//            //getHash(event.newURL);
//            hashData.detail = location.hash.replace(/^#!/, ''); //event.newURL;
//            hashData.extra = "";
//            UTILS.updatePageStatus();
//
//            ga('send', 'pageview', {
//                'page': location.pathname + location.search  + location.hash
//            });
//        });

        window.addEventListener('load', function onPageLoad (event) {
            window.scrollTo(0, 0);
            ga('send', 'pageview');
            UTILS.applySH();
        });

        window.addEventListener('keyup', function onKeyUpEvent (event) {
            switch(event.keyCode){
                case 27: { // esc
                    UTILS.closeModal();
                    break;
                }
            }
        });
    }
    
    applyEvents();
    UTILS.goToPage(location);
    
})();