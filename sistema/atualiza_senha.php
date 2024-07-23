<?php
    session_start();
    ob_start();
    require_once("configs/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Inove | Recupera Senha</title>
    <link rel="icon" href="../assets/icon.svg" />

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Main files -->
    <link rel="stylesheet" href="../css/Back/style.min.css">

    <script defer src="js/Login/script.min.js"></script>
    <script src="../js/svg-inject.min.js"></script>
</head>

<body class="recuperaSenha">

    <main>
        <img class="Back_Login" src="../assets/backgrounds/Login_Background.webp" alt="Background">
        <a class="logo_Vertical" href="https://www.autoinove.com.br">
            <img src="../assets/logo_Vertical.svg" onload="SVGInject(this)" alt="Logo Auto inove vertical">
        </a>

        <?php
            $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
            if (!empty($chave)) {
                $result_user = $pdo->prepare("SELECT id FROM usuarios WHERE senha_Recup =:senha_Recup LIMIT 1");
                $result_user->bindParam(':senha_Recup', $chave);
                $result_user->execute();
                if ($result_user->rowCount() != 0) {
                    $row_usuario = $result_user->fetch(PDO::FETCH_ASSOC);
                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if (!empty($dados['SendNovaSenha'])) {
                        if($dados['novaSenhaUser'] !== $dados['repetNovaSenhaUser']){
                            $msg = '<div class="msgErro">As senhas não são iguais</div>';
                            echo $msg;
                        }
                        else{
                            $senha = $dados['novaSenhaUser'];
                            $senha_crip = md5($dados['novaSenhaUser']);
                            $recuperar_senha = 'NULL';
                            $result_up_usuario = $pdo->prepare("UPDATE usuarios SET senha = :senha, senha_Crip = :senha_Crip, senha_Recup = :senha_Recup WHERE id =:id LIMIT 1");
                            $result_up_usuario->bindParam(':senha', $senha);
                            $result_up_usuario->bindParam(':senha_Crip', $senha_crip);
                            $result_up_usuario->bindParam(':senha_Recup', $recuperar_senha);
                            $result_up_usuario->bindParam(':id', $row_usuario['id']);
                            if ($result_up_usuario->execute()) {
                                $_SESSION['msg_rec'] = "<div class='msgRecupSenha' style='bottom: 2vh !important; background:#BAF811; color:#131313;'>Senha atualizada com sucesso!</div>";
                                header("Location: index.php");
                            } else {
                                $_SESSION['msg_rec'] = "<div class='msgRecupSenha' style='bottom: 2vh !important; background:#F83810;'>Erro: Tente novamente!</div>";
                                header("Location: index.php");
                            }
                        }
                    }
                } else {
                    $_SESSION['msg_rec'] = "<div class='msgRecupSenha' style='bottom: 2vh !important; background:#F83810;'>Erro: Link inválido, solicite novo link para atualizar a senha!</div>";
                    header("Location: index.php");
                }
            } else {
                $_SESSION['msg_rec'] = "<div class='msgRecupSenha' style='bottom: 2vh !important; background:#F83810;'>Erro: Link inválido</div>";
                header("Location: index.php");
            }
        ?>

        <section class="recuperaSenhaBlock">
            <form class="RecupSenhaBox" method="post">
                <h2>Recuperação de senha</h2>

                <div class="BlockBox senhaInput">
                    <input type="password" name="novaSenhaUser" id="novaSenhaUser" maxlength="25" required>
                    <span>Digite sua nova senha:</span>
                    <i id="password_toggle" onclick="setupPasswordToggle('novaSenhaUser', 'password_toggle')" class="senhaIcon fa-regular fa-eye-slash"></i>
                    <p class="lengthInput ResetSenhaInput"></p>
                </div>

                <div class="BlockBox senhaInputNew">
                    <input type="password" name="repetNovaSenhaUser" id="repetNovaSenhaUser" maxlength="25" required>
                    <span>Digite novamente sua nova senha:</span>
                    <i id="password_toggle_again" onclick="setupPasswordToggle('repetNovaSenhaUser', 'password_toggle_again')" class="senhaIconAgain fa-regular fa-eye-slash"></i>
                    <p class="lengthInput repetResetSenhaInput"></p>
                </div>

                <input type="submit" id="ResetSenhaBtn" value="Atualizar senha" name="SendNovaSenha">
            </form>
        </section>

        <p class="voltaTela"> Lembrou da senha? <a href="index.php"> Clique aqui </a> para conectar-se agora! </p>
    </main>
    
</body>
</html>