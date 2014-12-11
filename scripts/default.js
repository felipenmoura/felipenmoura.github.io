(function () {
    
    var _b= document.body,
        currentlyShowing= false;
    
    function showContent (id, src, path) {
        if(currentlyShowing && currentlyShowing == id || id == 'home'){
            hideContent();
        } else {
            currentlyShowing= id;
            _b.setAttribute('data-showing-content', '1');
            _b.setAttribute('data-showing-content-type', id);
            history.pushState({}, "home", path || src);
        }
    }
    
    function hideContent () {
        _b.removeAttribute('data-showing-content');
        currentlyShowing= false;
        
        history.pushState({}, "home", "./");
    }
    
    _b.addEventListener('click', function(event){
        var target= event.target || event.srcElement,
            tag= target.tagName.toLowerCase(),
            src= '#';
        
        if(tag == 'a' && target.classList.contains('use-ajax')){
            // clicked on a link that must be retrieved via Ajax
            src= target.getAttribute('href');
            
            // TODO: take it via jQuery
            showContent(src.replace(/^(\.|\/)+/, '').replace(/\/.+/, ''), src);
            
            event.preventDefault();
            event.stopPropagation();
        }
    });
})();