<?php
session_start();
require_once("../configs/conexao.php");

$idUserSession = @$_SESSION['id_user'];
$query = $pdo->query("SELECT * FROM medicos WHERE id = '$idUserSession' LIMIT 1");
$dados = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
    $status = $dados[0]['status_perfil'];
    $email = $dados[0]['email'];
    $senha = $dados[0]['senha'];
    $senha_temp = $dados[0]['senha_temp'];
    $imagem = $dados[0]['foto'];
    $especialidade = $dados[0]['especialidade'];
    $nome_user = $dados[0]['nome'];
    $documento = $dados[0]['documento'];
    $estado = $dados[0]['estado'];
    $tipoAtendimento = $dados[0]['tipo_atendimento'];
    $abordagem = $dados[0]['abordagem'];
    $publico = $dados[0]['publico'];
    $descricao = $dados[0]['bio'];

    $linkedin = $dados[0]['linkedin'];
    $instagram = $dados[0]['instagram'];
    $facebook = $dados[0]['facebook'];
    $whatsapp = $dados[0]['whatsapp'];


    //Tratamento estado
    if($estado == "AC"){ $estado_longo = "Acre - AC"; }
    if($estado == "AL"){ $estado_longo = "Alagoas - AL"; }
    if($estado == "AP"){ $estado_longo = "Amapá - AP"; }
    if($estado == "AM"){ $estado_longo = "Amazonas - AM"; }
    if($estado == "BA"){ $estado_longo = "Bahia- BA"; }
    if($estado == "CE"){ $estado_longo = "Ceará - CE"; }
    if($estado == "DF"){ $estado_longo = "Distrito Federal - DF"; }
    if($estado == "ES"){ $estado_longo = "Espírito Santo - ES"; }
    if($estado == "GO"){ $estado_longo = "Goiás - GO"; }
    if($estado == "MT"){ $estado_longo = "Mato Grosso - MT"; }
    if($estado == "MS"){ $estado_longo = "Mato Grosso do Sul - MS"; }
    if($estado == "MG"){ $estado_longo = "Minas Gerais - MG"; }
    if($estado == "PA"){ $estado_longo = "Pará - PA"; }
    if($estado == "PB"){ $estado_longo = "Paraíba - PB"; }
    if($estado == "PR"){ $estado_longo = "Paraná - PR"; }
    if($estado == "PE"){ $estado_longo = "Pernambuco - PE"; }
    if($estado == "PI"){ $estado_longo = "Piauí - PI"; }
    if($estado == "RJ"){ $estado_longo = "Rio de Janeiro - RJ"; }
    if($estado == "RN"){ $estado_longo = "Rio Grande do Norte - RN"; }
    if($estado == "RS"){ $estado_longo = "Rio Grande do Sul - RS"; }
    if($estado == "RO"){ $estado_longo = "Rondônia - RO"; }
    if($estado == "RR"){ $estado_longo = "Roraima - RR"; }
    if($estado == "SC"){ $estado_longo = "Santa Catarina - SC"; }
    if($estado == "SP"){ $estado_longo = "São Paulo - SP"; }
    if($estado == "SE"){ $estado_longo = "Sergipe - SE"; }
    if($estado == "TO"){ $estado_longo = "Tocantins - TO"; }
    	 
} 
else {
    echo "<script language='javascript'> window.alert('Acesso Negado: Usuario não encontrado!') </script>";
    echo "<script language='javascript'> window.location='../../sistema' </script>";
}

