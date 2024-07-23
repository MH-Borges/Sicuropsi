$(document).ready(function () {
    $('.RecuperarSenha').click(function (event) {
        event.preventDefault();
        $.ajax({
            url: "configs/recuperar.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                handleResponse(msg.trim());
            }
        });
    });

    function handleResponse(msg) {
        $('.CloseBtn').click();
        if (msg === 'Link para a recuperação de senha enviado para o e-mail informado!') {
            mostrarMensagem(msg, '#8000FF', 2000, window.location.reload);
        } else if (msg === 'Preencha o campo de recuperação de e-mail!' || msg === 'Este e-mail não está cadastrado!') {
            mostrarMensagem(msg, '#F83810', 4000);
        } else {
            mostrarMensagem('Erro ao Enviar o Formulário! Possíveis falhas ao se conectar ao servidor de hospedagem.', '#F83810', 6000);
        }
    }

    function mostrarMensagem(texto, cor, tempo, callback) {
        var mensagemLogin = $('.mensagemLogin');

        mensagemLogin.css({ 'bottom': '2vh', 'background': cor }).text(texto).delay(tempo).animate({ 'bottom': '-12vw' }, 1000, function () {
            mensagemLogin.text('').css('background', 'none');
            if (typeof callback === 'function') callback();
        });
    }
});

//FUNÇÃO DE VISUALIZAR SENHA
function setupPasswordToggle(inputId, toggleId) {
    var passwordInput = document.getElementById(inputId);
    var passwordToggle = document.getElementById(toggleId);

    if (passwordInput != null && passwordToggle != null) {
        function passwordToggleHandler() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            }
        }
    }
    passwordToggleHandler();
}

//VERICAÇÃO QUANTIDADE DE CARACTERES INPUT
function verificaTamanhoInput(inputId, displayClass, maxLen) {
    var inputElement = document.getElementById(inputId);
    var displayElement = document.querySelector('.' + displayClass);

    if (inputElement !== null && displayElement !== null) {
        var tamInput = inputElement.value.length;

        if (tamInput < maxLen - 15) {
            displayElement.innerHTML = '';
            displayElement.classList.remove('text-warning', 'text-danger');
        } else if (tamInput < maxLen - 5) {
            displayElement.innerHTML = (maxLen - tamInput) + '/' + maxLen;
            displayElement.classList.remove('text-danger');
            displayElement.classList.add('text-warning');
        } else {
            displayElement.innerHTML = (maxLen - tamInput) + '/' + maxLen;
            displayElement.classList.remove('text-warning');
            displayElement.classList.add('text-danger');
        }
    }
}

setInterval(
    function () {
        verificaTamanhoInput('emailRecuperaSenha', 'EmailResetSenhaInput', 50);
        verificaTamanhoInput('novaSenhaUser', 'ResetSenhaInput', 25);
        verificaTamanhoInput('repetNovaSenhaUser', 'repetResetSenhaInput', 25);
}, 50);

//VERICAÇÃO DE EXCLUSÃO DE MSG
function limpaMsg(elementClass) {
    var elements = document.querySelectorAll('.' + elementClass);

    elements.forEach(function (element) {
        element.style.bottom = '-12vw';

        setTimeout(function () {
            element.textContent = '';
            element.style.background = 'none';
            element.remove();
        }, 1000);
    });
}

setInterval(function () {
    limpaMsg('msgRecupSenha');
    limpaMsg('msgErro');
}, 4000);