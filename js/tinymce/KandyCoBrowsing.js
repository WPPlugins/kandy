(function() {
    tinymce.create('tinymce.plugins.kandyCoBrowsing', {
        init : function(ed, url) {
            ed.addButton('kandyCoBrowsing', {
                title : 'Kandy CoBrowsing',
                image : url+'/img/cobrowsing.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyCoBrowsing class="myChatStyle" id ="my-chat"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Kandy Chat",
                author : 'Kodeplus Dev',
                authorurl : 'http://kodeplus.net/',
                infourl : 'http://kodeplus.net/',
                version : "1.4"
            };
        }
    });
    tinymce.PluginManager.add('kandyCoBrowsing', tinymce.plugins.kandyCoBrowsing);
})();