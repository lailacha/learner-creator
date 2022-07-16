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

    const inputSubmit = $("#formRegister > input[type=submit]");
    const checkbox = $('#checkPassword');
    const inputModifyPassword = $('.modifyPassword');
    const labels = inputModifyPassword.prev();
    const inputPassword = $('#passwordEditProfile');
    const span = "<span class='' id='span'></span>"

    inputModifyPassword.hide();
    labels.hide();

    $(inputSubmit).prop('disabled', true);
    $(span).insertAfter(inputPassword);




    inputPassword.on('keyup', function () {
        const span = $('#span');
        let password = inputPassword.val();
        if (password.length > 0) {
            $.ajax({
                method: "POST",
                url: "/verifyPassword",
                data: { password: password}
            })
                .done(function( data) {
                    if (data === "1"){
                        if ($('.spanSuccess').length === 0) {
                            span.removeClass('spanError')
                                .addClass('spanSuccess')
                                .css('color', 'green')
                                .text('Password correct');

                            $(inputSubmit).prop('disabled', false);

                        }

                    }
                    else if (data === "0"){
                        if ($('.spanError').length === 0) {
                            span.removeClass('spanSuccess')
                                .addClass('spanError')
                                .css('color', 'red')
                                .text('Password incorrect');


                            $(inputSubmit).prop('disabled', true);

                        }


                    }

                });
        }
    })



    $(inputSubmit).click(function (e) {

        if(checkbox.is(':checked') && inputModifyPassword[0].value === inputModifyPassword[1].value){
            if(inputModifyPassword[1].value.match( /[0-9]/g) &&
                inputModifyPassword[1].value.match( /[A-Z]/g) &&
                inputModifyPassword[1].value.match(/[a-z]/g) &&
                inputModifyPassword[1].value.length >= 8){

            }
            else{
                e.preventDefault()
                alert("Votre mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre");
            }
        }
        else if (checkbox.is(':checked')){
            e.preventDefault()
            alert("Veuillez vérifier votre mot de passe ");
        }

    })





    checkbox.click(function () {
        if (checkbox.is(':checked')) {


            inputModifyPassword.css('display', 'block');

        } else {
            $(inputSubmit).prop('disabled', false);

            labels.hide();
            inputModifyPassword.css('display', 'none');
        }
    });


    $(".search-bar input").on("keyup", function(e) {
        if($(this).val() == ""){
            $(".search-results").html("");
            return;                  
        }
        $.ajax({
            url: "/search/course?course=" + $(this).val(),
            success: function(data) {

                let html = "";
                if(data.length > 0){
                    data = JSON.parse(data);
                data.forEach(function(element) {
                    html += "<div class='course-thumbnail col-md-3'>";
                    html += "<img className='cover' src="+ element.path +" />";
                    html += "<a href='/show/course?id="+element.id+ "'>" + element.name + "</a>";
                    html += "<p>" + element.description + "</p>";
                    html += "</div>";
                });
            }

                $(".search-results").html(html);
            }
    });
    });



    $('.dataTable').DataTable();

    const dialog = document.querySelector('.modal');
    if( document.getElementById('show'))
    {
        document.getElementById('show').addEventListener('click', function () {
            dialog.showModal();
            body.style.filter = "blur(5px)";

        });
    }
    if( document.getElementById('hide'))
    {
        document.getElementById('hide').addEventListener('click', function () {
            dialog.close();
        });
    }

    tinymce.init({
        selector: 'textarea.editable',
        plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
        toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
    });

    tinymce.init({
        selector: 'textarea.comment',
        width: '70%',
        plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
        toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
    });

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





