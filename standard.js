﻿function toggle_visibility(id) {
	var e = document.getElementById(id);
	if(e.style.display == 'block')
		e.style.display = 'none';
	else
		e.style.display = 'block';
}
function resetForm(form) {
    // clearing inputs
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i<inputs.length; i++) {
        switch (inputs[i].type) {
            case 'hidden':
            case 'text':
                inputs[i].value = '';
                break;
            case 'radio':
            case 'checkbox':
                inputs[i].checked = false;   
        }
    }
    
    // clearing selects
    var selects = form.getElementsByTagName('select');
    for (var i = 0; i<selects.length; i++)
        selects[i].selectedIndex = 0;
    
    // clearing textarea
    var text= form.getElementsByTagName('textarea');
    for (var i = 0; i<text.length; i++)
        text[i].innerHTML= '';
    
    return false;
}
var myForm = document.getElementById('avgrens');

myForm.addEventListener('submit', function () {
    var allInputs = myForm.getElementsByTagName('input');

    for (var i = 0; i < allInputs.length; i++) {
        var input = allInputs[i];

        if (input.name && !input.value) {
            input.name = '';
        }
    }
});

// Create cookie for autorefresh
function createAutoRefreshCookie(name,value,days,domain) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else {
		var expires = "";
	}
    document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
	window.location.reload();
}