(function () {
    
    var _b= document.body,
        currentlyShowing= false,
        hashData = {};
    
    function showContent (id, src, path) {
        if(currentlyShowing && currentlyShowing == id || id == 'home'){
            src = id = 'home';
        }
        currentlyShowing= id;
        _b.setAttribute('data-page', id);
        setHash({
            page: (path || src).replace(/^(\.|\/)+/g, '')
        });
        //history.pushState({}, path || src, path || src);
    }
    
    _b.addEventListener('click', function(event){
        var target = event.target || event.srcElement,
            tag = target.tagName.toLowerCase(),
            tmp,
            cl = target.classList,
            src= '#';
        
        if(tag == 'a' && cl.contains('local')){
            // clicked on a link that must be retrieved via Ajax
            src= target.getAttribute('href');
            
            // TODO: get it via ajax
            showContent(src.replace(/^(\.|\/)+/, '').replace(/\/.+/, ''), src);
            
            event.preventDefault();
            event.stopPropagation();
        }else if((tmp = target.getAttribute('data-yt-ref')) || (tmp = target.parentNode.getAttribute('data-yt-ref'))){
            showModal({
                type: "player",
                bg: target.getAttribute('src'),
                ytRef: tmp
            });
        }else if(cl.contains('closeLayerBtn')){
            closeModal();
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
    });
    
    function getHash(url){
        if(url.indexOf('#!') > 0){
            url = url.split('#!')[1];
            url = url.split('/');
            hashData = {
                page: url[0] || '',
                detail: url[1] || '',
                extra: url[2] || ''
            };
            _b.setAttribute('data-page', hashData.page);
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
        }else{
            //_b.removeAttribute('data-page');
            _b.setAttribute('data-page', 'home');
            _b.removeAttribute('hash-bang-detail');
            _b.removeAttribute('hash-bang-extra');
            hashData = {};
        }
        if(!hashData.extra){
            closeModal();
        }
    }
    
    function setHash(data){
        var newHash = '#!' + data.page;
        if(data.detail){
            newHash+= '/' + data.detail;
            if(data.extra){
                newHash+= '/' + data.extra;
            }
        }
        location.hash = newHash;
    }
    
    function showPlayer(data){
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
    function closePlayer(){
        document.getElementById('playerElement').removeAttribute('src');
        setHash({
            page: hashData.page,
            detail: hashData.detail,
            extra: ''
        });
    }
    
    function showModal(data){
        switch(data.type){
            case 'player': {
                showPlayer(data);
                break;
            }
        }
        _b.setAttribute('data-full-layer', data.type);
    }
    
    function closeModal(){
        var curModal = _b.getAttribute('data-full-layer');
        switch(curModal){
            case 'player': {
                closePlayer();
                break;
            }
        }
        _b.removeAttribute('data-full-layer');
    }
    
    function applySH(){
        debugger;
        sh_highlightDocument();
    }
    
    window.addEventListener('keyup', function(event){
        switch(event.keyCode){
            case 27: { // esc
                closeModal();
                break;
            }
        }
    });
    
    window.addEventListener('hashchange', function(event){
        getHash(event.newURL);
        // ga('send', 'event', 'button', 'click', 'nav buttons', 4);
        ga('send', 'pageview', {
            'page': location.pathname + location.search  + location.hash
        });
    });
    
    window.addEventListener('load', function(event){
        getHash(location.href);
        ga('send', 'pageview');
        applySH();
    });
    
    window.scrollTo(0, 0);
})();