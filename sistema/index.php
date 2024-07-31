<?php
@session_start();
@ob_start();
require_once("configs/conexao.php");

$chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
$Recup_True = false; 
if (!empty($chave)) {
    $res = $pdo->query("SELECT * FROM medicos WHERE senha_Recup = '$chave' LIMIT 1");
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    if(@count($dados) != 0){
        $Recup_True = true; 
    }
    else{
		echo "<script language='javascript'> window.alert('Erro: Link inválido, solicite novo link para atualizar a senha!') </script>";
		echo "<script language='javascript'> window.location='../sistema' </script>";
    }
}
else{
    //VERIFICAR SE EXISTE ALGUM CADASTRO NO BANCO, SE NÃO TIVER CADASTRAR O USUÁRIO ADMINISTRADOR
    $res = $pdo->query("SELECT * FROM medicos");
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $senha_crip = md5('Sicuro312@@');
    $data = date('Y/m/d H:i:s');
    
    if(@count($dados) == 0){
        $res = $pdo->query("INSERT into medicos (nivel, email, senha, senha_Crip, data_Registro) values ('adm', 'administrador@sicuropsi.com.br', 'Sicuro312@@', '$senha_crip', '$data' )");
    }
    
    if(@$_SESSION['id_user'] != null && @$_SESSION['nivel_user'] == 'adm'){
        echo "<script> window.location='./Adm'</script>";
    }
    if(@$_SESSION['id_user'] != null && @$_SESSION['nivel_user'] == 'med'){
        echo "<script> window.location='./Medico'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        if(!$Recup_True){
            echo "<title> Sicuro Psicologia | Login </title>";
        }
        else{
            echo "<title> Sicuro Psicologia | Recuperação de senha </title>";
        }
    ?>
    <link rel="icon" href="../assets/icon.svg" />

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- SVG Inject -->
    <script src="../js/svg-inject.min.js"></script>

    <!-- Main files -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main id="Main_login">
        <section id="login_sreen">
            <video autoplay loop muted>
                <source src="../assets/Login/bg_login.mp4" type="video/mp4">
            </video>

            <?php 
                if(!$Recup_True){
                    echo '
                        <a id="logo" href="../">
                            <img src="../assets/Login/sicuro_logo.svg" onload="SVGInject(this)">
                        </a>

                        <form id="LoginBox" action="configs/autenticar.php" method="post">
                            <h2>Seja bem vindo!</h2>
                            <div class="BlockBox">
                                <input type="text" name="emailLogin" id="emailLogin" required>
                                <span>E-mail:</span>
                            </div>
                            <div class="BlockBox senhaInput">
                                <input type="password" name="senhaLogin" id="senhaLogin" required>
                                <span>Senha:</span>
                                <div id="eye_box" onclick="ShowPass(`1`)">
                                    <img id="eye" src="../assets/Login/eye.svg" onload="SVGInject(this)">
                                    <img id="eye_slash" class="hide" src="../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                                </div>
                            </div>
                            <button type="button" id="senhaRecoverBtn" data-bs-toggle="modal" data-bs-target="#ModalRecoverSenha">
                                Esqueceu a senha?
                            </button>
                            <button class="btns btn_login" type="submit" id="loginBt">Conectar</button>
                        </form>
                    ';
                }
                else{
                    echo '
                        <form id="Recupera_senha" method="post">
                            <h2>Recuperação de senha</h2>
                            <div class="BlockBox senhaInput">
                                <input type="password" name="novaSenhaUser" id="novaSenhaUser" maxlength="25" required>
                                <span>Digite sua nova senha:</span>
                                <div id="eye_boxRecup" onclick="ShowPass(`2`)">
                                    <img id="eyeRecup" src="../assets/Login/eye.svg" onload="SVGInject(this)">
                                    <img id="eye_slashRecup" class="hide" src="../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                                </div>
                                <p class="lengthInput ResetSenhaInput"></p>
                            </div>
                            <div class="BlockBox senhaInput">
                                <input type="password" name="repetNovaSenhaUser" id="repetNovaSenhaUser" maxlength="25" required>
                                <span>Digite novamente sua nova senha:</span>
                                <div id="eye_box_RecupRepet" onclick="ShowPass(`3`)">
                                    <img id="eye_RecupRepet" src="../assets/Login/eye.svg" onload="SVGInject(this)">
                                    <img id="eye_slash_RecupRepet" class="hide" src="../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                                </div>
                                <p class="lengthInput repetResetSenhaInput"></p>
                            </div>
                            <input class="hide" type="text" name="chave" id="chave" value="'.$chave.'">
                            <button class="btns btn_Resetlogin" type="submit" id="ResetSenhaBtn">Atualizar senha</button>
                        </form>
                        <div id="msg_RecupSenha"></div>
                        <p id="voltaTela">Lembrou da senha? <a href="../sistema"> Clique aqui </a> para conectar-se agora! </p>
                    ';
                }
            ?> 
        </section>
   
        <!-- Modal recupera senha-->
        <div class="modal fade" id="ModalRecoverSenha" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog ModalRecoverSenha">

                <form id="Form_ModalrecupSenha" method="post" class="modal-content">
                    <button type="button" class="CloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
    
                    <div class="modal-body">
                        <h5>Por favor, insira o e-mail que foi cadastrado</h5>
                        <div class="BlockBox">
                            <input type="text" name="emailRecuperaSenha" id="emailRecuperaSenha" maxlength="50" required>
                            <span>E-mail para recuperação de senha:</span>
                            <p class="lengthInput EmailResetSenhaInput"></p>
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button class="btns btn_cancel" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btns btn_salvar RecuperarSenha" type="submit">Recuperar senha</button>
                    </div>
                </form>

                <div id="msg_ModalRecupSenha"></div>
            </div>
        </div>
    </main>

    <script>
        //FUNÇÃO DE VISUALIZAR SENHA
        function ShowPass(boxNum) {
            var elements = {
                '1': {
                    eye: 'eye',
                    eyeSlash: 'eye_slash',
                    passwordInput: 'senhaLogin'
                },
                '2': {
                    eye: 'eyeRecup',
                    eyeSlash: 'eye_slashRecup',
                    passwordInput: 'novaSenhaUser'
                },
                '3': {
                    eye: 'eye_RecupRepet',
                    eyeSlash: 'eye_slash_RecupRepet',
                    passwordInput: 'repetNovaSenhaUser'
                }
            };
            var element = elements[boxNum];
            if (element) {
                var eye = document.getElementById(element.eye);
                var eyeSlash = document.getElementById(element.eyeSlash);
                var passwordInput = document.getElementById(element.passwordInput);

                if (eyeSlash.classList.contains('hide')) {
                    eyeSlash.classList.remove('hide');
                    eye.classList.add('hide');
                    passwordInput.type = 'text';
                } else {
                    eyeSlash.classList.add('hide');
                    eye.classList.remove('hide');
                    passwordInput.type = 'password';
                }
            }
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

        $(document).ready(function () {
            $('#Form_ModalrecupSenha').submit(function (e) {
                e.preventDefault();
                $('#msg_ModalRecupSenha').text('');
                $('#msg_ModalRecupSenha').removeClass('text-danger');
                $('#msg_ModalRecupSenha').removeClass('text-success');
                $.ajax({
                    url: "configs/send_email_recuperar.php",
                    method: "post",
                    data: $('form').serialize(),
                    dataType: "text",
                    success: function (msg) {
                        if (msg.trim() === 'Link para a recuperação de senha enviado para o e-mail informado!') {
                            $('#msg_ModalRecupSenha').addClass('text-success');
                            $('#msg_ModalRecupSenha').text(msg);
                            setTimeout(() => { window.location.reload(); }, 5000)
                        }
                        else if (msg.trim() == 'Preencha o campo de recuperação de e-mail!' || msg.trim() == 'Este e-mail não está cadastrado!') {
                            $('#msg_ModalRecupSenha').addClass('text-danger');
                            $('#msg_ModalRecupSenha').text(msg);
                        }
                        else{
                            $('#msg_ModalRecupSenha').removeClass('text-success');
                            $('#msg_ModalRecupSenha').addClass('text-danger');
                            $('#msg_ModalRecupSenha').text('Erro ao enviar o formulario, provaveis problemas com o servidor, você pode tentar nos contactar via Instagram ou Whatsapp');
                        }
                    }
                })
            });

            $('#Recupera_senha').submit(function (e) {
                e.preventDefault();
                $('#msg_RecupSenha').text('');
                $('#msg_RecupSenha').removeClass('text-danger');
                $('#msg_RecupSenha').removeClass('text-success');
                $.ajax({
                    url: "configs/recupera_senha.php",
                    method: "post",
                    data: $('form').serialize(),
                    dataType: "text",
                    success: function (msg) {
                        if (msg.trim() === 'Senha atualizada com sucesso!') {
                            $('#msg_RecupSenha').addClass('text-success');
                            $('#msg_RecupSenha').text(msg);
                            setTimeout(() => { window.location='../sistema'; }, 2000)
                        }
                        else if(msg.trim() == 'Preencha o campo de nova senha!' || msg.trim() == 'Preencha o campo de repetição de senha!' || msg.trim() == 'As senhas não são iguais!' || msg.trim() == 'Erro: Tente novamente!' ) {
                            $('#msg_RecupSenha').addClass('text-danger');
                            $('#msg_RecupSenha').text(msg);
                        }
                        else{
                            $('#msg_RecupSenha').removeClass('text-success');
                            $('#msg_RecupSenha').addClass('text-danger');
                            $('#msg_RecupSenha').text('Erro ao enviar o formulario, provaveis problemas com o servidor, você pode tentar nos contactar via Instagram ou Whatsapp');
                        }
                    }
                })
            });
        });    
    </script>
</body>
</html>