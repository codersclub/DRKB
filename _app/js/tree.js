function tree_open_all() {
    var allLists = document.querySelectorAll('.tree ul');
    var checkboxes = [];
    
    for (var i = 0; i < allLists.length; i++) {
        var parentLi = allLists[i].parentElement;
        if (parentLi && parentLi.tagName === 'LI') {
            var checkbox = parentLi.querySelector('input[type="checkbox"]');
            if (checkbox && checkboxes.indexOf(checkbox) === -1) {
                checkboxes.push(checkbox);
            }
        }
    }
    
    var allChecked = checkboxes.length > 0;
    for (var i = 0; i < checkboxes.length; i++) {
        if (!checkboxes[i].checked) {
            allChecked = false;
            break;
        }
    }
    
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = !allChecked;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var currentURL = window.parent.location.pathname;
    var allLists = document.querySelectorAll('.tree ul');
    var checkboxIndex = 1;
    
    for (var i = 0; i < allLists.length; i++) {
        var parentLi = allLists[i].parentElement;
        if (parentLi && parentLi.tagName === 'LI' && !parentLi.querySelector('input[type="checkbox"]')) {
            var tpl = '<input id="tree_check_' + checkboxIndex + '" type="checkbox"><label for="tree_check_' + checkboxIndex + '"></label>';
            parentLi.insertAdjacentHTML('afterbegin', tpl);
            checkboxIndex++;
        }
    }
    
    var currentLink = document.querySelector('a[href="' + currentURL + '"]');
    
    if (currentLink) {
        currentLink.classList.add('current');
        
        var parent = currentLink.parentElement;
        while (parent) {
            if (parent.tagName === 'LI') {
                var checkbox = parent.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.checked = true;
            }
            parent = parent.parentElement;
        }
        
        setTimeout(function() {
            currentLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }
});
