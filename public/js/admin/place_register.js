const wrapper = document.getElementById("auto_next");
const el = wrapper.querySelectorAll(".form-control");
const inputLength = el.length;

Array.prototype.forEach.call(el, function(e, index){
    e.addEventListener("keyup", function(e){
        const maxlength = e.target.getAttribute("maxlength");
        const length = e.target.value.length;
        if (maxlength == length && index < (inputLength-1)) {
            el[index + 1].focus();
        }
    });
});

