	'use strict';

	var TinyMce = {
		init: function(options){
			tinymce.init({
				selector: "textarea.tiny-mce",
				convert_newlines_to_brs: false,
				force_p_newlines: true,
				force_br_newlines : false,
				remove_redundant_brs : true,
				remove_linebreaks : true,
				forced_root_block : "",
				height: 200,
			  menubar: false,
			  plugins: [
			    'advlist autolink lists link image charmap print preview anchor',
			    'searchreplace visualblocks code fullscreen',
			    'insertdatetime media table contextmenu paste code'
			  ],
			  toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify bullist numlist outdent indent',
				font_size_style_values: "12px, 16px, 20px, 24px, 28px, 32px, 36px",
				filemanager_crossdomain: true,
				filemanager_title:"Responsive Filemanager",
				external_filemanager_path: options.baseUrl + "/js/filemanager/",
				external_plugins: { "filemanager" : options.baseUrl +  "/js/filemanager/plugin.min.js"},
				imagetools_cors_hosts: [options.baseUrl],
				remove_script_host : true,
				document_base_url : [options.baseUrl],
				convert_urls : true,
				relative_urls: false,
				//tab key
				setup: function(ed) {
					ed.on('keydown', function(event) {
						if (event.keyCode == 9){ // tab pressed
							ed.execCommand('mceInsertContent', false, '&emsp;&emsp;'); // inserts tab
							event.preventDefault();
							event.stopPropagation();
							return false;
						}
					});

					ed.on('keyup', function(e) {
						//console.debug('Key up event: ' + e.keyCode);
					});
				}
				//tab key
			});
		}
	}
