document.querySelector(".navbar-toggler-icon").addEventListener("click", animateBars);
    var line1 = document.querySelector(".line1-menu");
    var line2 = document.querySelector(".line2-menu");
    var line3 = document.querySelector(".line3-menu");
    var container = document.querySelector(".navbar-brand");

 function animateBars(){
    line1.classList.toggle("activeline1_bars-menu");
    line2.classList.toggle("activeline2_bars-menu");
    line3.classList.toggle("activeline3_bars-menu");
    
    container.classList.toggle("menu_active");
 }