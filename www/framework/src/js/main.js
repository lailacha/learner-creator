$(document).ready(function () {
    const body = $('body');
    const sidebar = $('nav');
    const toggle = $('.toggle');
    const searchBtn = $('.search-box');
    const modeSwitch = $('.toggle-switch');
    const modeText = $('.mode-text');
    var ctx = document.getElementById('myChart').getContext("2d");

    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#2F7DC0');

    var gradientFill = ctx.createLinearGradient(300, 0, 300, 200);
    gradientFill.addColorStop(0.6, "rgba(47, 118, 192, 0.8)");
    gradientFill.addColorStop(1, "rgba(59, 205, 179, 0.4)");

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Data",
                borderColor: gradientStroke,
                pointBorderColor: gradientStroke,
                pointBackgroundColor: gradientStroke,
                pointHoverBackgroundColor: gradientStroke,
                pointHoverBorderColor: gradientStroke,
                pointBorderWidth: 10,
                pointHoverRadius: 10,
                pointHoverBorderWidth: 1,
                pointRadius: 3,
                fill: true,
                backgroundColor: gradientFill,
                borderWidth: 4,
                data: [3.3, 2.3, 1.9, 1.8, 1.9, 2.4, 2.7, 2.9, 3, 2.9, 2.7, 2.5],
            }]
        },
        options: {
            animation: {
                easing: "easeInOutBack"
            },
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem) {
                        return tooltipItem.yLabel;
                    }
                }

            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold",
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        padding: 20
                    },
                    gridLines: {
                        drawTicks: false,
                        display: false
                    }

                }],
                xAxes: [{
                    gridLines: {
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        padding: 20,

                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold"
                    }
                }]
            }
        }
    });





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





