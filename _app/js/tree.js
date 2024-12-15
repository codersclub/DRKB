function tree_open_all() {
	$('.tree ul').toggleClass('all_off');
}

$(document).ready(function () {
	
	var url = window.parent.location.pathname;
	var selector = 'a[href="'+url+'"]';
	
	$(selector).addClass('current').focus();
	
	var i = 6; // Max depth level
	
	while(url !== '/' && i) {
		
		var elem = document.getElementById(url);
		
		if(elem) {
			elem.checked = true;
		}
		
		url = url.replace(/\/$/, '').replace(/\/[^\/]*$/, '/');
		
		i--;
	}
	
});



// Add a Tree Expand/Collapse Handler
var index = 1;

var len = $('.tree li:has(ul)').length - 1;
$.each($('.tree li:has(ul)'), function(itr) {
	var tpl = `<input id="tree_${index}" type="checkbox">
	<label for="tree_${index}"></label>`;
	index++;
	$(this).prepend(tpl);
	if(itr == len){
		currentNav();
		expandToCurrent();
	}
});

// Nav tree
// TODO: Ajax tree?
function currentNav(){
	var currentURL = window.location.href;
	currentURL = currentURL.slice(currentURL.indexOf('/', currentURL.indexOf('//') + 2)); //ToDo: simplify
	if(currentURL.includes('?')){
		currentURL = currentURL.slice(0, currentURL.indexOf('?'))
	}
	$('.tree a').each(function(){
		if($(this).attr('href') == currentURL){
			$(this).addClass('current');
		}
	});
	// var elements = document.querySelectorAll('.tree li a');
	//     Array.from(elements).forEach(function(element) {
	//       if(element.getAttribute('href') == currentURL){
	//         element.classList.add('current');
	//       }
	//     });
}

function expandToCurrent(){
	$('.tree .current').parents('li').children('input[type=checkbox]').prop('checked', true);
}
