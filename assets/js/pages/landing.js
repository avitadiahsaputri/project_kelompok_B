if ("undefined" == typeof (jQuery)) {
	alert("Zero Cool Need jQuery");
	console.error("Zero Cool Need jQuery");
}
$(function () {
	$("#toggle-button").click(function () {
		$(".collapse").slideToggle(200, function () {
			$(this).toggleClass("in");
		})
	});


	$("a[rel='page-scroll']").click(function (e) {
		var $anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: ($($anchor.attr("href")).offset().top) - $(".navbar").height() - 30
		}, 800);
		e.preventDefault();
	});
})


$.zeroModal = function (show, option) {
	var selector = $(".zero-modal");
	var bg = option.bg || null;
	var title = option.title || 'Zero Modal'

	selector.css({ "background-image": "url('" + bg + "')" });
	selector.find(".title").text(title);

	if (show == 'show') {
		selector.show('normal');
	}
	if (show == 'close') {
		selector.hide('normal');
	}

	$(".close-modal").click(function () {
		selector.hide('normal');
	});
}
$(window).scroll(function () {
	var opacity = ($(".cover").height() - $(this).scrollTop()) / 100;
	if (opacity < 0) {
		opacity = 0;
	}
	if (opacity <= 1) {
		$(".navbar-default").addClass("hide-cover");
		$(".nav").addClass("collapse-cover");
	}
	else {
		$(".navbar-default").removeClass("hide-cover");
	}
	$(".cover").css({ opacity: opacity })
});

$.fn.zeroAnimate = function (classElement) {
	var element = $(this);
	var $scroll = $(this).offset().top;
	element.addClass("fadeout");

	$(window).scroll(function () {
		if ($(this).scrollTop() >= $scroll - 600) {
			element.removeClass("fadeout");
			element.addClass(classElement);
		}
		else {
			element.removeClass(classElement);
			element.addClass("fadeout");
		}
	});
}


var pos;
$(window).bind('scroll', function (event) {
	clearInterval(timeout);
	var timeout = setTimeout(function () {
		pos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
		activateNav(pos);
	}, 50);
}).trigger('scroll');


function activateNav(pos) {
	var offset = 300;
	$(".content").each(function (doc) {
		var contentPos = eval($(this).offset().top) - 100;
		if (contentPos <= pos + offset) {
			var id = $(this).attr("id");
			$("a[rel='page-scroll']").removeClass("active");
			$("a[rel='page-scroll'][href='#" + id + "']").addClass("active");
		}
	})
}


$(function () {
	$(".gallery-link").click(function (e) {
		var img = $(this).find("img").attr("src");
		var title = $(this).find(".caption-content").text();

		$.zeroModal('show', { bg: img, title: title });
		e.preventDefault();
	})
})
