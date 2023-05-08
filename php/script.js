function submitCycle() {
    let form = document.getElementById("formCycle");
    form.submit();
}
function togglePassword() {
    let x = document.getElementById("password1");
    let y = document.getElementById("showPassword1");
    let i = document.getElementById("password2");
    let j = document.getElementById("showPassword2");
    let k = document.getElementById("password3");
    let l = document.getElementById("showPassword3");
    let m = document.getElementById("password5");
    let n = document.getElementById("showPassword5");
    if(n.checked) {
        m.type = "text";
    } else {
        m.type = "password";
    }
    if (y.checked) {
        x.type = "text";
    } else {
        x.type = "password";
    }
    if (j.checked) {
        i.type = "text";
    }
    else {
        i.type = "password";
    }
    if (l.checked) {
        k.type = "text";
    }
    else {
        k.type = "password";
    }
}

function togglePassword2() {
    let x = document.getElementById("password2");
    let y = document.getElementById("showPassword2");
    if (y.checked) {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

let slidePosition = 0;

function isNotMultiple(a, b){
    if(b==0){
        return false;
    }
    if(a % b == 0){
        return false;
    }else{
        return true;
    }
}


function previous(){
    let currentWidth = document.querySelector('.slider_content').scrollLeft;
    const widthSlider = document.querySelector('.slider_content').offsetWidth;
    const slider_content = document.querySelector('.slider_content');
    console.log(widthSlider);
    console.log(currentWidth);

    if(isNotMultiple(widthSlider, currentWidth)){
        let rest = currentWidth % widthSlider;
        slider_content.scrollLeft -= rest;
        console.log("bug");
    }else{
        slider_content.scrollLeft -= widthSlider;
    }

    slider_content.scrollLeft -= widthSlider;
    if(slidePosition == 2){
        document.querySelector('.slider__nav__button--next').style.display = "block";
        slidePosition--;
    }
    else if(slidePosition == 1){
        document.querySelector('.slider__nav__button--prev').style.display = "none";
        slidePosition--;
    }

}

function next(){
    let currentWidth = document.querySelector('.slider_content').scrollLeft;
    const widthSlider = document.querySelector('.slider_content').offsetWidth;
    const slider_content = document.querySelector('.slider_content');
    console.log(widthSlider);
    console.log(currentWidth);

    if(isNotMultiple(widthSlider, currentWidth)){
        let rest = currentWidth % widthSlider;
        slider_content.scrollLeft += rest;
        console.log("bug");
    }else{
        slider_content.scrollLeft += widthSlider;
    }

    
    slider_content.scrollLeft += widthSlider;
    if(slidePosition == 0){
        document.querySelector('.slider__nav__button--prev').style.display = "block";
        slidePosition++;
    }
    else if(slidePosition == 1){
        document.querySelector('.slider__nav__button--next').style.display = "none";
        slidePosition++;
    }
}

setTimeout(function() {
    let erreurParagraphe = document.querySelector('#erreurParagraphe');
        console.log(erreurParagraphe);
        erreurParagraphe.style.display = "none";
}, 5000);

setTimeout(function() {
    let cours = document.getElementById('cours');
    cours.style.display = "none";
}, 5000);
