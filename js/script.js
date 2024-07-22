document.addEventListener( 'DOMContentLoaded', function() {
    var elms = document.getElementsByClassName( 'splide' );
    for ( var i = 0; i < elms.length; i++ ) {
        if(i == 0){
            new Splide( elms[i], {
                type    : 'loop',
                autoplay: true,
                perPage: 1,
            }).mount();
        }
        else{
            new Splide( elms[i], {
                type   : 'loop',
                perPage: 6,
                drag   : 'free',
                perMove: 1,
                arrowPath: 'M28.6236 16.8294C31.0942 18.6647 31.0942 22.3353 28.6236 24.1706L7.88833 39.574C4.83451 41.8426 0.476562 39.6843 0.476562 35.9034L0.476564 5.09658C0.476564 1.31565 4.83451 -0.842576 7.88833 1.42598L28.6236 16.8294Z',
            }).mount();
        }
    }
});

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