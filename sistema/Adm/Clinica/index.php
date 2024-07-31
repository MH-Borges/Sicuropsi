<?php
session_start();
require_once("../../configs/conexao.php");

$idUserSession = @$_SESSION['id_user'];
$query = $pdo->query("SELECT * FROM medicos WHERE id = '$idUserSession' LIMIT 1");
$dados = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($dados) > 0){
    $emailAdm = $dados[0]['email'];
    $senhaAdm = $dados[0]['senha'];
} 
else {
    echo "<script language='javascript'> window.alert('Acesso Negado: Usuario não encontrado!') </script>";
    echo "<script language='javascript'> window.location='../../../sistema' </script>";
}

?> 

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativo Clinica</title>
    <link rel="icon" href="../../../assets/icon.svg" />

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- SVG Inject -->
    <script src="../../../js/svg-inject.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <!-- Main files -->
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <header>
        <ul class="menu">
            <li id="logo">
                <a href="../../../../Sicuropsi/">
                    <img src="../../../assets/sicuro_clinica.svg" onload="SVGInject(this)">
                </a>
            </li>

            <li <?php if (@$_GET["pag"] == "") { echo 'class="hide"'; } ?>>
                <div class="dropdown">
                    <button type="button" id="dropdownMiniMenu" data-bs-toggle="dropdown">
                        <img src="../../../assets/sistema/menu.svg" onload="SVGInject(this)">
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMiniMenu">
                        <li>
                            <a class="dropdown-item" href="../Clinica">
                                <img src="../../../assets/sistema/home.svg" onload="SVGInject(this)">
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="index.php?pag=medicos">
                                <img src="../../../assets/sistema/medico.svg" onload="SVGInject(this)">
                                Medicos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="index.php?pag=especialidades">
                                <img src="../../../assets/sistema/Especialidade.svg" onload="SVGInject(this)">
                                Especialidades
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="index.php?pag=blog">
                                <img src="../../../assets/sistema/blog.svg" onload="SVGInject(this)">
                                Blog
                            </a>
                        </li>
                        <li>
                            <!-- index.php?pag=emailMarketing -->
                            <a class="dropdown-item" href="">
                                <img src="../../../assets/sistema/email_marketing.svg" onload="SVGInject(this)">
                                E-mail marketing
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <div class="dropdown">
                    <button type="button" id="dropdownMenu" data-bs-toggle="dropdown">
                        <img src="../../../assets/sistema/config.svg" onload="SVGInject(this)">
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <li>
                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#ModalEditPerfil">
                                <img src="../../../assets/sistema/user_edit.svg" onload="SVGInject(this)">
                                Editar dados
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                                <img src="../../../assets/sistema/logout.svg" onload="SVGInject(this)">
                                Sair
                            </button>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./Main_menus/backup.php">
                                <img src="../../../assets/sistema/backup.svg" onload="SVGInject(this)">
                                Backup
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </header>

    <main id="Main_Clinica">
        <?php
            if (isset($_SESSION['msg_BancoDados'])) {
                echo $_SESSION['msg_BancoDados'];
                unset($_SESSION['msg_BancoDados']);
            }
        ?>

        <section id="home" <?php if (@$_GET["pag"] !== "" && @$_GET["pag"] !== null) { echo 'class="hide"'; } ?>>
            <a class="itens" href="index.php?pag=medicos">
                <img src="../../../assets/sistema/medico.svg" onload="SVGInject(this)">
                Medicos
            </a>

            <a class="itens" href="index.php?pag=especialidades">
                <img src="../../../assets/sistema/Especialidade.svg" onload="SVGInject(this)">
                Especialidades
            </a>

            <a class="itens" href="index.php?pag=blog">
                <img src="../../../assets/sistema/blog.svg" onload="SVGInject(this)">
                Blog
            </a>

            <!-- index.php?pag=emailMarketing -->
            <a class="itens" href="">
                <img src="../../../assets/sistema/email_marketing.svg" onload="SVGInject(this)">
                E-mail marketing
                <span>(em breve)</span>
            </a>
        </section>
            
        <?php 
            if (@$_GET["pag"] == "medicos") { include_once("Medicos/medicos.php"); }
            else if (@$_GET["pag"] == "especialidades") { include_once("Especialidades/especialidades.php"); }
            else if (@$_GET["pag"] == "blog") { include_once("Blog/blog.php"); }
            else if (@$_GET["pag"] == "emailMarketing") { include_once("EmailMarketing/emailMarketing.php"); }
        ?>

        <!-- Modal Logout-->
        <div class="modal fade" id="ModalLogout" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="CloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <h5>Já vai embora?</h5>
                        <h6>Tem certeza que gostaria de sair da sa conta?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btns btn_cancel" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <a class="btns btn_salvar" href="../../configs/logout.php" type="button">Sair</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar perfil-->
        <div class="modal fade" id="ModalEditPerfil" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="CloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <div id="MenuAdm" class="nav nav-pills">
                            <a class="active" data-bs-toggle="pill" href="#EmailTroca">Troca de email</a>
                            <a data-bs-toggle="pill" href="#SenhaTroca">Troca de senha</a>
                        </div>
                        <div id="TabsAdm" class="tab-content">
                            <div class="tab-pane fade show active" id="EmailTroca">
                                <h4>Alterar Email:</h4>
                                <form id="formEditEmailUser" class="emailEdit" method="POST">
                                    <div class="BlockBox">
                                        <input type="text" name="antigoEmail" id="antigoEmail" maxlength="50" required>
                                        <span>E-mail Antigo:</span>
                                        <p class="lengthInput emailAntigoEditInput"></p>
                                    </div>
                                    <div class="BlockBox">
                                        <input type="text" name="novoEmail" id="novoEmail" maxlength="50" required>
                                        <span>Novo e-mail:</span>
                                        <p class="lengthInput novoEmailEditInput"></p>
                                    </div>
                                    <div class="BlockBox">
                                        <input type="text" name="confirmaNovoEmail" id="confirmaNovoEmail" maxlength="50" required>
                                        <span>Confirma novo e-mail:</span>
                                        <p class="lengthInput ConfirmaNovoEmailEditInput"></p>
                                    </div>
            
                                    <input value="<?php echo $idUserSession ?>" class="hide" type="hidden" name="idUserEmail" id="idUserEmail">
                                    <input value="<?php echo $emailAdm ?>" class="hide" type="hidden" name="emailUserSemAlteracoes" id="emailUserSemAlteracoes">
                                    <button class="btns btn_salvar" type="submit">Salvar</button>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="SenhaTroca">
                                <h4>Alterar Senha:</h4>
                                <form id="formEditSenhaUser" class="senhaEdit" method="POST">
                                    <div class="BlockBox senhaInput">
                                        <input type="password" name="antigaSenha" id="antigaSenha" maxlength="25" required>
                                        <span>Senha antiga:</span>
                                        <div id="eye_box" onclick="ShowPass('1')">
                                            <img id="eye" src="../../../assets/Login/eye.svg" onload="SVGInject(this)">
                                            <img id="eye_slash" class="hide" src="../../../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                                        </div>
                                        <p class="lengthInput SenhaAntigaEditInput"></p>
                                    </div>
                                    <div class="BlockBox senhaInput">
                                        <input type="password" name="novaSenha" id="novaSenha" maxlength="25" required>
                                        <span>Nova senha:</span>
                                        <div id="eye_boxRecup" onclick="ShowPass(`2`)">
                                            <img id="eyeRecup" src="../../../assets/Login/eye.svg" onload="SVGInject(this)">
                                            <img id="eye_slashRecup" class="hide" src="../../../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                                        </div>
                                        <p class="lengthInput NovaSenhaEditInput"></p>
                                    </div>
                                    <div class="BlockBox senhaInput">
                                        <input type="password" name="confirmaNovaSenha" id="confirmaNovaSenha" maxlength="25" required>
                                        <span>Confirma nova senha:</span>
                                        <div id="eye_box_RecupRepet" onclick="ShowPass(`3`)">
                                            <img id="eye_RecupRepet" src="../../../assets/Login/eye.svg" onload="SVGInject(this)">
                                            <img id="eye_slash_RecupRepet" class="hide" src="../../../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                                        </div>
                                        <p class="lengthInput ConfirmaNovaSenhaEditInput"></p>
                                    </div>
                                    <input value="<?php echo $idUserSession ?>" class="hide" type="hidden" name="idUserSenha" id="idUserSenha">
                                    <input value="<?php echo $senhaAdm ?>" class="hide" type="hidden" name="senhaUserSemAlteracoes" id="senhaUserSemAlteracoes">
                                    <button class="btns btn_salvar" type="submit">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="msgErro_EditUser"></div>
        </div>
    </main>

    <script>
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
                verificaTamanhoInput('antigoEmail', 'emailAntigoEditInput', 50);
                verificaTamanhoInput('novoEmail', 'novoEmailEditInput', 50);
                verificaTamanhoInput('confirmaNovoEmail', 'ConfirmaNovoEmailEditInput', 50);

                verificaTamanhoInput('antigaSenha', 'SenhaAntigaEditInput', 25);
                verificaTamanhoInput('novaSenha', 'NovaSenhaEditInput', 25);
                verificaTamanhoInput('confirmaNovaSenha', 'ConfirmaNovaSenhaEditInput', 25);
        }, 50);

        // UPLOAD INFOS
        $(document).ready(function () {
            $('#formEditEmailUser').submit(function(e){
                e.preventDefault();
                $('#msgErro_EditUser').text('');
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').removeClass('text-success');
                $.ajax({
                    url:"./Main_menus/EditEmail.php",
                    method:"post",
                    data: $('form').serialize(),
                    dataType: "text",
                    success: function(msg){
                        if(msg.trim() === 'E-mail alterado com Sucesso!'){
                            $('#msgErro_EditUser').addClass('text-success');
                            $('#msgErro_EditUser').text(msg);
                            window.alert('Necessario relogar para alteração completa do email');
                            window.location='../../configs/logout.php';
                        }
                        else{
                            $('#msgErro_EditUser').addClass('text-danger');
                            $('#msgErro_EditUser').text(msg);
                        }
                    }
                })
            });

            $('#formEditSenhaUser').submit(function(e){
                e.preventDefault();
                $('#msgErro_EditUser').text('');
                $('#msgErro_EditUser').removeClass('text-danger');
                $('#msgErro_EditUser').removeClass('text-success');
                $.ajax({
                    url:"./Main_menus/EditSenha.php",
                    method:"post",
                    data: $('form').serialize(),
                    dataType: "text",
                    success: function(msg){
                        if(msg.trim() === 'Senha alterada com Sucesso!'){
                            $('#msgErro_EditUser').addClass('text-success');
                            $('#msgErro_EditUser').text(msg);
                            setTimeout(() => { location.reload(); }, 5000);
                        }
                        else{
                            $('#msgErro_EditUser').addClass('text-danger');
                            $('#msgErro_EditUser').text(msg);
                        }
                    }
                });
            });
        });

        function ShowPass(boxNum) {
            var elements = {
                '1': {
                    eye: 'eye',
                    eyeSlash: 'eye_slash',
                    passwordInput: 'antigaSenha'
                },
                '2': {
                    eye: 'eyeRecup',
                    eyeSlash: 'eye_slashRecup',
                    passwordInput: 'novaSenha'
                },
                '3': {
                    eye: 'eye_RecupRepet',
                    eyeSlash: 'eye_slash_RecupRepet',
                    passwordInput: 'confirmaNovaSenha'
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
    </script>
</body>
</html>