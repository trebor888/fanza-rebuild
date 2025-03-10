tinymce.PluginManager.add('instagramembeded', function(editor, url) {
            // Add a button on toolbar
            editor.addButton('instagramembeded', {
                text: 'Instagram',
                icon: false,
                context:"toolbar",
                onclick: function() {
                    instagramEmbedOpen();
                }
            });
            //Add menu item 
            editor.addMenuItem('instagramembeded', {
                text: 'Embed Instagram Feed',
                context: 'tools',
                onclick: function() {
                    // Open window
                    instagramEmbedOpen();
                }
            });

            function instagramEmbedOpen() {
                editor.windowManager.open({
                    title: 'Embed Instagram Feed',
                    width:400,
                    height:190,
                    body: [{
                            type: 'textbox', name: 'post', label: 'Embed code', id: 'embedins',
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
                                id: 'embedinswidth'
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
                                id: 'embedinsheight'
                            }],
                    }],
                    onsubmit: function(e) {
                        var INSEmbedError = false;
                        var insUrl = jQuery('#embedins').val();
                        var embedinswidth = jQuery('#embedinswidth').val();
                        var embedinsheight = jQuery('#embedinsheight').val();
                        editor.insertContent('<iframe src="'+insUrl+'embed/" width="'+embedinswidth+'" height="'+embedinsheight+'" frameborder="0" scrolling="yes" allowtransparency="true"></iframe>');
                    }
                });
            }
        });