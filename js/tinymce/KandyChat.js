(function() {
    tinymce.create('tinymce.plugins.kandyChat', {
        init : function(ed, url) {
            ed.addButton('kandyChat', {
                title : 'Kandy Chat',
                image : url+'/img/kandyChat.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyChat class="myChatStyle" id ="my-chat"]');
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
    tinymce.PluginManager.add('kandyChat', tinymce.plugins.kandyChat);
})();