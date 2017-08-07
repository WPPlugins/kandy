(function() {
    tinymce.create('tinymce.plugins.kandyVideoAnonymous', {
        init : function(ed, url) {
            ed.addButton('kandyVideoAnonymous', {
                title : 'Kandy Anonymous Video Call',
                image : url+'/img/kandyVideoAnonymous.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyVideoButton class="myButtonStyle" callOutButtonText="Call Us" callto="kandy_username@domain.com" anonymous="true"]\n[kandyVideo title="You" id="myVideo" style = "width: 300px;height: 225px;"][kandyVideo title="Them" id="theirVideo" style = "width:300px;height: 225px;"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Kandy Anonymous Video Call",
                author : 'Kodeplus Dev',
                authorurl : 'http://kodeplus.net/',
                infourl : 'http://kodeplus.net/',
                version : "1.4"
            };
        }
    });
    tinymce.PluginManager.add('kandyVideoAnonymous', tinymce.plugins.kandyVideoAnonymous);
})();