<?php
    @session_start();
    require_once("../configs/conexao.php"); 

    $id_User = $_POST['idUser'];
    $status = $_POST['status'];

    $nome = $_POST['nome'];
    $doc = $_POST['doc'];
    $especialidade = $_POST['especialidade'];
    $estado = $_POST['estado'];
    $atendimento = $_POST['atendimento'];
    $abordagem = $_POST['abordagem'];
    $publico_alvo = $_POST['publico_alvo'];
    $bio = $_POST['bio'];

    $linkedin = $_POST['linkedin'];
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $whatsapp = $_POST['whatsapp'];
    
    // ===== VERIFICAÇÃO DE INPUTS VAZIOS + VERIFICAÇÃO DE POSSIVEIS ERROS =====
    if($status == "inativo"){
        $status = "ativo";
    }
    if($nome == ""){
        echo 'Preencha o campo de nome';
        exit();
    }

    $caracteresProibidos = ['_', '{', '}', '|', '\\', '^', '[', ']', '`', ';', '/', '?', ':', '@', '&', '=', '+', '$', ','];
    foreach ($caracteresProibidos as $caractere) {
        if (str_contains($nome, $caractere)) {
            echo "O caractere '$caractere' não pode ser utilizado";
            exit();
        }
    }

    if($doc == ""){
        echo 'Preencha o campo de documento';
        exit();
    }
    if($especialidade == ""){
        echo 'Selecione uma especialidade';
        exit();
    }
    if($abordagem == ""){
        echo 'Selecione uma estilo de abordagem';
        exit();
    }

    if($bio !== ""){
        $bio = nl2br(htmlentities($bio, ENT_QUOTES, 'UTF-8'));
    }
    if($publico_alvo !== ""){
        $publico_alvo = nl2br(htmlentities($publico_alvo, ENT_QUOTES, 'UTF-8'));
    }

    if($linkedin !== "" && $linkedin !== null){
        if($linkedin[0] == 'h' && $linkedin[1] == 't' && $linkedin[2] == 't' && $linkedin[4] == 's' ){
            $linkedin = ltrim($linkedin, 'https://');
        }
        
        if($linkedin[0] == 'h' && $linkedin[1] == 't' && $linkedin[2] == 't' && $linkedin[4] == ':' ){
            $linkedin = ltrim($linkedin, 'http://');
        }
    }
    if($instagram !== "" && $instagram !== null){
        if($instagram[0] == 'h' && $instagram[1] == 't' && $instagram[2] == 't' && $instagram[4] == 's' ){
            $instagram = ltrim($instagram, 'https://');
        }
        
        if($instagram[0] == 'h' && $instagram[1] == 't' && $instagram[2] == 't' && $instagram[4] == ':' ){
            $instagram = ltrim($instagram, 'http://');
        }
    }
    if($facebook !== "" && $facebook !== null){
        if($facebook[0] == 'h' && $facebook[1] == 't' && $facebook[2] == 't' && $facebook[4] == 's' ){
            $facebook = ltrim($facebook, 'https://');
        }
        
        if($facebook[0] == 'h' && $facebook[1] == 't' && $facebook[2] == 't' && $facebook[4] == ':' ){
            $facebook = ltrim($facebook, 'http://');
        }
    }
    if($whatsapp !== "" && $whatsapp !== null){
        if($whatsapp[0] == 'h' && $whatsapp[1] == 't' && $whatsapp[2] == 't' && $whatsapp[4] == 's' ){
            $whatsapp = ltrim($whatsapp, 'https://');
        }
        
        if($whatsapp[0] == 'h' && $whatsapp[1] == 't' && $whatsapp[2] == 't' && $whatsapp[4] == ':' ){
            $whatsapp = ltrim($whatsapp, 'http://');
        }
    }

    // ===== SCRIPTS PARA SUBIR BANNER WEB E MOBILE PARA O BANCO =====
    function uploadImage($inputName, $targetDir, $defaultImage) {
        $uploadedFile = @$_FILES[$inputName];
        $imageName = preg_replace('/[ -]+/' , '-' , $uploadedFile['name']);
        $imageName = preg_replace('/_/' , '-' , $uploadedFile['name']);
        $targetPath = $targetDir . $imageName;

        if (empty($uploadedFile['name'])) { return $defaultImage; }

        $imageTemp = $uploadedFile['tmp_name'];
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedExtensions = ['png', 'webp', 'jpg', 'jpeg'];

        if (in_array($imageExt, $allowedExtensions)) {
            move_uploaded_file($imageTemp, $targetPath);
            return $imageName;
        } else {
            echo "Extensão da imagem não permitida!";
            exit();
        }
    }
    // Diretórios e imagens padrão
    $img_User_Diret = '../../Clinica/assets/users/';
    $default_img_user = 'user_placeholder.webp';
    $img_User = uploadImage('img_User_Input', $img_User_Diret, $default_img_user);


    // ===== INSERÇÃO DE DADOS NO BANCO =====
    $res = $pdo->prepare("UPDATE medicos SET foto = :img, status_perfil = :status_perfil, nome = :nome, documento = :documento, especialidade = :especialidade, estado = :estado, tipo_atendimento = :atendimento, abordagem = :abordagem, publico = :publico_alvo, bio = :bio, linkedin = :linkedin, instagram = :instagram, facebook = :facebook, whatsapp = :whatsapp WHERE id = :id");
    $res->bindValue(":img", $img_User);

    $res->bindValue(":status_perfil", $status);
    $res->bindValue(":nome", $nome);
    $res->bindValue(":documento", $doc);
    $res->bindValue(":especialidade", $especialidade);
    $res->bindValue(":estado", $estado);
    $res->bindValue(":atendimento", $atendimento);
    $res->bindValue(":abordagem", $abordagem);
    $res->bindValue(":publico_alvo", $publico_alvo);
    $res->bindValue(":bio", $bio);
    $res->bindValue(":linkedin", $linkedin);
    $res->bindValue(":instagram", $instagram);
    $res->bindValue(":facebook", $facebook);
    $res->bindValue(":whatsapp", $whatsapp);
    $res->bindValue(":id", $id_User);

    if ($res->execute()) {
        echo 'Perfil Atualizado com Sucesso!!';
    } else {
        echo 'Erro: Tente novamente!';
    }
   
?>