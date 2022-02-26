$(function(argument) {
	//start dashbord toggle plus 
	$(".latest .toggle-info").click(function(){
		$(this).toggleClass("selected").parent().next(".panel-body").fadeToggle(200);
		if ($(this).hasClass("selected")){
			$(this).html("<i class='fa fa-plus fa-lg'></i>");
		 } else {
		 	$(this).html("<i class='fa fa-minus fa-lg'></i>");
		 }
	})

	/*start dashbord toggle plus
		$(".latest .toggle-info").click(function(){
			$(this).children('i').toggleClass("fa-minus fa-plus").parent().parent(".panel-heading").next(".panel-body").fadeToggle(200);
		})
	*/
	//hide placeholder in focus and show in blur
	$("[placeholder]").focus(function () {
		$(this).attr('data-text',$(this).attr("placeholder"));
		$(this).attr("placeholder","");

	}).blur(function() {
		$(this).attr("placeholder",$(this).attr("data-text"))	
	});

	//add sterisk on required field

	$("input").each(function(){
		if($(this).attr("required")==='required'){
			$(this).after('<span class="asterisk">*</span>');
		}
	})
	//convert password field to text field on hover
	var passfield=$(".password");
	$(".show-pass").hover(function(){
		passfield.attr("type","text");
	},function(){
		passfield.attr("type","password");
	});


	//confirmation message on button
	$(".confirm").click(function(){  //plugin in bootstrap
		return confirm("Are You Sure ?");
	});

	//category view port

	$('.categories .cat h3').click(function(){
		$(this).next('.full-view').fadeToggle(200);
	});

	$(".option span").click(function(){
		$(this).addClass("active").siblings("span").removeClass("active");
		if($(this).data('view')=='full'){
			$(".cat .full-view").fadeIn(200);
		}else{
			$(".cat .full-view").fadeOut(200);
		}

	})

	$(".child-link").hover(function(){
		$(this).find(".show-delete").fadeIn()
	},function(){
		$(this).find(".show-delete").fadeOut()

	})

	//trigger the select boxit
	$("select").selectBoxIt({
		autoWidth:false
	});
})