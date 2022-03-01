$(document).ready(function(){


    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".sidebar");
    const container = document.querySelector(".main-container");

    hamburger.addEventListener("click", function(){
        hamburger.classList.toggle("active");
        navMenu.classList.toggle("active");
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


    var canvas = document.getElementById("chart-courses");
    var ctx = canvas.getContext('2d');


    let dataCourses = {
        labels: ["Mathematics", "English", "Geography"],

        datasets: [
            {
                fill: true,
                backgroundColor: [
                    '#E5DAFB',
                    '#5E3FBE'],
                data: [30, 20, 30],

                borderWidth: [2, 2]
            }
        ]
    };

    var options = {
        legend: {
            position: 'bottom',
            maxWidth: 3000
        },

        rotation: -0.7 * Math.PI
    };

    var CourseCategorieChart = new Chart(ctx, {
        type: 'pie',
        data: dataCourses,
        options: options,
        plugins: [{
            beforeInit: function (CourseCategorieChart, options) {
                CourseCategorieChart.legend.afterFit = function () {
                    this.padding = this.padding + 20;
                };
            }
        }]
    });


    const labels = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
    ];

    const userChart = new Chart(
        document.getElementById('chart-users'),
        {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'users',
                    backgroundColor: 'rgb(113, 126, 158)',
                    data: [0, 10, 5, 2, 20, 30, 45],
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display:false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display:false
                        }
                    }]
                },
                responsive: true,
                legend: {
                    position: 'bottom'
                },
                maintainAspectRatio: false
            },

        }
    );

    const vistCharts = new Chart(
        document.getElementById('chart-visits'),
        {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'visits',
                    backgroundColor: 'rgb(132, 89, 128)',
                    data: [0, 10, 5, 2, 20, 30, 45],
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display:false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display:false
                        }
                    }]
                },
                responsive: true,
                legend: {
                    position: 'bottom'
                },
                maintainAspectRatio: false
            },

        }
    );


    // S'il existe des éléments avec la classe .slider
    if($('.slider').length){
        $('.slider').each(function(index){
            sliderInit($(this));
        })
    }

    var premierSlider = $('.slider')[0];
    //Ajouter un autoplay au premier slider
    var interval = setInterval(function() {
        next($(premierSlider))
    }, 2000)

    interval();
})


function disableNav(slider){
    slider.find("nav button").attr("disabled", "false");
}

function enableNav(slider){
    slider.find("nav button").removeAttr("disabled");
}

function sliderInit(element){

    let container = $('<div></div>');
    container.addClass('slides-container');
    container.html(element.html());

    let totalSlides = container.children('img').length;

    element.html(container);
    container.find('img').addClass('slide');

    let nav = $('<nav/>')
        .append('<button class="prev"></button>')
        .append('<button class="next">s</button>');

    element.append(nav);

    element.attr('data-currentSlide', 0);

    element.find('.prev').click(function(){
        prev(element);
    })

    element.find('.next').click(function(){
        next(element);
    })
}


function next(slider){
    let attrValue = Number(slider.attr('data-currentSlide'));

    slider.attr('data-currentSlide', attrValue + 1);
    slide(slider)
}

function prev(slider){
    let attrValue = Number(slider.attr('data-currentSlide'));
    slider.attr('data-currentSlide', attrValue - 1);
    slide(slider)
}

function slide(slider){
    let attrValue = Number(slider.attr('data-currentSlide'));
    let leftValue = attrValue * -100;

    let container = slider.children('.slides-container');

    // Desactiver la nav
    disableNav(slider);

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

    // Si on dépasse la première image :
    //	- cloner la dernière image et mettre le clone à la fin du container
    // 	- ecouter la fin de la transition css :
    //		- enlever la transition du container
    //		- 'rembobiner' le container vers la première image
    //		- supprimer le clone
    //		- remettre la transition sur le container


    if(attrValue == -1){
        let clone = container.children("img:last-child").clone();
        clone.css({
            position: "absolute",
            left: 0,
            top: 0,
            transform: "translateX(-100%)"
        });
        container.prepend(clone);
    }

    container.css('left', leftValue + '%');

    //Ecouter la fin de la transion pour rétablir la nav



}
















