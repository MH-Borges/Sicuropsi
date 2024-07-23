//UPLOAD DE IMAGENS
function carregarImagem(inputId, targetId, defaultImagePath, imgContainerClass) {
    var target = document.getElementById(targetId);
    var fileInput = document.querySelector("#" + inputId);
    var file = fileInput.files[0];
    var reader = new FileReader();

    reader.onloadend = function () { target.src = reader.result; };

    if (file) {
        reader.readAsDataURL(file);
        document.querySelector('.' + imgContainerClass).classList.add('imgSelected');
    } else {
        target.src = defaultImagePath;
        document.querySelector('.' + imgContainerClass).classList.remove('imgSelected');
    }
}

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

        if (tamInput < maxLen - 20) {
            displayElement.innerHTML = '';
            displayElement.classList.remove('text-warning', 'text-danger');
        } else if (tamInput < maxLen - 10) {
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
        verificaTamanhoInput('nomeCompEdit', 'NomeCompEditInput', 75);
        verificaTamanhoInput('antigoEmail', 'emailAntigoEditInput', 50);
        verificaTamanhoInput('novoEmail', 'novoEmailEditInput', 50);
        verificaTamanhoInput('confirmaNovoEmail', 'ConfirmaNovoEmailEditInput', 50);
        verificaTamanhoInput('antigaSenha', 'SenhaAntigaEditInput', 25);
        verificaTamanhoInput('novaSenha', 'NovaSenhaEditInput', 25);
        verificaTamanhoInput('confirmaNovaSenha', 'ConfirmaNovaSenhaEditInput', 25);
}, 50);

//FUNÇÃO DE SELETORES CUSTOMIZADOS
function OptionSelection(selectedValueId, optionsButtonId, optionInputsClass) {
    let selectedValue = document.getElementById(selectedValueId),
        optionsViewButton = document.getElementById(optionsButtonId),
        inputsOptions = document.querySelectorAll('.' + optionInputsClass + ' input');

    inputsOptions.forEach(input => { 
        input.addEventListener('click', event => {
            selectedValue.textContent = input.dataset.label;
            optionsViewButton.click();
        });
    });
}

// UPLOAD INFOS
$(document).ready(function () {
    $('#telefoneContatoEdit').mask('(00) 00000 - 0000');

    $('#themeSwitch').click(function (e) {
        $("body").toggleClass("light-theme");
        e.preventDefault();
        $.ajax({
            url: "../Adm/Main_menus/theme.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Sucesso!!") {
                    $('#msgErro_themeSwitch').addClass('text-success');
                    setTimeout(() => { location.reload(); }, 500);
                }
                else{
                    $('#msgErro_themeSwitch').removeClass('text-success');
                    $('#msgErro_themeSwitch').removeClass('text-warning');
                    $('#msgErro_themeSwitch').addClass('text-danger');
                    $('#msgErro_themeSwitch').text(msg)
                }
            }
        })
    });
    
    $('#formEditUser').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"../Adm/Main_menus/EditCadastro.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').addClass('text-warning');
                $('#msgErro_EditUser').text('carregando..');
                if(msg.trim() === 'Cadastro alterado com Sucesso!!'){
                    $('#msgErro_EditUser').removeClass('text-danger');
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-success');
                    $('#msgErro_EditUser').text(msg);
                    setTimeout(() => { location.reload(); }, 4000);
                }
                else{
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-danger');
                    $('#msgErro_EditUser').text(msg);
                }
            }
        })
    });

    $('#formEditEmailUser').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"../Adm/Main_menus/EditEmail.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').addClass('text-warning');
                $('#msgErro_EditUser').text('carregando..');
                if(msg.trim() === 'E-mail alterado com Sucesso!'){
                    $('#msgErro_EditUser').removeClass('text-danger');
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-success');
                    $('#msgErro_EditUser').text(msg);
                    setTimeout(() => { 
                        $('#msgErro_EditUser').text('Necessario relogar para alteração completa do email');
                        setTimeout(() => { window.location='../../configs/logout.php'; }, 5000);
                    }, 2000);
                }
                else{
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-danger');
                    $('#msgErro_EditUser').text(msg);
                }
            }
        })
    });

    $('#formEditSenhaUser').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"../Adm/Main_menus/EditSenha.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').addClass('text-warning');
                $('#msgErro_EditUser').text('carregando..');
                if(msg.trim() === 'Senha alterada com Sucesso!'){
                    $('#msgErro_EditUser').removeClass('text-danger');
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-success');
                    $('#msgErro_EditUser').text(msg);
                    setTimeout(() => { location.reload(); }, 5000);
                }
                else{
                    $('#msgErro_EditUser').removeClass('text-warning');
                    $('#msgErro_EditUser').addClass('text-danger');
                    $('#msgErro_EditUser').text(msg);
                }
            }
        });
    });
});