document.addEventListener( 'DOMContentLoaded', function() {
    document.getElementById("data_footer").textContent = new Date().getFullYear();
    if(window.pageYOffset > 150){ document.querySelector(".menu").classList.add('color'); }

    //animation home
    document.querySelector('header').style.opacity = 1;
    document.querySelector('header').style.translate = '0 125px';
    document.querySelector('.imgsBlock').style.opacity = 1;
    document.querySelector('.imgsBlock').style.translate = '35vw 0';
    document.querySelector('.infosBlock').style.opacity = 1;
    document.querySelector('.infosBlock').style.translate = '-55vw 0';

    // fade animation
    AOS.init();

    // galeria
    new Splide( '.splide', {
        type   : 'loop',
        perPage: 3,
        focus  : 'center',
        autoplay: true
    }).mount();
});

window.addEventListener('scroll', function() {
    //menu fixo
    if(window.pageYOffset > 150){ document.querySelector(".menu").classList.add('color'); }
    else{ document.querySelector(".menu").classList.remove('color'); }
});

//Scroll Menu
document.querySelectorAll('.links').forEach(item => { item.addEventListener('click', scrollToIdOnClick); });
function scrollToIdOnClick(event) {
    const targetElement = document.querySelector(event.currentTarget.getAttribute('href'));
    if (targetElement) {
        if(event.currentTarget.getAttribute('href') == '#home'){
            var targetOffset = targetElement.offsetTop;
        }else{
            var targetOffset = targetElement.offsetTop - 125;
        }
        smoothScrollTo(0, targetOffset);
    }
}
function smoothScrollTo(endX, endY, duration = 500) {
    const startX = window.scrollX || window.pageXOffset;
    const startY = window.scrollY || window.pageYOffset;
    const distanceX = endX - startX;
    const distanceY = endY - startY;
    const startTime = performance.now();
    const easeInOutQuart = (time, from, distance, duration) => {
        if ((time /= duration / 2) < 1) return distance / 2 * time * time * time * time + from;
        return -distance / 2 * ((time -= 2) * time * time * time - 2) + from;
    };
    function scroll() {
        const currentTime = performance.now();
        const elapsedTime = currentTime - startTime;
        if (elapsedTime >= duration) {
            window.scroll(endX, endY);
        } else {
            const newX = easeInOutQuart(elapsedTime, startX, distanceX, duration);
            const newY = easeInOutQuart(elapsedTime, startY, distanceY, duration);
            window.scroll(newX, newY);
            requestAnimationFrame(scroll);
        }
    }
    scroll();
}

//formulario
$(document).ready(function () {
    $('#telefone').mask('(00) 00000 - 0000');

    $('#btn_form').click(function (e) {
        $('#nome').prop('required',false);
        $('#email').prop('required',false);
        $('#telefone').prop('required',false);
        $('#mensagem').prop('required',false);
    });

    $('#formulario').submit(function (e) {
        e.preventDefault();
        $('#msg_form').text('');
        $('#msg_form').removeClass('text-danger');
        $('#msg_form').removeClass('text-success');
        $.ajax({
            url: "email.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === 'Mensagem enviada com sucesso! Entrarei em contato em breve!') {
                    $('#msg_form').addClass('text-success');
                    $('#msg_form').text(msg);
                    setTimeout(() => { window.location.reload(); }, 5000)
                }
                else if (msg.trim() == "Preencha o campo de 'Nome completo'" || msg.trim() == 'Preencha o campo de E-mail' || msg.trim() == 'O campo de mensagem está vazio!') {
                    $('#msg_form').addClass('text-danger');
                    $('#msg_form').text(msg);
                }
                else{
                    $('#msg_form').removeClass('text-success');
                    $('#msg_form').addClass('text-danger');
                    $('#msg_form').text('Erro ao enviar o formulario, provaveis problemas com o servidor, você pode tentar me mandar mensagem via Instagram ou Whatsapp');
                }
            }
        })
    });
});