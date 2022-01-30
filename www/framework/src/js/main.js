$(document).ready(function(){
    function sliderInit(element){
        let container = $("<div/>");
       container.append("<nav><button>Prec</button> </nav>");
        container.addClass("slides-container");
        container.html(element.html());
        element.html(container);
        element.find("img").addClass("slide")

    }
    if($('.slider').length > 0){
        $(".slider").each(function(){
sliderInit($(this));
        });
    }
})