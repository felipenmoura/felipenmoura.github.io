(function () {
    
    var _b= document.body,
        currentlyShowing= false;
    
    function showContent (id, src, path) {
        if(currentlyShowing && currentlyShowing == id || id == 'home'){
            src = id = 'home';
        }
        currentlyShowing= id;
        _b.setAttribute('data-page', id);
        //history.pushState({}, path || src, path || src);
    }
    
    _b.addEventListener('click', function(event){
        var target= event.target || event.srcElement,
            tag= target.tagName.toLowerCase(),
            src= '#';
        
        if(tag == 'a' && target.classList.contains('local')){
            // clicked on a link that must be retrieved via Ajax
            src= target.getAttribute('href');
            
            // TODO: take it via jQuery
            showContent(src.replace(/^(\.|\/)+/, '').replace(/\/.+/, ''), src);
            
            event.preventDefault();
            event.stopPropagation();
        }
    });
    
    window.scrollTo(0, 0);
})();