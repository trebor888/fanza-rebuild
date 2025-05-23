tinymce.PluginManager.add('facebookembed', function(editor, url) {
	    	// Add a button on toolbar
	    	editor.addButton('facebookembed', {
		        text: 'Facebook',
		        icon: false,
		        context:"toolbar",
		        onclick: function() {
		            facebookEmbedOpen();
		        }
	    	});
	    	//Add menu item 
	    	editor.addMenuItem('facebookembed', {
		        text: 'Embed Facebook post',
		        context: 'tools',
		        onclick: function() {
		            // Open window
		            facebookEmbedOpen();
		        }
    		});

		    function facebookEmbedOpen() {
		    	editor.windowManager.open({
	                title: 'Embed Facebook post',
	                width:400,
	                height:190,
	                body: [{
	                    	type: 'textbox', name: 'post', label: 'Embed code', id: 'embedfb',
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
								id: 'embedfbwidth'
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
								id: 'embedfbheight'
							}],
					}],
	                onsubmit: function(e) {
	                	var FbEmbedError = false;
	                	var fbUrl = jQuery('#embedfb').val();
	                	var embedfbwidth = jQuery('#embedfbwidth').val();
	                	var embedfbheight = jQuery('#embedfbheight').val();
	                	editor.insertContent('<iframe src="https://www.facebook.com/plugins/post.php?href='+fbUrl+'&tabs=timeline&width='+embedfbwidth+'&height='+embedfbheight+'&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="'+embedfbwidth+'" height="'+embedfbheight+'" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>');
	                	var regex = /=https?\:\/\/\w{3}\.facebook\.com\/(.*)\/(videos?|posts?)\/\d+/i;
						var FbEmbeds = regex.exec(decodeURIComponent(e.data.post));
						
	                    if(FbEmbeds === null){
	                    	FbEmbedError = true;
	                    }else if(!FbEmbeds.length) {
	                    	FbEmbedError = true;
	                    }
	                    
	                    if(!FbEmbedError) {
	                    	
	                    	//Get Width
	                    	FbBEmbedWidth = parseInt(e.data.width);
		                    
		                    //Create img element
		                    FbImage = document.createElement("img");
		                    
		                    //Set img src attribute value
		                    FbImage.src = tinymce.baseURL + '/plugins/facebookembed/img/facebookembedpost-tinymce-placeholder.png';
		                    
		                    //Add data attributes to img element
		                    FbImage.setAttribute('class','FacebookEmbedPost');
		                    FbImage.setAttribute('data-post', FbEmbeds[0].replace('=', ''));
		                    FbImage.setAttribute('data-width', (FbBEmbedWidth ? FbBEmbedWidth : 960));
		                    // Insert content when the window form is submitted
		                   	editor.insertContent(FbImage.outerHTML);
		                }
	                }
	            });
		    }
		});