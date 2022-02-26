$(function(argument) {
	
	//switch between singnup and login
	$(".login-page h1 span").click(function(){
		$(this).addClass("selected").siblings().removeClass("selected");
		$(".login-page form").hide();
		$("."+$(this).data('class')).fadeIn(100);	
	});


	//hide placeholder in focus and show in blur
	$("[placeholder]").focus(function () {
		$(this).attr('data-text',$(this).attr("placeholder"));
		$(this).attr("placeholder","");

	}).blur(function() {
		$(this).attr("placeholder",$(this).attr("data-text"))	
	});

	//convert password field to text field on hover
	var passfield=$(".password");
	$(".show-pass").hover(function(){
		passfield.attr("type","text");
	},function(){
		passfield.attr("type","password");
	});

	//add asterisk on required field
	// $("input").each(function(){
	// 	if($(this).attr("required")==='required'){
	// 		$(this).after('<span class="asterisk">*</span>');
	// 	}
	// })

	//carousel
	$(".carousel-inner > .item > img, .carousel-inner > .item > a > img").css({
		"height":window.innerHeight,
		"width":window.innerWidth
	})

	$('.carousel').carousel({
	  interval: 1000
	})

	//confirmation message on button
	$(".confirm").click(function(){  //plugin in bootstrap
		return confirm("Are You Sure ?");
	});

	//category view port

	/*$(".form-group .live-name").keyup(function(){
		$(".live-preview .caption h3").text($(this).val());
	});

	$(".form-group .live-dec").keyup(function(){
		$(".live-preview .caption p").text($(this).val());
	});
	$(".form-group .live-price").keyup(function(){
		$(".live-preview .price-tag").text("$"+$(this).val());
	});
	*/

	$(".live").keyup(function(){
		$($(this).data("class")).text($(this).val());
	})

	//thumbnails 
	$(".thumbnails img").click(function(){
		$(this).addClass("selected").parent().siblings().children().removeClass("selected");
		$(".master-img img").hide().attr("src",$(this).attr("src")).fadeIn(800);
	});

	
	//show scroll to top button
    var button=$("#scroll-top");
    $(window).scroll(function() {
    	if($(this).scrollTop()>=700){
    		button.show();
    	}else{
    		button.hide();
    	}
    })
    //click in button to scroll top
    button.click(function(){
     	$("html,body").animate({scrollTop:0},600);
    });
	
	//trigger the select boxit
	$("select").selectBoxIt({
		autoWidth:false
	});

})