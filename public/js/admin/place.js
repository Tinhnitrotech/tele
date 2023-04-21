//Switch in place list
var elems = document.querySelectorAll('.js-switch');

if (elems) {
    for (var i = 0; i < elems.length; i++) {
        var switchery = new Switchery(elems[i],{size:'small'});
    }
}

