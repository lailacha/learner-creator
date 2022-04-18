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

$(document).ready(function () {


    function close_all_dropdowns() {
        $(".sidebar i").css("transform", "rotate(0deg)" );

        let dropdowns = document.getElementsByClassName('dropdown-items')
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = 'none';
        }
    }

    //sidebar items listener
    $(".item").click(function () {
        close_all_dropdowns();

        if ($(this).parent().children("ul").length > 0) {
            $(this).parent().children("ul").css("display", "block");
        }

        const elems = document.querySelectorAll(".isActive");
        [].forEach.call(elems, function (el) {
            el.classList.remove("isActive");


        });
        $(this).addClass("isActive");
        $(".isActive i").css("transform", "rotate(180deg)" );


    });


    const body = $('body');
    const sidebar = $('nav');
    const toggle = $('.toggle');
    const searchBtn = $('.search-box');
    const modeSwitch = $('.toggle-switch');
    const modeText = $('.mode-text');




    toggle.click(function () {
        sidebar.toggleClass("close");
    });

    searchBtn.click(function () {
        sidebar.removeClass("close");
    })

    modeSwitch.click(function () {
        body.toggleClass("dark");

        if (body.hasClass("dark")) {
            modeText.html("Light mode");
        } else {
            modeText.html("Dark mode");
        }
    });

    if($('.slider').length){
        $('.slider').each(function(index){
            sliderInit($(this));
        })
    }
})

function sliderInit(element){
    let prevButton = $('.prev');
    let nextButton = $('.next');

    prevButton.click(function(){
        prev(element);
    })

    nextButton.click(function(){
        next(element);
    })


    let container = $('<div></div>');
    container.addClass('slides-container');
    container.html(element.html());

    element.html(container);
    container.find('img').addClass('slide');


    element.attr('data-currentSlide', 0);


}


function next(slider){
    let attrValue = Number(slider.attr('data-currentSlide'));
    slider.attr('data-currentSlide', attrValue + 1);
    slide(slider)
}

function prev(slider){
    let attrValue = Number(slider.attr('data-currentSlide'));
    if (attrValue > 0){
        slider.attr('data-currentSlide', attrValue - 1);
        slide(slider)
    }

}

function slide(slider){
    let attrValue = Number(slider.attr('data-currentSlide'));
    let leftValue = attrValue * -100;
    let container = slider.children('.slides-container');

    // Si on dépasse la dernière image :
    //	- cloner la premiere image et mettre le clone à la fin du container
    // 	- ecouter la fin de la transition css :
    //		- enlever la transition du container
    //		- 'rembobiner' le container vers la première image
    //		- supprimer le clone
    //		- remettre la transition sur le container

    if(attrValue == container.children('img').length){
        let clone = container.children('img:first-child').clone();
        container.append(clone);

        container.on('transitionend', function(){
            container.off('transitionend');
            container.css('transition', 'none');
            container.css('left', 0);
            slider.attr('data-currentSlide', 0);
            container.children('img:last-child').remove();
            setTimeout(function(){
                container.css('transition', 'left 1s');
            }, 20);

        })
    }

    container.css('left', leftValue/3 + '%');
}





