tinymce.PluginManager.add('twitterembeded', function(editor, url) {
            // Add a button on toolbar
            editor.addButton('twitterembeded', {
                text: 'Twitter',
                icon: false,
                context:"toolbar",
                onclick: function() {
                    twitterEmbedOpen();
                }
            });
            //Add menu item 
            editor.addMenuItem('twitterembeded', {
                text: 'Embed Twitter tweet',
                context: 'tools',
                onclick: function() {
                    // Open window
                    twitterEmbedOpen();
                }
            });

            function twitterEmbedOpen() {
                editor.windowManager.open({
                    title: 'Embed Twitter tweet',
                    width:400,
                    height:190,
                    body: [{
                            type: 'textbox', name: 'post', label: 'Embed code', id: 'embedtw',
                    },
                    {
                        type: 'container',
                        label: 'Width',
                        layout: 'flex',
                        direction: 'row',
                        align: 'center',
                        spacing: 5,
                        items: [{
                            name:'width', 
                                type:'textbox', 
                                maxLength:4,
                                size:3,
                                onchange:false,
                                ariaLabel:'Width',
                                id: 'embedtwwidth'
                            }],
                    },
                    {
                        type: 'container',
                        label: 'Height',
                        layout: 'flex',
                        direction: 'row',
                        align: 'center',
                        spacing: 5,
                        items: [{
                            name:'height', 
                                type:'textbox', 
                                maxLength:4,
                                size:3,
                                onchange:false,
                                ariaLabel:'Height',
                                id: 'embedtwheight'
                            }],
                    }],
                    onsubmit: function(e) {
                        var TWEmbedError = false;
                        var twUrl = jQuery('#embedtw').val();
                        var embedtwwidth = jQuery('#embedtwwidth').val();
                        var embedtwheight = jQuery('#embedtwheight').val();
                        editor.insertContent('<iframe border=0 frameborder=0 height='+embedtwheight+' width='+embedtwwidth+' src="https://twitframe.com/show?url='+twUrl+'"></iframe>');
                    }
                });
            }
        });