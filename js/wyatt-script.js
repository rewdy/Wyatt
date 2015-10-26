// Javascript
jQuery(function(){
	setupUi();
	watchComments();
});

// set up ui
function setupUi() {
	// menu link
	jQuery('a#menu-link').click(function(){
		jQuery(this).siblings('ul').add(this).toggleClass('open');
		return false;
	});

	// youTube video wrappers
	jQuery('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').not('.ignore').wrap('<span class="video-wrapper"></span>');

	if ('ontouchstart' in document.documentElement) {
		jQuery('body').addClass('touch-enabled');
	}

	// set up the gallery lightbox
	setupLightbox();

	// sharing links
	setupSharing();
}

// start watching the comment form for html in the comment
function watchComments() {
	jQuery('textarea#comment').each(function(){
		var htmlNotice = jQuery('.some-html-allowed');
		var htmlNoticeVisible = false;
		var timer = false;
		jQuery(this).focus(function(){
			$commentbox = jQuery(this);
			timer = setInterval(function(){
				var commentContent = $commentbox.val();
				if (htmlNoticeVisible) {
					if (commentContent.indexOf('<') < 0) {
						htmlNotice.slideUp();
						htmlNoticeVisible = false;
					}
				} else if (commentContent.indexOf('<') >= 0) {
					htmlNotice.slideDown();
					htmlNoticeVisible = true;
				}
			},500);
		}).blur(function(){
			clearInterval(timer);
		});
	});
}

// Sets up the lightbox
function setupLightbox() {
	jQuery('.gallery').each(function(index){
		var $gal = jQuery(this);
		var galId = $gal.attr('id');
		var $galleryLinks = $gal.find('.gallery-icon a').filter("[href$='.jpg'], [href$='.gif'], [href$='.png']");
		$galleryLinks.each(function(){
			if (jQuery(this).attr('title')!='') {
				$link = jQuery(this);
				var title = $link.find('img').attr('alt');
				$link.attr('title', title);
			}
		});
		$galleryLinks.attr('data-lightbox-gallery', galId);
		$galleryLinks.nivoLightbox({effect: 'fadeScale'});
	});
}

// Sets up the sharing links
function setupSharing() {
	$sharingLinks = jQuery('.sharing-list a:not(.pinterest):not(.email)');
	$sharingLinks.click(function(e){
		href = this.getAttribute('href');
		openWindow(href, 'Share');
		e.preventDefault();
	});
	var $pinterestLink = jQuery('.sharing-list a.pinterest');
	$pinterestLink.click(function(e){
		faLoadingIndicator(jQuery(this), 'fa-pinterest', 2000); // show loading indicator
		pinterestPinIt(); // fire of pinterest function
		e.preventDefault(); // stop default
	});
}

// function to open urls in a new window (used by sharing)
function openWindow(url, title) {
	var winWidth = 700;
	var winHeight = 450;
	var left = (screen.width/2)-(winWidth/2);
	var top = (screen.height/2)-(winHeight/2);
	window.open(
		url, // url
		title, // window name
		'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, height='+winHeight+', width='+winWidth+', left='+left+', top='+top
	);
}

// pinterest action
function pinterestPinIt() {
	var e = document.createElement('script');
	e.setAttribute('type','text/javascript');
	e.setAttribute('charset','UTF-8');
	e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);
	document.body.appendChild(e);
}

// show font awesome loading indicator
function faLoadingIndicator($el, iconClass, duration) {
	$icon = $el.find('.fa');
	$icon.removeClass(iconClass);
	$icon.addClass('fa-spinner').addClass('fa-spin');
	setTimeout(function(){
		$icon.removeClass('fa-spinner').removeClass('fa-spin');
		$icon.addClass(iconClass);
	}, duration);
}

// end