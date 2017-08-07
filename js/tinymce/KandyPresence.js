(function() {
    tinymce.create('tinymce.plugins.kandyPresence', {
        init : function(ed, url) {
            ed.addButton('kandyPresence', {
                title : 'Kandy Presence',
                image : url+'/img/kandyPresence.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyStatus class="myStatusStyle" id="myStatus"][kandyAddressBook class="myAddressBookStyle" id="myContact"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Kandy Presence",
                author : 'Kodeplus Dev',
                authorurl : 'http://kodeplus.net/',
                infourl : 'http://kodeplus.net/',
                version : "1.4"
            };
        }
    });
    tinymce.PluginManager.add('kandyPresence', tinymce.plugins.kandyPresence);
})();