?> 

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil medico <?php echo @$nome; ?> | Clinica Sicuro</title>
    <link rel="icon" href="../../assets/icon.svg" />

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- SVG Inject -->
    <script src="../../js/svg-inject.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <!-- Main files -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <ul class="menu">
            <li id="logo">
                <a href="../../../Sicuropsi/">
                    <img src="../../assets/sicuro_clinica.svg" onload="SVGInject(this)">
                </a>
            </li>

            <li>
                <button type="button" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                    <img src="../../assets/sistema/logout.svg" onload="SVGInject(this)">
                    Sair
                </button>
            </li>
            <li>
                <button type="button" data-bs-toggle="modal" data-bs-target="#ModalEditPerfil">
                    <img src="../../assets/sistema/user_edit.svg" onload="SVGInject(this)">
                    Editar dados
                </button>
            </li>
        </ul>
    </header>

    <main id="Main_Medicos">

        <!-- Modal Cria senha-->
        <div class="modal fade" id="ModalCriaSenha" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <form id="Form_ModalCriaSenha" method="post" class="modal-content">
                    <div class="modal-body">
                        <h2>Para continuar crie uma senha!</h2>
                        <div class="BlockBox senhaInput">
                            <input type="password" name="novaSenhaUser" id="novaSenhaUser" maxlength="25" required>
                            <span>Digite sua nova senha:</span>
                            <div id="eye_box" onclick="ShowPass(`1`)">
                                <img id="eye" src="../../assets/Login/eye.svg" onload="SVGInject(this)">
                                <img id="eye_slash" class="hide" src="../../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                            </div>
                            <p class="lengthInput novaSenhaInput"></p>
                        </div>
                        <div class="BlockBox senhaInput">
                            <input type="password" name="repetNovaSenhaUser" id="repetNovaSenhaUser" maxlength="25" required>
                            <span>Digite novamente sua nova senha:</span>
                            <div id="eye_box_Repet" onclick="ShowPass(`2`)">
                                <img id="eye_Repet" src="../../assets/Login/eye.svg" onload="SVGInject(this)">
                                <img id="eye_slash_Repet" class="hide" src="../../assets/Login/eye_slash.svg" onload="SVGInject(this)">
                            </div>
                            <p class="lengthInput repetSenhaInput"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input value="<?php echo $idUserSession ?>" class="hide" type="hidden" name="idUserSenha" id="idUserSenha">

                        <button class="btns btn_salvar" type="submit">Salvar Senha</button>
                    </div>
                </form>
            </div>
            <div id="msg_ModalCriaMedico"></div>
        </div>
        <?php
            if($senha == "" && $senha_temp != "" && $status == "inativo") {
                echo "
                    <button id='openModalCriaSenha' class='hide' type='button' data-bs-toggle='modal' data-bs-target='#ModalCriaSenha'></button>
                    <script language='javascript'>$('#openModalCriaSenha').click();</script>
                ";
            }
        ?>

        <section id="home">
            <?php 
                if($status == 'inativo' && $nome_user == ""){ 
                    echo "<h2 id='status_msg'>Este perfil se encontra desativado, preencha com suas informações para ativa-lo.</h2>"; 
                }
                if($status == 'inativo' && $nome_user != ""){ 
                    echo "<h2 id='status_msg'>Este perfil se encontra desativado, Entre em contato com o administrador para mais informações!</h2>"; 
                }
            ?>
            
            <form id="Form_DadosMedico" method="post">

                <div id="imgUser_block">
                    <?php
                        if($imagem == "placeholder.webp" || $imagem == ""){
                            $imagem = "<img class='imgMedico' src='../../Clinica/assets/users/user_placeholder.webp'>";
                        }else{
                            $imagem = "<img class='imgMedico' src='../../Clinica/assets/users/$imagem'>";
                        }

                        echo $imagem;
                    ?>
                </div>

                <div id="infos">
                    <div class="Seletor">
                        <div id="especialidades-select">
                            <input type="checkbox" id="select_input_espec" onchange="OptionSelection('selected_val_espec', 'select_input_espec', 'options_espec');">

                            <div id="select-button">
                                <div id='selected_val_espec'><?php if($especialidade == ""){ echo "Selecione uma especialidade"; } else{ echo $especialidade; } ?></div>
                                <img src="../../assets/sistema/seta_fina.svg" onload="SVGInject(this)">
                            </div>
                        </div>
                        
                        <ul id="options">
                            <?php 
                                $query = $pdo->query("SELECT * FROM especialidade ORDER BY id DESC");
                                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                for ($i=0; $i < count($dados); $i++) {
                                    $nome_espec = $dados[$i]['nome'];
                                    if($nome_espec === $especialidade){
                                        echo "
                                            <li class='options_espec'>
                                                <input type='radio' name='especialidade' value='$nome_espec' data-label='$nome_espec' checked>
                                                <span class='label'>$nome_espec</span>
                                            </li>
                                        ";
                                    }
                                    else{
                                        echo "
                                            <li class='options_espec'>
                                                <input type='radio' name='especialidade' value='$nome_espec' data-label='$nome_espec'>
                                                <span class='label'>$nome_espec</span>
                                            </li>
                                        ";
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="BlockBox">
                        <input type="text" name="nome" id="nome" value="<?php echo @$nome_user?>" maxlength="100" required>
                        <span>Nome e sobrenome:</span>
                        <p class="lengthInput NomeInput"></p>
                    </div>
                    <div class="BlockBox">
                        <input type="text" name="doc" id="doc" value="<?php echo @$documento?>" maxlength="100" required>
                        <span>Documento:</span>
                    </div>
                    <div class="Seletor">
                        <div id="estado-select">
                            <input type="checkbox" id="select_input_estado" onchange="OptionSelection('selected_val_estado', 'select_input_estado', 'options_estado');">

                            <div id="select-button">
                                <div id='selected_val_estado'><?php if($estado == ""){ echo "Selecione um estado"; } else{ echo $estado_longo; } ?></div>
                                <img src="../../assets/sistema/seta_fina.svg" onload="SVGInject(this)">
                            </div>
                        </div>
                        <ul id="options">
                            <?php 
                                if($estado != ""){
                                    echo "
                                        <li class='options_estado'>
                                            <input type='radio' name='estado' value='$estado' data-label='$estado' checked>
                                            <span class='label'>$estado_longo</span>
                                        </li>
                                    ";
                                }
                            ?>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Acre - AC' data-label='Acre - AC'>
                                <span class='label'>Acre - AC</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Alagoas - AL' data-label='Alagoas - AL'>
                                <span class='label'>Alagoas - AL</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Amapá - AP' data-label='Amapá - AP'>
                                <span class='label'>Amapá - AP</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Amazonas - AM' data-label='Amazonas - AM'>
                                <span class='label'>Amazonas - AM</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Bahia - BA' data-label='Bahia - BA'>
                                <span class='label'>Bahia - BA</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Ceará - CE' data-label='Ceará - CE'>
                                <span class='label'>Ceará - CE</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Distrito Federal - DF' data-label='Distrito Federal - DF'>
                                <span class='label'>Distrito Federal - DF</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Espírito Santo - ES' data-label='Espírito Santo - ES'>
                                <span class='label'>Espírito Santo - ES</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Goiás - GO' data-label='Goiás - GO'>
                                <span class='label'>Goiás - GO</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Mato Grosso - MT' data-label='Mato Grosso - MT'>
                                <span class='label'>Mato Grosso - MT</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Mato Grosso do Sul - MS' data-label='Mato Grosso do Sul - MS'>
                                <span class='label'>Mato Grosso do Sul - MS</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Minas Gerais - MG' data-label='Minas Gerais - MG'>
                                <span class='label'>Minas Gerais - MG</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Pará - PA' data-label='Pará - PA'>
                                <span class='label'>Pará - PA</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Paraíba - PB' data-label='Paraíba - PB'>
                                <span class='label'>Paraíba - PB</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Paraná - PR' data-label='Paraná - PR'>
                                <span class='label'>Paraná - PR</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Pernambuco - PE' data-label='Pernambuco - PE'>
                                <span class='label'>Pernambuco - PE</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Piauí - PI' data-label='Piauí - PI'>
                                <span class='label'>Piauí - PI</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Rio de Janeiro - RJ' data-label='Rio de Janeiro - RJ'>
                                <span class='label'>Rio de Janeiro - RJ</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Rio Grande do Norte - RN' data-label='Rio Grande do Norte - RN'>
                                <span class='label'>Rio Grande do Norte - RN</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Rio Grande do Sul - RS' data-label='Rio Grande do Sul - RS'>
                                <span class='label'>Rio Grande do Sul - RS</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Rondônia - RO' data-label='Rondônia - RO'>
                                <span class='label'>Rondônia - RO</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Roraima - RR' data-label='Roraima - RR'>
                                <span class='label'>Roraima - RR</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Santa Catarina - SC' data-label='Santa Catarina - SC'>
                                <span class='label'>Santa Catarina - SC</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='São Paulo - SP' data-label='São Paulo - SP'>
                                <span class='label'>São Paulo - SP</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Sergipe - SE' data-label='Sergipe - SE'>
                                <span class='label'>Sergipe - SE</span>
                            </li>
                            <li class='options_estado'>
                                <input type='radio' name='estado' value='Tocantins - TO' data-label='Tocantins - TO'>
                                <span class='label'>Tocantins - TO</span>
                            </li>
                        </ul>
                    </div>
                    <div class="Seletor">
                        <div id="atendimento-select">
                            <input type="checkbox" id="select_input_atendimento" onchange="OptionSelection('selected_val_atendimento', 'select_input_atendimento', 'options_atendimento');">

                            <div id="select-button">
                                <div id='selected_val_atendimento'><?php if($tipoAtendimento == ""){ echo "Selecione a sua modalidade de atendimento"; } else{ echo $tipoAtendimento; } ?></div>
                                <img src="../../assets/sistema/seta_fina.svg" onload="SVGInject(this)">
                            </div>
                        </div>
                        <ul id="options">
                            <?php 
                                if($tipoAtendimento != ""){
                                    if($tipoAtendimento == "Online&Presencial"){ $tipoAtendimento = "Online e Presencial"; }
                                    echo "
                                        <li class='options_atendimento'>
                                            <input type='radio' name='atendimento' value='$tipoAtendimento' data-label='$tipoAtendimento' checked>
                                            <span class='label'>$tipoAtendimento</span>
                                        </li>
                                    ";
                                }
                            ?>
                            <li class='options_atendimento'>
                                <input type='radio' name='atendimento' value='Online' data-label='Online'>
                                <span class='label'>Online</span>
                            </li>
                            <li class='options_atendimento'>
                                <input type='radio' name='atendimento' value='Presencial' data-label='Presencial'>
                                <span class='label'>Presencial</span>
                            </li>
                            <li class='options_atendimento'>
                                <input type='radio' name='atendimento' value='Online&Presencial' data-label='Online&Presencial'>
                                <span class='label'>Online e Presencial</span>
                            </li>
                        </ul>
                    </div>
                    <div class="Seletor">
                        <div id="abordagem-select">
                            <input type="checkbox" id="select_input_abordagem" onchange="OptionSelection('selected_val_abordagem', 'select_input_abordagem', 'options_abordagem');">

                            <div id="select-button">
                                <div id='selected_val_abordagem'><?php if($abordagem == ""){ echo "Selecione seu estilo de abordagem"; } else{ echo $abordagem; } ?></div>
                                <img src="../../assets/sistema/seta_fina.svg" onload="SVGInject(this)">
                            </div>
                        </div>
                        
                        <ul id="options">
                            <?php 
                                $query = $pdo->query("SELECT * FROM abordagem ORDER BY id DESC");
                                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                for ($i=0; $i < count($dados); $i++) {
                                    $nome_abordagem = $dados[$i]['nome'];
                                    if($nome_abordagem === $abordagem){
                                        echo "
                                            <li class='options_abordagem'>
                                                <input type='radio' name='abordagem' value='$nome_abordagem' data-label='$nome_abordagem' checked>
                                                <span class='label'>$nome_abordagem</span>
                                            </li>
                                        ";
                                    }
                                    else{
                                        echo "
                                            <li class='options_abordagem'>
                                                <input type='radio' name='abordagem' value='$nome_abordagem' data-label='$nome_abordagem'>
                                                <span class='label'>$nome_abordagem</span>
                                            </li>
                                        ";
                                    }
                                }
                            ?>
                        </ul>
                    </div>

                    <div class="BlockBox TextAreaBox">
                        <textarea type="text" name="publico_alvo" id="publico_alvo" maxlength="500" required><?php echo @$publico ?></textarea>
                        <span>Publico Alvo:</span>
                    </div>
                    <div class="BlockBox TextAreaBox">
                        <textarea type="text" name="bio" id="bio" maxlength="2000" required><?php echo @$descricao ?></textarea>
                        <span>Sua Biografia:</span>
                    </div>

                    <div class="BlockBox">
                        <input type="text" name="linkedin" id="linkedin" value="<?php echo @$linkedin?>" required>
                        <span>Linkedin:</span>
                    </div>
                    <div class="BlockBox">
                        <input type="text" name="instagram" id="instagram" value="<?php echo @$instagram?>" required>
                        <span>Instagram:</span>
                    </div>
                    <div class="BlockBox">
                        <input type="text" name="facebook" id="facebook" value="<?php echo @$facebook?>" required>
                        <span>Facebook:</span>
                    </div>
                    <div class="BlockBox">
                        <input type="text" name="whatsapp" id="whatsapp" value="<?php echo @$whatsapp?>" required>
                        <span>Whatsapp:</span>
                    </div>
                </div>

                <input value="<?php echo $idUserSession ?>" class="hide" type="hidden" name="idUser" id="idUser">

                <button class="btns btn_salvar" type="submit">Salvar Senha</button>
            </form>
        </section>
            
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
                        <a class="btns btn_salvar" href="../configs/logout.php" type="button">Sair</a>
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
        //VERICAÇÃO QUANTIDADE DE CARACTERES INPUT + Show Eye Icon
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
                verificaTamanhoInput('novaSenhaUser', 'novaSenhaInput', 25);
                verificaTamanhoInput('repetNovaSenhaUser', 'repetSenhaInput', 25);
        }, 50);

        function ShowPass(boxNum) {
            var elements = {
                '1': {
                    eye: 'eye',
                    eyeSlash: 'eye_slash',
                    passwordInput: 'novaSenhaUser'
                },
                '2': {
                    eye: 'eye_Repet',
                    eyeSlash: 'eye_slash_Repet',
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
            $('#Form_ModalCriaSenha').submit(function(e){
                e.preventDefault();
                $('#msg_ModalCriaMedico').text('');
                $('#msg_ModalCriaMedico').removeClass('text-danger');
                $('#msg_ModalCriaMedico').removeClass('text-success');
                $.ajax({
                    url:"insert_senha.php",
                    method:"post",
                    data: $('form').serialize(),
                    dataType: "text",
                    success: function(msg){
                        if(msg.trim() === 'Nova senha adicionada com Sucesso!'){
                            $('#msg_ModalCriaMedico').addClass('text-success');
                            $('#msg_ModalCriaMedico').text(msg);
                            setTimeout(() => { location.reload(); }, 5000);
                        }
                        else{
                            $('#msg_ModalCriaMedico').addClass('text-danger');
                            $('#msg_ModalCriaMedico').text(msg);
                        }
                    }
                })
            });

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