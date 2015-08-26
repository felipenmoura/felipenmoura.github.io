
module.exports = function(grunt){
    var fs = require('fs');
    grunt.registerMultiTask('create', 'Creates a new article', function() {
        var artName = "teste";
        console.log(this);
        try {
            fs.realpathSync('articles/' + artName);
        } catch(e) {
            fs.mkdir('articles/' + artName);
            fs.writeFileSync('articles/' + artName + '/_content.html', "<h2>"+artName+"</h2>\nContent goes here");
            fs.writeFileSync('articles/' + artName + '/_meta.json', '{\
    "title": "'+artName+' <em></em>",\
    "creationDate": "'+((new Date()).toGMTString())+'",\
    "tags": ["article"],\
    "resume": "",\
    "headerImg": "/articles/'+artName+'/'+artName+'.jpg",\
    "status": "published",\
    "articleLang": "pt-BR"\
}');
        }
    });
}
