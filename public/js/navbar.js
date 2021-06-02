// variable
const element = document.getElementById("header-side");
const linkProfile = "'#'";
var current_rotation = 0;

// media query
var active = false;
var x = window.matchMedia("(max-width: 658px)");
x.addEventListener( "change", (e) => {
    if (active && e.matches) {
    element.style.width = "100%";
    element.style.borderRadius = "0";
    element.style.position = "absolute";
    element.style.zIndex = "2";
    document.getElementById("container").style.marginLeft = ("75px");
  } else if (active) {
    element.style.borderRadius = "0 5px 5px 0";
    element.style.width = '275px';
    setTimeout(function(){ element.style.position = "unset"; }, 450);
    setTimeout(function(){ document.getElementById("container").style.marginLeft = ("0"); }, 450);
  }
})

// rotate button navabr
document.querySelector(".rotate").addEventListener('click', function(){
    current_rotation += 180;
    document.querySelector(".rotate").style.transform = 'rotate(' + current_rotation + 'deg)';
});

// function
function navbarDeactive() {
    active = false;
    const element = document.getElementsByClassName("js-item");

    // navbar head
    (function() {
        element[0].getElementsByTagName("img")[0].style.display = "none";
        element[0].getElementsByTagName("button")[0].setAttribute("onclick","navbarActive()");
        element[0].id = "j-center";
    })();

    // navbar link
    (function() {
        const elementText = element[1].getElementsByTagName("span");
        const elementContainer = element[1].getElementsByTagName("a");
        for ( i=0; i < elementText.length; i++) {
            elementText[i].style.display = "none";
            elementContainer[i].id = "j-center";
        }
    })();

    // navbar profile
    (function() {
        element[2].getElementsByTagName("div")[0].style.display = "none";
        element[2].id = "j-center";
    })();

    document.getElementById("header-side").style.width = "75px";
}

function navbarActive() {
    active = true;
    const element = document.getElementsByClassName("js-item");

    // navbar head
    (function() {
        element[0].getElementsByTagName("img")[0].style.display = "block";
        element[0].getElementsByTagName("button")[0].setAttribute("onclick","navbarDeactive()");
        element[0].id = "";
    })();

    // navbar link
    (function() {
        const elementText = element[1].getElementsByTagName("span");
        const elementContainer = element[1].getElementsByTagName("a");
        for ( i=0; i < elementText.length; i++) {
            elementText[i].style.display = "block";
            elementContainer[i].id = "";
        }
    })();

    // navbar profile
    (function() {
        const lengthName = element[2].getElementsByTagName("h5")[0];
        lengthName.innerHTML = (lengthName.innerHTML.length >= 16) ? (lengthName.innerHTML.substring(0,16) + "...") : lengthName.innerHTML;
        element[2].getElementsByTagName("div")[0].style.display = "block";
        element[2].id = "";
    })();

    document.getElementById("header-side").style.width = "275px";
}
