
	'use strict';

	var CommentHandler = {
		createIt: function(options){

			var handler = {
				_validate: function(){
					var self = this;

					var bCheck = true;

					if($('#news-name').val() <= 0){
						$('.news-name-group').addClass('has-error');
						$('.news-name-msg').html('Judul tidak boleh kosong.');

						bCheck = false;
					}

					if(tinyMCE.get('news-details').getContent().length <= 0){
						$('.news-details-group').addClass('has-error');
						$('.news-details-msg').html('Berita tidak boleh kosong.');

						bCheck = false;
					}

					return bCheck;
				},

				_save: function(){
					var self = this;

					var valid = self._validate();
					if(!valid)
						return false;

					loader.block();
					var success = function(response)
					{
						if(response.status == 'OK')
						{
							window.location.href = options.baseUrl + '/news';

						}else
						{
							if(typeof response.message != 'undefined')
							{
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Save is failed');
							}
						}
						loader.unblock();
					}

					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						news_id 		: options.news_id,
						news_name		: $('#news-name').val(),
						news_details	: tinyMCE.get('news-details').getContent(),
						file_id			: 'no-file',
						act 			: options.act
					}

					//console.log(postdata); return false;

					LumiRequest.sendApi({
						url: options.baseUrl + '/save-news',
						postdata: postdata,
						success: success,
						error: error
					})
				},

				_clickListener: function(){
					var self = this;

					$('#news-name').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.news-name-group').removeClass('has-error');
							$('.news-name-msg').html('');
						}
					});

					setTimeout(function(){

						var desc = tinyMCE.get('news-details');

						desc.on('keyup', function(){
							var ctrl = desc.getContent();
							if(ctrl.length > 0){
								$('.news-details-group').removeClass('has-error');
								$('.news-details-msg').html('');
							}
						});

					}, 500);

					$('#btn-upload').on('click', function(){
						$('.upload-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});

					$('#form-action').on('submit', function(e){
						e.preventDefault()
						self._save();
					});

					$('#cancel').on('click', function(){
						window.location.href = options.baseUrl + '/news';
					});
				},

				init: function(){
					var self = this;

					self._clickListener();
				}
			}

			return handler;
		}
	}
