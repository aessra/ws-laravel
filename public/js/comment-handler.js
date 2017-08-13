
	'use strict';

	var CommentHandler = {
		createIt: function(options){

			var COMMENT_ID_;

			var handler = {

				_delete: function(){
					var self = this;

					var success = function(response)
					{
						if(response.status == 'OK')
						{
							messageBox(SUCCESS, 'Disable comments success');
							location.reload();

						}else
						{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Delete news failed');
							}
						}
						loader.unblock();
					}

					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						id 	: COMMENT_ID_
					}

					//console.log(postdata); return false;

					LumiRequest.sendApi({
						url: options.baseUrl + '/api',
						postdata: postdata,
						success: success,
						error: error
					});

				},

				_clickListener: function(){
					var self = this;

					$('.delete-yes').on('click', function(){
						$('.delete-confirmation').modal('hide');
						self._delete();
					});

					$(document).on('click', '.btn-delete', function(){
						var ctrl = $(this);

						NEWS_ID_ = ctrl.attr('data-name');

						$('.delete-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
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
