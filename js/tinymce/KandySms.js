(function() {
    tinymce.create('tinymce.plugins.kandySms', {
        init : function(ed, url) {
            ed.addButton('kandySms', {
                title : 'Kandy Sms',
                image : url+'/img/kandySms.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandySms class="mySms" id ="mySms"]');
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
    tinymce.PluginManager.add('kandySms', tinymce.plugins.kandySms);
})();