var referrer = document.URL;
var title = document.title;
$(document).ready(function(){
	//console.log($.param(search_query));
	if(typeof $.cookie("more_details_counter")!='undefined')
		more_details_counter = $.cookie("more_details_counter");
	else
		more_details_counter=0;
	console.log(more_details_counter);
	// login modal
	Handlebars.registerHelper('numberWithComma', function(number) {
		if(typeof number=='undefined')
			return 0;
		return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	});
	
	$("#contact_form").validate({
		submitHandler: function(form) {
			$.ajax({
				type: "POST",
				url: baseurl+"/account",
				data: $('#contact_form').serialize()
			}).done(function(data) {
				if(data.success){
					$('#contact_form').prepend('<div class="alert alert-success account_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(){ $(".account_success").fadeOut(300); }, 10000);
				}
				else{
					$('#contact_form').prepend('<div class="alert alert-danger account_error" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(){ $(".account_error").fadeOut(300); }, 10000);
				}
			});

		}
	});
	
	$("#change_password_form").validate({
		 rules : {
                new_password : {
                	required:true,
                    minlength : 5
                },
                new_password_confirmation : {
                    minlength : 5,
                    required : true,
                    equalTo : "#new_password"
                }
            },
		submitHandler: function(form) {
			$.ajax({
				type: "POST",
				url: baseurl+"/change_password",
				data: $('#change_password_form').serialize()
			}).done(function(data) {
				if(data.success){
					$('#change_password_form').prepend('<div class="alert alert-success account_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(){ $(".account_success").fadeOut(300); }, 10000);
				}
				else{
					$('#change_password_form').prepend('<div class="alert alert-danger account_error" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(){ $(".account_error").fadeOut(300); }, 10000);
				}
			});

		}
	});

	$("#login_ajax_form").validate({
		submitHandler: function(form) {
			$.ajax({
				type: "POST",
				url: baseurl+"/login",
				data: $('#login_ajax_form').serialize()
			}).done(function(data) {
				if(data.success){
					window.location.replace(data.redirect);
				}
				else{
					$('.sign_in_pop').prepend('<div class="alert alert-danger signin_error" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.error_msg+'</div>');
					setTimeout(function(){ $(".signin_error").fadeOut(300); }, 10000);
				}
			});

		}
	});

	$("#forgot_password_form").validate({
		submitHandler: function(form) {
			$.ajax({
				type: "POST",
				url: baseurl+"/forgot",
				data: $('#forgot_password_form').serialize()
			}).done(function(data) {
				if(data.success){
					$('.sign_in_pop').prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.status+'</div>');
					setTimeout(function(){ $(".signin_error").fadeOut(300); $("#forgot_pass").modal('hide');}, 5000);

				}
				else{
					$('.sign_in_pop').prepend('<div class="alert alert-danger signin_error" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.errors+'</div>');
					setTimeout(function(){ $(".signin_error").fadeOut(300); }, 10000);
				}
			});

		}
	});

	$("#view_full_details").on("click",".request_an_agent",function(e){
		e.preventDefault();
		var form_data = $("#request_showing_ajax_form").serialize();
		$.ajax({
			url: baseurl+'/visitor/send_request_email',
			type: 'POST',
			data: form_data
		})
		.done(function(data) {
			if(data.success){
				$("#view_full_details #message").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Email send successfully!!!!</div>');
				setTimeout(function(e){$('.showing_success').remove();$('#view_full_details').modal('hide');},8000);
			}else{
				$("#view_full_details #message").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Could not Send Request</div>');
				if(typeof data.errors != 'undefined'){
					var arr = data.errors;
					$.each(arr, function(index, value)
					{
						if (value.length != 0)
						{
							$("#request_showing_ajax_form").find("#" + index).after('<span class="text-error validation-error-inline">' + value[0] + '</span>');
						}
					});
				}

				setTimeout(function(e){$('.showing_success').remove();},8000);
			}
		});
	});

	$("#request_showing_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			$.ajax({
				url: baseurl+'/visitor/send_request_email',
				type: 'POST',
				data: form_data
			}).done(function(data) {
				if(data.success){
					$("#request_a_showing .modal-body").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Email send successfully!!!!</div>');
					setTimeout(function(e){$('.showing_success').remove();$('#request_a_showing').modal('hide');},8000);
				}else{
					$("#request_a_showing .modal-body").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Could not Send Request</div>');
						if(typeof data.errors != 'undefined'){
							var arr = data.errors;
							$.each(arr, function(index, value)
							{
								if (value.length != 0)
								{
									$("#request_showing_form").find("#" + index).after('<span class="text-error validation-error-inline">' + value[0] + '</span>');
								}
							});
						}
					setTimeout(function(e){$('.showing_success').remove();},8000);
				}
			});
		}
	});


	$("#free_mls_reg").on('click',".already_signed_in",function(){
		$("#free_mls_reg").modal('hide');
	});

	$("#forgot_pass").on('click',".already_signed_in",function(){
		$("#forgot_pass").modal('hide');
	});
	$("#sign_up").on('click',".free_reg",function(){
		$("#sign_up").modal('hide');
	});
	$("#sign_up").on('click',".forgot_pass",function(){
		$("#sign_up").modal('hide');
	});

	$("body").on("click",".favorites",function(event){
		event.preventDefault();
		var that=$(this);

		if($(this).data("is_signed_in")==true){
			var form_data=[];
			if($(this).data("fav")!=true){
				form_data.search_link=$(this).data("id");
				$.ajax({
					url: baseurl+'/visitor/save-favorite',
					type: 'POST',
					data: {search_link:$(this).data("id")}
				})
					.done(function(data) {
						if(data.success==true){
							$(that).find('.fav-text').html('FAVORITE');
							$(that).addClass('fav');
							$(that).data("fav",true);
							$("#menu-fav-count").html('Favorites('+data.count+')');
						}
					});
			}else{
				form_data.search_link=$(this).data("id");
				$.ajax({
					url: baseurl+'/visitor/delete-favorite',
					type: 'POST',
					data: {search_link:$(this).data("id")}
				}).done(function(data) {
						if(data.success==true){
							$(that).find('.fav-text').html('ADD TO FAVORITES');
							$(that).removeClass('fav');
							$(that).data("fav",false);
							$("#menu-fav-count").html('Favorites('+data.count+')');
						}
				});
			}

		}else{
			$("#free_mls_reg").modal('show');
		}
	});

	$("#free_mls_reg_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			var modal_form=$("#free_mls_reg_form");
			$.ajax({
				url: baseurl+'/register/member',
				type: 'POST',
				data: form_data
			})
				.done(function(data) {
					if(data.success==true){
						$("#free_mls_reg .modal-body .modal_container").hide();
						$("#free_mls_reg .modal-body").html('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>User Create Successfully</div>');
						setTimeout(function(e){$('.showing_success').remove();$('#free_mls_reg').modal('hide');},8000);
					}else{
						$("#free_mls_reg .modal-body").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Could not Create User. Try Again...</div>');
						if(typeof data.errors != 'undefined'){
							var arr = data.errors;
							$.each(arr, function(index, value)
							{
								if (value.length != 0)
								{
									modal_form.find("#" + index).after('<span class="text-error validation-error-inline">' + value[0] + '</span>');
								}
							});
						}

						setTimeout(function(e){$('.showing_success').remove();},8000);
					}
				});
		}
	});

	$('#save_search').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('whatever') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		//var url_split=window.location.href.split("?");
		if(typeof window.location.href.split("?")[1]!=='undefined'){
			modal.find('#search_link').val(window.location.href.split("?")[1]);
			modal.find('#search_link1').val(window.location.href.split("?")[1].replace(/&/gi,'\n'));

		}
		//modal.find('.modal-body input').val(recipient)
	})

	$("#save_search_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			$.ajax({
				url: baseurl+'/visitor/save-search',
				type: 'POST',
				data: form_data
			}).done(function(data) {

				if(data.success==true){
					$("#save_search .modal-body").prepend('<div class="alert alert-success " role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(e){$('.showing_success').remove();$('#save_search').modal('hide');},8000);
				}else{
					$("#save_search .modal-body").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					if(typeof data.errors != 'undefined'){
						var arr = data.errors;
						$.each(arr, function(index, value)
						{
							if (value.length != 0)
							{
								modal_form.find("#" + index).after('<span class="text-error validation-error-inline">' + value[0] + '</span>');
							}
						});
					}

					setTimeout(function(e){$('.showing_success').remove();},8000);
				}
			});
		}
	});

	$('#ask_an_agent').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget);
		$(this).find("#listing_id").val(button.data('id'));
		$(this).find("#listing_id_top").html(button.data('id'));
	});

	$("#ask_an_agent_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			$.ajax({
				url: baseurl+'/visitor/inquiry',
				type: 'POST',
				data: form_data
			}).done(function(data) {
				
				if(data.success==true){
					$("#ask_an_agent .modal-body").prepend('<div class="alert alert-success " role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(e){$('.showing_success').remove();$('#save_search').modal('hide');},8000);
				}else{
					$("#ask_an_agent .modal-body").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					if(typeof data.errors != 'undefined'){
						var arr = data.errors;
						$.each(arr, function(index, value)
						{
							if (value.length != 0)
							{
								modal_form.find("#" + index).after('<span class="text-error validation-error-inline">' + value[0] + '</span>');
							}
						});
					}

					setTimeout(function(e){$('.showing_success').remove();},8000);
				}
			});

		}
	});

	$("#subscribe_top").click(function(e){
		e.preventDefault();
		if(is_logged_in){
			$.ajax({
				url: baseurl+'/subscribe',
				type: 'POST'
			})
			.done(function(data) {
				if(data.success==true){
					$("#subscribe_message").html('<div class="showing_success">'+data.message+'</div>');
					setTimeout(function(e){$('.showing_success').remove();},8000);
				}else{
					if(typeof data.errors != 'undefined'){
						var arr = data.errors;
						$.each(arr, function(index, value)
						{
							if (value.length != 0)
							{
								if(value[0]=='The email has already been taken.')
									value[0]='You are Already Subscribed';
								$("#subscribe_message").html('<div class="showing_success">'+value[0]+'</div>');

							}
						});
					}

					setTimeout(function(e){$('.showing_success').remove();$('.validation-error-inline').remove();},8000);
				}
			});
		}else{
			$('html, body').animate({scrollTop: $('#subscription_form').offset().top -290 }, 'slow');
		}
	});

	$("#subscription_form").validate({
		submitHandler: function (form) {
			var form_data = $("#subscription_form").serialize();
			$.ajax({
				url: baseurl+'/subscribe',
				type: 'POST',
				data: form_data
			})
			.done(function(data) {
				if(data.success==true){
					$("#subscription_form").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(e){$('.showing_success').remove();},8000);
				}else{
					$("#subscription_form").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					if(typeof data.errors != 'undefined'){
						var arr = data.errors;
						$.each(arr, function(index, value)
						{
							if (value.length != 0)
							{
								$("#subscription_form").find("#" + index).after('<span style="color:#fcd113" class="validation-error-inline">' + value[0] + '</span>');
							}
						});
					}

					setTimeout(function(e){$('.showing_success').remove();$('.validation-error-inline').remove();},8000);
				}
			});

		}
	});

	$("body").on('click','#btn-ask',function(e){
		e.preventDefault();
		var form_data = $("#ask_an_agent_details_form").serialize();
		$.ajax({
			url: baseurl+'/visitor/inquiry',
			type: 'POST',
			data: form_data
		}).done(function(data) {
			if(data.success==true){
				$(".ask_agent").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
				setTimeout(function(e){$('.showing_success').remove();$('#save_search').modal('hide');},8000);
			}else{
				$(".ask_agent").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
				if(typeof data.errors != 'undefined'){
					var arr = data.errors;
					$.each(arr, function(index, value)
					{
						if (value.length != 0)
						{
							$("#ask_an_agent_details_form").find("#" + index).after('<span class="text-error validation-error-inline">' + value[0] + '</span>');
						}
					});
				}

				setTimeout(function(e){$('.showing_success').remove();},8000);
			}
		});
	});

	//$("body").on('click','#subscribe',function(e){
	//	e.preventDefault();
	//	var form_data = $("#subscription_form").serialize();
	//	$.ajax({
	//		url: baseurl+'/blog/subscribe',
	//		type: 'POST',
	//		data: form_data
	//	})
	//	.done(function(data) {
	//		if(data.success==true){
	//			$("#subscription_form").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
	//			setTimeout(function(e){$('.showing_success').remove();},8000);
	//		}else{
	//			$("#subscription_form").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
	//			setTimeout(function(e){$('.showing_success').remove();},8000);
	//			var arr = data.errors;
	//			$.each(arr, function(index, value)
	//			{
	//				if (value.length != 0)
	//				{
	//					$("#subscription_form").find("#" + index).after('<span class="text-error validation-error-inline">' + value[0] + '</span>');
	//				}
	//			});
	//			setTimeout(function(e){$('.showing_success').remove();},8000);
	//		}
	//	});
	//});

	$("#buy_request_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			$.ajax({
				url: baseurl+'/buy',
				type: 'POST',
				data: form_data
			})
			.done(function(data) {
					if(data.success==true){
						$("#buy_request_form").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+' </div>');
						setTimeout(function(e){$('.showing_success').remove();},8000);
					}else{
						$("#buy_request_form").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
						if(typeof data.errors !='undefined'){
							$.each(data.errors,function(x,y){
								$("input[name='"+x+"']").after('<span class="text-error validation-error-inline">' + y[0] + '</span>');
							})
						}
						setTimeout(function(e){$('.showing_success').remove();$('.text-error').remove();},8000);
					}
				});
		}
	});

	$("#sell_request_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			$.ajax({
				url: baseurl+'/sell',
				type: 'POST',
				data: form_data
			})
				.done(function(data) {
					if(data.success==true){
						$("#sell_request_form").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
						setTimeout(function(e){$('.showing_success').remove();},8000);
					}else{
						$("#sell_request_form").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
						if(typeof data.errors !='undefined'){
							$.each(data.errors,function(x,y){
								$("input[name='"+x+"']").after('<span class="text-error validation-error-inline">' + y[0] + '</span>');
							})
						}
						setTimeout(function(e){$('.showing_success').remove();$('.text-error').remove();},8000);
					}
				});
		}
	});

	$("#finance_request_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			$.ajax({
				url: baseurl+'/finance',
				type: 'POST',
				data: form_data
			})
				.done(function(data) {
					if(data.success==true){
						$("#finance_request_form").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
						setTimeout(function(e){$('.showing_success').remove();},8000);
					}else{
						$("#finance_request_form").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
						if(typeof data.errors !='undefined'){
							$.each(data.errors,function(x,y){
								$("input[name='"+x+"']").after('<span class="text-error validation-error-inline">' + y[0] + '</span>');
							})
						}
						setTimeout(function(e){$('.showing_success').remove();$('.text-error').remove();},8000);
					}
				});
		}
	});
	$("#contact_request_form").validate({
		submitHandler: function (form) {
			var form_data = $(form).serialize();
			$.ajax({
				url: baseurl+'/contact-us',
				type: 'POST',
				data: form_data
			})
				.done(function(data) {
					//data=JSON.parse(data);
					if(data.success==true){
						$("#contact_request_form").prepend('<div class="alert alert-success showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
						setTimeout(function(e){$('.showing_success').remove();},8000);
					}else{
						$("#contact_request_form").prepend('<div class="alert alert-danger showing_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
						if(typeof data.errors !='undefined'){
							$.each(data.errors,function(x,y){
								$("input[name='"+x+"']").after('<span class="text-error validation-error-inline">' + y[0] + '</span>');
							});
						}
						setTimeout(function(e){$('.showing_success').remove();$('.text-error').remove();},8000);

					}
				});
		}
	});
	$('[data-toggle="tooltip"]').tooltip();

	$(".popular_listing, .listing_container").on({
		mouseenter: function () {
			$(this).find('.see_details_btn').fadeIn(10);
		},
		mouseleave: function () {
			$(this).find('.see_details_btn').fadeOut(10);
		}
	},'.listing');

	$(".banner_link").on({
		mouseenter: function () {
			$(this).find('.see_all').fadeIn(10);
		},
		mouseleave: function () {
			$(this).find('.see_all').fadeOut(10);
		}
	});
	$('body').on('click','#btnxt',function(e){
		e.preventDefault();
		$(this).text('Loading...');
		if(typeof search_query.page != 'undefined'){
			search_query.page=parseInt(search_query.page)+1;
		}else{
			search_query.page=2;
		}
		PNOBJ.Controller.showPhotoListing(search_query);
		keep_history(search_query);
	});
	$('body').on('click','#btnprv',function(e){
		e.preventDefault();
		$(this).text('Loading...');
		if(typeof search_query.page != 'undefined'){
			search_query.page=parseInt(search_query.page)-1;
		}else{
			search_query.page=1;
		}
		PNOBJ.Controller.showPhotoListing(search_query);
		keep_history(search_query);
	});


	$('body').on('click','.show_details_listing',function(e){
		e.preventDefault();
		var latitude = $(this).data('lat');
		var longitude = $(this).data('lng');

		var url_listing = $(this).attr('href');
		console.log(url_listing);
		console.log(more_details_counter);
		if(is_logged_in || (!is_logged_in && more_details_counter<more_details_limit)){
			$.ajax({
				type: "GET",
				url: url_listing,
				dataType: 'html',
				cache: true

			}).done(function( data ) {

				history.pushState(null, null, url_listing);

				$('#view_full_details').empty().html(data);
				$('#view_full_details').modal("show");

				var myCenter = new google.maps.LatLng(latitude, longitude);

				var marker = new google.maps.Marker({
					position: myCenter,
					icon: baseurl + '/assets/img/map-marker.png'
				});

				var mapProp = {
					center: myCenter,
					zoom: 14,
					// draggable: false,
					scrollwheel: false,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				var map = new google.maps.Map(document.getElementById('show_map'), mapProp);
				marker.setMap(map);
				$('#view_full_details').on('shown.bs.modal', function () {
					window.setTimeout(function () {

						var carousel = '.carousel-single-listing';
						var slider = '.slider-single-listing';
						$(carousel).flexslider({
							animation: "slide",
							controlNav: false,
							animationLoop: false,
							slideshow: false,
							itemWidth: 120,
							itemMargin: 5,
							asNavFor: slider
						});

						$(slider).flexslider({
							animation: "slide",
							controlNav: false,
							animationLoop: false,
							slideshow: false,
							sync: carousel
						});

						google.maps.event.trigger(map, "resize");
						map.panTo(myCenter);

					}, 300);

				});

				// direction initialization
				PNOBJ.Controller.initDirection(map,'direction_panel');
				//more_details_counter for unsigned visitor

			});
			more_details_counter=parseInt(more_details_counter)+1;
			$.cookie('more_details_counter', more_details_counter, { expires: 365, path: '/' });
			//$.cookie("more_details_counter", more_details_counter);
		}else{
			$("#free_mls_reg").modal('show');
			//$.removeCookie('more_details_counter');
			//$.cookie('more_details_counter', 0, { expires: 365, path: '/' });
			//more_details_counter=$.cookie("more_details_counter");
		}

	});

	$('#view_full_details').on('hidden.bs.modal', function (e) {
		history.pushState(null,null,referrer);
		// document.title = title;
		$(this).empty();
	});

	$('#view_full_details').on('click','#get_dir_distance',function(e){
		var to = $('#direction-to').val();
		var from = $('#direction-from').val();
		PNOBJ.Controller.showDistanceDirection(from,to,'direction_panel');

	});

	$("#view_full_details").on('click','.btn-group > .btn',function(){
		$(this).addClass("active").siblings().removeClass("active");
	});

	$('body').on('click', '.request_a_showing_btn', function(event) {
		event.preventDefault();
		var listing_id = $(this).data('id');
		var address = $(this).data('address');
		$("#request_a_showing .modal-header h4").html('About <i>'+address+'</i>');
		$("#request_a_showing #req_listing_id").val(listing_id);
		$("#request_a_showing #req_address").val(address);
	});

	$('body').on('click','.goto',function(e){
		e.preventDefault();
		$('.goto').removeClass('active');
		$(this).addClass('active');
		var space_height = $('.navbar-fixed-top').height();
		var target_id = $(this).data('target');
		// $('html, body').animate({scrollTop: $('#'+target_id).offset().top-200 }, 'slow');
		$('body').scrollTo( '#'+target_id, 1000 , {offset: {top:-(space_height+20)} });

	});

	$('body').on('shown.bs.tab','.photo-map', function (e) {
		e.preventDefault();
		var lat = $(this).data('lat');
		var lng = $(this).data('lng');
		var id = $(this).data('id');
		var selector_id = "map-canvas-"+id;
		PNOBJ.Controller.showMap(lat,lng,selector_id);
	});

	$('#view_full_details').on('shown.bs.tab','.photo-map', function (e) {
		e.preventDefault();
		var lat = $(this).data('lat');
		var lng = $(this).data('lng');
		var id = $(this).data('id');
		var selector_id = "map-canvas-details";
		PNOBJ.Controller.showMap(lat,lng,selector_id);
	});

	$('.datepicker').datepicker({ autoclose: true, todayHighlight: true });

	//$('.comments').on('click','#blog_comment_submit',function(event){
	//	event.preventDefault();
    //
	//});
	$("#comment_form").validate({
		submitHandler: function(form) {
			$.ajax({
				type: "POST",
				url: location.href,
				data: $('#comment_form').serialize()
			}).done(function(data) {
				if(data.success){
					$('#comment_form').prepend('<div class="alert alert-success account_success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(){ $(".account_success").fadeOut(300); }, 10000);
				}
				else{
					$('#comment_form').prepend('<div class="alert alert-danger account_error" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+data.message+'</div>');
					setTimeout(function(){ $(".account_error").fadeOut(300); }, 10000);
				}
			});

		}
	});
	$("#menu-fav-count").on('click',function(e){
		if(!is_logged_in){
			e.preventDefault();
			$("#free_mls_reg").modal('show');
		}
	});
	$("#menu-save_search").on('click',function(e){
		if(!is_logged_in){
			e.preventDefault();
			$("#free_mls_reg").modal('show');
		}
	});

});

function QS(){

	this.qs = {};
	var s = location.search.replace( /^\?|#.*$/g, '' );
	if( s ) {
		var qsParts = s.split('&');
		var i, nv;
		for (i = 0; i < qsParts.length; i++) {
			nv = qsParts[i].split('=');
			this.qs[nv[0]] = nv[1];
		}
	}
}

QS.prototype.add = function( name, value ) {
	if( arguments.length == 1 && arguments[0].constructor == Object ) {
		this.addMany( arguments[0] );
		return;
	}
	this.qs[name] = value;
}

QS.prototype.addMany = function( newValues ) {
	for( nv in newValues ) {
		this.qs[nv] = newValues[nv];
	}
}

QS.prototype.remove = function( name ) {
	if( arguments.length == 1 && arguments[0].constructor == Array ) {
		this.removeMany( arguments[0] );
		return;
	}
	delete this.qs[name];
}

QS.prototype.removeMany = function( deleteNames ) {
	var i;
	for( i = 0; i < deleteNames.length; i++ ) {
		delete this.qs[deleteNames[i]];
	}
}

QS.prototype.getQueryString = function() {
	var nv, q = [];
	for( nv in this.qs ) {
		q[q.length] = nv+'='+this.qs[nv];
	}
	return q.join( '&' );
}

QS.prototype.toString = QS.prototype.getQueryString;

var qs = new QS;

// //examples
// //instantiation
// var qs = new QS;
// alert( qs );

// //add a sinle name/value
// qs.add( 'new', 'true' );
// alert( qs );

// //add multiple key/values
// qs.add( { x: 'X', y: 'Y' } );
// alert( qs );

// //remove single key
// qs.remove( 'new' )
// alert( qs );

// //remove multiple keys
// qs.remove( ['x', 'bogus'] )
// alert( qs );
